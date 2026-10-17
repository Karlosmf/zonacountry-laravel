# Relevamiento y Propuesta de Migración a Laravel + IA: ZonaCountry.com.ar

> [!IMPORTANT]
> **Objetivo del Proyecto:** Transformar **ZonaCountry.com.ar** —actualmente montado sobre una estructura pesada y fragmentada en WordPress + Avada— en una **plataforma web moderna, ultrarrápida y 100% autogestionable desarrollada en Laravel con Inteligencia Artificial integrada**, donde el cliente pueda administrar **banners publicitarios, noticias y clasificados** en segundos desde el celular o la PC sin depender de soporte técnico.

---

## 1. Diagnóstico Actual del Proyecto (WordPress)

Tras auditar en profundidad el sitio en vivo, su API interna (`/wp-json/`), estructura de datos y paneles de contenido, relevamos qué tiene hoy el portal y por qué la autogestión actual resulta engorrosa para el cliente.

### 1.1. Radiografía Técnica Actual
- **CMS:** WordPress `7.1.3` alojado en **Hostinger**.
- **Tema y Maquetador:** **Avada Theme + Fusion Builder (`v3.14.2`)**. Genera un HTML extremadamente pesado (~270 KB solo de código base en la portada y más de **1,67 segundos** de generación dinámica en servidor antes de descargar imágenes, disimulado parcialmente con `WP-Super-Cache`).
- **Plugins Críticos Activos:**
  - **Publicidad:** *Advanced Ads (`v2.0.29`)* + sliders nativos de Avada + bloques HTML manuales + Google AdSense (`ca-pub-9830017074184728`).
  - **Clasificados e Inmobiliaria:** *Classified Listing (`rtcl`)* + *Classified Listing Pro* + *Elementor* (conviven dos constructores visuales distintos: Fusion Builder y Elementor).
  - **Formularios y Comunidad:** *Contact Form 7 (`v6.1.5`)*, *Nextend Social Login* (Google / Facebook), *JoinChat* (WhatsApp flotante `5493424878424`), *PDF.js Viewer* y *Yoast SEO (`v28.2`)*.

---

### 1.2. ¿Por qué hoy le cuesta autogestionar el sitio al cliente?

#### A. El caos de los Banners Publicitarios (3 sistemas distintos convivientes)
Hoy, para cambiar o subir un banner publicitario de auspiciantes como *Pilay, Sanatorio Santa Fe, Supermercado El Túnel, Varekai, Las Acacias o Grupo MIT*, el administrador debe lidiar con **tres lugares diferentes**:
1. **Sliders de Avada (`fusion-slider-sc`) maquetados dentro de la Portada:** Los banners principales superiores tienen un bloque para Escritorio y otro duplicado para Móvil dentro de filas de Fusion Builder. Si se toca mal una columna, se rompe el diseño de la home.
2. **Plugin Advanced Ads (`advanced_ads`):** Administra algunas posiciones puntuales (`zonac-home-728x90`, `zonac-home-cuerpo-2-728x90`, `zonac-home-1-300x250`, `zonac-home-2-300x250`, `zonac-despues-del-contenido`).
3. **Banners incrustados a mano en columnas o Widgets:** Ej. el bloque con gradiente personalizado de *Supermercado El Túnel*, los GIFs laterales de *ZC Inmuebles* (`vender.gif`), el canal de WhatsApp (`banner-400x480-2.gif`) y los widgets de imagen en la barra lateral de Clasificados.

> [!WARNING]
> **Consecuencia comercial:** El cliente no tiene un panel único donde ver qué pauta vence a fin de mes, no puede subir un banner desde el teléfono en 1 paso y no cuenta con un **reporte limpio de impresiones y clics** para demostrarle el retorno de inversión (ROI) a sus auspiciantes al momento de renovar la pauta.

#### B. Carga de Noticias Lenta y Manual
- Cuenta con más de **100 artículos publicados** distribuidos en categorías (*Noticias [77], Entrevistas [24], Eventos [15], Municipales [9], Obras, Proyectos, Voces de Vecinos, Vecinal Norte*).
- Subir una nota hoy implica entrar al editor pesado de WordPress + Avada, redactar desde cero, recortar imágenes afuera para que no pesen megabytes, elegir categorías, completar manualmente extractos y configurar Yoast SEO.

---

### 1.3. Mapa Completo de Módulos Actuales a Conservar y Mejorar

| Módulo Actual | Contenido / Alcance Relevado | Estado en WP |
| :--- | :--- | :--- |
| **1. Portal de Noticias y Blog** | Noticias de countries, entrevistas, eventos, obras, municipales y voces de vecinos. | Activo (Edición pesada en WP + Avada) |
| **2. Gestor de Banners y Pauta** | Banners top, intermedios, laterales (300x250 / 400x480), pie de nota y AdSense. | Fragmentado en 3 sistemas sin métricas unificadas |
| **3. Clasificados y ZC Inmuebles** | **270 avisos activos** en **17 rubros** (*Propiedades [Casas/Terrenos], Vehículos, Piletas, Profesionales, Hogar, Mascotas, etc.*) filtrados por **11+ Countries** (*El Paso, El Pinar, Aires del Llano, Dos Lagunas, Altos de la Ribera, La Tatenguita, Las Almenas, Santomás, Las Acacias, Miraflores, Aurora*). | Plugin `Classified Listing Pro` con campos personalizados, precio/consultar y botón directo a WhatsApp |
| **4. Vecinal Norte y Reclamos** | Sección institucional de la *Asociación Civil Vecinal Norte* (Ord. N° 3488/2021) + formulario `/reclamos-vecinal-norte/` (*Seguridad, Asfalto, Iluminación, Señalización, Seguridad Vial*). | Formulario básico en Contact Form 7 que solo envía un email sin seguimiento |
| **5. Servicios Útiles** | **Horarios de Colectivos** (Mapa Google MyMaps + 3 PDFs incrustados: Lun-Vie, Sáb, Dom) y **Horarios de Misa**. | Visor PDF lento en celulares |
| **6. Comunidad y Redes** | Botón WhatsApp, enlaces a grupo/canal de difusión de WhatsApp y feed de Instagram. | Integrado mediante plugins externos |

---

## 2. Arquitectura Propuesta: Plataforma Laravel + IA

Proponemos reemplazar WordPress por una aplicación web a medida construida con el stack moderno del ecosistema **Laravel**, optimizada para correr con fluidez en su servidor actual de **Hostinger** (o VPS) consumiendo una fracción de los recursos actuales.

### Stack Tecnológico Recomendado
- **Backend & Core:** **Laravel 11 / 12** (PHP 8.3+) con caché inteligente de consultas y vistas.
- **Panel de Autogestión (Backoffice):** **FilamentPHP v3** / Panel propio responsive.
- **Frontend Público:** **Blade + Tailwind CSS** con estética **Glassmorphism & Motion 60fps** manteniendo la identidad visual esmeralda de Zona Country.
- **Motor de Inteligencia Artificial:** **Laravel AI (Google Gemini / OpenAI)** con costos operativos mínimos y procesamiento de texto, voz e imagen.
