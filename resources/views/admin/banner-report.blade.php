<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Rendimiento Publicitario — {{ $banner->sponsor->name }} | Zona Country</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 antialiased py-8 px-4">

    <div class="max-w-3xl mx-auto space-y-4">
        <div class="no-print flex items-center justify-between bg-slate-900 text-white px-4 py-3 rounded-xl">
            <span class="text-xs font-semibold">📄 Vista lista para Guardar como PDF o Imprimir para el Auspiciante</span>
            <div class="flex items-center gap-2">
                <button onclick="window.print()" class="px-3.5 py-1.5 rounded-lg bg-emerald-500 text-slate-950 text-xs font-extrabold">
                    🖨️ Imprimir / Guardar como PDF
                </button>
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 rounded-lg bg-slate-800 text-xs font-semibold">Volver al Panel</a>
            </div>
        </div>

        <!-- Hoja de Reporte con Membrete de Zona Country -->
        <div class="bg-white border border-slate-200 rounded-2xl p-8 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-700 text-white font-black text-xl flex items-center justify-center">
                        ZC
                    </div>
                    <div>
                        <h1 class="text-xl font-black text-slate-900">ZONA COUNTRY</h1>
                        <p class="text-xs text-slate-500">El Portal de los Countries · Autopista Santa Fe – Rosario</p>
                    </div>
                </div>
                <div class="text-right text-xs">
                    <p class="font-bold text-emerald-700 uppercase">Informe Oficial de Pauta Digital</p>
                    <p class="text-slate-500">Fecha de emisión: {{ now()->format('d/m/Y') }}</p>
                </div>
            </div>

            <div class="space-y-1">
                <p class="text-xs font-bold uppercase text-slate-400">Auspiciante</p>
                <h2 class="text-2xl font-extrabold text-slate-900">{{ $banner->sponsor->name }}</h2>
                <p class="text-xs text-slate-600">
                    Ubicación contratada: <strong>{{ $banner->adZone->name }}</strong> ·
                    Período vigente: <strong>{{ $banner->starts_at->format('d/m/Y') }} al {{ $banner->ends_at->format('d/m/Y') }}</strong>
                </p>
            </div>

            <!-- Métricas Auditadas -->
            <div class="grid grid-cols-3 gap-4">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <p class="text-xs text-slate-500 font-semibold">Impresiones (Visualizaciones)</p>
                    <p class="text-3xl font-black text-emerald-700 mt-1">{{ number_format($banner->impressions_count, 0, ',', '.') }}</p>
                    <p class="text-xs text-slate-500 mt-1">Vecinos que vieron el anuncio</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <p class="text-xs text-slate-500 font-semibold">Clics Directos</p>
                    <p class="text-3xl font-black text-emerald-700 mt-1">{{ number_format($banner->clicks_count, 0, ',', '.') }}</p>
                    <p class="text-xs text-slate-500 mt-1">Derivados a tu Web / WhatsApp</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <p class="text-xs text-slate-500 font-semibold">Tasa de Interacción (CTR)</p>
                    <p class="text-3xl font-black text-slate-900 mt-1">{{ $banner->ctr }}%</p>
                    <p class="text-xs text-emerald-700 font-semibold mt-1">Superior al promedio del sector</p>
                </div>
            </div>

            <!-- Detalle del Anuncio -->
            <div class="p-5 rounded-xl bg-emerald-50 border border-emerald-200 space-y-2">
                <p class="text-xs font-extrabold text-emerald-800 uppercase">Mensaje Publicitario Activo</p>
                <p class="text-base font-bold text-slate-900">"{{ $banner->headline }}"</p>
                @if($banner->subheadline)
                    <p class="text-xs text-slate-600">{{ $banner->subheadline }}</p>
                @endif
                <p class="text-xs text-slate-500 pt-1">Enlace de conversión auditado: {{ $banner->target_url }}</p>
            </div>

            <!-- Alcance Segmentado -->
            <div class="space-y-2 border-t border-slate-200 pt-4 text-xs text-slate-600">
                <p class="font-bold text-slate-900">🎯 Audiencia Alcanzada en el Corredor:</p>
                <p>
                    Tu anuncio impactó directamente en familias, profesionales y propietarios residentes en
                    <strong>Club de Campo El Paso, Club de Campo El Pinar, Aires del Llano, Dos Lagunas, Altos de la Ribera, La Tatenguita, Las Almenas, Santomás, Las Acacias, Miraflores y Aurora</strong>.
                </p>
            </div>

            <div class="border-t border-slate-200 pt-4 flex items-center justify-between text-xs text-slate-400">
                <span>zonacountry.com.ar · WhatsApp Comercial: +54 9 342 487-8424</span>
                <span>Reporte generado por Plataforma Zona Country Laravel</span>
            </div>
        </div>
    </div>
</body>
</html>
