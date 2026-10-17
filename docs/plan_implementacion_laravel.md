# Plan de Implementación Técnico: ZonaCountry en Laravel 12 + IA

Este documento define la hoja de ruta de ingeniería para construir y migrar `zonacountry.com.ar` a **Laravel 12 + IA**.

---

## 1. Esquema de Base de Datos (Migraciones Laravel)

- **`sponsors`**: Auspiciantes comerciales (`name`, `contact_name`, `whatsapp`, `email`).
- **`ad_zones`**: Zonas publicitarias unificadas (`home-hero`, `home-top-wide`, `home-mid`, `sidebar`, `article-footer`).
- **`banners`**: Piezas publicitarias con programación por fechas (`starts_at`, `ends_at`) y contadores auditables (`impressions_count`, `clicks_count`).
- **`countries`**: Los 11+ barrios privados del corredor Autopista Santa Fe–Rosario.
- **`categories`** y **`articles`**: Artículos periodísticos con soporte de generación IA (`whatsapp_copy`, `instagram_copy`, `seo_meta_title`, `seo_meta_description`, `countries_tags`).
- **`classified_listings`**: Propiedades e inmuebles destacados filtrables por country.
- **`vecinal_claims`**: Tablero estadístico de reclamos y gestiones de la Vecinal Zona de Countries.

---

## 2. Cronograma de Ejecución por Sprints (6 Semanas)

- **Semana 1 — Arquitectura, Diseño UI Glassmorphism & Gestor de Banners**
- **Semana 2 — Maquetación de Portada Ultrarrápida e Integración de Zonas de Banners**
- **Semana 3 — Redactor de Noticias con Laravel IA (`ZonaCountryAiService`)**
- **Semana 4 — Migración de Contenido Editorial (`wp-json`) y Secciones Comunitarias**
- **Semana 5 — Clasificados, ZC Inmuebles y Asistente IA para Anunciantes**
- **Semana 6 — QA, Redirecciones SEO 301, Despliegue en Hostinger y Capacitación**
