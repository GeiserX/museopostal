# 04 · Auditoría UX/UI de museopostal.org (estado a 28-09-2026)

## Resumen en llano

El sitio no funciona hoy como museo. La portada no tiene ningún título y abre con un párrafo de unas 90 palabras en serif, negrita y cursiva. Debajo hay seis medallones generados por IA, todos con la misma composición, y tres de ellos no llevan a ninguna parte. Justo la sala central, «Museo Postal de la Región», no tiene enlace. Las salas que existen están vacías o rotas: Museo_murcia son 3 imágenes sin texto; Museos del Mundo, 8 fotos sin nombres ni enlaces; Proyecto Aula queda tapado por el aviso «Nuestra tienda está en obras»; y Padre_museo muestra «Please select a Menu From Setting!».

Por debajo, la página de inicio hace 150 peticiones y pesa 2,3 MB en móvil. Carga 7 familias tipográficas y 26 plugins activos, entre ellos tres de consentimiento. Aun así, Microsoft Clarity y Google Analytics (Site Kit) envían datos antes de que el visitante acepte nada.

Hay material que merece salvarse: las fichas de las 4 pinturas y la del Chardin, las dos entradas del blog, la idea del Proyecto Aula y la de «Comparte tu pieza», los sellos reales de Murcia, la paleta crema/granate/oro y el nombre.

---

## 0. Método, fuentes y límites

| Fuente | Uso |
|---|---|
| `/tmp/felipe/shots/*.png` (20 capturas) | Revisadas una a una. **Límite:** todas miden 1440×900 o 500×900, así que solo muestran la primera pantalla, no la página completa. Lo que queda por debajo se ha auditado en el HTML. |
| `/tmp/felipe/home.html` | Portada tal como se sirve (152 846 bytes). |
| `/tmp/felipe/mirror/*/index.html` | 24 páginas públicas. Las carpetas `contacto/200…900` son un bucle del crawler y se han ignorado. El espejo **solo contiene `wp-content/uploads`**, no CSS ni JS, así que el peso se ha medido contra el sitio en vivo (ver §1). |
| `/tmp/felipe/backup/museopostal-export-all-2026-09-28.xml` | WXR: 23 páginas, 2 entradas, 2 productos, 143 adjuntos, 17 `nav_menu_item`, `_elementor_data`. |
| `/tmp/felipe/pages.json`, `posts.json`, `media/media-index.json` | Títulos, slugs, `alt_text` de los 143 medios. |
| `/tmp/felipe/plugins.html` | Estado activo/inactivo de los 29 plugins. `/tmp/felipe/inventory.md` **no existe** en disco. |
| Sitio en vivo | `curl` (TTFB, cabeceras, robots, sitemaps, búsqueda, 404) y Chrome headless por CDP (LCP, peticiones, dominios contactados). PageSpeed Insights devolvió `429 Quota exceeded` y no se usó. |

**Aviso sobre los tiempos:** este Mac sale a Internet por un proxy local (`https_proxy=127.0.0.1:18303`), que infla las cifras absolutas. Para calibrar: por el mismo proxy, wordpress.org dio un TTFB de 1,01–3,11 s y correos.es de 0,82–1,52 s. Lo que importa son las cifras relativas y la cabecera `server-timing` del propio servidor.

---

## 1. Datos medidos

### 1.1 `curl -s -o /dev/null -w '%{time_starttransfer} %{time_total} %{size_download}' https://museopostal.org/`

| Pasada | TTFB (s) | Total (s) | Bytes |
|---|---|---|---|
| 1 | 8,416 | 9,442 | 152 846 |
| 2 | 2,059 | 3,767 | 152 846 |
| 3 | 10,334 | 11,034 | 152 846 |
| 4 (extra) | 2,050 | 3,649 | 152 846 · `server-timing: EXPIRED , rt;dur=1.252` |
| 5 (extra) | 4,934 | 7,468 | 152 846 · `rt;dur=3.304` |
| 6 (extra) | 3,158 | 4,401 | 152 846 · `rt;dur=1.403` |

La cabecera `x-microcache: True` va acompañada siempre de `EXPIRED`, es decir, la caché del hosting nunca sirvió la portada. Según `server-timing`, el servidor tarda 1,25–3,3 s en generar el HTML (PHP 8.4.17, nginx, Webempresa). No hay `cache-control` en el HTML.

### 1.2 Chrome headless (CDP, sin caché)

| Perfil | TTFB | FCP = LCP | DOMContentLoaded | load | Peticiones | Transferido | CLS |
|---|---|---|---|---|---|---|---|
| Escritorio 1440×900, sin limitar (pasada 1) | 2,03 s | 4,38 s | 7,38 s | 8,26 s | 151 | 1 336 KB | 0,004 |
| Escritorio (pasada 2) | 2,34 s | 3,01 s | 5,69 s | 6,61 s | 150 | 1 276 KB | 0,003 |
| Móvil 412 px, 1,6 Mbit/s, 150 ms RTT, CPU ×4 | 2,85 s | **4,90 s** | **14,05 s** | **15,11 s** | 151 | **2 338 KB** | 0,010 |

