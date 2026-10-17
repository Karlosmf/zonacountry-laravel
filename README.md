# 🏡 Zona Country — Plataforma Laravel 12 + IA (Glassmorphism & Motion 2026)

Propuesta integral de migración, rediseño **Glassmorphism & Motion 60fps** y **Panel de Autogestión con Inteligencia Artificial** para **[ZonaCountry.com.ar](https://zonacountry.com.ar/)**, el portal periodístico, inmobiliario y de servicios del corredor de countries de la Autopista Santa Fe – Rosario (Santo Tomé).

---

## ✨ Qué incluye este repositorio

1. **Portal Público Rediseñado (`resources/views/portal/index.blade.php` y `article.blade.php`)**:
   - Identidad oficial de Zona Country (`zc-logo.png`, `zc-logo-w.png`, tipografía `Barlow` + `Inter`, paleta `#03963b` / `#063115`) elevada con **Glassmorphism Esmeralda** (`backdrop-filter: blur(20px) saturate(180%)`), bordes especulares y orbes ambientales animados.
   - **Modo Glass Día / Modo Glass Nocturno Esmeralda** conmutable en 1 clic desde la barra superior.
   - **Hero Slider Publicitario con HUD de Cristal**, métricas en vivo y botón accesible de pausa/reanudación.
   - **Scroll-Driven Animations Nativas (CSS)** y micro-interacciones a 60fps en el hilo del compositor (`translate`, `scale`, `opacity`).
   - **Secciones reales precargadas**:
     - Banners reales de *Zona Country Inmuebles*, *Cablevideo Digital*, *Colegio Varekai*, *Sanatorio Santa Fe (Sede Country)* y *Grupo MIT*.
     - Grilla de 4 columnas **«Propiedades en ZC»** con filtro por los 11 countries del corredor.
     - Bloque **«Últimas Novedades»** (layout 3/4 noticias + 1/4 auspiciantes) con las 9 noticias reales actuales y sus fotografías originales.
     - Formulario de **«Publicá Gratis en Zona Country»**, **Horarios de Colectivos (Línea C Verde / Intercountry)** y tablero de **Vecinal Zona de Countries**.

2. **Backoffice de Autogestión + Laravel IA (`/admin`)**:
   - **Módulo 1 — Gestor Unificado de Banners (`AdZone` + `Banner` + `Sponsor`)**: Reemplaza los 3 sistemas dispersos del WordPress actual (*Slider Revolution*, *Widgets Avada* y *Advanced Ads*) por un único formulario donde el administrador sube la pieza, elige la ubicación, programa vigencia (`starts_at` / `ends_at`) y descarga o envía el **Reporte de Impresiones y Clics** al auspiciante.
   - **Módulo 2 — Redactor Periodístico con Laravel IA (`ZonaCountryAiService`)**: A partir de un punteo o gacetilla, genera automáticamente título periodístico, bajada, cuerpo HTML, etiquetas de countries, metadatos SEO, copy para el **Canal de Difusión de WhatsApp** y copy para **Instagram**.
   - **Módulo 3 — Clasificados & Propiedades + Importador en vivo desde WordPress (`wp-json/wp/v2/posts`)**.

---

## 🚀 Cómo correr el proyecto en local (Laravel Herd o Artisan)

```bash
# 1. Clonar el repositorio
git clone https://github.com/Karlosmf/zonacountry-laravel.git
cd zonacountry-laravel

# 2. Instalar dependencias PHP
composer install

# 3. Configurar entorno y base de datos SQLite
cp .env.example .env
touch database/database.sqlite
php artisan key:generate

# 4. Ejecutar migraciones y seeder con todos los banners, fotos y noticias reales de Zona Country
php artisan migrate:fresh --seed
```

### Opción A: Con Laravel Herd (Recomendado en Mac/Windows)
```bash
herd link zonacountry
```
* **Portada Pública**: [http://zonacountry.test](http://zonacountry.test)
* **Panel de Autogestión (`/admin`)**: [http://zonacountry.test/admin](http://zonacountry.test/admin)

### Opción B: Con servidor integrado de Laravel
```bash
php artisan serve
```
* **Portada Pública**: [http://127.0.0.1:8000](http://127.0.0.1:8000)
* **Panel de Autogestión (`/admin`)**: [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)

---

## 📂 Documentación y Propuesta Comercial

Dentro de la carpeta [`/docs`](./docs) se encuentran los documentos listos para revisar y presentar al cliente:

- 📄 [`docs/propuesta_migracion_laravel.md`](./docs/propuesta_migracion_laravel.md) — Diagnóstico técnico del WordPress actual y arquitectura de la solución en Laravel + IA.
- 💼 [`docs/propuesta_comercial_cliente.md`](./docs/propuesta_comercial_cliente.md) — Propuesta comercial lista para enviar por WhatsApp/Email con desglose de inversión y retorno.
- 🛠️ [`docs/plan_implementacion_laravel.md`](./docs/plan_implementacion_laravel.md) — Plan de implementación paso a paso y estrategia de migración sin caída de servicio en Hostinger.
