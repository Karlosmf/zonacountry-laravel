<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona Country — Propuesta Rediseño Glassmorphism & Motion (Laravel + IA)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,500;0,600;0,700;0,800;0,900;1,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --zc-green: #03963b;
            --zc-green-bright: #10b981;
            --zc-dark-green: #063115;
            --zc-deep: #041f0e;
        }

        /* Registered custom property for accessible reduced motion per modern-web-guidance */
        @property --animation-reduced {
            syntax: "*";
            inherits: false;
            initial-value: none;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            transition: background-color 0.45s cubic-bezier(0.22, 1, 0.36, 1), color 0.45s cubic-bezier(0.22, 1, 0.36, 1);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, .font-barlow {
            font-family: 'Barlow', sans-serif;
        }

        /* =========================================================
           MODO GLASS DÍA (DEFAULT) Y MODO GLASS NOCTURNO ESMERALDA
           ========================================================= */
        body.theme-light {
            background-color: #eef5f0;
            color: #0f172a;
        }
        body.theme-dark {
            background-color: #03150a;
            color: #f1f5f9;
        }

        /* Orbes ambientales animados en compositor (opacity + translate/scale) */
        .ambient-orb {
            position: fixed;
            border-radius: 9999px;
            filter: blur(95px);
            pointer-events: none;
            z-index: 0;
            will-change: transform, opacity;
            animation: floatOrb 18s ease-in-out infinite alternate;
            --animation-reduced: none;
        }
        .ambient-orb-2 {
            animation-duration: 24s;
            animation-direction: alternate-reverse;
        }
        @keyframes floatOrb {
            0% {
                translate: 0px 0px;
                scale: 1;
            }
            50% {
                translate: 35px -28px;
                scale: 1.08;
            }
            100% {
                translate: -25px 25px;
                scale: 0.95;
            }
        }

        /* =========================================================
           SISTEMA DE CAPAS GLASSMORPHISM (BORDES ESPECULARES + BLUR)
           ========================================================= */
        .glass-panel {
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            transition: translate 0.35s cubic-bezier(0.22, 1, 0.36, 1),
                        scale 0.35s cubic-bezier(0.22, 1, 0.36, 1),
                        box-shadow 0.35s cubic-bezier(0.22, 1, 0.36, 1),
                        border-color 0.35s ease,
                        background-color 0.35s ease;
        }

        body.theme-light .glass-panel {
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(255, 255, 255, 0.88);
            box-shadow:
                0 12px 32px -8px rgba(6, 49, 21, 0.08),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.9);
        }

        body.theme-dark .glass-panel {
            background: rgba(9, 42, 22, 0.55);
            border: 1px solid rgba(167, 243, 208, 0.16);
            box-shadow:
                0 16px 40px -10px rgba(0, 0, 0, 0.55),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.14);
        }

        /* Tarjetas interactivas con elevación y reflejo especular */
        .glass-card-hover {
            position: relative;
            overflow: hidden;
        }
        .glass-card-hover::before {
            content: "";
            position: absolute;
            top: 0;
            left: -120%;
            width: 65%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.28),
                transparent
            );
            transform: skewX(-20deg);
            transition: translate 0.7s cubic-bezier(0.22, 1, 0.36, 1);
            pointer-events: none;
            z-index: 10;
        }
        .glass-card-hover:hover {
            translate: 0px -6px;
        }
        .glass-card-hover:hover::before {
            translate: 360% 0;
        }
        body.theme-light .glass-card-hover:hover {
            border-color: rgba(3, 150, 59, 0.45);
            box-shadow:
                0 22px 45px -12px rgba(3, 150, 59, 0.16),
                inset 0 1px 0 0 rgba(255, 255, 255, 1);
        }
        body.theme-dark .glass-card-hover:hover {
            border-color: rgba(16, 185, 129, 0.55);
            box-shadow:
                0 22px 48px -12px rgba(3, 150, 59, 0.32),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.25);
        }

        /* Propiedades Destacadas Glass Warm */
        body.theme-light .glass-featured-prop {
            background: linear-gradient(145deg, rgba(255, 251, 245, 0.88), rgba(255, 244, 229, 0.75));
            border: 1px solid rgba(251, 191, 36, 0.45);
        }
        body.theme-dark .glass-featured-prop {
            background: linear-gradient(145deg, rgba(28, 37, 24, 0.78), rgba(14, 48, 26, 0.65));
            border: 1px solid rgba(251, 191, 36, 0.35);
        }

        /* Zoom suave de imágenes en compositor */
        .img-zoom {
            transition: scale 0.6s cubic-bezier(0.22, 1, 0.36, 1);
            will-change: transform;
        }
        .group:hover .img-zoom {
            scale: 1.06;
        }

        /* =========================================================
           SCROLL-DRIVEN ANIMATIONS (CSS NATIVO SIN LISTENERS JS)
           ========================================================= */
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

        @supports (animation-timeline: view()) {
            .reveal-on-scroll {
                animation: glassReveal linear both;
                animation-timeline: view();
                animation-range: entry 8% cover 24%;
                --animation-reduced: none;
            }
            @keyframes glassReveal {
                from {
                    opacity: 0.15;
                    translate: 0 28px;
                    scale: 0.97;
                }
                to {
                    opacity: 1;
                    translate: 0 0;
                    scale: 1;
                }
            }
        }

        /* Entrada inicial escalonada */
        .fade-up-enter {
            animation: fadeUpEnter 0.7s cubic-bezier(0.22, 1, 0.36, 1) both;
            --animation-reduced: none;
        }
        @keyframes fadeUpEnter {
            from {
                opacity: 0;
                translate: 0 20px;
            }
            to {
                opacity: 1;
                translate: 0 0;
            }
        }

        /* Pulso suave en vivo */
        .live-dot {
            animation: pulseDot 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            --animation-reduced: none;
        }
        @keyframes pulseDot {
            0%, 100% { opacity: 1; scale: 1; }
            50% { opacity: 0.45; scale: 1.25; }
        }

        /* Accesibilidad prefers-reduced-motion siguiendo modern-web-guidance */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation: var(--animation-reduced) !important;
            }
            .glass-card-hover,
            .img-zoom {
                transition: none !important;
            }
        }
    </style>
