<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->seo_meta_title ?: $article->title }} — Zona Country</title>
    <meta name="description" content="{{ $article->seo_meta_description ?: $article->excerpt }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @property --animation-reduced {
            syntax: "*";
            inherits: false;
            initial-value: none;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #eef5f0;
            color: #0f172a;
            overflow-x: hidden;
        }
        h1, h2, h3, .font-barlow {
            font-family: 'Barlow', sans-serif;
        }
        .ambient-orb {
            position: fixed;
            border-radius: 9999px;
            filter: blur(95px);
            pointer-events: none;
            z-index: 0;
            will-change: transform;
            animation: floatOrb 18s ease-in-out infinite alternate;
            --animation-reduced: none;
        }
        @keyframes floatOrb {
            0% { translate: 0px 0px; scale: 1; }
            100% { translate: 30px -25px; scale: 1.07; }
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.76);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.88);
            box-shadow: 0 14px 36px -8px rgba(6, 49, 21, 0.09), inset 0 1px 0 0 rgba(255, 255, 255, 0.9);
        }
        @supports (animation-timeline: scroll()) {
            .scroll-progress-bar {
                transform-origin: 0% 50%;
                animation: growProgress auto linear;
                animation-timeline: scroll(root block);
                --animation-reduced: none;
            }
            @keyframes growProgress {
                from { scale: 0 1; }
                to { scale: 1 1; }
            }
        }
        @media (prefers-reduced-motion: reduce) {
            * { animation: var(--animation-reduced) !important; }
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col relative">

    <div class="fixed top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#03963b] via-[#34d399] to-[#f59e0b] z-50 scroll-progress-bar"></div>
    <div class="ambient-orb w-[420px] h-[420px] bg-[#03963b]/20 -top-24 -left-24"></div>
    <div class="ambient-orb w-[460px] h-[460px] bg-[#10b981]/15 bottom-10 -right-24"></div>

    <!-- Topbar -->
    <div class="relative z-40 bg-[#041f0e]/90 backdrop-blur-xl text-white text-xs border-b border-white/15">
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 py-2.5 flex flex-wrap items-center justify-between gap-2">
            <a href="{{ route('portal.home') }}" class="font-bold text-[#a7f3d0] hover:text-white transition">← Volver a la Portada Glassmorphism de ZonaCountry</a>
            <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-1 rounded-full bg-gradient-to-r from-[#03963b] to-[#10b981] text-white font-barlow font-bold uppercase tracking-wider">⚙️ Panel de Autogestión Laravel + IA</a>
        </div>
    </div>

    <!-- Floating Glass Header -->
    <header class="sticky top-3 z-40 px-3 sm:px-6 mt-3">
        <div class="max-w-[1200px] mx-auto glass-panel rounded-2xl px-4 sm:px-6 py-3 flex items-center justify-between gap-4">
            <a href="{{ route('portal.home') }}" class="shrink-0">
                <img src="https://zonacountry.com.ar/wp-content/uploads/2024/07/zc-logo.png"
                     alt="Zona Country"
                     class="h-10 sm:h-11 w-auto object-contain">
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('portal.home') }}#novedades" class="text-sm font-barlow font-bold uppercase hover:text-[#03963b]">Últimas Novedades</a>
                <a href="{{ route('portal.home') }}#propiedades" class="hidden sm:inline-block text-sm font-barlow font-bold uppercase hover:text-[#03963b]">Propiedades</a>
                <a href="https://whatsapp.com/channel/0029Va9fP0vAInPlVhmGPm2u" target="_blank" rel="noopener"
                   class="px-4 py-2 rounded-xl bg-gradient-to-r from-[#03963b] to-[#04491f] text-white font-barlow font-bold uppercase text-xs tracking-wider shadow">
                    Canal WhatsApp
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 py-8 space-y-8 flex-1 relative z-10">
        <article class="glass-panel rounded-3xl p-6 sm:p-10 space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-2 text-xs">
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-xl bg-[#03963b] text-white font-barlow font-bold uppercase tracking-wider shadow-xs">
                        {{ $article->category->name ?? 'Actualidad' }}
                    </span>
                    @if($article->generated_with_ai)
                        <span class="px-3 py-1 rounded-xl bg-purple-500/15 text-purple-900 border border-purple-400/30 font-semibold">
                            ✨ Redactada y Optimizada con Laravel IA
                        </span>
                    @endif
                </div>
                <span class="text-slate-500 font-medium">{{ optional($article->published_at)->format('d/m/Y H:i') }}</span>
            </div>

            <h1 class="text-2xl sm:text-4xl font-barlow font-black text-slate-900 leading-tight">
                {{ $article->title }}
            </h1>

            <p class="text-base sm:text-lg text-slate-700 font-medium border-l-4 border-[#03963b] pl-4">
                {{ $article->excerpt }}
            </p>

            @if($article->featured_image)
                <div class="rounded-2xl overflow-hidden shadow-lg border border-white/60">
                    <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="w-full max-h-[480px] object-cover">
                </div>
            @endif

            <div class="prose max-w-none text-slate-800 space-y-4 leading-relaxed text-base">
                {!! $article->content_html !!}
            </div>

            <!-- Etiquetas de Countries -->
            <div class="flex flex-wrap items-center gap-2 pt-5 border-t border-emerald-900/10">
                <span class="text-xs font-bold uppercase text-slate-500">Countries vinculados:</span>
                @foreach(($article->countries_tags ?? []) as $tag)
                    <span class="px-3 py-1 rounded-xl bg-[#03963b]/10 text-[#063115] text-xs font-bold">📍 {{ $tag }}</span>
                @endforeach
            </div>

            <!-- Cajas de Difusión Generadas por IA -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-5 border-t border-emerald-900/10">
                <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/25 space-y-1.5">
                    <span class="text-xs font-barlow font-extrabold uppercase tracking-wide text-[#063115]">📲 Copy Automático para Canal de Difusión WhatsApp</span>
                    <p class="text-xs text-slate-800 whitespace-pre-line">{{ $article->whatsapp_copy }}</p>
                </div>
                <div class="p-4 rounded-2xl bg-white/60 border border-white/80 space-y-1.5">
                    <span class="text-xs font-barlow font-extrabold uppercase tracking-wide text-slate-800">📸 Copy Automático para Instagram</span>
                    <p class="text-xs text-slate-600 whitespace-pre-line">{{ $article->instagram_copy }}</p>
                </div>
            </div>
        </article>
    </main>

    <footer class="bg-[#041f0e] text-white py-8 border-t border-white/10 relative z-10">
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 flex flex-wrap items-center justify-between gap-4 text-xs text-emerald-100/70">
            <img src="https://zonacountry.com.ar/wp-content/uploads/2024/07/zc-logo-w.png" alt="Zona Country" class="h-8 w-auto">
            <span>© {{ date('Y') }} ZonaCountry.com.ar · Propuesta Glassmorphism & Motion (Laravel + IA)</span>
        </div>
    </footer>
</body>
</html>
