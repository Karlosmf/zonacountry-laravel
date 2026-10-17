<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Banner;
use App\Models\Category;
use App\Models\ClassifiedListing;
use App\Models\Country;
use App\Models\VecinalClaim;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index(Request $request)
    {
        $activeBanners = Banner::with(['sponsor', 'adZone'])
            ->where('is_active', true)
            ->orderByDesc('id')
            ->get();

        // Incrementar impresiones reales al cargar el portal
        Banner::where('is_active', true)->increment('impressions_count');

        $bannersByZone = $activeBanners->groupBy(fn (Banner $banner) => $banner->adZone->slug ?? 'other');

        $heroBanners = $bannersByZone->get('home-hero', collect());
        $topWideBanners = $bannersByZone->get('home-top-wide', collect());
        $infeedBanners = $bannersByZone->get('home-mid', collect());
        $sidebarBanners = $bannersByZone->get('sidebar', collect());

        $articlesQuery = Article::with('category')
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->orderByDesc('id');

        if ($request->filled('categoria')) {
            $articlesQuery->whereHas('category', fn ($q) => $q->where('slug', $request->string('categoria')));
        }

        $articles = $articlesQuery->take(9)->get();
        $featuredArticle = $articles->first();
        $latestArticles = $articles->slice(1)->values();

        $selectedCountry = $request->string('country')->toString();

        $listingsQuery = ClassifiedListing::with('country')
            ->where('status', 'active')
            ->orderByDesc('is_featured')
            ->orderByDesc('id');

        if ($selectedCountry !== '') {
            $listingsQuery->whereHas('country', fn ($q) => $q->where('slug', $selectedCountry));
        }

        $listings = $listingsQuery->take(6)->get();
        $countries = Country::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        $claims = VecinalClaim::with('country')->latest()->take(5)->get();

        $claimsByType = VecinalClaim::selectRaw('claim_type, count(*) as total')
            ->groupBy('claim_type')
            ->pluck('total', 'claim_type');

        $busSchedules = [
            ['line' => 'Continental · C Verde (Countries)', 'route' => 'Sale de Los Molinos / El Paso → Centro Santa Fe', 'departure' => '06:45 hs', 'type' => 'habil'],
            ['line' => 'Continental · C Verde (Countries)', 'route' => 'Aires del Llano / El Pinar → Plaza del Soldado', 'departure' => '07:30 hs', 'type' => 'habil'],
            ['line' => 'Continental · C Verde (Countries)', 'route' => 'Regreso Centro Santa Fe → Corredor Autopista', 'departure' => '13:15 hs', 'type' => 'habil'],
            ['line' => 'Continental · C Verde (Countries)', 'route' => 'Regreso Vespertino Centro → Countries Autopista', 'departure' => '18:30 hs', 'type' => 'habil'],
            ['line' => 'Continental · Fin de Semana', 'route' => 'Corredor Countries → Centro Santa Fe', 'departure' => '09:00 hs', 'type' => 'finde'],
            ['line' => 'Continental · Fin de Semana', 'route' => 'Regreso Centro Santa Fe → Countries', 'departure' => '20:15 hs', 'type' => 'finde'],
        ];

        return view('portal.index', compact(
            'bannersByZone',
            'heroBanners',
            'topWideBanners',
            'infeedBanners',
            'sidebarBanners',
            'articles',
            'featuredArticle',
            'latestArticles',
            'listings',
            'countries',
            'selectedCountry',
            'categories',
            'claims',
            'claimsByType',
            'busSchedules'
        ));
    }

    public function showArticle(string $slug)
    {
        $article = Article::with('category')->where('slug', $slug)->firstOrFail();

        $footerBanners = Banner::with(['sponsor', 'adZone'])
            ->where('is_active', true)
            ->whereHas('adZone', fn ($q) => $q->whereIn('slug', ['article-footer', 'home-mid']))
            ->get();

        $sidebarBanners = Banner::with(['sponsor', 'adZone'])
            ->where('is_active', true)
            ->whereHas('adZone', fn ($q) => $q->where('slug', 'sidebar'))
            ->get();

        $relatedArticles = Article::with('category')
            ->where('id', '!=', $article->id)
            ->orderByDesc('id')
            ->take(3)
            ->get();

        return view('portal.article', compact('article', 'footerBanners', 'sidebarBanners', 'relatedArticles'));
    }

    public function clickBanner(Request $request, Banner $banner)
    {
        $banner->increment('clicks_count');

        if ($request->boolean('stay')) {
            return back()->with('status', "Clic registrado en el banner de {$banner->sponsor->name} (Total: {$banner->clicks_count} clics).");
        }

        return redirect()->away($banner->target_url);
    }

    public function storeClaim(Request $request)
    {
        $validated = $request->validate([
            'neighbor_name' => 'required|string|max:120',
            'neighbor_phone' => 'nullable|string|max:60',
            'country_id' => 'required|exists:countries,id',
            'claim_type' => 'required|string|max:80',
            'description' => 'required|string|max:1000',
        ]);

        VecinalClaim::create($validated);

        return back()->with('status', 'Tu reclamo fue registrado en el tablero de Vecinal Norte y sumado a las estadísticas del corredor.');
    }

    public function storeClassified(Request $request)
    {
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'title' => 'required|string|max:200',
            'category_type' => 'required|string|max:100',
            'price_label' => 'nullable|string|max:100',
            'description' => 'required|string|max:1000',
            'contact_whatsapp' => 'required|string|max:60',
        ]);

        ClassifiedListing::create([
            'country_id' => $validated['country_id'],
            'title' => $validated['title'],
            'slug' => \Illuminate\Support\Str::slug($validated['title']) . '-' . \Illuminate\Support\Str::lower(\Illuminate\Support\Str::random(4)),
            'category_name' => $validated['category_type'],
            'price_label' => $validated['price_label'] ?: 'Consultar',
            'description' => $validated['description'],
            'features' => ['Publicado desde Zona Country', 'Trato Directo'],
            'image_path' => 'https://zonacountry.com.ar/wp-content/uploads/classified-listing/2026/08/c2ea3ac7-84c0-4b26-8b8a-53419f94629d-scaled-370x462.jpeg',
            'whatsapp_contact' => $validated['contact_whatsapp'],
            'is_featured' => true,
            'status' => 'active',
        ]);

        return back()->with('status', '¡Tu aviso fue publicado gratis y ya está visible en Propiedades & Clasificados de Zona Country!');
    }
}