- El elemento LCP es siempre el `<p class="elementor-heading-title">` del saludo, que es texto y no imagen. Lo retrasan las 60 hojas de estilo y las fuentes que bloquean el renderizado. Un LCP por encima de 4 s es «malo» según los umbrales de Core Web Vitals (https://web.dev/articles/vitals).
- Dominios contactados **sin tocar el banner de cookies**: `www.clarity.ms`, `scripts.clarity.ms`, `c.clarity.ms`, `e/n/o.clarity.ms` (recogida de Clarity), `www.googletagmanager.com`, `www.google-analytics.com` y `fonts.googleapis.com`.
- El CLS es bueno (≤ 0,01) y hay que mantenerlo.

### 1.3 Inventario de recursos de `home.html`

- **106 etiquetas `<script>`**: 64 externas y 42 en línea. **63 `<link rel=stylesheet>`**, 60 de ellas encoladas por WordPress.
- 130 URL únicas de JS, CSS e imágenes. Peso descargado con UA de Chrome y `br/gzip`: **1 022 KB de recursos + 30 KB de HTML**. Por tipo: JS 510 KB en 63 ficheros (`gtag.js` de Site Kit pesa 173 KB comprimido), CSS 162 KB en 60 ficheros e imágenes 348 KB en 7 ficheros. Descomprimido: 1 516 KB más 149 KB de HTML.
- La imagen más pesada es `LOGOMUSEOPOSTAL-293x300.png`, con **156 KB**, un logo de 293 px que se muestra al 56 % de opacidad al pie de la portada. El original `LOGOMUSEOPOSTAL.png` pesa 913 KB.
- **Fuentes:** 7 peticiones CSS a Google Fonts (Playfair Display dos veces, una desde Neve y otra desde Elementor; Playfair; Montserrat; Roboto; Roboto Slab; Alex Brush), con **307 `@font-face`** y 46 woff2 distintos. Roboto, Roboto Slab, Alex Brush y Playfair Display se piden con los 18 pesos y estilos (`100…900italic`). En Museos del Mundo se añade **Poppins**.
- El JS del filtro de productos HUSKY/WOOF (`woocommerce-products-filter`) aporta **21 scripts y 25 hojas de estilo** en todas las páginas (y el núcleo de WooCommerce otros 13 scripts), para una tienda que tiene 2 productos.

### 1.4 Plugins activos que se ven en el HTML (26 activos de 29, según `plugins.html`)

| Función | Plugins activos | Huella en `home.html` |
|---|---|---|
| Maquetador | Elementor + **Essential Addons** + **Element Pack Lite** (bdthemes) + **Royal Elementor Addons** + Templately | `eael-general`, `bdt-uikit` (57 KB JS), `wpr-*`, particles.js, jarallax y parallax cargados sin usarse |
| SEO (×2) | **Yoast SEO 28.5** + **All in One SEO 5.0.2** | 2 `<link rel="canonical">`, 2 bloques Open Graph que se contradicen, 2 grafos JSON-LD |
| Analítica (×4) | **Site Kit** (GA `GT-5RMB74JP`), **MonsterInsights** (GA `G-DY7BN4YTKW`), **Microsoft Clarity**, **UserFeedback Lite** | Dos `gtag` distintos. Clarity se inyecta sin bloqueo |
| Publicidad | **Reddit for WooCommerce** | `redditAdsTrackingData = {"is_pixel_enabled":"1","is_conversion_enabled":"1"…}` |
| Consentimiento (×3) | **Complianz** (+ Complianz Terms & Conditions), **WPConsent**, **Protección de datos RGPD** | Solo Complianz dibuja banner. WPConsent no deja huella visible. RGPD solo deja CSS (`/* Sección de Privacidad (RGPD) */` en `contacto`) |
| Formularios (×2) | **Contact Form 7** (Contacto) + **WPForms Lite** (Formulario_informacion) | Los dos cargan JS en todas las páginas. Site Kit añade además los «events providers» de CF7, WPForms y WooCommerce |
| Tienda | WooCommerce + WOOF/HUSKY | photoswipe, flexslider, zoom y `single-product.min.js` cargados en la portada |
| Otros | Feedzy RSS, Cool Timeline + Timeline Block (**dos plugins de línea de tiempo**), Image Optimization, Really Simple SSL, Duplicator | CSS `cltb_cp_timeline`, CSS de feedzy |

---

## 2. Problemas priorizados

Escala: **P0** impide la misión (el visitante no puede visitar el museo, o hay riesgo legal o de credibilidad); **P1** la perjudica claramente; **P2** es pulido.

### P0: bloquean la misión

**P0-1 · La portada no lleva a las salas: 3 de 6 tarjetas no tienen enlace, entre ellas la sala de Murcia**
- *Página:* portada. *Evidencia:* `home-desktop.png`, `home-mobile.png`. En `home.html`, las `<figure>` de «Museo Postal de la Región» (`5_murcia-300x183.png`), «Comparte tu pieza con el Museo» (la **misma** imagen `5_murcia`) y «Juegos y Juguetes .... postales» no contienen `<a>`. Solo enlazan Museos del Mundo, Las Pinturas y Eclipses. Este último abre en `target="_blank"` y lleva un atributo basura `eclipse=""`.
- *Por qué importa:* el visitante que pulsa la tarjeta de Murcia, que es la razón de ser del museo, no obtiene nada. La primera y la tercera tarjeta son idénticas, así que parecen un error.
- *Arreglo:* una portada con un H1 que diga qué es el museo, 3–5 salas **reales y enlazadas** con fotografía de pieza auténtica, y ninguna tarjeta sin destino.

**P0-2 · Las salas están vacías, rotas o tapadas**

| Página (slug) | Estado real | Evidencia |
|---|---|---|
| Museo_murcia (`/museo_murcia/`) | 3 imágenes (sellos «La Parranda» 1983, «Revolución Cantonal de Cartagena» y un tercer escaneo), **0 títulos**, 3 alt vacíos y una única línea de texto: «Narciso García Yepes (Lorca.1927-Murcia.1997)». Imágenes de 372, 555 y 1024 px de ancho | `museo_murcia-desktop.png`, mirror |
| Museos del Mundo (`/museos-del-mundo/`) | 8 fotos de fachadas con alt correcto, pero **sin nombre visible, sin texto y sin enlace** al museo real. Dos H1 («Museos en el Mundo» y «Museos Postales en el Mundo») | `museos-desktop.png` |
| Investigación (`/investigacion/`) | 3 tarjetas. Solo «Videoconferencias» enlaza; «El informe semanal» y «Carteros Honorarios» están muertas. 0 títulos. Alt = nombre de fichero (`11_conferencias`) | `investigacion-desktop.png` |
| 11-Videoconferencias | 11 vídeos de YouTube tapados por «Haz clic para aceptar cookies de marketing y permitir este contenido». No hay título en texto, así que sin aceptar marketing la sala queda vacía. La meta description son URL crudas de youtu.be | `videoconf-desktop.png`, `videoconf-mobile.png` |
| Proyecto_Aula_001 (`/la-tarjeta-del-soldado/`) | Está configurada como **página de Tienda de WooCommerce**: `<body class="… post-type-archive-product woocommerce-shop">` con `woocommerce-coming-soon-store-only`. Muestra «Tenemos grandes proyectos por anunciar. Se está cocinando algo grande. Nuestra tienda está en obras…». Su contenido real (`tarjeta1gm1.jpg`, `tarjeta1gm2.jpg`) nunca se ve | `aula-desktop.png`, `aula-mobile.png`, WXR id 118 |
| Padre_museo (`/padre_museo/`) | Widget `bdt-navbar` sin menú: el contenido y la meta description dicen «Please select a Menu From Setting!». Aparece en `page-sitemap.xml` | WXR id 596 |
| Comparte_museo (`/pagina_wasap/`) | H1 literal «Comparte_museo», texto con «Whasap» y un enlace `wa.me` al **móvil personal**. 3 imágenes sin alt | mirror |

- *Por qué importa:* un museo virtual se visita recorriendo salas. Hoy casi todas llevan a un callejón sin salida o a un aviso de tienda.
- *Arreglo:* publicar menos salas pero completas. Retirar o despublicar Padre_museo, Proyecto Aula (hasta que tenga contenido), las tarjetas muertas y Juegos y Juguetes. Separar la página de Tienda de WooCommerce de Proyecto Aula.

**P0-3 · La arquitectura de navegación no es la de un museo, y hay páginas huérfanas**
- *Evidencia:* el menú principal (`MENU PRINCIPAL` en el WXR) es Blog · Investigación · **Museos** (= portada) · Tienda · Contacto. Estas páginas **no reciben ningún enlace** ni desde el menú ni desde el contenido: Museo_murcia, Comparte_museo, Proyecto_Aula_001, «Una mujer sellando una carta» (Chardin), Formulario de Contacto y Padre_museo. «Las pinturas» solo se alcanza desde una tarjeta de la portada. En el WXR hay 9 `nav_menu_item` sueltos, sin menú, restos de menús anteriores.
- En escritorio aparecen a la vez el menú horizontal **y** una hamburguesa que abre un panel lateral con **los mismos 5 enlaces** (`nv-primary-navigation-top` y `nv-primary-navigation-sidebar` en `home.html`).
- El buscador solo existe en escritorio: en móvil la cabecera es logo + hamburguesa.
- El icono de **carrito** con «0» ocupa la cabecera de un museo y enlaza a `https://museopostal.org` (portada), porque WooCommerce no tiene página de carrito (`"cart_url":"https://museopostal.org"`). `/carrito/` redirige a la imagen `CARRITO.jpg` y `/tienda/` da 404.
- *Arreglo:* un menú de museo (Inicio · Salas o Colecciones · Aula · Actividades/Conferencias · Blog o Artículos · Sobre el museo · Contacto), sin hamburguesa duplicada en escritorio, con búsqueda también en móvil y sin carrito en cabecera.

**P0-4 · Seguimiento antes del consentimiento y tres plugins de consentimiento**
- *Evidencia:* Chrome sin interacción contacta `clarity.ms` (recogida incluida) y `google-analytics.com`. En `home.html`, `<script id="google_gtagjs-js" src="https://www.googletagmanager.com/gtag/js?id=GT-5RMB74JP" async>` se carga sin `type="text/plain"` y sin `gtag('consent','default',…)`. El loader de Clarity (`clarity.ms/tag/…`) va en línea sin bloqueo. Complianz solo reenvía señales a Clarity (`cmplzCallClarity`). El píxel de Reddit está activo (`is_pixel_enabled:"1"`). Las fuentes se piden a `fonts.googleapis.com`, así que la IP del visitante llega a Google sin consentimiento (LG München I, 20-01-2022, 3 O 17493/20). Solo el gtag de MonsterInsights está bien bloqueado (`type="text/plain" data-category="statistics"`).
- Hay tres plugins de consentimiento activos (Complianz, WPConsent y Protección de datos RGPD) y solo uno muestra banner.
- *Por qué importa:* una institución que pide confianza, y que además recoge correos para newsletter, no puede rastrear antes de preguntar. La AEPD exige consentimiento previo para cookies analíticas de terceros (Guía sobre el uso de las cookies, https://www.aepd.es/guias/guia-cookies.pdf).
- *Arreglo:* **una** herramienta de consentimiento, o mejor aún ninguna necesaria: analítica sin cookies y autoalojada, fuentes autoalojadas, fuera Clarity, Reddit y el segundo GA. YouTube con fachada `youtube-nocookie.com` que cargue al hacer clic.

**P0-5 · La imagen principal del museo son falsificaciones generadas por IA de material postal**
- *Evidencia:* `5_murcia.png` (1242×758) es un medallón dorado sobre una mesa de madera, con sobres de matasellos inventados («MURCIA 14 DE 1870», «VALENCIA DE ALCÁNTARA 1875»), letra manuscrita sin sentido («Hala Hamylon Murcia») y un escudo inventado. Las 9 imágenes de sala (`4_museos`, `Logo_Museo_pintura`, `Logo_Museo_juguete`, `botonEclipse`, `11_conferencias`, `9_elinforme`, `12_honorarios`, `videoconferencias`, `carteros-honorarios`) repiten la misma composición: medallón, madera, sobres, tintero y pluma (`home-desktop.png`, `investigacion-desktop.png`).
- *Por qué importa:* en un museo de filatelia la autenticidad **es** el producto. Un coleccionista reconoce enseguida un matasellos inventado, y seis medallones iguales hacen que las salas no se distingan entre sí.
- *Arreglo:* usar como portada de cada sala una **pieza real escaneada** (el museo ya las tiene: los sellos de Murcia, las cartas y los escaneos `img2025…`). Nunca material postal inventado.

**P0-6 · Rendimiento: el servidor tarda y la página pesa como una tienda grande**
- *Evidencia:* §1. TTFB de 2,0–10,3 s con `curl` (proceso PHP de 1,25–3,3 s, microcache siempre `EXPIRED`), LCP de 4,9 s y `load` de 15,1 s en móvil simulado, 150–151 peticiones y 2 338 KB en móvil.
- *Por qué importa:* el público natural (coleccionistas veteranos, docentes, visitantes desde el móvil) abandona antes de ver una sola pieza.
- *Arreglo:* ver objetivos T1–T4. En la práctica: menos plugins, caché de página real, fuentes autoalojadas y nada de WooCommerce ni WOOF fuera de la tienda.

### P1: perjudican claramente

**P1-1 · El texto principal cuesta de leer (serif negrita cursiva, interlineado ≈ 1, líneas de 151 caracteres)**
- *Evidencia:* `post-235.css`: `.elementor-element-65f435d .elementor-heading-title{font-family:"Playfair Display";font-weight:700;font-style:italic;letter-spacing:-0.1px;color:#8A1538}`. Es un **widget de título** configurado como `header_size:"p"` en `_elementor_data` que contiene un párrafo de ~90 palabras. En `home-desktop.png` hay 17 px entre líneas, con las líneas prácticamente pegadas, y la primera línea tiene **151 caracteres** (se recomiendan 60–75).
- *Arreglo:* texto corrido en redonda (no cursiva), de 18–20 px, con interlineado de 1,5–1,6 y un ancho máximo de ~70 caracteres. La cursiva, solo para citas.

**P1-2 · Siete familias tipográficas, cada zona con la suya**
- *Evidencia:* el menú va en Montserrat, los pies de tarjeta en Roboto, el saludo en Playfair Display cursiva, el pie de página, el banner y la tienda en Playfair (el banner, a 12 px), los H1 en **Alex Brush** (caligráfica, con `letter-spacing:3.9px;word-spacing:10px` en `post-7.css`; se ve en `museos-desktop.png` y `videoconf-desktop.png` como «Museos  en  el  Mundo»), el bloque oscuro de Museos del Mundo en Poppins espaciada y los títulos de las tarjetas del blog en Roboto. El kit de Elementor sigue con los colores por defecto (`--e-global-color-primary:#6EC1E4`, `--e-global-color-accent:#61CE70`).
- *Arreglo:* dos familias como máximo (una serif de lectura y una sans o versalitas para la interfaz), autoalojadas, con 3–4 pesos. Nada de caligráfica en títulos.

**P1-3 · Maquetación: marcos dobles dorados, logo repetido y tarjetas diminutas**
- *Evidencia:* los contenedores de tarjetas de la portada llevan `border-style:double;border-width:7px;border-color:#D4AF37;border-radius:27px` (`local-235-frontend-desktop.css`). Las imágenes tienen `border-style:groove;border-width:-10px…` (anchos **negativos**, CSS inválido). El dorado #D4AF37 sobre la crema #F4EAD5 da un contraste de 1,76:1.
- El logo aparece **tres veces** en la misma pantalla: en la cabecera, en el cuerpo (`LOGOMUSEOPOSTAL`, `opacity:0.56` y `box-shadow:-29px 49px 29px rgba(0,0,0,.5)`) y en el banner de cookies (`investigacion-desktop.png`, `contacto-desktop.png`).
- En el blog, las tarjetas miden 165 px en una rejilla con el 60 % vacío, y el autor aparece cortado como «Conservador del M» (`blog-desktop.png`).
- En la tienda, las tarjetas son blancas y los botones violeta `#8040ff`, fuera de la paleta (`tienda-desktop.png`).
- *Arreglo:* un único sistema de tarjeta: imagen real, título y una línea de contexto. Bordes finos o ninguno, espacio en blanco generoso y el logo una sola vez.

**P1-4 · Móvil: el banner de cookies tapa el 44 % de la pantalla en todas las páginas**
- *Evidencia:* en las 10 capturas `*-mobile.png` el banner ocupa de y≈505 a 900 (395 de 900 px). La cabecera ocupa 150 px más, así que queda ~40 % útil en la primera vista. En la portada móvil caben 3 tarjetas por fila, de ~147 px cada una, con pies de 2 líneas en ~12 px (`home-mobile.png`).
- *Arreglo:* si no hay rastreo, no hace falta banner. Si hace falta, una barra inferior de ≤ 25 % de alto. En móvil, tarjetas a una o dos columnas con objetivos táctiles de ≥ 44 px.

**P1-5 · El diseño del banner empuja a aceptar**
- *Evidencia:* «Aceptar» es el único botón con color (blanco sobre `#1E73BE`) y «Denegar» es gris claro `#f9f9f9`. Los enlaces azules `#1E73BE` sobre oro `#D4AF37` tienen un contraste de **2,35:1** (falla WCAG 1.4.3). El título va en Playfair a 15 px y el texto a 12 px. El marcado contiene plantillas sin rellenar: `Gestionar {vendor_count} proveedores` y `{title}`.
- *Arreglo:* aceptar y rechazar con el mismo peso visual, como pide la guía de la AEPD, y texto de 14 px como mínimo.

**P1-6 · Títulos, slugs y SEO: se ven los nombres internos**
- *Evidencia:* títulos visibles en la pestaña, en los resultados de búsqueda interna (`/?s=sello` devuelve «Eclipse_solar», «Cuadro_2», «Cuadro_1»…) y en Google: «Museos» (portada), «Eclipse_solar», «Las_pinturas», «Cuadro_1…4», «Museo_murcia», «Padre_museo», «Comparte_museo», «Proyecto_Aula_001», «11-Videoconferencias». Slugs: `/elementor-548/` (Tienda), `/elementor-573/` (Privacidad), `/elementor-662/`, `/elementor-821-copy/`, `/cuadro_1-copy-2/`, `/pagina_wasap/`, `/contenedor-de-blog/`, `/el-correo-submarino-2/`.
- **Yoast y AIOSEO a la vez:** 2 canónicos, 2 `og:title`, `og:image` distinto en cada uno (`LOGOMUSPOS1.jpg` frente a `5_murcia.png`) y un `og:site_name` que arrastra el lema caducado. `robots.txt` tiene dos grupos `User-agent: *` y declara 3 sitemaps (`sitemap.xml`, `sitemap.rss`, `sitemap_index.xml`, que redirige 302 a `sitemap.xml`). El `page-sitemap.xml` indexa Padre_museo, Proyecto Aula (aviso de tienda) y las imágenes IA.
- **Meta descriptions:** 6 de las 22 páginas no tienen (Las_pinturas, Contacto, Investigación, Cookies, Museo_murcia, Proyecto Aula). La de la portada empieza por «¡ Bienvenida y Bienvenido ! Espero que disfrute…». La de Padre_museo es «Please select a Menu From Setting!». La de Videoconferencias son URL de YouTube.
- *Arreglo:* un solo plugin de SEO, títulos editoriales («La carta de amor · Willem Bartel van der Kooi · Museo Postal de Murcia»), slugs legibles con redirecciones 301 desde los viejos y meta description escrita a mano en cada sala.

**P1-7 · Accesibilidad (WCAG 2.2)**

| Criterio | Hallazgo | Evidencia |
|---|---|---|
| 1.3.1 / 2.4.6 Encabezados | **0 encabezados** en portada, Contacto, Investigación, Museo_murcia, Las_pinturas y Padre_museo. **Dos H1** en Museos del Mundo. Saltos h1→h2→**h5** en «El wi-fi del Siglo XIX». Las fichas de cuadro empiezan en h2 (sin H1) y bajan a h4 | análisis de encabezados sobre el mirror |
| 1.1.1 Texto alternativo | **118 de 143** medios con `alt_text` vacío (83 %). En la portada, 6 de 7 imágenes de contenido con `alt=""`. En Investigación el alt es el nombre del fichero. Hay un alt con errata: «Boton Filatelia y Eclipes» | `media-index.json`, `home.html` |
| Nombre accesible del logo | El enlace del logo tiene `aria-label="Museo Postal y Filatélico de la Región de Murcia Estamos construyendo y dándole contenido. Estás en un sitio de iniciativa privada. . ¡ EL 1 de Agosto comenzamos !"`. Un lector de pantalla lo lee en cada página | `home.html` |
| 1.3.1 / 3.3.2 / 4.1.2 Formularios | En Contacto (CF7), los `<label>Nombre</label>` **no están asociados** a su `<input>` (sin `for`/`id` y sin envolverlo). La pista va en el `placeholder` | `mirror/contacto/index.html` |
| 1.4.3 Contraste | Enlaces del banner 2,35:1. Granate `#8A1538` sobre el oro del pie `#D4AF37`: 4,45:1 (no llega a 4,5). Lo demás aprueba: granate sobre crema 7,83:1, texto negro 17,6:1 | cálculo WCAG con colores del CSS y píxeles de las capturas |
| 2.5.8 Tamaño del objetivo | Tarjetas de ~147 px con pie de 12 px en móvil. Enlaces «Leer más» de ~11 px en el blog | `home-mobile.png`, `blog-desktop.png` |
| 3.1.1 Idioma | `lang="es"` correcto (se podría precisar `es-ES`) | `home.html` |
| 2.4.1 Saltar bloques | Hay enlace «Saltar al contenido» (Neve) y hay que conservarlo | `home.html` |

**P1-8 · Formularios duplicados y promesa de newsletter sin sistema**
- *Evidencia:* hay dos formularios con dos plugins. Contacto (CF7 id 798) pide nombre, correo, 5 temas, comentarios y la casilla de privacidad. Formulario_informacion (WPForms id 325) no está enlazado desde ningún sitio y tiene la etiqueta «Que de Correo», «informad@» y «Acepto las políticas de privacidad de este sitio seguro». El saludo de la portada pide «complete y envíe el formulario de Contacto» para la newsletter, **sin enlace**. El enlace «Política de Privacidad» del formulario apunta a `/politica-privacidad`, que devuelve **404** (la real está en `/elementor-573/`). En `contacto-desktop.png` hay ~70 px de hueco entre etiqueta y campo.
- *Arreglo:* un formulario de contacto y un alta a newsletter con doble opt-in, cada uno con su propósito, etiquetas asociadas y un enlace a privacidad que funcione.

**P1-9 · La tienda está rota y además no pinta nada en la cabecera**
- *Evidencia:* `/elementor-548/` lista 2 productos con «Añadir Al Carrito» y «Seleccionar Opciones» (en Title Case), estrellas vacías («Valorado con 0 de 5») y un icono de ojo. Pero las fichas de producto (`/producto/125-aniversario-submarino-peral/`, comprobado en vivo) muestran «Tenemos grandes proyectos por anunciar» (modo *coming soon* de WooCommerce). No hay página de carrito. Las condiciones (`/elementor-662/`) no mencionan desistimiento ni devoluciones.
- *Por qué importa:* un botón de compra que lleva a «tienda en obras» resta credibilidad al museo entero.
- *Arreglo:* decidir con Felipe. O bien la tienda se retira y los dos artículos pasan a «Publicaciones» con contacto por correo, o bien se completa (carrito, pago, desistimiento) y se relega al pie o a una sección «Tienda del museo». En ningún caso debe estar en el menú principal ni en la cabecera.

**P1-10 · Redacción y tono**
- Lema del sitio (en `og:site_name` y `aria-label`): «Estamos construyendo y  dándole contenido. Estás en un sitio de iniciativa privada. . ¡ EL 1 de Agosto comenzamos !». Tiene doble punto, doble espacio, «EL» en mayúsculas y «Agosto» con mayúscula, y la fecha ya pasó: hoy es 28-09-2026.
- «¡ Bienvenida y Bienvenido !» lleva espacios tras «¡» y antes de «!», que no se usan en español. Además, el saludo habla a un visitante que está «en un museo que aún está trabajando en dar contenido a algunos de los enlaces»: la primera frase se disculpa.
- El tratamiento es mixto: la portada usa «usted» («disfrute», «desea») y Contacto usa «tú» («Escribe tu nombre», «Selecciona»). WPForms usa «informad@».
- Erratas: «Whasap», «Politica de privacidad», «Condiciones de uso y envio», «Un funeral pictorico», «Juegos y Juguetes .... postales», «Todos los derechos reservados **®**2026» (el ® es de marca registrada; debería ser ©).
- *Arreglo:* guía de estilo breve con usted o tú (uno solo), sin disculpas en portada y sin fechas de lanzamiento en el lema.

**P1-11 · Datos personales del titular expuestos**
- *Evidencia:* `/elementor-662/` publica el DNI completo y el domicilio del titular, y la política de privacidad repite el domicilio y un correo personal de Gmail. Comparte_museo enlaza a un número de móvil personal por `wa.me`. La URL `/author/felipe/` revela el nombre de usuario de WordPress.
- *Por qué importa:* el art. 10 de la LSSI exige identificar al titular si hay actividad económica (la tienda). Sin tienda, esa obligación cambia. En cualquier caso, es exposición personal innecesaria.
- *Arreglo:* consultarlo con Felipe. Usar un correo del dominio (p. ej. `contacto@museopostal.org`) y un formulario en lugar del móvil personal, y cambiar el slug del autor (nicename).

**P1-12 · Comentarios abiertos sin antispam**
- *Evidencia:* las dos entradas muestran «Deja una respuesta» y Akismet está **inactivo**.
- *Arreglo:* cerrar comentarios, o activar antispam y moderación.

### P2: pulido

- **P2-1 · Logo:** hay dos logos en la biblioteca. Uno es granate («MUSEOPOSTAL.ORG · Filatelia e Historia Postal», lupa sobre el mapa de Murcia, `LOGOMUSPOS1.jpg` 712×729). El otro es azul («Museo Postal y Filatélico de la Región de Murcia», sello con corneta y castillo, `logotipo-mupo.png` 665×670, sin uso visible). El de la cabecera es un **JPEG** con fondo de papel verdoso que se ve como un cuadrado sobre la crema del sitio (`home-desktop.png`), y a 120 px el texto «FILATELIA E HISTORIA POSTAL» no se lee. No hay favicon (`<link rel="icon">` ausente). *Arreglo:* elegir un logo y vectorizarlo en SVG con fondo transparente, más una versión horizontal para la cabecera y favicon.
- **P2-2 · Pie:** la columna izquierda está vacía (`<p class="wp-block-paragraph"></p>`), el bloque dorado arranca en x=135 mientras el contenido lo hace en x=150, faltan dirección, correo, redes y newsletter, y el signo ® es incorrecto (`aula-desktop.png`, `tienda-desktop.png`).
- **P2-3 · Entradas:** la cabecera muestra a la vez la fecha de publicación y la de modificación, sin rótulo («18 de mayo de 2026 24 de julio de 2026»). Los extractos del blog funden el título interno con el cuerpo («Guerra Civil, Correo Submarino y Cartagena El 11 de mayo...»). «Leer más» sale en el azul por defecto del navegador y en Playfair, fuera del sistema.
- **P2-4 · Botones de la tienda en Title Case** («Añadir Al Carrito», «Seleccionar Opciones»), fuera de la norma ortográfica.
- **P2-5 · Enlaces que abren pestaña nueva sin avisarlo** (Eclipses) y atributo HTML inválido `eclipse=""`.
- **P2-6 · Botón «Scroll al inicio»** con etiqueta en inglés a medias.
- **P2-7 · Restos:** 9 `nav_menu_item` huérfanos, página Padre_museo, el Elementor Kit con colores por defecto, plugins inactivos (Akismet, Optimole, Pojo Accessibility) y Duplicator, que conviene desactivar después de usarlo.
- **P2-8 · Consistencia entre páginas:** el ancho de contenido cambia de una página a otra (1140 px en la portada, ~770 px en las entradas con margen izquierdo de 325 px, rejilla del blog de 4 columnas con 2 entradas). Las migas «Portada »» aparecen en las entradas y en solo 6 de las 22 páginas (Museos del Mundo, Videoconferencias, Comparte, Chardin, Formulario y Cookies), no en la portada, Investigación, Contacto, las fichas de cuadro ni la tienda. El H1 es visible en unas y no existe en otras.

---

## 3. Lo que merece conservarse

1. **El nombre** «Museo Postal y Filatélico de la Región de Murcia» y el dominio `museopostal.org`. El marco «museo virtual, desde y para la Región de Murcia» es un buen posicionamiento y no hay que cambiarlo.
2. **El concepto del logo granate** (sello dentado, lupa y mapa de Murcia, corona de laurel y corneta), que cuenta la idea de un vistazo. Necesita redibujarse en vector. El azul «MUPO» sirve como alternativa, pero hay que elegir uno.
3. **La paleta** crema `#F4EAD5`, granate `#8A1538`, azul tinta `#1A2E44` y oro `#D4AF37`, que es coherente con el papel y los sellos antiguos. El granate sobre crema da 7,83:1 y el azul sobre crema 11,58:1. El oro, solo como acento fino y nunca para texto ni como fondo del pie.
4. **La sala de pintura**: las fichas de los 4 cuadros (`/elementor-821/` San Jerónimo de Georges de la Tour, `/elementor-821-copy/` La carta de amor, `/cuadro_1-copy/` Las últimas diligencias de James Pollard, `/cuadro_1-copy-2/` El cartero del pueblo de Heywood Hardy) y la de Chardin (`/jean-baptiste-simeon-chardin/`). Siguen una estructura de cartela real (autor, título y fecha, país y estilo, ubicación) y tienen alt correcto. Es el mejor contenido del sitio y el modelo para las demás salas.
5. **Las dos entradas**: «El wi-fi del Siglo XIX» (prefilatelia, tono divulgativo que engancha) y «El Correo Submarino» (Guerra Civil y Cartagena, anclada en Murcia). También **Eclipse_solar** (19 imágenes de sellos de eclipses).
6. **Los sellos y escaneos reales** de Museo_murcia (La Parranda 1983, Revolución Cantonal de Cartagena, Narciso García Yepes) y las fotos `img2025…`: son el material auténtico que debe sustituir a los medallones IA.
7. **La idea del Proyecto Aula** («La tarjeta del soldado», `tarjeta1gm1.jpg` y `tarjeta1gm2.jpg`): una línea educativa para colegios e institutos, que es lo que distingue a un museo de un blog. Hoy está oculta por la tienda.
8. **La idea de «Comparte tu pieza con el Museo»**: participación ciudadana con piezas locales. Hay que rehacerla con formulario y subida de foto, sin el móvil personal.
9. **Las 11 videoconferencias** (AFINET, SOFIMA, Ágora de Filatelia): con título, ponente y fecha en texto se convierten en una videoteca de verdad.
10. **Las 8 fotos de Museos del Mundo** (alt ya correctos), que pueden ser un directorio con nombre, ciudad y enlace.
11. **Técnicamente**: el CLS bajo (≤ 0,01), el enlace «Saltar al contenido» y `lang="es"`.

---

## 4. Diez objetivos medibles para el rediseño

| # | Métrica | Hoy (medido) | Objetivo | Cómo medirlo |
|---|---|---|---|---|
| T1 | LCP de la portada, móvil (412 px, 1,6 Mbit/s, 150 ms, CPU ×4) | 4,90 s | **≤ 2,5 s** (≤ 1,5 s en escritorio) | Chrome headless por CDP o PageSpeed Insights |
| T2 | TTFB del HTML (servidor) | 2,0–10,3 s (`curl`); `server-timing rt` 1,25–3,3 s; microcache `EXPIRED` | **≤ 0,6 s** con caché de página acertando (`HIT`) | `curl -w %{time_starttransfer}` ×5 y cabecera `x-microcache` |
| T3 | Peso transferido de la portada | 2 338 KB móvil / 1 276–1 336 KB escritorio | **≤ 500 KB** móvil, JS ≤ 80 KB comprimido | CDP `encodedDataLength` |
| T4 | Peticiones de la portada | 150–151 (64 `<script src>`, 63 hojas de estilo) | **≤ 25**, con ≤ 3 CSS y ≤ 5 JS | CDP / DevTools |
| T5 | Terceros antes del consentimiento | 4 subdominios de clarity.ms, google-analytics.com, googletagmanager.com, fonts.googleapis.com | **0 peticiones a terceros** sin acción del usuario; **1** herramienta de consentimiento como máximo (0 si no hay rastreo) | Lista de dominios en CDP con perfil limpio |
| T6 | Tipografía | 7 familias, 307 `@font-face`, cuerpo en cursiva negrita, interlineado ≈ 1, 151 car./línea | **≤ 2 familias autoalojadas**, cuerpo en redonda de ≥ 18 px, interlineado ≥ 1,5 y 60–75 car./línea | CSS computado y captura |
| T7 | Contraste de texto | mínimo 2,35:1 (banner) y 4,45:1 (pie) | **≥ 4,5:1** en todo texto, ≥ 3:1 en bordes de controles | Calculadora WCAG sobre el CSS final |
| T8 | Estructura y alt | 6 páginas sin encabezados, 1 con dos H1, 118/143 medios sin alt | **1 H1 por página, sin saltos de nivel**; **100 %** de imágenes de contenido con alt descriptivo (decorativas marcadas `alt=""`) | Script de encabezados y alt sobre el HTML servido; axe DevTools sin errores |
| T9 | Objetivos táctiles y banner en móvil | tarjetas de ~147 px con pies de 12 px; banner al 44 % del viewport | **≥ 44×44 px** en todo control; banner ≤ 25 % del alto (o ninguno) | Captura a 390 y 500 px |
| T10 | Integridad de navegación | 3/6 tarjetas de portada sin enlace, 6 páginas huérfanas, 1 enlace interno 404, 10 títulos con «_» y 6 slugs `elementor-N`, 2 páginas en «coming soon», 26 plugins activos | **0** tarjetas sin destino, **0** huérfanas, **0** 404 internos, **0** títulos o slugs internos, **0** placeholders; **≤ 12 plugins activos** | Crawler (p. ej. `wget --spider` o Screaming Frog) y `wp plugin list --status=active` |

---

## 5. Resumen final

- Lo más grave: la portada no lleva a las salas (3 de 6 tarjetas muertas, sin H1), las salas están vacías o tapadas (Museo_murcia, Museos del Mundo, Proyecto Aula oculto tras «tienda en obras», Padre_museo roto) y la imagen principal son medallones IA con matasellos inventados.
- Clarity y GA (Site Kit) envían datos antes del consentimiento, con tres plugins de consentimiento activos. La portada hace 151 peticiones, pesa 2,3 MB en móvil y tiene un LCP de 4,9 s, y el servidor tarda de 1,3 a 3,3 s en generar cada página.
- Se conservan el nombre, el concepto del logo, la paleta crema/granate/azul, las fichas de pintura, las dos entradas y Eclipses, los sellos reales, el Proyecto Aula, «Comparte tu pieza» y las videoconferencias.
- **Siguiente paso:** con Felipe hay que decidir qué pasa con la tienda (retirarla o completarla) y con los datos personales publicados (DNI, domicilio, móvil). Esas dos decisiones cambian el menú, el pie de página y la obligación de mostrar banner de cookies.

Archivo: /tmp/felipe/research/04-auditoria-ux-ui.md