</head>
<body class="theme-light antialiased min-h-screen flex flex-col relative selection:bg-[#03963b] selection:text-white">

    <!-- Barra de progreso de lectura nativa con Scroll-Driven Animations -->
    <div class="fixed top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#03963b] via-[#34d399] to-[#f59e0b] z-50 scroll-progress-bar"></div>

    <!-- Orbes Ambientales para dar profundidad real al Glassmorphism -->
    <div class="ambient-orb w-[440px] h-[440px] bg-[#03963b]/20 -top-24 -left-24"></div>
    <div class="ambient-orb ambient-orb-2 w-[500px] h-[500px] bg-[#10b981]/15 top-[38%] -right-36"></div>
    <div class="ambient-orb w-[380px] h-[380px] bg-amber-400/10 bottom-16 left-[18%]"></div>

    <!-- ========================================================= -->
    <!-- BARRA FLOTANTE SUPERIOR: DEMO AUTOGESTIÓN + MODO VISUAL    -->
    <!-- ========================================================= -->
    <div class="relative z-40 bg-[#041f0e]/90 backdrop-blur-xl text-white text-xs border-b border-white/15">
        <div class="max-w-[1320px] mx-auto px-4 sm:px-6 py-2.5 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-[#34d399] live-dot"></span>
                <span class="font-barlow font-bold uppercase tracking-wider text-[#a7f3d0]">Propuesta Visual 2026:</span>
                <span class="text-white/90 hidden sm:inline">Glassmorphism Esmeralda + Micro-Animaciones 60fps + Laravel IA</span>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <!-- Toggle Día / Noche Glass -->
                <button type="button"
                        onclick="toggleGlassTheme()"
                        id="theme-toggle-btn"
                        class="px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold transition flex items-center gap-1.5 cursor-pointer">
                    <span id="theme-toggle-icon">🌙</span>
                    <span id="theme-toggle-text">Probar Modo Glass Nocturno</span>
                </button>

                <a href="{{ route('admin.dashboard') }}#banners"
                   class="px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 border border-white/15 text-white font-semibold transition">
                    🎯 Cargar Banner
                </a>
                <a href="{{ route('admin.dashboard') }}#noticias-ia"
                   class="px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 border border-white/15 text-white font-semibold transition">
                    ✨ Redactar con IA
                </a>
                <a href="{{ route('admin.dashboard') }}"
                   class="px-3.5 py-1 rounded-full bg-gradient-to-r from-[#03963b] to-[#10b981] hover:brightness-110 text-white font-barlow font-bold uppercase tracking-wider shadow-lg shadow-[#03963b]/30 transition">
                    ⚙️ Abrir Backoffice →
                </a>
            </div>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- CABECERA STICKY GLASSMORPHISM (FLOATING DOCK)             -->
    <!-- ========================================================= -->
    <header class="sticky top-3 z-40 px-3 sm:px-6 mt-3">
        <div class="max-w-[1320px] mx-auto glass-panel rounded-2xl px-4 sm:px-6 py-3 flex flex-wrap items-center justify-between gap-4">
            <!-- Logos Oficiales -->
            <a href="{{ route('portal.home') }}" class="flex items-center gap-3 shrink-0 group">
                <img id="brand-logo-light"
                     src="https://zonacountry.com.ar/wp-content/uploads/2024/07/zc-logo.png"
                     alt="Zona Country"
                     class="h-10 sm:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                <img id="brand-logo-dark"
                     src="https://zonacountry.com.ar/wp-content/uploads/2024/07/zc-logo-w.png"
                     alt="Zona Country"
                     class="h-10 sm:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105 hidden">
            </a>

            <!-- Navegación con Píldoras Glass -->
            <nav class="hidden lg:flex items-center gap-1 font-barlow text-[15px] font-bold uppercase tracking-wide">
                <a href="#novedades" class="px-3.5 py-2 rounded-xl text-[#03963b] bg-[#03963b]/10 transition">Noticias</a>
                <a href="#propiedades" class="px-3.5 py-2 rounded-xl hover:bg-[#03963b]/10 hover:text-[#03963b] transition">Propiedades</a>
                <a href="#auspiciantes" class="px-3.5 py-2 rounded-xl hover:bg-[#03963b]/10 hover:text-[#03963b] transition">Servicios</a>
                <a href="#propiedades" class="px-3.5 py-2 rounded-xl hover:bg-[#03963b]/10 hover:text-[#03963b] transition">Clasificados</a>
                <a href="#vecinal" class="px-3.5 py-2 rounded-xl hover:bg-[#03963b]/10 hover:text-[#03963b] transition">Vecinal</a>
                <a href="#colectivos" class="px-3.5 py-2 rounded-xl hover:bg-[#03963b]/10 hover:text-[#03963b] transition">Colectivos</a>
                <a href="#publicar-gratis" class="px-3.5 py-2 rounded-xl hover:bg-[#03963b]/10 hover:text-[#03963b] transition">Contacto</a>
            </nav>

            <!-- Botones de Acción -->
            <div class="flex items-center gap-2.5">
                <a href="#publicar-gratis"
                   class="glass-card-hover px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#03963b] to-[#04491f] text-white font-barlow font-extrabold uppercase text-xs sm:text-sm tracking-wider shadow-lg shadow-[#03963b]/25 flex items-center gap-1.5">
                    <span>＋ Publicá Gratis</span>
                </a>
            </div>
        </div>
    </header>

    @if(session('status'))
        <div class="max-w-[1320px] mx-auto px-4 sm:px-6 pt-4 relative z-20">
            <div class="glass-panel border-l-4 border-l-[#03963b] px-5 py-3.5 rounded-2xl flex items-center justify-between text-sm font-medium fade-up-enter">
                <span class="flex items-center gap-2">✨ {{ session('status') }}</span>
                <a href="{{ route('admin.dashboard') }}" class="text-[#03963b] font-bold underline text-xs">Ver métricas en el Panel →</a>
            </div>
        </div>
    @endif

    <!-- ========================================================= -->
    <!-- 1. HERO SLIDER PUBLICITARIO CON HUD GLASSMORPHISM          -->
    <!-- ========================================================= -->
    <section class="max-w-[1320px] mx-auto px-4 sm:px-6 pt-5 pb-3 w-full relative z-10 fade-up-enter">
        @if($heroBanners->isNotEmpty())
            <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-white/30 group"
                 id="zc-hero-slider"
                 onmouseenter="hoverPauseSlider(true)"
                 onmouseleave="hoverPauseSlider(false)">

                @foreach($heroBanners as $idx => $banner)
                    <div class="hero-slide {{ $idx === 0 ? 'block' : 'hidden' }} relative">
                        <a href="{{ route('portal.banner.click', ['banner' => $banner->id, 'stay' => 1]) }}"
                           class="block relative overflow-hidden">
                            @if($banner->desktop_image)
                                <img src="{{ $banner->desktop_image }}"
                                     alt="{{ $banner->headline }}"
                                     class="w-full h-[250px] sm:h-[400px] md:h-[470px] object-cover img-zoom">
                            @endif

                            <!-- Gradiente cinematográfico -->
                            <div class="absolute inset-0 bg-gradient-to-t from-[#03150a]/90 via-[#03150a]/25 to-transparent"></div>

                            <!-- Tarjeta Flotante Glassmorphism (HUD del Auspiciante) -->
                            <div class="absolute bottom-4 left-4 right-4 sm:bottom-7 sm:left-7 sm:right-auto sm:max-w-xl rounded-2xl p-4 sm:p-6 backdrop-blur-xl bg-black/45 border border-white/25 text-white shadow-2xl">
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    <span class="px-2.5 py-0.5 rounded-full bg-[#03963b] text-white text-[11px] font-barlow font-extrabold uppercase tracking-wider shadow">
                                        Auspiciante Destacado
                                    </span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-white/15 border border-white/20 text-white/90 text-[11px] font-medium">
                                        {{ $banner->sponsor->name }}
                                    </span>
                                    <span class="text-[11px] text-emerald-300 font-semibold ml-auto">
                                        👁️ {{ number_format($banner->impressions_count, 0, ',', '.') }} vistas
                                    </span>
                                </div>
                                <h2 class="text-lg sm:text-2xl font-barlow font-black uppercase tracking-tight leading-tight text-white">
                                    {{ $banner->headline }}
                                </h2>
                                @if($banner->subheadline)
                                    <p class="text-xs sm:text-sm text-white/80 mt-1 line-clamp-2">
                                        {{ $banner->subheadline }}
                                    </p>
                                @endif
                                <div class="mt-3 flex items-center gap-3">
                                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-xl bg-white text-[#063115] font-barlow font-extrabold uppercase text-xs tracking-wider shadow hover:bg-emerald-50 transition">
                                        Conocer más →
                                    </span>
                                    <span class="text-[11px] text-white/70">Autogestionado desde Laravel Admin</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

                @if($heroBanners->count() > 1)
                    <!-- Controles Glassmorphism (Accesibles con botón Pausa según modern-web-guidance) -->
                    <div class="absolute top-4 right-4 flex items-center gap-2 z-20">
                        <button type="button"
                                onclick="toggleSliderPlayPause()"
                                id="slider-pause-btn"
                                aria-label="Pausar o reanudar carrusel"
                                class="px-3 py-1.5 rounded-full backdrop-blur-xl bg-black/45 hover:bg-[#03963b] text-white border border-white/25 text-xs font-barlow font-bold uppercase tracking-wider transition cursor-pointer flex items-center gap-1.5">
                            <span id="slider-pause-icon">⏸</span>
                            <span id="slider-pause-label" class="hidden sm:inline">Pausar</span>
                        </button>
                    </div>

                    <button type="button" onclick="prevHeroSlide()" aria-label="Anterior"
                            class="absolute left-3 sm:left-5 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-12 sm:h-12 rounded-full backdrop-blur-xl bg-black/40 hover:bg-[#03963b] text-white border border-white/25 flex items-center justify-center text-xl font-bold transition shadow-lg cursor-pointer">
                        ‹
                    </button>
                    <button type="button" onclick="nextHeroSlide()" aria-label="Siguiente"
                            class="absolute right-3 sm:right-5 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-12 sm:h-12 rounded-full backdrop-blur-xl bg-black/40 hover:bg-[#03963b] text-white border border-white/25 flex items-center justify-center text-xl font-bold transition shadow-lg cursor-pointer">
                        ›
                    </button>

                    <!-- Indicadores Glass -->
                    <div class="absolute bottom-4 right-5 hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full backdrop-blur-xl bg-black/40 border border-white/20">
                        @foreach($heroBanners as $idx => $b)
                            <button type="button" onclick="goToHeroSlide({{ $idx }})"
                                    aria-label="Ir al banner {{ $idx + 1 }}"
                                    class="hero-dot h-2.5 rounded-full transition-all cursor-pointer {{ $idx === 0 ? 'bg-[#34d399] w-7' : 'bg-white/50 w-2.5 hover:bg-white' }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </section>

    <!-- ========================================================= -->
    <!-- 2. BANNER DIFUSIÓN WHATSAPP CON CÁPSULA GLASS              -->
    <!-- ========================================================= -->
    <section class="max-w-[1320px] mx-auto px-4 sm:px-6 py-3 w-full relative z-10">
        <div class="relative rounded-3xl overflow-hidden shadow-xl border border-emerald-400/30"
             style="background-image: url('https://zonacountry.com.ar/wp-content/uploads/2024/07/zc-bg-green-alt-1.jpg'); background-size: cover; background-position: center;">
            <div class="bg-gradient-to-r from-[#063115]/90 via-[#03963b]/85 to-[#063115]/90 backdrop-blur-xs px-6 py-6 sm:py-7 flex flex-col md:flex-row items-center justify-between gap-5">
                <div class="flex items-center gap-4 text-center md:text-left">
                    <div class="hidden sm:flex w-14 h-14 rounded-2xl backdrop-blur-xl bg-white/15 border border-white/30 items-center justify-center text-2xl shadow-inner shrink-0">
                        📲
                    </div>
                    <div>
                        <span class="px-2.5 py-0.5 rounded-full bg-white/15 border border-white/25 text-[11px] font-barlow font-bold uppercase tracking-widest text-emerald-200">
                            Comunidad en Tiempo Real · +11 Barrios Privados
                        </span>
                        <h3 class="text-white font-barlow font-black text-xl sm:text-2xl uppercase tracking-wide mt-1">
                            Sumate al Canal de Difusión en WhatsApp y recibí las novedades en tu celular
                        </h3>
                    </div>
                </div>
                <a href="https://whatsapp.com/channel/0029Va9fP0vAInPlVhmGPm2u"
                   target="_blank" rel="noopener"
                   class="glass-card-hover shrink-0 px-6 py-3.5 rounded-2xl backdrop-blur-xl bg-white text-[#063115] font-barlow font-black uppercase text-sm tracking-wider shadow-xl flex items-center gap-2">
                    <span>Unirme al Canal Oficial</span>
                    <span class="text-lg">→</span>
                </a>
            </div>
        </div>
    </section>

    <!-- ========================================================= -->
    <!-- 3. PROPIEDADES EN ZC (TARJETAS GLASS + FILTRO INTERACTIVO) -->
    <!-- ========================================================= -->
    <section id="propiedades" class="max-w-[1320px] mx-auto px-4 sm:px-6 pt-8 pb-6 w-full relative z-10 reveal-on-scroll">
        <div class="glass-panel rounded-3xl p-5 sm:p-7">
            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-emerald-500/20 pb-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#03963b] to-[#063115] text-white flex items-center justify-center text-xl shadow-md shadow-[#03963b]/25">
                        🏡
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-2xl sm:text-3xl font-barlow font-black uppercase tracking-tight">
                                Propiedades en ZC
                            </h2>
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-500/15 text-amber-600 dark:text-amber-300 border border-amber-500/30 text-xs font-barlow font-bold uppercase">
                                Destacadas
                            </span>
                        </div>
                        <p class="text-xs opacity-70">Oportunidades inmobiliarias verificadas en la autopista Santa Fe – Santo Tomé</p>
                    </div>
                </div>

                <!-- Filtro por Country en Píldora Glass -->
                <div class="flex flex-wrap items-center gap-2">
                    <form method="GET" action="{{ route('portal.home') }}" class="flex items-center gap-2">
                        <select name="country" onchange="this.form.submit()"
                                class="text-xs font-semibold rounded-xl px-3.5 py-2.5 bg-white/80 dark:bg-black/40 border border-emerald-500/30 text-slate-800 dark:text-white focus:outline-hidden focus:ring-2 focus:ring-[#03963b]">
                            <option value="">📍 Todos los Countries (11)</option>
                            @foreach($countries as $c)
                                <option value="{{ $c->slug }}" {{ $selectedCountry === $c->slug ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                        @if($selectedCountry)
                            <a href="{{ route('portal.home') }}" class="text-xs text-[#03963b] font-bold underline">Ver todos</a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Grilla de 4 Columnas con Tarjetas Glass -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($listings->take(4) as $item)
                    <div class="glass-panel glass-featured-prop glass-card-hover rounded-2xl overflow-hidden flex flex-col justify-between group">
                        <div>
                            <div class="relative h-52 overflow-hidden bg-gray-900">
                                @if($item->image_path ?? $item->image_url)
                                    <img src="{{ $item->image_path ?? $item->image_url }}"
                                         alt="{{ $item->title }}"
                                         class="w-full h-full object-cover img-zoom">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/20"></div>

                                <!-- Badges Flotantes en Cristal Esmerilado -->
                                <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                                    <span class="px-2.5 py-1 rounded-lg backdrop-blur-md bg-[#03963b]/90 text-white text-[11px] font-barlow font-extrabold uppercase tracking-wider shadow">
                                        {{ $item->category_name ?? $item->category_type ?? 'Propiedades' }}
                                    </span>
                                    @if($item->is_featured)
                                        <span class="px-2.5 py-1 rounded-lg backdrop-blur-md bg-amber-400/95 text-slate-950 text-[11px] font-barlow font-extrabold uppercase tracking-wider shadow">
                                            ★ Destacado
                                        </span>
                                    @endif
                                </div>

                                <!-- Precio sobre cristal en la base de la foto -->
                                <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between">
                                    <span class="px-3 py-1 rounded-xl backdrop-blur-md bg-black/55 border border-white/20 text-white font-barlow font-black text-base tracking-tight">
                                        {{ $item->price_label ?: 'Consultar' }}
                                    </span>
                                    <span class="px-2.5 py-1 rounded-lg backdrop-blur-md bg-white/20 border border-white/25 text-white text-[11px] font-semibold">
                                        📍 {{ $item->country->name ?? 'Zona Country' }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-4 space-y-2">
                                <h3 class="font-barlow font-bold text-base leading-snug group-hover:text-[#03963b] transition line-clamp-2">
                                    {{ $item->title }}
                                </h3>
                                <p class="text-xs opacity-75 line-clamp-2 leading-relaxed">
                                    {{ $item->description }}
                                </p>
                            </div>
                        </div>

                        <div class="px-4 pb-4 pt-2 flex items-center justify-between border-t border-black/5 dark:border-white/10">
                            <span class="text-[11px] font-medium opacity-60">Trato directo</span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->whatsapp_contact ?? $item->contact_whatsapp ?: '5493425299114') }}?text={{ urlencode('Hola! Vi su publicación en ZonaCountry.com.ar: ' . $item->title) }}"
                               target="_blank" rel="noopener"
                               class="px-3.5 py-1.5 rounded-xl bg-[#03963b] hover:bg-[#04491f] text-white text-xs font-barlow font-bold uppercase tracking-wider transition shadow-sm">
                                Consultar WhatsApp →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ========================================================= -->
    <!-- 4. BLOQUE CENTRAL: ÚLTIMAS NOVEDADES (3/4) + BANNERS (1/4) -->
    <!-- ========================================================= -->
    <main id="novedades" class="max-w-[1320px] mx-auto px-4 sm:px-6 py-6 w-full flex-1 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- COLUMNA 3/4 (9 cols): ÚLTIMAS NOVEDADES -->
            <div class="lg:col-span-9 space-y-6">
                <div class="glass-panel rounded-2xl px-5 py-4 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-8 rounded-full bg-gradient-to-b from-[#03963b] to-[#10b981]"></span>
                        <div>
                            <h2 class="text-2xl sm:text-3xl font-barlow font-black uppercase tracking-tight">
                                Últimas Novedades
                            </h2>
                            <p class="text-xs opacity-70">Periodismo hiperlocal del corredor de countries Santa Fe – Santo Tomé</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.dashboard') }}#noticias-ia"
                       class="px-3.5 py-2 rounded-xl bg-[#03963b]/15 hover:bg-[#03963b] text-[#03963b] hover:text-white border border-[#03963b]/30 text-xs font-barlow font-extrabold uppercase tracking-wider transition">
                        ✨ Redactar Nueva Nota con IA →
                    </a>
                </div>

                <!-- Noticia Principal Destacada (Editorial Hero Card) -->
                @if($featuredArticle)
                    <article class="glass-panel glass-card-hover rounded-3xl overflow-hidden group reveal-on-scroll">
                        <div class="grid grid-cols-1 md:grid-cols-12">
                            <a href="{{ route('portal.article', $featuredArticle->slug) }}" class="md:col-span-7 relative h-64 sm:h-80 md:h-full overflow-hidden bg-gray-900 block">
                                @if($featuredArticle->featured_image)
                                    <img src="{{ $featuredArticle->featured_image }}"
                                         alt="{{ $featuredArticle->title }}"
                                         class="w-full h-full object-cover img-zoom">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                <div class="absolute top-4 left-4 flex items-center gap-2">
                                    <span class="px-3 py-1 rounded-xl backdrop-blur-md bg-[#03963b]/90 text-white text-xs font-barlow font-extrabold uppercase tracking-wider shadow">
                                        {{ $featuredArticle->category->name ?? 'Actualidad' }}
                                    </span>
                                    @if($featuredArticle->generated_with_ai)
                                        <span class="px-2.5 py-1 rounded-xl backdrop-blur-md bg-purple-600/85 text-white text-[11px] font-bold">
                                            ✨ Optimizado con IA
                                        </span>
                                    @endif
                                </div>
                            </a>

                            <div class="md:col-span-5 p-6 sm:p-7 flex flex-col justify-between space-y-4">
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2 text-xs opacity-65 font-medium">
                                        <span>📅 {{ optional($featuredArticle->published_at)->format('d/m/Y') }}</span>
                                        <span>•</span>
                                        <span>👁️ {{ number_format($featuredArticle->views_count, 0, ',', '.') }} lecturas</span>
                                    </div>
                                    <h3 class="font-barlow font-black text-xl sm:text-2xl leading-tight group-hover:text-[#03963b] transition">
                                        <a href="{{ route('portal.article', $featuredArticle->slug) }}">
                                            {{ $featuredArticle->title }}
                                        </a>
                                    </h3>
                                    <p class="text-xs sm:text-sm opacity-80 leading-relaxed line-clamp-4">
                                        {{ $featuredArticle->excerpt }}
                                    </p>
                                </div>

                                <div class="pt-4 border-t border-black/5 dark:border-white/10 flex flex-wrap items-center justify-between gap-2">
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach(array_slice($featuredArticle->countries_tags ?? [], 0, 2) as $tag)
                                            <span class="px-2.5 py-0.5 rounded-lg bg-[#03963b]/10 text-[#03963b] text-[11px] font-semibold">
                                                📍 {{ $tag }}
                                            </span>
                                        @endforeach
                                    </div>
                                    <a href="{{ route('portal.article', $featuredArticle->slug) }}"
                                       class="inline-flex items-center gap-1 text-xs font-barlow font-extrabold uppercase tracking-wider text-[#03963b] group-hover:translate-x-1 transition-transform">
                                        Leer crónica completa →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                @endif

                <!-- Grilla de Noticias Recientes en Tarjetas Glass -->
                @php
                    $gridArticles = collect([$featuredArticle])->merge($latestArticles)->filter()->unique('id')->slice(1);
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($gridArticles as $article)
                        <article class="glass-panel glass-card-hover rounded-2xl overflow-hidden flex flex-col justify-between group reveal-on-scroll">
                            <div>
                                <a href="{{ route('portal.article', $article->slug) }}" class="block relative h-52 overflow-hidden bg-gray-900">
                                    @if($article->featured_image)
                                        <img src="{{ $article->featured_image }}"
                                             alt="{{ $article->title }}"
                                             class="w-full h-full object-cover img-zoom">
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/65 via-transparent to-transparent"></div>

                                    <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg backdrop-blur-md bg-[#03963b]/90 text-white text-[11px] font-barlow font-bold uppercase tracking-wider shadow">
                                        {{ $article->category->name ?? 'Actualidad' }}
                                    </span>

                                    @if($article->generated_with_ai)
                                        <span class="absolute top-3 right-3 px-2 py-0.5 rounded-lg backdrop-blur-md bg-black/55 border border-white/25 text-emerald-300 text-[10px] font-bold">
                                            ✨ IA SEO
                                        </span>
                                    @endif
                                </a>

                                <div class="p-5 space-y-2.5">
                                    <h3 class="font-barlow font-extrabold text-lg leading-snug group-hover:text-[#03963b] transition">
                                        <a href="{{ route('portal.article', $article->slug) }}">
                                            {{ $article->title }}
                                        </a>
                                    </h3>
                                    <p class="text-xs opacity-75 line-clamp-3 leading-relaxed">
                                        {{ $article->excerpt }}
                                    </p>
                                </div>
                            </div>

                            <div class="px-5 pb-4 pt-3 border-t border-black/5 dark:border-white/10 flex items-center justify-between text-xs">
                                <span class="opacity-60">{{ optional($article->published_at)->format('d/m/Y') }}</span>
                                <a href="{{ route('portal.article', $article->slug) }}"
                                   class="font-barlow font-extrabold uppercase text-[#03963b] tracking-wider group-hover:translate-x-1 transition-transform">
                                    Leer más →
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- BANNER INTERMEDIO DE NOTICIAS (IN-FEED) EN CÁPSULA GLASS -->
                @if($infeedBanners->isNotEmpty())
                    <div class="pt-2 space-y-3 reveal-on-scroll">
                        @foreach($infeedBanners as $banner)
                            <a href="{{ route('portal.banner.click', ['banner' => $banner->id, 'stay' => 1]) }}"
                               class="glass-panel glass-card-hover block rounded-2xl overflow-hidden group">
                                @if($banner->desktop_image)
                                    <div class="relative">
                                        <img src="{{ $banner->desktop_image }}" alt="{{ $banner->headline }}" class="w-full max-h-56 object-cover img-zoom">
                                        <span class="absolute top-3 right-3 px-2.5 py-1 rounded-lg backdrop-blur-md bg-black/60 text-white text-[10px] font-barlow font-bold uppercase tracking-wider">
                                            Espacio Publicitario · {{ $banner->sponsor->name }}
                                        </span>
                                    </div>
                                @endif
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- COLUMNA 1/4 (3 cols): SIDEBAR GLASS DE AUSPICIANTES -->
            <aside id="auspiciantes" class="lg:col-span-3 space-y-5 lg:sticky lg:top-24">
                <div class="glass-panel rounded-2xl p-4 space-y-4">
                    <div class="flex items-center justify-between border-b border-emerald-500/20 pb-2.5">
                        <span class="text-xs font-barlow font-extrabold uppercase tracking-wider text-[#03963b]">
                            🎯 Espacio Publicitario
                        </span>
                        <a href="{{ route('admin.dashboard') }}#banners" class="text-[11px] font-bold underline opacity-75 hover:opacity-100">
                            + Subir Banner
                        </a>
                    </div>

                    <div class="space-y-4">
                        @foreach($sidebarBanners as $banner)
                            <div class="glass-card-hover rounded-2xl overflow-hidden border border-white/40 dark:border-white/10 shadow-md group bg-white/40 dark:bg-black/30">
                                <a href="{{ route('portal.banner.click', ['banner' => $banner->id, 'stay' => 1]) }}" class="block relative overflow-hidden">
                                    @if($banner->desktop_image)
                                        <img src="{{ $banner->desktop_image }}"
                                             alt="{{ $banner->headline }}"
                                             class="w-full h-auto object-cover img-zoom">
                                    @endif
                                </a>
                                <div class="px-3 py-2 flex items-center justify-between text-[11px] opacity-75">
                                    <span class="font-bold truncate">{{ $banner->sponsor->name }}</span>
                                    <span class="text-[#03963b] font-semibold">👁️ {{ number_format($banner->impressions_count, 0, ',', '.') }} · 🖱️ {{ $banner->clicks_count }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Mini Widget de Autogestión para el Cliente -->
                    <div class="rounded-2xl p-4 bg-gradient-to-br from-[#063115] to-[#03963b] text-white space-y-2 shadow-lg">
                        <span class="px-2 py-0.5 rounded bg-white/15 text-[10px] font-barlow font-bold uppercase tracking-widest">
                            Ventaja Laravel + IA
                        </span>
                        <h4 class="font-barlow font-extrabold text-base uppercase leading-tight">
                            ¿Nuevo Auspiciante en Zona Country?
                        </h4>
                        <p class="text-xs text-white/85 leading-relaxed">
                            Subí el GIF o JPG desde tu celular, definí fecha de vencimiento y enviá el reporte de clics por WhatsApp en 1 clic.
                        </p>
                        <a href="{{ route('admin.dashboard') }}#banners"
                           class="inline-block w-full text-center py-2 rounded-xl bg-white text-[#063115] font-barlow font-extrabold uppercase text-xs tracking-wider shadow hover:bg-emerald-50 transition">
                            Probar Carga de Banner →
                        </a>
                    </div>
                </div>
            </aside>

        </div>
    </main>

    <!-- ========================================================= -->
    <!-- 5. FRANJA VERDE GLASS «PUBLICÁ GRATIS EN ZONA COUNTRY»     -->
    <!-- ========================================================= -->
    <section id="publicar-gratis" class="max-w-[1320px] mx-auto px-4 sm:px-6 py-6 w-full relative z-10 reveal-on-scroll">
        <div class="rounded-3xl overflow-hidden shadow-2xl border border-emerald-400/30"
             style="background-image: url('https://zonacountry.com.ar/wp-content/uploads/2024/07/zc-bg-green-alt-1.jpg'); background-size: cover; background-position: center;">
            <div class="bg-[#063115]/88 backdrop-blur-md p-6 sm:p-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-5 text-white space-y-3">
                    <span class="px-3 py-1 rounded-full bg-white/15 border border-white/25 text-xs font-barlow font-bold uppercase tracking-wider text-emerald-200">
                        Clasificados & Inmuebles · Autogestión
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-barlow font-black uppercase tracking-tight leading-none">
                        Publicá Gratis en Zona Country
                    </h2>
                    <p class="text-sm text-white/85 leading-relaxed">
                        ¿Tenés una propiedad en alquiler/venta o brindás servicios profesionales en los countries de la autopista? Completá el formulario y aparecé al instante en la portada.
                    </p>
                </div>

                <form action="{{ route('portal.classifieds.store') }}" method="POST"
                      class="lg:col-span-7 rounded-2xl p-5 sm:p-6 backdrop-blur-xl bg-white/90 dark:bg-black/65 border border-white/40 shadow-2xl grid grid-cols-1 sm:grid-cols-2 gap-3.5 text-slate-900 dark:text-white">
                    @csrf
                    <div>
                        <label class="block text-xs font-barlow font-bold uppercase mb-1">Título del Aviso</label>
                        <input type="text" name="title" required placeholder="Ej: Casa 3 dormitorios con pileta..."
                               class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-white dark:bg-slate-900 border border-gray-300 dark:border-white/20">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-barlow font-bold uppercase mb-1">Rubro</label>
                            <select name="category_type" class="w-full px-3 py-2.5 rounded-xl text-xs bg-white dark:bg-slate-900 border border-gray-300 dark:border-white/20">
                                <option value="Alquileres">Alquileres</option>
                                <option value="Venta">Venta</option>
                                <option value="Terrenos">Terrenos</option>
                                <option value="Servicios">Servicios</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-barlow font-bold uppercase mb-1">Country</label>
                            <select name="country_id" class="w-full px-3 py-2.5 rounded-xl text-xs bg-white dark:bg-slate-900 border border-gray-300 dark:border-white/20">
                                @foreach($countries as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-barlow font-bold uppercase mb-1">Precio (U$D / $)</label>
                        <input type="text" name="price_label" placeholder="Ej: U$D 185.000 o Consultar"
                               class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-white dark:bg-slate-900 border border-gray-300 dark:border-white/20">
                    </div>
                    <div>
                        <label class="block text-xs font-barlow font-bold uppercase mb-1">WhatsApp de Contacto</label>
                        <input type="text" name="contact_whatsapp" required placeholder="Ej: 3425123456"
                               class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-white dark:bg-slate-900 border border-gray-300 dark:border-white/20">
                    </div>
                    <div class="sm:col-span-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <input type="text" name="description" required placeholder="Breve descripción de comodidades, lote o servicio..."
                               class="flex-1 px-3.5 py-2.5 rounded-xl text-xs bg-white dark:bg-slate-900 border border-gray-300 dark:border-white/20">
                        <button type="submit"
                                class="px-6 py-2.5 rounded-xl bg-[#03963b] hover:bg-[#04491f] text-white font-barlow font-extrabold uppercase text-xs tracking-wider transition cursor-pointer shrink-0 shadow-lg">
                            Publicar Ahora →
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- ========================================================= -->
    <!-- 6. SERVICIOS ÚTILES: COLECTIVOS + VECINAL ZONA COUNTRIES   -->
    <!-- ========================================================= -->
    <section class="max-w-[1320px] mx-auto px-4 sm:px-6 py-6 w-full relative z-10 reveal-on-scroll">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Horarios de Colectivos -->
            <div id="colectivos" class="lg:col-span-6 glass-panel rounded-3xl p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-emerald-500/20 pb-3">
                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-2xl bg-[#03963b]/15 text-[#03963b] flex items-center justify-center text-xl">🚌</span>
                        <div>
                            <h3 class="text-xl font-barlow font-black uppercase">Horarios de Colectivos</h3>
                            <p class="text-xs opacity-70">Frecuencias directas Corredor Autopista – Centro Santa Fe</p>
                        </div>
                    </div>
                    <div class="flex gap-1.5">
                        <button type="button" onclick="filterBus('habil')" id="btn-bus-habil"
                                class="px-3 py-1 rounded-xl bg-[#03963b] text-white text-xs font-barlow font-bold uppercase cursor-pointer">
                            Lunes a Viernes
                        </button>
                        <button type="button" onclick="filterBus('finde')" id="btn-bus-finde"
                                class="px-3 py-1 rounded-xl bg-black/5 dark:bg-white/10 text-xs font-barlow font-bold uppercase cursor-pointer">
                            Sáb / Dom
                        </button>
                    </div>
                </div>

                <div class="space-y-2.5">
                    @foreach($busSchedules as $bus)
                        <div class="bus-item {{ $bus['type'] === 'finde' ? 'hidden' : '' }} flex items-center justify-between p-3.5 rounded-2xl bg-white/50 dark:bg-black/30 border border-black/5 dark:border-white/10"
                             data-bus-type="{{ $bus['type'] }}">
                            <div>
                                <span class="text-xs font-barlow font-extrabold uppercase text-[#03963b]">{{ $bus['line'] }}</span>
                                <p class="text-xs opacity-80 mt-0.5">{{ $bus['route'] }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-xl bg-[#063115] text-white font-barlow font-extrabold text-sm">
                                {{ $bus['departure'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Vecinal Zona de Countries -->
            <div id="vecinal" class="lg:col-span-6 glass-panel rounded-3xl p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-emerald-500/20 pb-3">
                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-2xl bg-[#03963b]/15 text-[#03963b] flex items-center justify-center text-xl">🏛️</span>
                        <div>
                            <h3 class="text-xl font-barlow font-black uppercase">Vecinal Zona de Countries</h3>
                            <p class="text-xs opacity-70">Seguimiento de gestiones viales, seguridad y luminarias</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-2.5">
                    @foreach($claims as $claim)
                        <div class="p-3.5 rounded-2xl bg-white/50 dark:bg-black/30 border border-black/5 dark:border-white/10 flex items-center justify-between gap-3">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-[#03963b]">📍 {{ $claim->country->name ?? 'Autopista' }}</span>
                                    <span class="text-[11px] opacity-60">· {{ $claim->claim_type ?? $claim->category }}</span>
                                </div>
                                <p class="text-xs font-semibold mt-0.5">{{ $claim->description ?? $claim->title }}</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-barlow font-bold uppercase shrink-0 {{ ($claim->status === 'Resuelto' || $claim->status === 'resuelto') ? 'bg-emerald-500/20 text-emerald-700 dark:text-emerald-300' : 'bg-amber-500/20 text-amber-700 dark:text-amber-300' }}">
                                {{ $claim->status === 'en_gestion' ? 'En Gestión' : $claim->status }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

    <!-- ========================================================= -->
    <!-- 7. FOOTER INSTITUCIONAL GLASS                              -->
    <!-- ========================================================= -->
    <footer class="bg-[#041f0e] text-white mt-10 border-t border-white/10 relative z-10">
        <div class="max-w-[1320px] mx-auto px-4 sm:px-6 py-10 grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
            <div class="md:col-span-5 space-y-3">
                <img src="https://zonacountry.com.ar/wp-content/uploads/2024/07/zc-logo-w.png"
                     alt="Zona Country"
                     class="h-10 w-auto object-contain">
                <p class="text-xs text-emerald-100/70 leading-relaxed max-w-sm">
                    El portal de noticias, negocios inmobiliarios y servicios de la comunidad de countries de la Autopista Santa Fe – Santo Tomé.
                </p>
            </div>
            <div class="md:col-span-4 space-y-1.5 text-xs text-emerald-100/75">
                <p class="font-barlow font-bold uppercase text-white tracking-wider">Cobertura Hiperlocal</p>
                <p>El Paso · Aires del Llano · Los Molinos · La Tatenguita · Las Delicias · El Pinar · Altos de la Ribera · Las Almenas · Ubajay</p>
            </div>
            <div class="md:col-span-3 flex md:justify-end">
                <a href="{{ route('admin.dashboard') }}"
                   class="px-5 py-3 rounded-2xl bg-gradient-to-r from-[#03963b] to-[#10b981] text-white font-barlow font-extrabold uppercase text-xs tracking-wider shadow-lg">
                    ⚙️ Panel Autogestión Laravel →
                </a>
            </div>
        </div>
    </footer>

    <!-- Botón Flotante WhatsApp con Halo Glass -->
    <a href="https://whatsapp.com/channel/0029Va9fP0vAInPlVhmGPm2u"
       target="_blank" rel="noopener"
       class="fixed bottom-5 right-5 z-50 px-4 py-3 rounded-full backdrop-blur-xl bg-[#03963b]/90 hover:bg-[#01963a] text-white border border-white/30 shadow-2xl flex items-center gap-2 text-xs font-barlow font-extrabold uppercase tracking-wider transition hover:scale-105">
        <span class="w-2.5 h-2.5 rounded-full bg-white live-dot"></span>
        <span>Canal WhatsApp ZC</span>
    </a>

    <!-- Scripts del Slider Accesible, Filtro de Colectivos y Modo Glass Día/Noche -->
    <script>
        let currentHeroSlide = 0;
        let sliderPaused = false;
        let hoverPaused = false;
        const heroSlides = document.querySelectorAll('.hero-slide');
        const heroDots = document.querySelectorAll('.hero-dot');

        function showHeroSlide(index) {
            if (!heroSlides.length) return;
            currentHeroSlide = (index + heroSlides.length) % heroSlides.length;
            heroSlides.forEach((slide, i) => {
                slide.classList.toggle('block', i === currentHeroSlide);
                slide.classList.toggle('hidden', i !== currentHeroSlide);
            });
            heroDots.forEach((dot, i) => {
                if (i === currentHeroSlide) {
                    dot.className = 'hero-dot h-2.5 rounded-full transition-all cursor-pointer bg-[#34d399] w-7';
                } else {
                    dot.className = 'hero-dot h-2.5 rounded-full transition-all cursor-pointer bg-white/50 w-2.5 hover:bg-white';
                }
            });
        }

        function nextHeroSlide() { showHeroSlide(currentHeroSlide + 1); }
        function prevHeroSlide() { showHeroSlide(currentHeroSlide - 1); }
        function goToHeroSlide(i) { showHeroSlide(i); }

        function hoverPauseSlider(state) {
            hoverPaused = state;
        }

        function toggleSliderPlayPause() {
            sliderPaused = !sliderPaused;
            const icon = document.getElementById('slider-pause-icon');
            const label = document.getElementById('slider-pause-label');
            if (icon) icon.textContent = sliderPaused ? '▶' : '⏸';
            if (label) label.textContent = sliderPaused ? 'Reanudar' : 'Pausar';
        }

        if (heroSlides.length > 1) {
            setInterval(() => {
                if (!sliderPaused && !hoverPaused) {
                    nextHeroSlide();
                }
            }, 5500);
        }

        function filterBus(type) {
            document.querySelectorAll('.bus-item').forEach(el => {
                el.classList.toggle('hidden', el.dataset.busType !== type);
            });
            const btnHabil = document.getElementById('btn-bus-habil');
            const btnFinde = document.getElementById('btn-bus-finde');
            if (type === 'habil') {
                btnHabil.className = 'px-3 py-1 rounded-xl bg-[#03963b] text-white text-xs font-barlow font-bold uppercase cursor-pointer';
                btnFinde.className = 'px-3 py-1 rounded-xl bg-black/5 dark:bg-white/10 text-xs font-barlow font-bold uppercase cursor-pointer';
            } else {
                btnFinde.className = 'px-3 py-1 rounded-xl bg-[#03963b] text-white text-xs font-barlow font-bold uppercase cursor-pointer';
                btnHabil.className = 'px-3 py-1 rounded-xl bg-black/5 dark:bg-white/10 text-xs font-barlow font-bold uppercase cursor-pointer';
            }
        }

        function toggleGlassTheme() {
            const body = document.body;
            const isLight = body.classList.contains('theme-light');
            body.classList.toggle('theme-light', !isLight);
            body.classList.toggle('theme-dark', isLight);

            const logoLight = document.getElementById('brand-logo-light');
            const logoDark = document.getElementById('brand-logo-dark');
            const icon = document.getElementById('theme-toggle-icon');
            const text = document.getElementById('theme-toggle-text');

            if (isLight) {
                logoLight.classList.add('hidden');
                logoDark.classList.remove('hidden');
                icon.textContent = '☀️';
                text.textContent = 'Volver a Glass Día';
            } else {
                logoDark.classList.add('hidden');
                logoLight.classList.remove('hidden');
                icon.textContent = '🌙';
                text.textContent = 'Probar Modo Glass Nocturno';
            }
        }
    </script>
</body>
</html>
