<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Autogestión Laravel + IA — ZonaCountry.com.ar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-barlow { font-family: 'Barlow', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 antialiased min-h-screen">

    <!-- Cabecera del Backoffice de Autogestión con identidad real de Zona Country -->
    <header class="bg-[#063115] text-white sticky top-0 z-40 shadow-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3.5 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('portal.home') }}" class="shrink-0">
                    <img src="https://zonacountry.com.ar/wp-content/uploads/2024/07/zc-logo-w.png"
                         alt="Zona Country"
                         class="h-10 w-auto object-contain">
                </a>
                <div class="border-l border-white/20 pl-4">
                    <div class="flex items-center gap-2">
                        <h1 class="font-barlow font-extrabold uppercase tracking-wide text-base sm:text-lg">Panel de Autogestión Zona Country</h1>
                        <span class="px-2.5 py-0.5 rounded bg-[#03963b] text-white text-xs font-barlow font-bold uppercase">
                            Laravel + IA Local
                        </span>
                    </div>
                    <p class="text-xs text-emerald-200/80">Administración centralizada de Banners Publicitarios, Noticias con IA y Clasificados</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <form action="{{ route('admin.sync.wp') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="px-3 py-2 rounded bg-white/10 hover:bg-white/20 border border-white/20 text-xs font-barlow font-bold uppercase tracking-wide text-white transition">
                        🔄 Importar Últimas Notas desde WordPress (wp-json)
                    </button>
                </form>

                <a href="{{ route('portal.home') }}"
                   class="px-4 py-2 rounded bg-[#03963b] hover:bg-[#01963a] text-white text-xs font-barlow font-extrabold uppercase tracking-wide transition shadow">
                    🌐 Ver Portal Público en Vivo →
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-6 space-y-8">

        @if(session('status'))
            <div class="bg-emerald-700 text-white px-4 py-3.5 rounded-xl shadow flex flex-wrap items-center justify-between gap-2 text-sm font-semibold">
                <span>✅ {{ session('status') }}</span>
                <a href="{{ route('portal.home') }}" class="underline text-xs font-bold">Ver resultado en la Portada →</a>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-600 text-white px-4 py-3 rounded-xl text-xs space-y-1">
                @foreach($errors->all() as $err)
                    <p>• {{ $err }}</p>
                @endforeach
            </div>
        @endif

        <!-- KPIs DE NEGOCIO Y AUTOGESTIÓN -->
        <section class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-xs">
                <p class="text-xs text-slate-500 font-semibold">Banners Activos</p>
                <p class="text-2xl font-black text-slate-900 mt-1">{{ $stats['active_banners'] }}</p>
                <p class="text-xs text-emerald-700 font-medium mt-0.5">Unificados en 1 panel</p>
            </div>
            <div class="bg-white border border-amber-400 rounded-xl p-4 shadow-xs">
                <p class="text-xs text-amber-700 font-bold">⚠️ Pautas por Vencer</p>
                <p class="text-2xl font-black text-slate-900 mt-1">{{ $stats['expiring_banners'] }}</p>
                <p class="text-xs text-slate-500 mt-0.5">Próximos 7 días</p>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-xs">
                <p class="text-xs text-slate-500 font-semibold">Impresiones Reales</p>
                <p class="text-2xl font-black text-emerald-700 mt-1">{{ number_format($stats['total_impressions'], 0, ',', '.') }}</p>
                <p class="text-xs text-slate-500 mt-0.5">Vistas auditadas</p>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-xs">
                <p class="text-xs text-slate-500 font-semibold">Clics a Auspiciantes</p>
                <p class="text-2xl font-black text-emerald-700 mt-1">{{ number_format($stats['total_clicks'], 0, ',', '.') }}</p>
                <p class="text-xs text-slate-500 mt-0.5">Web y WhatsApp</p>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-xs">
                <p class="text-xs text-slate-500 font-semibold">Noticias Publicadas</p>
                <p class="text-2xl font-black text-slate-900 mt-1">{{ $stats['total_articles'] }}</p>
                <p class="text-xs text-purple-700 font-medium mt-0.5">Con SEO + Redes IA</p>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-xs">
                <p class="text-xs text-slate-500 font-semibold">Clasificados Activos</p>
                <p class="text-2xl font-black text-slate-900 mt-1">{{ $stats['total_listings'] }}</p>
                <p class="text-xs text-slate-500 mt-0.5">11 Countries</p>
            </div>
        </section>

        <!-- ========================================================= -->
        <!-- MÓDULO 1: AUTOGESTIÓN DE BANNERS Y REPORTES A CLIENTES     -->
        <!-- ========================================================= -->
        <section id="banners" class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Formulario de Carga en 1 Clic -->
            <div class="lg:col-span-5 bg-white border border-slate-200 rounded-2xl p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-200 pb-3">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">Módulo Estrella 1</span>
                    <h2 class="text-lg font-extrabold text-slate-900 mt-1">🎯 Subir o Programar Banner Publicitario</h2>
                    <p class="text-xs text-slate-500">Elegí el auspiciante, la zona del sitio y las fechas de vigencia. Se adapta solo a PC y Móvil.</p>
                </div>

                <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3.5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Auspiciante / Marca</label>
                        <input type="text" name="sponsor_name" required list="sponsors-list"
                               placeholder="Ej: Sanatorio Santa Fe, Pilay, Clínica..."
                               value="Clínica de Diagnóstico Country"
                               class="w-full px-3 py-2 rounded-lg text-sm bg-slate-50 border border-slate-300">
                        <datalist id="sponsors-list">
                            @foreach($sponsors as $sp)
                                <option value="{{ $sp->name }}"></option>
                            @endforeach
                        </datalist>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Zona Publicitaria del Portal</label>
                        <select name="ad_zone_id" required class="w-full px-3 py-2 rounded-lg text-sm bg-slate-50 border border-slate-300">
                            @foreach($adZones as $zone)
                                <option value="{{ $zone->id }}">{{ $zone->name }} ({{ $zone->dimensions_label }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Titular / Promoción Principal del Banner</label>
                        <input type="text" name="headline" required
                               value="Turnos Médicos por WhatsApp sin Espera — A 5 min de la Autopista"
                               class="w-full px-3 py-2 rounded-lg text-sm bg-slate-50 border border-slate-300">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Subtítulo o Bajada Comercial (Opcional)</label>
                        <input type="text" name="subheadline"
                               value="Atención todas las obras sociales y prepagas · Estacionamiento propio"
                               class="w-full px-3 py-2 rounded-lg text-xs bg-slate-50 border border-slate-300">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Enlace Web o WhatsApp Destino</label>
                            <input type="text" name="target_url" required value="https://wa.me/5493424878424"
                                   class="w-full px-3 py-2 rounded-lg text-xs bg-slate-50 border border-slate-300">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Estilo Visual</label>
                            <select name="color_theme" class="w-full px-3 py-2 rounded-lg text-xs bg-slate-50 border border-slate-300">
                                <option value="emerald">Verde Country / Salud</option>
                                <option value="blue">Azul Corporativo / Inmuebles</option>
                                <option value="amber">Naranja / Supermercados &amp; Retail</option>
                                <option value="purple">Violeta /Desarrollos &amp; Loteos</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Inicio de Pauta</label>
                            <input type="date" name="starts_at" required value="{{ now()->toDateString() }}"
                                   class="w-full px-3 py-2 rounded-lg text-xs bg-slate-50 border border-slate-300">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Fin de Pauta (Vencimiento)</label>
                            <input type="date" name="ends_at" required value="{{ now()->addMonth()->toDateString() }}"
                                   class="w-full px-3 py-2 rounded-lg text-xs bg-slate-50 border border-slate-300">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Imagen / GIF del Banner (Opcional: sube archivo real)</label>
                        <input type="file" name="banner_image" accept="image/*"
                               class="w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    </div>

                    <button type="submit"
                            class="w-full py-3 px-4 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-extrabold text-sm shadow transition">
                        🚀 Publicar Banner en el Portal y Activar Métricas
                    </button>
                </form>
            </div>

            <!-- Listado de Banners Activos + Botón Reporte PDF Cliente -->
            <div class="lg:col-span-7 bg-white border border-slate-200 rounded-2xl p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-200 pb-3 flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900">📊 Pautas Publicitarias y Reportes para Auspiciantes</h2>
                        <p class="text-xs text-slate-500">Hacé clic en <strong>"📄 Reporte PDF Cliente"</strong> para abrir el informe con membrete listo para enviar por WhatsApp.</p>
                    </div>
                </div>

                <div class="space-y-3">
                    @foreach($banners as $banner)
                        <div class="p-4 rounded-xl border {{ $banner->is_expiring_soon ? 'border-amber-400 bg-amber-50/40' : 'border-slate-200 bg-slate-50' }} flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="space-y-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="font-extrabold text-sm text-slate-900">{{ $banner->sponsor->name }}</span>
                                    @if(!$banner->is_active)
                                        <span class="px-2 py-0.5 rounded-full bg-slate-200 text-slate-700 text-xs font-bold">Pausado</span>
                                    @elseif($banner->is_expiring_soon)
                                        <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-300 text-xs font-bold">
                                            ⚠️ Vence en {{ $banner->days_remaining }} días ({{ $banner->ends_at->format('d/m/Y') }})
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">
                                            ✓ Vigente hasta {{ $banner->ends_at->format('d/m/Y') }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-600 font-medium">
                                    📍 <strong>{{ $banner->adZone->name }}</strong>
                                </p>
                                <p class="text-xs text-slate-500 italic">"{{ $banner->headline }}"</p>
                            </div>

                            <div class="flex items-center gap-3 self-end sm:self-center">
                                <div class="text-right">
                                    <p class="text-xs font-extrabold text-slate-900">👁️ {{ number_format($banner->impressions_count, 0, ',', '.') }} vistas</p>
                                    <p class="text-xs font-bold text-emerald-700">👆 {{ $banner->clicks_count }} clics (CTR {{ $banner->ctr }}%)</p>
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <a href="{{ route('admin.banners.report', $banner->id) }}" target="_blank"
                                       class="px-3 py-1.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold text-center whitespace-nowrap shadow-xs">
                                        📄 Reporte PDF Cliente
                                    </a>
                                    <form action="{{ route('admin.banners.toggle', $banner->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full px-2.5 py-1 rounded border border-slate-300 bg-white hover:bg-slate-100 text-xs font-semibold text-slate-700">
                                            {{ $banner->is_active ? 'Pausar' : 'Activar' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ========================================================= -->
        <!-- MÓDULO 2: REDACTOR DE NOTICIAS CON LARAVEL IA              -->
        <!-- ========================================================= -->
        <section id="noticias" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs space-y-6">
            <div class="border-b border-slate-200 pb-4 flex flex-wrap items-center justify-between gap-2">
                <div>
                    <span class="px-2.5 py-0.5 rounded-full bg-purple-100 text-purple-800 text-xs font-bold">Módulo Estrella 2 · Laravel IA</span>
                    <h2 class="text-xl font-extrabold text-slate-900 mt-1">✨ Redactor Inteligente de Noticias + SEO + Copys para Redes</h2>
                    <p class="text-xs text-slate-500">Pegá la transcripción de un audio de WhatsApp, una gacetilla municipal o dos renglones y la IA redacta toda la nota lista para publicar.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Columna Izquierda: Entrada en Bruto para la IA -->
                <div class="lg:col-span-5 space-y-4 bg-slate-50 p-5 rounded-xl border border-slate-200">
                    <label class="block text-xs font-bold text-slate-700">1. Probá con un caso real de Zona Country o escribí tu propio punteo:</label>
                    <div class="space-y-2">
                        <button type="button" onclick="loadRawPreset('vecinal')"
                                class="w-full text-left p-2.5 rounded-lg bg-white border border-slate-300 hover:border-emerald-600 text-xs flex items-center justify-between">
                            <span>🎙️ <strong>Audio WhatsApp:</strong> 45 Luminarias LED y lectoras de patentes (Vecinal Norte)</span>
                            <span class="text-emerald-700 font-bold">Cargar →</span>
                        </button>
                        <button type="button" onclick="loadRawPreset('torneo')"
                                class="w-full text-left p-2.5 rounded-lg bg-white border border-slate-300 hover:border-emerald-600 text-xs flex items-center justify-between">
                            <span>🏆 <strong>Nota Deportiva:</strong> Torneo Intercountries en Club de Campo El Paso</span>
                            <span class="text-emerald-700 font-bold">Cargar →</span>
                        </button>
                        <button type="button" onclick="loadRawPreset('municipal')"
                                class="w-full text-left p-2.5 rounded-lg bg-white border border-slate-300 hover:border-emerald-600 text-xs flex items-center justify-between">
                            <span>📄 <strong>Gacetilla Municipal:</strong> Nuevo cronograma de recolección de poda</span>
                            <span class="text-emerald-700 font-bold">Cargar →</span>
                        </button>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Material en bruto (Audio transcripto / Gacetilla / Punteo):</label>
                        <textarea id="ai-raw-input" rows="6"
                                  class="w-full p-3 rounded-lg text-xs sm:text-sm bg-white border border-slate-300">Audio de WhatsApp recibido: "Hola Joaquín, hoy nos reunimos desde Vecinal Norte con autoridades provinciales y municipales por las luminarias LED en la colectora entre Aires del Llano, El Pinar y Dos Lagunas. Confirmaron que la próxima semana instalan 45 artefactos LED nuevos y cámaras lectoras de patentes en los accesos."</textarea>
                    </div>

                    <button type="button" id="btn-run-ai" onclick="runLaravelAiArticleGenerator()"
                            class="w-full py-3 px-4 rounded-xl bg-purple-700 hover:bg-purple-800 text-white font-extrabold text-sm shadow transition">
                        ✨ Redactar Noticia + SEO + Copys con Laravel IA
                    </button>
                </div>

                <!-- Columna Derecha: Formulario Autocompletado por la IA listo para Guardar en SQLite -->
                <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="lg:col-span-7 space-y-3.5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Categoría Sugerida por IA</label>
                            <select id="form-category-slug" name="category_slug" class="w-full px-3 py-2 rounded-lg text-xs font-bold bg-slate-50 border border-slate-300">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Countries Detectados en el Texto</label>
                            <input type="text" id="form-countries-tags" name="countries_tags"
                                   value="Aires del Llano, Club de Campo El Pinar, Dos Lagunas"
                                   class="w-full px-3 py-2 rounded-lg text-xs font-semibold bg-slate-50 border border-slate-300">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Titular Periodístico</label>
                        <input type="text" id="form-title" name="title" required
                               value="Vecinal Norte: confirman la instalación de 45 nuevas luminarias LED y lectoras de patentes en colectora"
                               class="w-full px-3 py-2 rounded-lg text-sm font-extrabold bg-slate-50 border border-slate-300">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Bajada / Copete Resumen</label>
                        <textarea id="form-excerpt" name="excerpt" rows="2" required
                                  class="w-full p-2.5 rounded-lg text-xs bg-slate-50 border border-slate-300">Tras gestiones de la Asociación Civil Vecinal Norte ante autoridades provinciales y municipales, las obras comenzarán la próxima semana en el corredor de Aires del Llano, El Pinar y Dos Lagunas.</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Cuerpo HTML de la Noticia</label>
                        <textarea id="form-content-html" name="content_html" rows="5" required
                                  class="w-full p-3 rounded-lg text-xs bg-slate-50 border border-slate-300"><p>Importantes avances en materia de infraestructura vial y prevención comunitaria para el corredor de countries de la <strong>Autopista Santa Fe–Rosario</strong>.</p><h3>Recambio lumínico y anillo digital en accesos</h3><p>La próxima semana comenzará el operativo de colocación de 45 nuevos artefactos de iluminación LED sobre la colectora, abarcando Aires del Llano, El Pinar y Dos Lagunas, junto con nuevas cámaras lectoras de patentes.</p></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-emerald-800 mb-1">📲 Copy Generado para Canal de WhatsApp</label>
                            <textarea id="form-wa-copy" name="whatsapp_copy" rows="3"
                                      class="w-full p-2.5 rounded-lg text-xs bg-emerald-50 border border-emerald-200">🚨 *NUEVAS LUMINARIAS LED Y CÁMARAS EN LA ZONA DE COUNTRIES* 💡📹 La próxima semana instalan 45 artefactos LED y lectoras de patentes en colectora. 👉 Leé la nota en ZonaCountry.com.ar</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">📸 Copy + Hashtags para Instagram</label>
                            <textarea id="form-ig-copy" name="instagram_copy" rows="3"
                                      class="w-full p-2.5 rounded-lg text-xs bg-slate-50 border border-slate-300">Avanza la seguridad e iluminación vial en el corredor de la Autopista ✨ Vecinal Norte confirmó la colocación de 45 luminarias LED. #ZonaCountry #VecinalNorte #SantoTome</textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-center pt-1">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Título SEO Google</label>
                            <input type="text" id="form-seo-title" name="seo_meta_title"
                                   value="Vecinal Norte: 45 nuevas luminarias LED | Zona Country"
                                   class="w-full px-2.5 py-1.5 rounded-lg text-xs bg-slate-50 border border-slate-300">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Foto Destacada (Opcional)</label>
                            <input type="file" name="article_image" accept="image/*" class="w-full text-xs">
                        </div>
                        <div class="pt-4">
                            <button type="submit"
                                    class="w-full py-2.5 px-4 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-extrabold text-xs sm:text-sm shadow transition">
                                🌐 Publicar Noticia en el Portal
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- ========================================================= -->
        <!-- MÓDULO 3: CLASIFICADOS Y ZC INMUEBLES ASISTIDOS POR IA     -->
        <!-- ========================================================= -->
        <section id="clasificados" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs space-y-4">
            <div class="border-b border-slate-200 pb-3">
                <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 text-xs font-bold">Módulo 3 · Clasificados &amp; ZC Inmuebles</span>
                <h2 class="text-lg font-extrabold text-slate-900 mt-1">🏡 Carga de Avisos e Inmuebles Asistida por IA</h2>
                <p class="text-xs text-slate-500">Escribí una idea corta en 1 renglón, presioná <strong>"✨ Redactar Aviso con IA"</strong> y publicalo en la guía clasificada.</p>
            </div>

            <form action="{{ route('admin.listings.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">
                @csrf
                <div class="lg:col-span-4">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Idea rápida del vecino o inmobiliaria</label>
                    <input type="text" id="listing-raw-idea"
                           value="Vendo casa 3 dormitorios con pileta y quincho en El Pinar lote 800m2"
                           class="w-full px-3 py-2 rounded-lg text-xs bg-slate-50 border border-slate-300">
                </div>
                <div class="lg:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Country / Ubicación</label>
                    <select id="listing-country-id" name="country_id" class="w-full px-3 py-2 rounded-lg text-xs bg-slate-50 border border-slate-300">
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="lg:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Precio / Modalidad</label>
                    <input type="text" id="listing-price" name="price_label" value="Consultar (ZC Inmuebles)"
                           class="w-full px-3 py-2 rounded-lg text-xs bg-slate-50 border border-slate-300">
                </div>
                <div class="lg:col-span-3">
                    <button type="button" onclick="runLaravelAiListingEnhancer()"
                            class="w-full py-2 px-3 rounded-lg bg-purple-700 hover:bg-purple-800 text-white text-xs font-bold">
                        ✨ Redactar Aviso con IA
                    </button>
                </div>

                <div class="lg:col-span-5">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Título Comercial Generado</label>
                    <input type="text" id="listing-title" name="title" required
                           value="Destacada Propiedad en Club de Campo El Pinar: Casa 3 dormitorios con piscina"
                           class="w-full px-3 py-2 rounded-lg text-xs font-bold bg-slate-50 border border-slate-300">
                </div>
                <div class="lg:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Rubro Clasificado</label>
                    <input type="text" id="listing-category" name="category_name" required
                           value="Propiedades · ZC Inmuebles"
                           class="w-full px-3 py-2 rounded-lg text-xs bg-slate-50 border border-slate-300">
                </div>
                <div class="lg:col-span-4">
                    <label class="block text-xs font-bold text-slate-700 mb-1">WhatsApp del Anunciante</label>
                    <input type="text" name="whatsapp_contact" value="5493424878424"
                           class="w-full px-3 py-2 rounded-lg text-xs bg-slate-50 border border-slate-300">
                </div>

                <div class="lg:col-span-9">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Descripción Completa del Aviso</label>
                    <textarea id="listing-description" name="description" rows="2" required
                              class="w-full p-2.5 rounded-lg text-xs bg-slate-50 border border-slate-300">Excelente propiedad desarrollada sobre lote de 800 m² con 3 dormitorios, piscina y quincho. Publicación verificada en Zona Country.</textarea>
                </div>
                <div class="lg:col-span-3">
                    <button type="submit" class="w-full py-3 px-4 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-extrabold text-xs shadow">
                        🏡 Publicar Aviso Clasificado
                    </button>
                </div>
            </form>
        </section>

    </main>

    <script>
        const rawPresets = {
            vecinal: 'Audio de WhatsApp recibido (01:14 min): "Hola Joaquín, hoy nos reunimos desde Vecinal Norte con autoridades provinciales y municipales por las luminarias LED en la colectora entre Aires del Llano, El Pinar y Dos Lagunas. Confirmaron que la próxima semana instalan 45 artefactos LED nuevos y cámaras lectoras de patentes en los accesos."',
            torneo: 'Punteo rápido: "Este sábado y domingo desde las 9 hs se juega el Torneo Intercountries de Pádel y Tenis Copa Primavera en las canchas del Club de Campo El Paso. Participan más de 80 parejas de El Pinar, Dos Lagunas, Aires del Llano y Altos de la Ribera con patio gastronómico."',
            municipal: 'Gacetilla Municipal: "La Municipalidad de Santo Tomé informa el nuevo cronograma de recolección de restos de poda y residuos verdes para los countries El Paso, El Pinar, La Tatenguita, Aires del Llano, Dos Lagunas y Santomás de lunes a jueves."'
        };

        function loadRawPreset(key) {
            document.getElementById('ai-raw-input').value = rawPresets[key] || '';
            runLaravelAiArticleGenerator();
        }

        async function runLaravelAiArticleGenerator() {
            const btn = document.getElementById('btn-run-ai');
            const rawInput = document.getElementById('ai-raw-input').value;
            btn.textContent = '⏳ Redactando en servidor Laravel IA...';

            try {
                const res = await fetch('{{ route('admin.ai.article') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ raw_input: rawInput })
                });
                const data = await res.json();
                if (data.title) {
                    document.getElementById('form-title').value = data.title;
                    document.getElementById('form-excerpt').value = data.excerpt;
                    document.getElementById('form-content-html').value = data.content_html;
                    document.getElementById('form-category-slug').value = data.category_slug || 'noticias';
                    document.getElementById('form-countries-tags').value = (data.detected_countries || []).join(', ');
                    document.getElementById('form-wa-copy').value = data.whatsapp_copy || '';
                    document.getElementById('form-ig-copy').value = data.instagram_copy || '';
                    document.getElementById('form-seo-title').value = data.seo_meta_title || data.title;
                }
            } catch (e) {
                console.error(e);
            } finally {
                btn.textContent = '✨ Redactar Noticia + SEO + Copys con Laravel IA';
            }
        }

        async function runLaravelAiListingEnhancer() {
            const rawIdea = document.getElementById('listing-raw-idea').value;
            const countryId = document.getElementById('listing-country-id').value;
            const priceLabel = document.getElementById('listing-price').value;

            const res = await fetch('{{ route('admin.ai.listing') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ raw_idea: rawIdea, country_id: countryId, price_label: priceLabel })
            });
            const data = await res.json();
            if (data.title) {
                document.getElementById('listing-title').value = data.title;
                document.getElementById('listing-category').value = data.category_name;
                document.getElementById('listing-description').value = data.description;
            }
        }
    </script>
</body>
</html>
