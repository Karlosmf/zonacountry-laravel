<?php

namespace Database\Seeders;

use App\Models\AdZone;
use App\Models\Article;
use App\Models\Banner;
use App\Models\Category;
use App\Models\ClassifiedListing;
use App\Models\Country;
use App\Models\Sponsor;
use App\Models\User;
use App\Models\VecinalClaim;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'joaquin_agusti@hotmail.com'],
            [
                'name' => 'Joaquín Agusti (Admin Zona Country)',
                'password' => Hash::make('nefromogia'),
            ]
        );

        // 1. Countries del corredor Autopista Santa Fe - Rosario
        $countriesData = [
            'Club de Campo El Paso',
            'Club de Campo El Pinar',
            'Aires del Llano',
            'Dos Lagunas',
            'Altos de la Ribera',
            'La Tatenguita',
            'Las Almenas',
            'Santomás',
            'Las Acacias',
            'Miraflores',
            'Aurora Villa Residencial',
        ];

        $countries = [];
        foreach ($countriesData as $name) {
            $countries[$name] = Country::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'sector' => 'Corredor Autopista Santa Fe - Rosario']
            );
        }

        // 2. Categorías Editoriales Reales de ZonaCountry.com.ar
        $categoriesData = [
            ['name' => 'Noticias', 'slug' => 'noticias', 'badge_color' => 'emerald'],
            ['name' => 'Proyectos', 'slug' => 'proyectos', 'badge_color' => 'teal'],
            ['name' => 'Entrevistas', 'slug' => 'entrevistas', 'badge_color' => 'indigo'],
            ['name' => 'Eventos', 'slug' => 'eventos', 'badge_color' => 'purple'],
            ['name' => 'Obras', 'slug' => 'obras', 'badge_color' => 'amber'],
            ['name' => 'Vecinal Norte', 'slug' => 'vecinal-norte', 'badge_color' => 'blue'],
            ['name' => 'Voces de Vecinos', 'slug' => 'vecinos', 'badge_color' => 'emerald'],
            ['name' => 'Municipales', 'slug' => 'municipales', 'badge_color' => 'amber'],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 3. Zonas Publicitarias Unificadas (con los nombres reales de las posiciones de Zona Country)
        $zoneHero = AdZone::updateOrCreate(
            ['slug' => 'home-hero'],
            [
                'name' => 'Slider Principal Portada (1280x480 PC / Adaptable Móvil)',
                'dimensions_label' => '1280x480 px (PC) / 590x600 px (Móvil)',
                'description' => 'Carrusel principal en el tope de la portada de Zona Country.',
            ]
        );

        $zoneTopWide = AdZone::updateOrCreate(
            ['slug' => 'home-top-wide'],
            [
                'name' => 'Banner Ancho Superior Home (Debajo de Difusión WhatsApp)',
                'dimensions_label' => '1200x675 / 728x90 px',
                'description' => 'Posición destacada zonac-home-728x90 antes de la grilla de propiedades.',
            ]
        );

        $zoneMid = AdZone::updateOrCreate(
            ['slug' => 'home-mid'],
            [
                'name' => 'Banner Cuerpo Central Home (728x90 / 728x164)',
                'dimensions_label' => '728x164 px',
                'description' => 'Posición zonac-home-cuerpo-2-728x90 entre Propiedades y Últimas Novedades.',
            ]
        );

        $zoneSidebar = AdZone::updateOrCreate(
            ['slug' => 'sidebar'],
            [
                'name' => 'Columna Derecha Noticias (300x250 / 400x480)',
                'dimensions_label' => '300x250 px / 400x480 GIF',
                'description' => 'Banners cuadrados y verticales junto a Últimas Novedades.',
            ]
        );

        $zoneFooter = AdZone::updateOrCreate(
            ['slug' => 'article-footer'],
            [
                'name' => 'Pie de Nota (Después del Contenido)',
                'dimensions_label' => '728x90 px / 547x205 px',
                'description' => 'Aparece al finalizar la lectura de cada noticia.',
            ]
        );

        // 4. Auspiciantes Reales de ZonaCountry.com.ar y sus Banners con las Imágenes Reales del Sitio
        $spZcProp = Sponsor::updateOrCreate(
            ['name' => 'ZC Inmuebles — Propiedades'],
            ['contact_name' => 'Joaquín Agusti', 'whatsapp' => '5493425299114', 'email' => 'info@zonacountry.com.ar']
        );

        $spCablevideo = Sponsor::updateOrCreate(
            ['name' => 'Cablevideo Digital'],
            ['contact_name' => 'Depto. Comercial', 'whatsapp' => '5493424878424', 'email' => 'comercial@cablevideo.com.ar']
        );

        $spVarekai = Sponsor::updateOrCreate(
            ['name' => 'Varekai Viajes y Turismo'],
            ['contact_name' => 'Casa Central Santa Fe', 'whatsapp' => '5493424878424', 'email' => 'info@varekaiviajes.tur.ar']
        );

        $spSanatorio = Sponsor::updateOrCreate(
            ['name' => 'Sanatorio Santa Fe — Sede Country'],
            ['contact_name' => 'Comunicación Institucional', 'whatsapp' => '5493424878424', 'email' => 'contacto@sanatoriosantafe.com.ar']
        );

        $spGrupoMit = Sponsor::updateOrCreate(
            ['name' => 'Grupo MIT — Las Acacias'],
            ['contact_name' => 'Asesores Comerciales', 'whatsapp' => '5493424878424', 'email' => 'ventas@grupomit.com.ar']
        );

        $spTunel = Sponsor::updateOrCreate(
            ['name' => 'Supermercado El Túnel'],
            ['contact_name' => 'Marketing El Túnel', 'whatsapp' => '5493424878424', 'email' => 'marketing@eltunel.com.ar']
        );

        // Banners con las imágenes reales actuales de zonacountry.com.ar
        Banner::updateOrCreate(
            ['title' => 'Slider Propiedades ZC 1'],
            [
                'sponsor_id' => $spZcProp->id,
                'ad_zone_id' => $zoneHero->id,
                'headline' => 'Encontrá las mejores casas y terrenos en la zona de countries',
                'subheadline' => 'Propiedades seleccionadas en El Paso, El Pinar, Aires del Llano, Dos Lagunas y Las Almenas',
                'image_path' => 'https://zonacountry.com.ar/wp-content/uploads/2024/07/propiedades-1.jpg',
                'target_url' => '#propiedades-zc',
                'color_theme' => 'emerald',
                'starts_at' => now()->subDays(30)->toDateString(),
                'ends_at' => now()->addDays(60)->toDateString(),
                'impressions_count' => 24310,
                'clicks_count' => 685,
                'is_active' => true,
            ]
        );

        Banner::updateOrCreate(
            ['title' => 'Slider Propiedades ZC 2'],
            [
                'sponsor_id' => $spZcProp->id,
                'ad_zone_id' => $zoneHero->id,
                'headline' => '¿Querés vender o alquilar tu propiedad en Zona Country?',
                'subheadline' => 'Publicá en nuestro portal exclusivo del corredor Autopista Santa Fe – Rosario',
                'image_path' => 'https://zonacountry.com.ar/wp-content/uploads/2024/07/propiedades-3.jpg',
                'target_url' => '#propiedades-zc',
                'color_theme' => 'emerald',
                'starts_at' => now()->subDays(30)->toDateString(),
                'ends_at' => now()->addDays(60)->toDateString(),
                'impressions_count' => 21140,
                'clicks_count' => 530,
                'is_active' => true,
            ]
        );

        Banner::updateOrCreate(
            ['title' => 'Banner Principal Cablevideo'],
            [
                'sponsor_id' => $spCablevideo->id,
                'ad_zone_id' => $zoneTopWide->id,
                'headline' => 'Cablevideo Digital — Fibra Óptica y Entretenimiento en la Zona de Countries',
                'subheadline' => 'Conectividad de alta velocidad para hogares en Santo Tomé y Santa Fe',
                'image_path' => 'https://zonacountry.com.ar/wp-content/uploads/2025/03/1920x1080-copia-2-1200x675.png',
                'target_url' => 'https://cablevideo.com.ar/home',
                'color_theme' => 'blue',
                'starts_at' => now()->subDays(20)->toDateString(),
                'ends_at' => now()->addDays(25)->toDateString(),
                'impressions_count' => 18940,
                'clicks_count' => 492,
                'is_active' => true,
            ]
        );

        Banner::updateOrCreate(
            ['title' => 'Banner Central Varekai Viajes'],
            [
                'sponsor_id' => $spVarekai->id,
                'ad_zone_id' => $zoneMid->id,
                'headline' => 'Varekai Viajes — Descubrí nuestras nuevas oficinas y próximas salidas grupales',
                'subheadline' => 'Atención personalizada para tus próximas vacaciones',
                'image_path' => 'https://zonacountry.com.ar/wp-content/uploads/2025/07/Banner-web-ZC.jpg',
                'target_url' => 'https://www.varekaiviajes.tur.ar/',
                'color_theme' => 'purple',
                'starts_at' => now()->subDays(18)->toDateString(),
                'ends_at' => now()->addDays(32)->toDateString(),
                'impressions_count' => 16420,
                'clicks_count' => 438,
                'is_active' => true,
            ]
        );

        Banner::updateOrCreate(
            ['title' => 'Sidebar Sanatorio Santa Fe Sede Country'],
            [
                'sponsor_id' => $spSanatorio->id,
                'ad_zone_id' => $zoneSidebar->id,
                'headline' => 'Sanatorio Santa Fe — Nueva Sede Country',
                'subheadline' => 'El primer centro de salud integral en la zona de countries',
                'image_path' => 'https://zonacountry.com.ar/wp-content/uploads/2025/06/SEDE-COUNTRY-GIF2-1.jpg',
                'target_url' => 'https://www.instagram.com/sanatoriosantafe.ig/',
                'color_theme' => 'emerald',
                'starts_at' => now()->subDays(15)->toDateString(),
                'ends_at' => now()->addDays(45)->toDateString(),
                'impressions_count' => 19450,
                'clicks_count' => 542,
                'is_active' => true,
            ]
        );

        Banner::updateOrCreate(
            ['title' => 'Sidebar Grupo MIT Las Acacias'],
            [
                'sponsor_id' => $spGrupoMit->id,
                'ad_zone_id' => $zoneSidebar->id,
                'headline' => 'Grupo MIT — Desarrollos y Lotes en Las Acacias',
                'subheadline' => 'Consultá planes de financiación directa',
                'image_path' => 'https://zonacountry.com.ar/wp-content/uploads/2025/05/Banner.jpeg',
                'target_url' => 'https://grupomit.com.ar/',
                'color_theme' => 'blue',
                'starts_at' => now()->subDays(12)->toDateString(),
                'ends_at' => now()->addDays(40)->toDateString(),
                'impressions_count' => 15950,
                'clicks_count' => 404,
                'is_active' => true,
            ]
        );

        Banner::updateOrCreate(
            ['title' => 'Sidebar ZC Inmuebles Vender GIF'],
            [
                'sponsor_id' => $spZcProp->id,
                'ad_zone_id' => $zoneSidebar->id,
                'headline' => '¿Querés vender tu casa o terreno? Contactá a ZC Inmuebles',
                'subheadline' => 'Asesoramiento especializado en countries',
                'image_path' => 'https://zonacountry.com.ar/wp-content/uploads/2024/11/vender.gif',
                'target_url' => 'https://api.whatsapp.com/send?phone=5493425299114&text=Hola%20ZCInmuebles%2C%20quiero%20contactarme',
                'color_theme' => 'emerald',
                'starts_at' => now()->subDays(25)->toDateString(),
                'ends_at' => now()->addDays(65)->toDateString(),
                'impressions_count' => 14800,
                'clicks_count' => 390,
                'is_active' => true,
            ]
        );

        Banner::updateOrCreate(
            ['title' => 'Sidebar Canal de WhatsApp GIF'],
            [
                'sponsor_id' => $spZcProp->id,
                'ad_zone_id' => $zoneSidebar->id,
                'headline' => 'Seguí el Canal de WhatsApp de Zona Country',
                'subheadline' => 'Novedades, alertas y servicios al instante',
                'image_path' => 'https://zonacountry.com.ar/wp-content/uploads/2026/05/banner-400x480-2.gif',
                'target_url' => 'https://whatsapp.com/channel/0029Vb6wXxl7IUYO8iO05W0I',
                'color_theme' => 'emerald',
                'starts_at' => now()->subDays(20)->toDateString(),
                'ends_at' => now()->addDays(90)->toDateString(),
                'impressions_count' => 17200,
                'clicks_count' => 615,
                'is_active' => true,
            ]
        );

        Banner::updateOrCreate(
            ['title' => 'Supermercado El Túnel Pie de Nota'],
            [
                'sponsor_id' => $spTunel->id,
                'ad_zone_id' => $zoneFooter->id,
                'headline' => 'Supermercado El Túnel — Envíos a Domicilio en toda la Zona de Countries',
                'subheadline' => 'Hacé tu pedido online y recibilo en tu barrio privado',
                'image_path' => null,
                'target_url' => 'https://wa.me/5493424878424',
                'color_theme' => 'amber',
                'starts_at' => now()->subDays(26)->toDateString(),
                'ends_at' => now()->addDays(4)->toDateString(),
                'impressions_count' => 15200,
                'clicks_count' => 410,
                'is_active' => true,
            ]
        );

        // 5. Las 9 Noticias Reales de la Portada de ZonaCountry.com.ar con sus Fotos Reales
        $realArticles = [
            [
                'slug' => 'comienzan-las-obras-del-nuevo-sector-deportivo-y-social-de-santomas',
                'category' => 'proyectos',
                'title' => 'Comienzan las obras del nuevo sector deportivo y social de Santomás',
                'excerpt' => 'El desarrollo urbanístico ubicado sobre el corredor de la autopista puso en marcha la ejecución de su nuevo polo deportivo y social para residentes y familias.',
                'image' => 'https://zonacountry.com.ar/wp-content/uploads/2026/04/santomas-800x403.jpg',
                'countries' => ['Santomás', 'Aires del Llano', 'Dos Lagunas'],
                'date' => now()->subDays(1),
            ],
            [
                'slug' => 'tu-propio-espacio-en-comunidad-descubri-housing-santomas',
                'category' => 'proyectos',
                'title' => 'Tu propio espacio, en comunidad: descubrí Housing Santomás',
                'excerpt' => 'Una propuesta residencial moderna que combina la practicidad de unidades tipo housing con todos los amenities y la seguridad de un gran barrio privado.',
                'image' => 'https://zonacountry.com.ar/wp-content/uploads/2025/11/INGRESO-HOUSING-800x533.jpg',
                'countries' => ['Santomás'],
                'date' => now()->subDays(3),
            ],
            [
                'slug' => 'proyectamos-futuro-con-la-nueva-campana-hagamos-algo-nuevo',
                'category' => 'noticias',
                'title' => 'Proyectamos futuro con la nueva campaña “Hagamos algo nuevo”',
                'excerpt' => 'Iniciativas de innovación, sustentabilidad y vida al aire libre impulsadas para transformar la experiencia de vivir en la zona de countries.',
                'image' => 'https://zonacountry.com.ar/wp-content/uploads/2025/09/15fddec0-f8db-47b3-bf77-dc72ab73091d-800x450.jpg',
                'countries' => ['Club de Campo El Paso', 'Club de Campo El Pinar', 'Santomás'],
                'date' => now()->subDays(5),
            ],
            [
                'slug' => 'nuevas-oficinas-de-varekai-viajes-3-pisos-y-muchas-funcionalidades',
                'category' => 'noticias',
                'title' => 'Nuevas oficinas de Varekai Viajes, 3 pisos y muchas funcionalidades',
                'excerpt' => 'La reconocida agencia de viajes inauguró su moderno edificio de tres plantas pensado para brindar una experiencia integral a los viajeros de toda la región.',
                'image' => 'https://zonacountry.com.ar/wp-content/uploads/2025/07/VAREKAI-INAUGURACION-80-de-335-e1753811490536.jpg',
                'countries' => ['Club de Campo El Paso', 'Club de Campo El Pinar', 'Aires del Llano'],
                'date' => now()->subDays(7),
            ],
            [
                'slug' => 'pilay-alcanzo-las-74-entregas-en-santa-fe-con-un-nuevo-edificio',
                'category' => 'proyectos',
                'title' => 'Pilay alcanzó las 74 entregas en Santa Fe con un nuevo edificio',
                'excerpt' => 'Con un nuevo hito constructivo en la ciudad y desarrollos clave en el corredor de countries, Pilay reafirma su liderazgo regional.',
                'image' => 'https://zonacountry.com.ar/wp-content/uploads/2025/07/Entrega-SJ96-3-600x899.jpg',
                'countries' => ['Santomás', 'Aires del Llano'],
                'date' => now()->subDays(10),
            ],
            [
                'slug' => 'santomas-presenta-sus-nuevos-lotes-de-500-m2',
                'category' => 'proyectos',
                'title' => 'Santomás presenta sus nuevos lotes de 500 m²',
                'excerpt' => 'Nueva etapa de comercialización de terrenos de 500 m² con infraestructura subterránea completa y acceso directo desde la Autopista Santa Fe–Rosario.',
                'image' => 'https://zonacountry.com.ar/wp-content/uploads/2025/07/04e880b4-b23b-43c9-a380-7bff7b5709b8-800x600.jpeg',
                'countries' => ['Santomás'],
                'date' => now()->subDays(12),
            ],
            [
                'slug' => 'sanatorio-santa-fe-construira-el-primer-centro-de-salud-en-la-zona-de-countries',
                'category' => 'obras',
                'title' => 'Sanatorio Santa Fe: construirá el primer centro de salud en la zona de countries',
                'excerpt' => 'Un proyecto estratégico que acercará consultorios médicos, diagnóstico por imágenes y atención ambulatoria directamente al corredor de la autopista.',
                'image' => 'https://zonacountry.com.ar/wp-content/uploads/2025/06/Storie-1-32-600x1067.jpg',
                'countries' => ['Club de Campo El Paso', 'Club de Campo El Pinar', 'Aires del Llano', 'Dos Lagunas'],
                'date' => now()->subDays(15),
            ],
            [
                'slug' => 'nuevo-salon-en-miraflores-tatiana-martinez-llego-para-romper-las-reglas',
                'category' => 'entrevistas',
                'title' => 'Nuevo salón en Miraflores: Tatiana Martínez llegó para romper las reglas',
                'excerpt' => 'Conversamos con Tatiana Martínez sobre la apertura de su nuevo espacio de estilismo y bienestar en el complejo Miraflores sobre la autopista.',
                'image' => 'https://zonacountry.com.ar/wp-content/uploads/2025/06/tatiana-martinez-zona-country-600x800.jpeg',
                'countries' => ['Miraflores', 'Club de Campo El Pinar', 'La Tatenguita'],
                'date' => now()->subDays(18),
            ],
            [
                'slug' => 'grupo-mit-abrira-su-sede-en-las-acacias',
                'category' => 'proyectos',
                'title' => 'GRUPO MIT abrirá su sede en Las Acacias',
                'excerpt' => 'El grupo desarrollador desembarca con oficinas propias de atención en el barrio abierto residencial Las Acacias para acompañar el crecimiento del sector.',
                'image' => 'https://zonacountry.com.ar/wp-content/uploads/2025/05/slider-3-scaled-1-800x450.jpg',
                'countries' => ['Las Acacias', 'Aurora Villa Residencial'],
                'date' => now()->subDays(21),
            ],
        ];

        foreach ($realArticles as $art) {
            Article::updateOrCreate(
                ['slug' => $art['slug']],
                [
                    'category_id' => $categories[$art['category']]->id,
                    'title' => $art['title'],
                    'excerpt' => $art['excerpt'],
                    'content_html' => "<p>{$art['excerpt']}</p><h3>Desarrollo y crecimiento en el corredor de countries</h3><p>Esta iniciativa forma parte de la transformación constante que vive el corredor de la <strong>Autopista Santa Fe–Rosario</strong>, consolidando nuevos servicios, infraestructura deportiva, salud y propuestas residenciales para las familias de <strong>" . implode(', ', $art['countries']) . "</strong>.</p>",
                    'featured_image' => $art['image'],
                    'countries_tags' => $art['countries'],
                    'whatsapp_copy' => "📰 *{$art['title']}* ✨\n{$art['excerpt']}\n👉 Leé la nota completa en: https://zonacountry.com.ar",
                    'instagram_copy' => "{$art['title']} 📍 Conocé todos los detalles en el link de nuestra bio. #ZonaCountry #SantaFe #SantoTome #Countries",
                    'seo_meta_title' => $art['title'] . ' | Zona Country',
                    'seo_meta_description' => Str::limit($art['excerpt'], 155),
                    'generated_with_ai' => false,
                    'is_published' => true,
                    'published_at' => $art['date'],
                ]
            );
        }

        // 6. Clasificados y Propiedades Reales con sus Fotos Originales de ZonaCountry.com.ar
        ClassifiedListing::updateOrCreate(
            ['slug' => 'venta-imponente-propiedad-en-el-pinar-a-estrenar'],
            [
                'country_id' => $countries['Club de Campo El Pinar']->id,
                'title' => 'Venta imponente propiedad en el Pinar a estrenar!!!!',
                'category_name' => 'Casas',
                'price_label' => 'Consultar',
                'description' => 'Propiedad de primera categoría a estrenar en Club de Campo El Pinar (Santo Tomé). Desarrollada en dos plantas con amplios ventanales, galería con asador, piscina y parquización.',
                'features' => ['Lourdes Reyes', 'Casas', 'El Pinar · Santo Tomé', '38 vistas'],
                'image_path' => 'https://zonacountry.com.ar/wp-content/uploads/classified-listing/2026/08/c2ea3ac7-84c0-4b26-8b8a-53419f94629d-scaled-370x462.jpeg',
                'whatsapp_contact' => '5493425299114',
                'is_featured' => true,
                'status' => 'active',
            ]
        );

        ClassifiedListing::updateOrCreate(
            ['slug' => 'propietario-vende-terreno-en-equina-en-contry-el-pinar'],
            [
                'country_id' => $countries['Club de Campo El Pinar']->id,
                'title' => 'Propietario vende terreno en esquina en Country El Pinar',
                'category_name' => 'Terrenos',
                'price_label' => 'USD 98.000',
                'description' => 'Excelente lote en esquina ubicado en Club de Campo El Pinar. Listo para escriturar y construir, con orientación privilegiada y todos los servicios.',
                'features' => ['Sergio Bagnaroli', 'Terrenos', 'El Pinar', 'Dueño Directo'],
                'image_path' => 'https://zonacountry.com.ar/wp-content/uploads/classified-listing/2026/08/Imagen-de-WhatsApp-2025-11-04-a-las-15.04.23_503ba710-924x427.jpg',
                'whatsapp_contact' => '5493425299114',
                'is_featured' => true,
                'status' => 'active',
            ]
        );

        ClassifiedListing::updateOrCreate(
            ['slug' => 'terreno-a-la-venta-en-las-almenas'],
            [
                'country_id' => $countries['Las Almenas']->id,
                'title' => 'TERRENO A LA VENTA EN LAS ALMENAS',
                'category_name' => 'Terrenos',
                'price_label' => 'USD 120.000',
                'description' => 'Amplio terreno en venta en barrio privado Las Almenas. Entorno consolidado y arbolado a minutos del acceso a autopista.',
                'features' => ['Maximiliano Martinez', 'Terrenos', 'Las Almenas', 'Escritura inmediata'],
                'image_path' => 'https://zonacountry.com.ar/wp-content/uploads/classified-listing/2026/05/20250813_095807_2_11zon-1-616x462.jpg',
                'whatsapp_contact' => '5493425299114',
                'is_featured' => true,
                'status' => 'active',
            ]
        );

        ClassifiedListing::updateOrCreate(
            ['slug' => 'terreno-en-venta-en-las-almenas-tatenguita'],
            [
                'country_id' => $countries['La Tatenguita']->id,
                'title' => 'TERRENO EN VENTA EN LAS ALMENAS / TATENGUITA',
                'category_name' => 'Terrenos',
                'price_label' => 'USD 120.000',
                'description' => 'Lote nivelado y parquizado con excelente ubicación dentro del complejo residencial. Consultas y visitas coordinadas.',
                'features' => ['Maximiliano Martinez', 'Terrenos', 'Tatenguita', '43 vistas'],
                'image_path' => 'https://zonacountry.com.ar/wp-content/uploads/classified-listing/2026/05/20250813_095807_2_11zon-400x280.jpg',
                'whatsapp_contact' => '5493425299114',
                'is_featured' => true,
                'status' => 'active',
            ]
        );

        // 7. Reclamos Iniciales de Vecinal Norte
        $claimsSamples = [
            ['country' => 'Aires del Llano', 'type' => 'Iluminación', 'neighbor' => 'Martín G.', 'desc' => 'Dos columnas apagadas sobre colectora a 150 metros del ingreso principal.'],
            ['country' => 'Club de Campo El Pinar', 'type' => 'Iluminación', 'neighbor' => 'Carolina S.', 'desc' => 'Solicitud de refuerzo de luminarias LED en dársena de espera de colectivos.'],
            ['country' => 'Dos Lagunas', 'type' => 'Seguridad', 'neighbor' => 'Fernando R.', 'desc' => 'Pedido de mayor frecuencia de patrullaje preventivo en horario nocturno.'],
            ['country' => 'Club de Campo El Paso', 'type' => 'Asfalto y Bacheo', 'neighbor' => 'Alejandro M.', 'desc' => 'Bache profundo en carril de desaceleración mano hacia Santo Tomé.'],
            ['country' => 'La Tatenguita', 'type' => 'Señalización Vial', 'neighbor' => 'Laura P.', 'desc' => 'Reposición de cartel indicador y demarcación horizontal en cruce peatonal.'],
        ];

        foreach ($claimsSamples as $sample) {
            VecinalClaim::firstOrCreate(
                ['neighbor_name' => $sample['neighbor'], 'description' => $sample['desc']],
                [
                    'country_id' => $countries[$sample['country']]->id,
                    'neighbor_phone' => '342-5000000',
                    'claim_type' => $sample['type'],
                    'status' => 'en_gestion',
                ]
            );
        }
    }
}
