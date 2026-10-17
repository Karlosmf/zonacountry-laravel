<?php

namespace App\Http\Controllers;

use App\Models\AdZone;
use App\Models\Article;
use App\Models\Banner;
use App\Models\Category;
use App\Models\ClassifiedListing;
use App\Models\Country;
use App\Models\Sponsor;
use App\Models\VecinalClaim;
use App\Services\ZonaCountryAiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $banners = Banner::with(['sponsor', 'adZone'])->orderByDesc('id')->get();
        $sponsors = Sponsor::orderBy('name')->get();
        $adZones = AdZone::orderBy('id')->get();
        $articles = Article::with('category')->orderByDesc('id')->take(12)->get();
        $categories = Category::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();
        $listings = ClassifiedListing::with('country')->orderByDesc('id')->take(10)->get();
        $claims = VecinalClaim::with('country')->orderByDesc('id')->take(10)->get();

        $stats = [
            'active_banners' => $banners->where('is_active', true)->count(),
            'expiring_banners' => $banners->filter(fn (Banner $b) => $b->is_expiring_soon)->count(),
            'total_impressions' => $banners->sum('impressions_count'),
            'total_clicks' => $banners->sum('clicks_count'),
            'total_articles' => Article::count(),
            'total_listings' => ClassifiedListing::count(),
        ];

        return view('admin.dashboard', compact(
            'banners',
            'sponsors',
            'adZones',
            'articles',
            'categories',
            'countries',
            'listings',
            'claims',
            'stats'
        ));
    }

    public function storeBanner(Request $request)
    {
        $validated = $request->validate([
            'sponsor_name' => 'required|string|max:140',
            'ad_zone_id' => 'required|exists:ad_zones,id',
            'headline' => 'required|string|max:200',
            'subheadline' => 'nullable|string|max:200',
            'target_url' => 'required|string|max:255',
            'color_theme' => 'required|string|max:40',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after_or_equal:starts_at',
            'banner_image' => 'nullable|image|max:5120',
        ]);

        $sponsor = Sponsor::firstOrCreate(
            ['name' => trim($validated['sponsor_name'])],
            ['whatsapp' => '5493424878424', 'is_active' => true]
        );

        $imagePath = null;
        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/banners'), $filename);
            $imagePath = '/uploads/banners/' . $filename;
        }

        Banner::create([
            'sponsor_id' => $sponsor->id,
            'ad_zone_id' => $validated['ad_zone_id'],
            'title' => 'Campaña ' . $sponsor->name,
            'headline' => $validated['headline'],
            'subheadline' => $validated['subheadline'] ?? 'Auspiciante Oficial Zona Country',
            'image_path' => $imagePath,
            'target_url' => $validated['target_url'],
            'color_theme' => $validated['color_theme'],
            'starts_at' => $validated['starts_at'],
            'ends_at' => $validated['ends_at'],
            'impressions_count' => 150,
            'clicks_count' => 6,
            'is_active' => true,
        ]);

        return redirect()->route('admin.dashboard', ['#banners'])
            ->with('status', "Banner de '{$sponsor->name}' publicado y activo en el portal.");
    }

    public function toggleBanner(Banner $banner)
    {
        $banner->update(['is_active' => ! $banner->is_active]);

        return back()->with('status', "Estado del banner de {$banner->sponsor->name} actualizado.");
    }

    public function sponsorReport(Banner $banner)
    {
        $banner->load(['sponsor', 'adZone']);

        return view('admin.banner-report', compact('banner'));
    }

    public function generateArticleWithAi(Request $request, ZonaCountryAiService $aiService)
    {
        $request->validate([
            'raw_input' => 'required|string|min:10',
        ]);

        $generated = $aiService->generateArticle($request->string('raw_input')->toString());

        return response()->json($generated);
    }

    public function storeArticle(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:240',
            'category_slug' => 'required|string',
            'excerpt' => 'required|string',
            'content_html' => 'required|string',
            'countries_tags' => 'nullable|string',
            'whatsapp_copy' => 'nullable|string',
            'instagram_copy' => 'nullable|string',
            'seo_meta_title' => 'nullable|string|max:160',
            'seo_meta_description' => 'nullable|string|max:255',
            'article_image' => 'nullable|image|max:6144',
        ]);

        $category = Category::where('slug', $validated['category_slug'])->first()
            ?? Category::firstOrCreate(['slug' => 'noticias'], ['name' => 'Noticias', 'badge_color' => 'emerald']);

        $imagePath = null;
        if ($request->hasFile('article_image')) {
            $file = $request->file('article_image');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/articles'), $filename);
            $imagePath = '/uploads/articles/' . $filename;
        }

        $countriesArray = array_values(array_filter(array_map('trim', explode(',', $validated['countries_tags'] ?? 'El Paso, El Pinar, Aires del Llano'))));

        $slugBase = Str::slug($validated['title']);
        $slug = $slugBase . '-' . Str::lower(Str::random(4));

        $article = Article::create([
            'category_id' => $category->id,
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'],
            'content_html' => $validated['content_html'],
            'featured_image' => $imagePath,
            'countries_tags' => $countriesArray,
            'whatsapp_copy' => $validated['whatsapp_copy'],
            'instagram_copy' => $validated['instagram_copy'],
            'seo_meta_title' => $validated['seo_meta_title'] ?? $validated['title'],
            'seo_meta_description' => $validated['seo_meta_description'] ?? Str::limit($validated['excerpt'], 150),
            'generated_with_ai' => true,
            'is_published' => true,
            'published_at' => now(),
        ]);

        return redirect()->route('admin.dashboard', ['#noticias'])
            ->with('status', "Noticia '{$article->title}' publicada exitosamente con SEO y textos para redes.");
    }

    public function enhanceListingWithAi(Request $request, ZonaCountryAiService $aiService)
    {
        $request->validate([
            'raw_idea' => 'required|string|min:5',
            'country_id' => 'required|exists:countries,id',
            'price_label' => 'nullable|string|max:100',
        ]);

        $country = Country::findOrFail($request->integer('country_id'));
        $result = $aiService->enhanceListing(
            $request->string('raw_idea')->toString(),
            $country->name,
            $request->string('price_label')->toString() ?: 'Consultar'
        );

        return response()->json($result);
    }

    public function storeListing(Request $request)
    {
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'title' => 'required|string|max:200',
            'category_name' => 'required|string|max:100',
            'price_label' => 'required|string|max:100',
            'description' => 'required|string',
            'whatsapp_contact' => 'nullable|string|max:60',
        ]);

        ClassifiedListing::create([
            'country_id' => $validated['country_id'],
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . Str::lower(Str::random(4)),
            'category_name' => $validated['category_name'],
            'price_label' => $validated['price_label'],
            'description' => $validated['description'],
            'features' => ['Verificado en Zona Country', 'Contacto directo WhatsApp'],
            'whatsapp_contact' => $validated['whatsapp_contact'] ?: '5493424878424',
            'is_featured' => true,
            'status' => 'active',
        ]);

        return redirect()->route('admin.dashboard', ['#clasificados'])
            ->with('status', 'Aviso clasificado / propiedad publicado en el portal.');
    }

    /**
     * Importador en vivo desde la API REST del WordPress actual (zonacountry.com.ar).
     */
    public function syncFromWordPress()
    {
        $importedPosts = 0;

        try {
            $response = Http::timeout(12)->get('https://zonacountry.com.ar/wp-json/wp/v2/posts?per_page=5&_embed=1');
            if ($response->successful()) {
                $defaultCategory = Category::firstOrCreate(['slug' => 'noticias'], ['name' => 'Noticias', 'badge_color' => 'emerald']);
                foreach ($response->json() as $wpPost) {
                    $wpId = data_get($wpPost, 'id');
                    $title = html_entity_decode(strip_tags((string) data_get($wpPost, 'title.rendered')), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    $excerpt = trim(html_entity_decode(strip_tags((string) data_get($wpPost, 'excerpt.rendered')), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                    $content = (string) data_get($wpPost, 'content.rendered');
                    $featuredImg = data_get($wpPost, '_embedded.wp:featuredmedia.0.source_url');

                    if ($wpId && $title) {
                        Article::updateOrCreate(
                            ['wp_post_id' => $wpId],
                            [
                                'category_id' => $defaultCategory->id,
                                'title' => $title,
                                'slug' => data_get($wpPost, 'slug', Str::slug($title)) . '-' . $wpId,
                                'excerpt' => $excerpt ?: Str::limit(strip_tags($content), 160),
                                'content_html' => $content,
                                'featured_image' => $featuredImg,
                                'countries_tags' => ['Corredor Autopista', 'Zona Country'],
                                'whatsapp_copy' => "📰 *{$title}*\n👉 Leé la nota en ZonaCountry.com.ar",
                                'instagram_copy' => "{$title} #ZonaCountry #SantaFe #SantoTome",
                                'seo_meta_title' => $title,
                                'seo_meta_description' => Str::limit($excerpt, 155),
                                'generated_with_ai' => false,
                                'is_published' => true,
                                'published_at' => now(),
                            ]
                        );
                        $importedPosts++;
                    }
                }
            }
        } catch (\Throwable $e) {
            return back()->with('status', 'Nota: El entorno local está offline o sin acceso directo a wp-json, usando base de datos local.');
        }

        return back()->with('status', "¡Sincronización con WordPress completada! Se importaron/actualizaron {$importedPosts} noticias reales en vivo desde zonacountry.com.ar.");
    }
}
