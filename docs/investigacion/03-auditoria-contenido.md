# museopostal.org: mapa de contenido y auditoría

Fecha: 28-09-2026. Alcance: todo el contenido del sitio actual (WordPress 7.1.2, tema Neve, Elementor 4.3.2, WooCommerce). El texto real, ya limpio y ordenado página a página, está en el fichero hermano `/tmp/felipe/research/03b-contenido-extraido.md`. Este informe también está en `/tmp/felipe/research/03-auditoria-contenido.md`.

## Resumen

- **Qué hay en el export (WXR):** 23 páginas, 2 entradas, 2 productos (con 6 variantes), 143 adjuntos, 2 menús clásicos, 2 formularios de Contact Form 7, 1 importación de Feedzy y 1 kit de Elementor. Quedan además restos de tres temas de bloques que ya no se usan.
- **Prosa real y reutilizable: unas 4.100 palabras en 10 piezas.**
  - 2 artículos de blog: Correo Submarino (1.136 palabras) y «El wi-fi del siglo XIX» (674).
  - La exposición del eclipse (607).
  - 5 fichas de pintura (740 + 4 × ~190).
  - El texto de bienvenida de la portada (90).
  - La invitación a compartir piezas por WhatsApp (32).
  - Aparte hay 2 textos legales largos (~2.000 palabras) que no sirven tal cual.
- **Casi la mitad de las páginas están vacías por dentro:**
  - Botones con imagen y sin texto (Investigación, Contacto, Las pinturas).
  - Galerías sin pies (Museos del mundo, Museo de Murcia).
  - Vídeos sin títulos (Videoconferencias).
  - Restos de pruebas: Padre_museo muestra al público «Please select a Menu From Setting!».
- **Seis páginas publicadas son huérfanas** (no llega a ellas ningún menú ni enlace): Comparte_museo, Proyecto_Aula_001, Formulario de Contacto, Padre_museo, Museo_murcia y la ficha de Chardin. Dos son justo las salas que la portada anuncia pero no enlaza: «Museo Postal de la Región» y «Comparte tu pieza».
- **La tienda no puede vender:**
  - No existen las páginas de carrito, pago ni cuenta.
  - La página de tienda de WooCommerce es la del «Proyecto Aula 001».
  - Las fichas de producto muestran «tienda en obras».
  - La variante «Usado» no tiene precio.
  - El icono del carrito lleva a la portada.
- **Los textos legales tienen errores serios:**
  - Las condiciones de uso están copiadas de otro comerciante filatélico (enlace y correo de estudifilatelic.com, domicilio en Barcelona).
  - Publican el DNI del titular.
  - La política de privacidad termina con una frase cortada.
  - El enlace a la política desde el formulario da 404.
- **Títulos y slugs internos a la vista del público:**
  - La portada se titula «Museos».
  - Las fichas de cuadros se llaman «Cuadro_1» a «Cuadro_4», con slugs `elementor-821`, `elementor-821-copy`, `cuadro_1-copy` y `cuadro_1-copy-2`.
  - La tienda está en `/elementor-548/` y la privacidad en `/elementor-573/`.
- **Siguiente paso:** el nuevo sitio puede arrancar con estas 10 piezas reales, 5 salas con contenido parcial y 4 salas vacías que Felipe ya tenía pensadas (juegos y juguetes, informe semanal, carteros honorarios, línea de tiempo). Hay que pedirle a Felipe el material que falta (sección 13).

---

## 1. Fuentes y método

| Fuente | Para qué se usó |
|---|---|
| `/tmp/felipe/backup/museopostal-export-all-2026-09-28.xml` | Fuente de verdad. Lo analiza el script `/tmp/felipe/research/_parse.py`, que saca `wp:post_id`, `wp:status`, `wp:post_name`, fechas y `postmeta`. El JSON de `_elementor_data` se recorrió nodo a nodo para sacar `widgetType`, textos, imágenes y enlaces. |
| `/tmp/felipe/pages.json`, `/tmp/felipe/posts.json` | Confirman qué está publicado: la API REST devuelve 22 páginas y 2 entradas. La página que falta es el borrador 748. |
| `/tmp/felipe/home.html`, `/tmp/felipe/mirror/**/index.html` | HTML tal como se sirve: `<title>`, H1, meta, menús como se ven, imágenes realmente servidas y grafo de enlaces. |
| `/tmp/felipe/shots/*.png` | Estado visual. Se revisaron home, videoconf, museo_murcia, museos y aula en escritorio, y home en móvil. |
| `/tmp/felipe/media/media-index.json` | 143 adjuntos; coincide con el export. |
| Comprobaciones en vivo (solo lectura, 28-09-2026) | Se probaron con `curl` las 198 URL de `wp-content/uploads` que cita el HTML servido: todas devuelven 200. El control negativo `/wp-content/uploads/2026/05/NOEXISTE_control.jpg` devuelve 404, así que la prueba sí detecta roturas. Las 6 páginas publicadas que faltaban en el mirror se descargaron a `/tmp/felipe/research/_live/`. Los títulos de los 6 vídeos salen del oEmbed público de YouTube. |

El fichero `/tmp/felipe/inventory.md` **no existía** al escribir este informe. Por eso los plugins se deducen de los metadatos del export y del HTML (sección 10).

---

## 2. Identidad global del sitio

| Elemento | Valor actual | Problema |
|---|---|---|
| Título del sitio | «Museo Postal y Filatélico de la Región de Murcia» | Correcto. |
| Lema (tagline) | «Estamos construyendo y  dándole contenido. Estás en un sitio de iniciativa privada. . ¡ EL 1 de Agosto comenzamos !» | Caducado: el sitio abrió el 1-8-2026. Tiene doble espacio, «. .», «¡ EL» y signos separados. AIOSEO lo mete en `og:site_name`, así que sale en cada vista previa cuando alguien comparte un enlace. |
| `<title>` de la portada | «Museos - Museo Postal y Filatélico de la Región de Murcia» | Viene del título de la página 235, «Museos». |
| Meta descripción de la portada | Los primeros ~300 caracteres del texto de bienvenida, cortados a mitad de frase («…que inicia su andadura,») | Se genera sola; nadie la redactó. |
| SEO | Hay **dos plugins de SEO activos a la vez**: All in One SEO 5.0.2 y Yoast SEO 28.5 (lo dicen los comentarios de `home.html`). | La portada sale con **dos `rel=canonical`** y **dos juegos de Open Graph** con imágenes distintas (`LOGOMUSPOS1.jpg` y `5_murcia.png`). |
| Favicon | No hay (falta `<link rel="icon">` en `home.html`). | |
| Logo de cabecera | `LOGOMUSPOS1.jpg` (adjunto 587, 712×729), sin alt. | Es un JPG cuadrado con fondo verdoso sobre una cabecera beis (captura `home-desktop.png`). |
| H1 | 15 URL públicas **no tienen H1**: la portada, Blog, Investigación, Contacto, Tienda, Las pinturas, los 4 cuadros, Eclipse, Museo_murcia, Padre_museo y las 2 páginas legales. Museos del mundo tiene **dos**. | Los encabezados de Elementor quedan como `h2` o `p`, y la plantilla «ancho completo» de Neve oculta el título de la página. |
| Indexación | Todas las URL públicas llevan `robots: max-image-preview:large`; ninguna lleva `noindex`. | Los buscadores indexan también Padre_museo (con la meta descripción «Please select a Menu From Setting!») y las páginas huérfanas. |
| Kit de Elementor (id 7, «Kit por defecto»; es el único elemento de `elementor_library`) | Colores del sistema: principal `#6EC1E4` y énfasis `#61CE70` (los que trae Elementor de fábrica), secundario `#54595F`, texto `#700B0B`. Tipografías: Roboto / Roboto Slab (las de fábrica). H1 en Alex Brush, color `#8F3A3A`, con 3,9 px entre letras y 10 px entre palabras. | La letra manuscrita Alex Brush en todos los títulos de página se lee mal (captura `museos-desktop.png`). No hay plantillas guardadas ni cabecera o pie de Elementor. |
| CSS adicional (`custom_css` id 686, «neve») | **Vacío** (modificado el 6-6-2026). | No hay CSS propio que migrar. |
| Estilos globales (`wp_global_styles` 25, 583, 584, 677) | Cuatro registros vacíos para twentytwentytwo, theme-1, twentytwentyfour y neve. | Restos de temas probados. |
| Pie | «Todos los derechos reservados ®2026» y el menú legal. | Usa ® (marca registrada) donde debería ir ©. |

---

## 3. Menús

### 3.1 «MENU PRINCIPAL» (término 36, ubicación principal de Neve)

Ningún elemento tiene título propio: todos muestran el título de la página a la que enlazan.

| Orden | id del elemento | Destino (id de página) | Texto visible | URL |
|---|---|---|---|---|
| 1 | 645 | 531 Blog | Blog | `/contenedor-de-blog/` |
| 2 | 703 | 691 Investigación | Investigación | `/investigacion/` |
| 3 | 644 | 235 Museos (portada) | Museos | `/` |
| 4 | 648 | 548 Tienda | Tienda | `/elementor-548/` |
| 5 | 702 | 697 Contacto | Contacto | `/contacto/` |

Problemas:

- «Museos» lleva a la portada. No hay un «Inicio» explícito y ninguna sala del museo tiene entrada propia en el menú.
- El blog va primero y la portada tercera.
- En escritorio Neve pinta el menú en línea **y además** un botón de hamburguesa que abre el mismo menú en un panel lateral. En `<body>` aparece `menu_sidebar_slide_left` y en el HTML se lee tres veces «Menú de navegación».
- La cabecera tiene buscador y carrito. El icono del carrito enlaza a `https://museopostal.org`, es decir, a la portada.

### 3.2 «Menu_legal» (término 38, pie)

| Orden | id | Destino | Texto visible |
|---|---|---|---|
| 1 | 679 | 573 | «Politica de privacidad» (sin tilde) |
| 2 | 680 | 662 | «Condiciones de uso y envio» (sin tilde) |
| 3 | 681 | 658 | «Política de cookies (UE)» |

### 3.3 Restos

- **9 elementos de menú huérfanos en borrador** (602, 603, 604, 614, 615, 620, 631, 633 y 636, del 21-5-2026). Apuntan a Museo_murcia, Museos en el Mundo, Comparte_museo (3 veces), Tienda y Blog. Son de menús borrados y se pueden ignorar.
- **`wp_navigation` 29 «Menú Cabecera»**, de Twenty Twenty-Two. Enlaza a `/museo-postal-y-filatelico-region-de-murcia/` y `/pagina-ejemplo/`; las dos dan **404** en vivo.
- **`wp_navigation` 5 «Navegación»**: una simple lista de páginas (`page-list`).
- Ninguno de estos dos bloques de navegación se usa con Neve.

---

## 4. Grafo de enlaces: qué páginas se pueden alcanzar

- Desde los menús: 531, 691, 235, 548, 697, 573, 662 y 658.
- Desde la portada: 126 (Museos del mundo), 854 (Las pinturas) y 925 (Eclipse).
- Desde 854: 821, 827, 836 y 857.
- Desde 691: 97 (Videoconferencias).
- Desde 548: los 2 productos.
- Desde 531: las 2 entradas.

**Páginas huérfanas.** Están publicadas y responden 200, pero no las enlaza nada. Se buscaron enlaces en todo el HTML del mirror y en `home.html`.

| id | Título | URL | Qué debería enlazarla |
|---|---|---|---|
| 59 | Comparte_museo | `/pagina_wasap/` | El botón «Comparte tu pieza con el Museo» de la portada, que no tiene enlace. |
| 598 | Museo_murcia | `/museo_murcia/` | El botón «Museo Postal de la Región», que tampoco tiene enlace. |
| 753 | Una mujer sellando una carta | `/jean-baptiste-simeon-chardin/` | La galería de Las pinturas, que solo muestra 4 cuadros. |
| 118 | Proyecto_Aula_001 | `/la-tarjeta-del-soldado/` | Nada. Además hace de página de tienda de WooCommerce (sección 7). |
| 324 | Formulario de Contacto | `/formulario_informacion/` | Nada. Repite lo de Contacto con otro plugin de formularios. |
| 596 | Padre_museo | `/padre_museo/` | Nada. Es una prueba rota. |

**Botones que no llevan a ninguna parte:**

- En la portada: «Museo Postal de la Región», «Comparte tu pieza con el Museo» y «Juegos y Juguetes .... postales».
- En Investigación: «El informe semanal» y «Carteros Honorarios».

**Redirecciones que conviene conservar al migrar:**

- `/proximamente-pagina-principal/` → `/` (es el slug real de la página 235).
- `/el-correo-en-los-ultimos-2000-anos/` → `/el-wi-fi-del-siglo-xix/`.
- `/el-correo-submarino/` → `/el-correo-submarino-2/`.
- `/carrito/` → página de adjunto de `CARRITO.jpg`. Es una colisión de slug y hay que eliminarla, no conservarla.

---

## 5. Páginas (23)

Cada ficha recoge, cuando aplica:

- id, título interno, URL, estado, fechas de creación y modificación, y plantilla.
- Para qué sirve la página.
- Si el texto es real o de relleno, y cuántas palabras de prosa visible tiene. Cuentan los encabezados y los editores de texto; los pies de imagen se cuentan aparte.
- Imágenes, con su id de adjunto y fichero.
- Widgets de Elementor, como `widgetType` × n (sin contar los contenedores).
- Enlaces externos.
- Problemas.

Ninguna página tiene padre (`post_parent = 0` en todas), así que **no hay jerarquía**. Todas usan Elementor en modo `builder`.

### 5.1 Portada: id 235, «Museos»

- **URL:** `https://museopostal.org/`. El slug real es `proximamente-pagina-principal`.
- **Estado y fechas:** publicada; creada el 04-05-2026, modificada el 12-08-2026.
- **Plantilla:** `template-pagebuilder-full-width.php`. Imagen destacada: 233.
- **Para qué sirve:** bienvenida y mosaico de 6 salas.
- **Contenido:** real. 90 palabras, más 31 de pies.
- **Imágenes:** 233 `5_murcia.png` (dos veces), 232 `4_museos.png`, 777 `Logo_Museo_pintura.webp`, 776 `Logo_Museo_juguete.webp`, 920 `botonEclipse.webp` y 586 `LOGOMUSEOPOSTAL.png`. Seis de las siete no tienen alt.
- **Widgets:** heading ×1 e image ×7, dentro de contenedores `e-flexbox` (Elementor v4). El heading está configurado como `header_size: p`, así que no es un título.
- **Enlaces:** internos a 126, 854 y 925. El de 925 lleva `is_external: on` (abre pestaña nueva) y `custom_attributes: "eclipse"`, que no tiene el formato clave|valor que espera Elementor.
- **Problemas:**
  - El título interno «Museos» aparece en `<title>`, en el menú y en Open Graph. El slug «proximamente-pagina-principal» es un resto.
  - «Comparte tu pieza» usa la misma imagen que «Museo Postal de la Región» (233), y ninguno de los dos enlaza a su página.
  - «Juegos y Juguetes .... postales» es una sala sin página, escrita con cuatro puntos.
  - Todo el texto de bienvenida va en cursiva y granate, en un solo bloque (captura `home-desktop.png`).
  - Promete una newsletter mensual que no existe: el formulario de Contacto solo envía un correo a informacion@.
  - «¡ Bienvenida y Bienvenido !» lleva espacios dentro de los signos.
  - No tiene H1.
  - En móvil, el banner de cookies de Complianz tapa casi la mitad de la pantalla (`home-mobile.png`).

### 5.2 Blog: id 531, «Blog»

- **URL:** `/contenedor-de-blog/`. Publicada; 19-05 / 25-05-2026. Plantilla de ancho completo.
- **Para qué sirve:** índice de entradas.
- **Contenido:** ningún texto propio.
- **Widgets:** `eael-post-grid` ×1 (Essential Addons).
- **Problemas:**
  - No es la página de entradas nativa de WordPress, sino una rejilla de un complemento.
  - El `content:encoded` guardado está desfasado: lista una entrada 428 que ya no existe y un título antiguo.
  - La meta descripción son títulos pegados sin espacio («El Correo SubmarinoConservador del Museo…»).
  - No tiene H1.

### 5.3 Investigación: id 691

- **URL:** `/investigacion/`. Publicada; 22-05-2026. Plantilla de ancho completo.
- **Imagen destacada:** 233, la de Murcia, que no tiene relación con esta página.
- **Contenido:** 0 palabras de texto y 6 de pies. La página está vacía por dentro.
- **Imágenes:** 241 `11_conferencias.png`, 239 `9_elinforme.png`, 242 `12_honorarios.png` y el logo 586. Ninguna tiene alt.
- **Widgets:** image ×4.
- **Problemas:**
  - 2 de los 3 botones no llevan a ninguna parte.
  - No explica qué son «Carteros Honorarios» ni «El informe semanal».
  - No tiene H1.

### 5.4 Investigación - Copy: id 748 (borrador)

- **URL:** `/investigacion-copy/`. Da 404 porque no está publicada. Creada el 29-05, modificada el 15-07-2026.
- **Contenido:** maqueta sin texto.
  - Los 3 botones de Investigación.
  - 6 botones más, todos con la misma foto de stock (162, `pexels-shvets-…jpg`): «En la Pintura», «Biblioteca», «Hemeroteca», «Revistas del mes», «Informe AFINSA» y «COTIZACION ACTUAL».
  - Los botones que tienen enlace apuntan todos a Videoconferencias.
  - Al final hay un `text-editor` y un `e-heading` vacíos.
- **Valor:** es la lista de secciones que Felipe tenía en mente.

### 5.5 Videoconferencias: id 97, «11-Videoconferencias»

- **URL:** `/video-conferencias-historia-postal-y-filatelia/`. Publicada; 01-05 / 20-05-2026. Plantilla por defecto.
- **Contenido:** 0 palabras. La página no dice título, ponente, fecha ni fuente de ningún vídeo.
- **Widgets:** video ×6. Los títulos siguientes salen del oEmbed de YouTube, no de la página:

| ID | Título | Canal |
|---|---|---|
| UN_5rG_dqiQ | La Guerra Civil Española en la Filatelia | SOFIMA |
| zq1xeiuCDTM | Sellos de Isabel II: sus marcas y sus falsos (parte 1), por Manuel Gago (Tintero); YouTube escribe «Manual» | Afinet AgoradeFilatelia |
| Urkw7vTvUek | ¡Ese sello es de 2 reales! El secreto del mítico 2 reales azul de 1851 por fin explicado | Afinet AgoradeFilatelia |
| pbXu3SvLHb0 | El Correo en la Administración Central de Madrid hasta 1800 | SOFIMA |
| 89N1gaPyb1c | Barcos en la Filatelia | SOFIMA |
| 6iQwRhxRvxU | El asedio de París durante la Guerra Franco Prusiana | SOFIMA |

- **Problemas:**
  - Cada widget guarda también las URL de ejemplo que trae Elementor (Vimeo, Dailymotion, VideoPress). No se muestran, pero ensucian los datos.
  - El prefijo «11-» del título viene del nombre del botón `11_conferencias.png`.
  - Complianz bloquea los seis vídeos hasta que se aceptan las cookies de marketing (captura `videoconf-desktop.png`).
  - La meta descripción son las seis URL de YouTube pegadas.
  - Los vídeos son de terceros (SOFIMA, Afinet) y la página no los menciona ni les da crédito.

### 5.6 Museos en el Mundo: id 126

- **URL:** `/museos-del-mundo/`. Publicada; 01-05 / 21-06-2026.
- **Contenido:** 5 palabras, solo el encabezado «Museos Postales en el Mundo».
- **Imágenes:** un carrusel con 110 `museo_paris.jpg`, 108 `museo_japon.jpg`, 109 `museo_londres.avif`, 107 `museo_espana-scaled.webp`, 106 `museo_eeuu.jpg`, 111 `museo_suecia.jpg`, 105 `museo_chile.jpg` y 104 `museo_canada.webp`. Ninguna tiene pie ni alt.
- **Widgets:** heading ×1 (como h1) e image-carousel ×1.
- **Problemas:**
  - No dice qué museo es cada foto, ni dónde está, ni enlaza a ninguno.
  - Tiene dos H1.
  - Hay un bloque oscuro de ancho completo con las letras muy separadas.
  - Una de las imágenes está en AVIF.

### 5.7 Las pinturas: id 854, «Las_pinturas»

- **URL:** `/elementor-854/`. Publicada el 18-07-2026. Plantilla de ancho completo.
- **Contenido:** no hay ni una frase que presente la sala; solo 22 palabras de pies.
- **Imágenes:** 863 `CUADROS_EN_MUSEO.png` (alt «Sala museo»), 823, 829, 843 y 858. Todas tienen alt.
- **Widgets:** image ×5.
- **Problemas:**
  - El slug `elementor-854` lo generó WordPress y el título «Las_pinturas» lleva guion bajo.
  - Falta la quinta obra, la de Chardin (753).
  - El pie de la obra 3 dice «del correo **de** Newcastle» y su ficha dice «**en**».
  - Algunos metadatos están duplicados en la base de datos (`_wp_page_template`, `_elementor_edit_mode` y `_elementor_version` aparecen dos veces).
  - No tiene H1.

### 5.8 a 5.11 Fichas de cuadros: ids 821, 827, 836 y 857

Las cuatro tienen la misma estructura: heading ×1 (h2), text-editor ×1 e image ×1. Usan la plantilla de ancho completo y Elementor 4.2.0. Se crearon el 17 y 18-07-2026 y se modificaron el 27-07-2026. El texto es real: un subtítulo, tres párrafos y una ficha con autor, título y fecha, escuela y ubicación.

| id | Título interno (va al `<title>`) | URL | Obra | Palabras | Imagen | Problemas |
|---|---|---|---|---|---|---|
| 821 | Cuadro_1 | `/elementor-821/` | San Jerónimo leyendo una carta (Georges de La Tour, 1627-1629, Museo del Prado) | 193 | 823 `Cuadro_1_res.jpg` | Punto final en el encabezado; «transciende» (la RAE prefiere «trasciende»). |
| 827 | Cuadro_2 | `/elementor-821-copy/` | La carta de amor (Willem Bartel van der Kooi, 1808, Rijksmuseum) | 228 | 829 `cuadro_2_res.webp` | El slug «-copy» delata que se duplicó de otra página; doble espacio en «primera  decisión». |
| 836 | Cuadro_3 | `/cuadro_1-copy/` | Las últimas diligencias del correo en Newcastle upon Tyne (James Pollard, 1848, colección privada) | 175 | 843 `cuadro_3_res.webp` | «pictorico» sin tilde. |
| 857 | Cuadro_4 | `/cuadro_1-copy-2/` | El cartero del pueblo (Heywood Hardy, siglo XIX, colección privada) | 189 | 858 `cuadro_4_res.jpg` | El slug dice «cuadro_1-copy-2» para el cuadro 4. |

Problemas de las cuatro:

- No tienen H1.
- No se puede pasar de una obra a otra: no hay anterior/siguiente ni enlace de vuelta a la sala.
- Elementor guarda `.jpg` en 829 y 843, pero la biblioteca sirve `.webp`.
- No hay enlaces rotos.

### 5.12 Una mujer sellando una carta: id 753

- **URL:** `/jean-baptiste-simeon-chardin/`. Publicada; 06-06 / 21-06-2026. Plantilla por defecto.
- **Contenido:** real, **740 palabras**, con secciones propias.
- **Imágenes:** una sola, enlazada directamente desde Wikimedia Commons (`upload.wikimedia.org/…/Jean-Baptiste_Sim%C3%A9on_Chardin_013.jpg`). No está en la biblioteca de medios.
- **Widgets:** image ×1 y text-editor ×1.
- **Problemas:**
  - Es huérfana.
  - Su formato no se parece al de las otras cuatro fichas: tiene tono de blog y otra plantilla.
  - El enlace a museopostal.org está envuelto en una redirección de Gmail (`google.com/url?q=…&source=gmail`), porque el texto se copió de un correo.
  - Tiene metadatos duplicados en la base de datos.

### 5.13 Eclipse: id 925, «Eclipse_solar»

- **URL:** `/eclipse-solar-agosto-2026-filatelia-correos-espana/`. Publicada el 12-08-2026. Plantilla de ancho completo.
- **Contenido:** real, 607 palabras más 26 de pies.
  - Ficha técnica de la emisión de Correos: serie «Ciencia», emitida el 23-07-2026, impresión offset, papel estucado, engomado y fosforescente, 4 €, tirada de 65.000, hoja bloque.
  - Material de A Coruña: TuSello, tarjeta prefranqueada y matasellos.
  - Galería de 15 sellos de eclipses, de 1965 a 2024.
- **Imágenes:** 929, 930, 927 y 928, y la galería 931, 932, 936, 937, 939 a 947, 949 y 950. Las 15 de la galería no tienen alt; 4 de ellas (931, 945, 947 y 950) tampoco tienen pie.
- **Widgets:** heading ×2, `e-image` ×1, image ×18, text-editor ×2.
- **Problemas:**
  - Es una página y no una entrada, así que no sale en el blog y no tiene fecha ni categoría.
  - El `<title>` muestra el nombre interno «Eclipse_solar».
  - Erratas en el alt: «TARJTETA», «MATATASELLOS», «Eclipes».
  - Un pie está cortado: «2024 - Cá» (Canadá). Se ve así tanto en el export como en el HTML servido.
  - Otras erratas: «Las Pintadera», «paises», «De como», «sellos.......».
  - La ficha técnica está rota: «**Tamaño del sello:** 79,2 x 105,6 mmEfectos en pliego:** Hoja Bloque…». El tamaño 79,2 × 105,6 parece el de la hoja bloque; el sello mide 33 × 53. También sobra el `**` final en «Tirada: 65.000**».
  - Tres párrafos van maquetados como encabezados `h5`.
  - En la biblioteca hay duplicados sin usar: 938 y 948.

### 5.14 Museo_murcia: id 598

- **URL:** `/museo_murcia/`. Publicada; 21-05 / 24-07-2026.
- **Para qué sirve:** es la sala principal del proyecto según su propia descripción, pero está vacía por dentro: no tiene ni una palabra de texto.
- **Imágenes (ninguna con alt):**
  - 178 `1983_2697.jpg`: sello «La Parranda», 4 pta, 1983.
  - 187 `CANTONAL.jpg`: sello «Revolución Cantonal de Cartagena», 1,85 €.
  - 199: retrato con el pie «Narciso García Yepes (Lorca.1927-Murcia.1997)».
- **Problemas:** es huérfana y no explica nada de lo que muestra.

### 5.15 Comparte_museo: id 59

- **URL:** `/pagina_wasap/`. Publicada; 30-04 / 21-05-2026.
- **Contenido:** real, 32 palabras.
- **Imágenes:** 483 `wasap.png` y los ejemplos 205 y 204. Ninguna tiene alt.
- **Widgets:** heading ×1 e image ×3.
- **Enlaces:** [enlace wa.me al móvil personal].
- **Problemas:**
  - Es huérfana.
  - Erratas: «Whasap» y «¿ Te gustaría».
  - Todo el texto está dentro de un encabezado.
  - El H1 y el `<title>` dicen «Comparte_museo».
  - No explica qué se hace con las fotos que manda la gente.

### 5.16 Proyecto_Aula_001: id 118

- **URL:** `/la-tarjeta-del-soldado/`. Publicada; 01-05 / 10-08-2026.
- **Contenido:** 0 palabras. Solo dos escaneos, 120 y 121, titulados «EPSON MFP image» y sin alt.
- **Problema grave:** en vivo la página no muestra estos escaneos. Enseña «Tenemos grandes proyectos por anunciar… Nuestra tienda está en obras» (captura `aula-desktop.png`).
  - El motivo: el script del filtro de productos WOOF declara `woof_current_page_link = "https://museopostal.org/la-tarjeta-del-soldado/"`. Esta página es la página de tienda de WooCommerce, y el modo «Próximamente» de WooCommerce la tapa.
  - Es una deducción a partir del HTML: el ajuste `woocommerce_shop_page_id` no viene en el export.

### 5.17 Tienda: id 548

- **URL:** `/elementor-548/`. Publicada; 19-05 / 21-05-2026.
- **Contenido:** ningún texto propio.
- **Widgets:** `eicon-woocommerce` ×1 (rejilla de productos de Essential Addons, con `table_title` «Comparar productos»).
- **En vivo:**
  - El libro de la censura aparece a 60,00 € con el botón «Añadir al carrito».
  - El sello del Peral aparece a «3,00 € - 6,00 €».
  - Se muestra «Valorado con 0 de 5» aunque no hay reseñas.
- **Problemas:** el slug lo generó WordPress y esta no es la página de tienda oficial de WooCommerce (ver sección 7).

### 5.18 Contacto: id 697

- **URL:** `/contacto/`. Publicada; 22-05 / 22-06-2026.
- **Contenido:** 0 palabras. Ni correo, ni dirección, ni una explicación.
- **Imágenes y widgets:** el logo 586 sin alt, y el widget `bdt-contact-form-7` que carga el formulario CF7 798.
- **Problemas:** no tiene H1 y el enlace a la política de privacidad del formulario da 404 (sección 8).

### 5.19 Formulario de Contacto: id 324

- **URL:** `/formulario_informacion/`. Publicada; 08-05 / 21-06-2026. Imagen destacada: 310.
- **Contenido:** 16 palabras: «Si deseas estar informad@ de las novedades del sitio web, rellena y envía el siguiente formulario.»
- **Widgets:** text-editor ×1 y `wpforms` ×1 (formulario 325).
- **Problemas:**
  - Es huérfana.
  - Hace lo mismo que Contacto pero con otro plugin (WPForms).
  - El formulario 325 no viene en el export.

### 5.20 Padre_museo: id 596

- **URL:** `/padre_museo/`. Publicada el 21-05-2026.
- **Contenido:** en público se lee «**Please select a Menu From Setting!**», y esa frase es también su meta descripción.
- **Widgets:** `bdt-navbar` ×1 sin menú asignado.
- **Qué hacer:** es una página de prueba huérfana, en inglés y visible para los buscadores. Hay que borrarla.

### 5.21 Política de privacidad: id 573, «Politica de privacidad»

- **URL:** `/elementor-573/`. Publicada; 20-05 / 21-05-2026.
- **Contenido:** real, 724 palabras. Se pegó desde un PDF y cada línea termina con un salto de línea forzado (`<br />`).
- **Widgets:** heading ×1 y text-editor ×1.
- **Problemas:**
  - El encabezado está repetido.
  - Hay 4 viñetas «•» vacías.
  - **Termina a mitad de frase**: «Se aconseja al usuario revisar este».
  - El correo de contacto aparece entre corchetes.
  - Dice que usa cookies analíticas pero no nombra ningún proveedor, aunque el sitio carga Site Kit.
  - No menciona WhatsApp, YouTube ni WooCommerce.

### 5.22 Condiciones de uso y envío: id 662, «Condiciones de uso y envio»

- **URL:** `/elementor-662/`. Publicada el 21-05-2026.
- **Contenido:** 1.314 palabras, de las que solo dos frases son propias (las condiciones de envío). El resto es una plantilla de la ley de comercio electrónico (LSSI) **copiada de otro comercio**.
- **Widgets:** heading ×1 y text-editor ×1.
- **Problemas graves:**
  - El texto «WWW.» del titular enlaza a `estudifilatelic.com`.
  - Para ejercer los derechos de protección de datos (RGPD) remite a **estudi@estudifilatelic.com**.
  - Dice dos veces que el titular tiene domicilio en **Barcelona** (una de ellas como «30570-BARCELONA»), cuando en otro punto pone Murcia.
  - Publica el **DNI** del titular y además lo llama «CIF».
  - Las tildes están guardadas descompuestas (Unicode NFD, 103 marcas sueltas), lo que puede fallar en búsquedas y con algunas fuentes.
  - Erratas: «Envio», «envios», «le confiere el la normativa».

### 5.23 Política de cookies (UE): id 658

- **URL:** `/politica-de-cookies-ue/`.
- **Contenido:** solo el shortcode `[cmplz-document type="cookie-statement" region="eu"]`. Complianz genera unas 1.441 palabras a partir de él.
- **Qué hacer:** es texto generado. No hay que migrarlo; se vuelve a generar.

---

## 6. Entradas (2)

Las dos las firma el usuario `felipe`, que se muestra como «Conservador del Museo». Categoría: «Sin categoría». No tienen etiquetas ni comentarios.

### 6.1 id 472, «El wi-fi del Siglo XIX»

- **URL:** `/el-wi-fi-del-siglo-xix/`. La URL antigua `/el-correo-en-los-ultimos-2000-anos/` redirige aquí con 301.
- **Fechas:** publicada el 18-05-2026, modificada el 24-07-2026. Imagen destacada: 473.
- **Contenido:** real, 674 palabras. Recorre la etapa anterior al sello: el *cursus publicus*, el Itinerario de Antonino (Cartagena, Lorca, Águilas), la Ruta Murciana, el sello en las Partidas de Alfonso X, los Tassis, Felipe V y la Superintendencia de 1716, y el porte que pagaba el destinatario.
- **Imágenes:** 473, 474, 880, 878 y 879. Todas tienen alt.
- **Widgets:** text-editor ×4 e image ×5.
- **Problemas:**
  - Cada una de las cuatro secciones es una lista numerada independiente, así que todas salen como «1.».
  - Los títulos de sección son `h6`.
  - Una cita está metida dentro de una tabla.
  - Erratas en el alt: «ce correos» (de Correos) y «dia del sello» (Día del Sello).
  - «Siglo» va con mayúscula en el título.

### 6.2 id 717, «El Correo Submarino»

- **URL:** `/el-correo-submarino-2/`. La URL `/el-correo-submarino/` era de la entrada 428, ya borrada, y ahora redirige aquí.
- **Fechas:** publicada el 22-05-2026, modificada el 15-07-2026. Imagen destacada: 170.
- **Contenido:** real, 1.136 palabras. Es la pieza más sólida del sitio y tiene fuerte relación con Cartagena.
- **Imágenes:**
  - Dentro del texto: 170 `775_sellos.jpg` y 718 `corresubmarino_bocet` (la página sirve la versión `.png` y la biblioteca registra `.webp`; las dos responden 200).
  - En widgets: de 734 a 739, las imágenes `SUBMARINO_*PTA`, todas sin alt.
- **Widgets:** text-editor ×5 e image ×6.
- **Problemas:**
  - El pie «6 sellos… de diferente colo y v valor».
  - La tabla de tiradas está hecha a mano con «---}».
  - Los encabezados de D1 y A1 contienen el párrafo entero.
  - Erratas: «propagandísticos», «Tunez», «Soller».
  - Hay que confirmar el nombre del corresponsal, «Werner Kell».
  - Existe una etiqueta creada para este tema que no está asignada a la entrada.

---

## 7. WooCommerce

### 7.1 Productos

| id | Título | Tipo | Precio | SKU / código | Descripción | Imágenes | Categorías / etiquetas |
|---|---|---|---|---|---|---|---|
| 382 | 125 Aniversario Submarino Peral | variable | 3–6 € | SKU «Edifil 5317» | Corta: «Sello Aniversario de la botadura del submarino de Isaac Peral». Larga: vacía. | 195, con galería 189 y 196. Las tres tienen alt. | Sellos |
| 394 | Marcas utilizadas por la Censura Postal Nacional de 1936 a 1945 | simple | 60 € | GTIN «8493171700» (tiene 10 dígitos, así que parece un ISBN-10) | Corta y larga **vacías** | 396 (sin alt), con galería 397 | Libros, FILATELIA. Etiquetas: CENSURA, ERNSTL L. HELLER, GUERRA CIVIL, MARCAS POSTALES, NACIONAL |

**Variantes del producto 382:**

| Variante | Precio | Existencias |
|---|---|---|
| NUEVO | 3 € | 2 |
| USADO | **sin precio** (no se puede comprar) | 2 |
| BLOQUE 4 | 6 € | 2 |
| SPD MAD | 6 € | sin control |
| SPD BNA | 6 € | 1 |
| SPD Presentacion | 6 € | 2 |

**Producto 394:** 2 unidades en existencias, 1,1 kg, 24 × 17 × 3 cm.

### 7.2 Por qué la tienda no vende

- No existen las páginas de Carrito, Finalizar compra ni Mi cuenta. Estas URL dan 404: `/finalizar-compra/`, `/mi-cuenta/`, `/checkout/`, `/cart/` y `/tienda/`.
- `/carrito/` redirige con 301 a la página de adjunto de `CARRITO.jpg` (578).
- La página de tienda de WooCommerce es la 118 (Proyecto_Aula_001).
- Las fichas de producto muestran «tienda en obras», pero la página 548 sigue ofreciendo «Añadir al carrito».
- El icono del carrito lleva a la portada.
- Las condiciones de envío se reducen a dos frases, sin tarifas ni plazos.

---

## 8. Formularios

### 8.1 Formulario 798 (Contact Form 7, «formulario_informacion»)

Es el que se usa en Contacto (697).

- **Campos:**
  - Nombre* y Correo electrónico*.
  - Temas de interés, con casillas: Historia Postal, Filatelia, Tarjeta Postal, Filatelia Temática, Literatura Postal.
  - Comentarios.
  - Aceptación de la privacidad*.
  - Botón «Enviar Mensaje».
- **Adónde va:** a informacion@museopostal.org.
- **Problemas:**
  1. El enlace a la privacidad apunta a `/politica-privacidad`, que da **404**.
  2. La cabecera `Reply-To` es informacion@museopostal.org: cuando el museo pulsa «Responder», el correo vuelve al propio museo y no al visitante.
  3. El cuerpo del correo repite el bloque «Comentarios».
  4. El formulario lleva unas 150 líneas de CSS escritas dentro de él.
  5. La respuesta automática (Mail 2) está apagada y usa campos que el formulario no tiene.
  6. No da de alta a nadie en ninguna lista de correo, aunque la portada promete una newsletter mensual.

### 8.2 Formulario 268 (Contact Form 7, «Formulario de contacto 1»)

- **Dónde se usa:** en ninguna parte.
- **Campos:** Tu nombre*, Tu correo electrónico*, Asunto*, Tu mensaje. Envía al correo del administrador.
- **Qué hacer:** es el formulario que CF7 crea al instalarse. Sobra.

### 8.3 Formulario 325 (WPForms)

- **Dónde se usa:** en Formulario de Contacto (324). No viene en el export.
- **Campos, leídos del HTML servido:**
  - Nombre* y Correo electrónico*.
  - Un campo de texto con la etiqueta rota «interés de».
  - Comentario o mensaje.
  - «Que asuntos son de tu interés», de opción única: Sellos España, Historia Postal y Prefilatelia, Tarjeta postal, Filatelia temática, Otro.
  - Casilla «Acepto las políticas de privacidad de este sitio seguro.»
- **Problemas:**
  - Es un segundo plugin de formularios para el mismo fin.
  - La pregunta no lleva signos de interrogación ni tilde.
  - La casilla de privacidad no enlaza a la política.

---

## 9. Feeds (Feedzy) y línea de tiempo

- **`feedzy_imports` 819 «Asistente de configuración»** (en **borrador**):
  - Iba a traer noticias de `FESOFI.ES`, `SOFIMA.ONLINE` y `rahf.es` y publicarlas cada día como entradas: 10 cada vez, con la imagen 706 `informesemanal.webp` por defecto y sin quitar duplicados.
  - Nunca se activó.
  - Encaja con el botón «El informe semanal» de Investigación.
- **`feedzy_categories` 818 «Sitios de noticias»:** la categoría de demostración de Feedzy (feeds de themeisle, wptavern, wpbeginner, wpshout y planet.wordpress). Es relleno.
- **Feedzy en páginas:** no se usa en ninguna.
- **Línea de tiempo:** no se usa en ningún sitio. Lo único que queda es el botón sin usar `6_lineatiempo.png` (234).

---

## 10. Plugins y maquetadores que deja ver el contenido

- **Elementor 4.3.2.** Las páginas se guardaron con versiones de la 4.0.5 a la 4.2.2 y mezclan los contenedores de siempre con los nuevos widgets de la versión 4 (`e-flexbox`, `e-heading`, `e-image`).
- **Tres paquetes de complementos de Elementor a la vez:**
  - Essential Addons (`eael-*`, contador de visitas).
  - Element Pack (`bdt-*`, más unos ajustes `element_pack_*` con el texto «This is Tooltip» en todos los widgets).
  - Premium Addons (`pa_*`, `premium_tooltip_*`).
- **Dos de SEO:** AIOSEO y Yoast.
- **Dos de formularios:** Contact Form 7 y WPForms.
- **Otros:** Complianz, Really Simple Security, Site Kit by Google, MonsterInsights (quedan sus categorías de notas), WOOF, Reddit for WooCommerce, Feedzy y un conversor a WebP.
- **Restos de temas de bloques que no se usan con Neve:**
  - `wp_template_part` 30, 31 y 32 y `wp_template` 33, de Twenty Twenty-Two.
  - `wp_template_part` 588, de «theme-1».

---

## 11. Biblioteca de medios (143 adjuntos)

- **Formatos:** 62 JPG, 49 WebP, 24 PNG, 5 JPEG, 2 PDF y 1 AVIF.
- **Por mes de subida:** abril 9, mayo 104, junio 2, julio 5 y agosto 22, más el marcador de posición de WooCommerce.
- **Con texto alternativo:** solo **25 de 143**.
- **En uso en contenido publicado:** 69. **Sin usar:** 74.
- **Duplicados:**
  - `CANTONAL` (10 y 187).
  - `img20250711_18211656` ×5 (13, 26, 27, 28 y 204).
  - `img20250711_18435472` ×2 (14 y 205).
  - `img20250708_12594903` ×2 (12 y 197).
  - `1983_2690_SPDMurcia` ×2 (11 y 176).
  - `logotipo-mupo` ×4 (149, 150, 151 y 207).
  - `CARRITO` en .jpg y .png (578 y 579).
  - `sello`, `sello-1`, `SELLO1` y `sello2` (208, 310, 311 y 398).
  - Maldivas ×2 (938 y 939) y Gambia ×2 (948 y 949).
- **Material filatélico sin publicar que vale para el nuevo sitio:**
  - Correo Submarino: 168, 169 y 171 a 174, más los PDF 430 y 747.
  - Piezas murcianas: 175 a 177, 179 a 185, 167, 188 y 166. La 166 es la carta de Águilas a Murcia del 18-6-1866, con 4 cuartos azul y 20 céntimos de escudo lila, según el nombre del fichero.
  - Sobres de guerra: 209 y 210.
  - SPD 5040 bis: 211.
  - Más escaneos del sello del Peral: 190 a 194.
  - Ocho escaneos que no se han identificado: 197 a 203 y 206.
- **Decoración y relleno sin usar:**
  - Tres fotos de Pexels (162 a 164).
  - `bg88.jpg` (165) y `enobras.webp` (73).
  - Los 12 botones PNG y los 5 botones WebP de la primera portada.
  - El marcador de posición de WooCommerce (768).
- **Imágenes rotas:** ninguna. La única imagen externa es la de Wikimedia en la ficha de Chardin.

---

## 12. Problemas generales, de más a menos grave

1. **Legal.**
   - Las condiciones de uso están copiadas de otro comercio.
   - Se publica el DNI del titular.
   - La privacidad está cortada y no nombra proveedores.
   - El enlace a la privacidad desde el formulario da 404.
2. **Tienda.** Se ve en el menú pero no puede vender.
3. **Páginas huérfanas y botones sin destino.**
   - 6 páginas huérfanas.
   - 5 botones que no llevan a ninguna parte, justo en las salas principales (Murcia y Comparte).
4. **Títulos y slugs internos a la vista del público.**
   - Títulos: «Museos», «Cuadro_1» a «Cuadro_4», «Las_pinturas», «Eclipse_solar», «Museo_murcia», «Comparte_museo», «Padre_museo», «Proyecto_Aula_001» y «11-Videoconferencias».
   - Slugs: `elementor-*`, `*-copy`, `*-copy-2`, `*-2`, `proximamente-pagina-principal`, `contenedor-de-blog` y `pagina_wasap`.
5. **Páginas sin ninguna frase que explique su contenido:** Investigación, Videoconferencias, Museos del mundo, Museo_murcia, Las pinturas, Contacto, Tienda y Blog.
6. **Mayúsculas incoherentes.** «Siglo XIX», «Serie», y «Historia Postal» o «Filatelia» con mayúscula en mitad de la frase. Las etiquetas y categorías de producto van en mayúsculas.
7. **Erratas.** Whasap; colo / v valor; propagandísticos; Tunez; Soller; pictorico; transciende; TARJTETA; MATATASELLOS; Eclipes; «2024 - Cá»; Las Pintadera; paises; De como; Politica; envio y envios; «ce correos»; «dia del sello»; «Contra portada»; «exposicions»; «informad@»; «Que asuntos»; «interés de»; «¿ Te»; «¡ Bienvenida»; «¡ EL»; «Presentacion»; ERNSTL.
8. **Maquetación del texto.**
   - Encabezados usados como párrafos, y párrafos enteros metidos en encabezados.
   - Listas numeradas que vuelven a empezar en 1.
   - Una tabla hecha a mano con «---}».
   - Saltos de línea forzados, copiados de un PDF.
   - Tildes guardadas descompuestas (NFD).
9. **Accesibilidad.**
   - 118 de 143 adjuntos no tienen alt.
   - 15 URL no tienen H1.
   - Párrafos enteros en cursiva o en letra manuscrita.
   - Los vídeos quedan bloqueados sin ninguna alternativa.
10. **SEO.**
    - Dos plugins de SEO a la vez, con canonical y Open Graph duplicados.
    - El lema caducado aparece en `og:site_name`.
    - Las meta descripciones se generan solas, y algunas son URL o el texto «Please select a Menu…».
    - No hay favicon.
11. **Restos de la plataforma.**
    - 3 paquetes de complementos de Elementor y 2 plugins de formularios.
    - Restos de 3 temas de bloques.
    - 9 elementos de menú huérfanos.
    - Un borrador copiado de Investigación.
    - La importación y la categoría de demostración de Feedzy.

---

## 13. Qué pedirle a Felipe para el nuevo sitio

1. **Sala Museo Postal de la Región:**
   - Quién fue Narciso García Yepes.
   - Qué significan los sellos de «La Parranda» (1983) y el de la Revolución Cantonal.
   - Fichas de las piezas murcianas que ya están subidas a la biblioteca.
2. **Museos del mundo:** nombre, ciudad y web oficial de los 8 museos del carrusel.
3. **Videoconferencias:** título, ponente, fecha y organizador de cada vídeo, y confirmación de que se pueden enlazar.
4. **Salas pendientes:** qué son Carteros Honorarios, El informe semanal, Juegos y juguetes postales, la línea de tiempo y el Aula. De la tarjeta del soldado, qué pieza es y de qué año.
5. **Tienda:** si tiene que vender de verdad o salir del sitio por ahora. Si vende, hacen falta:
   - Los gastos de envío y la forma de pago.
   - El precio de la variante «Usado».
   - La descripción del libro y el nombre correcto de su autor.
6. **Newsletter:** si quiere una newsletter real, y con qué servicio.
7. **Datos legales correctos:**
   - Domicilio en Murcia.
   - Si es persona física o asociación, y si tiene que publicar el NIF.
   - Qué proveedores usa: analítica, YouTube y WhatsApp.
8. **Dos comprobaciones:** el apellido del corresponsal del Correo Submarino («Werner Kell») y el tamaño del sello del eclipse.

---

## Anexo A. Tabla de todas las entradas del export (sin adjuntos)

| id | Tipo | Estado | Título | Slug | Modificado | Palabras | Real o relleno | ¿Pública y enlazada? |
|---|---|---|---|---|---|---|---|---|
| 235 | page | publish | Museos | proximamente-pagina-principal (servida en `/`) | 2026-08-12 | 90 | real | sí (menú) |
| 531 | page | publish | Blog | contenedor-de-blog | 2026-05-25 | 0 | contenedor | sí (menú) |
| 691 | page | publish | Investigación | investigacion | 2026-05-22 | 0 | vacía | sí (menú) |
| 548 | page | publish | Tienda | elementor-548 | 2026-05-21 | 0 | contenedor | sí (menú) |
| 697 | page | publish | Contacto | contacto | 2026-06-22 | 0 | formulario | sí (menú) |
| 573 | page | publish | Politica de privacidad | elementor-573 | 2026-05-21 | 724 | real, con defectos | sí (pie) |
| 662 | page | publish | Condiciones de uso y envio | elementor-662 | 2026-05-21 | 1.314 | plantilla copiada | sí (pie) |
| 658 | page | publish | Política de cookies (UE) | politica-de-cookies-ue | 2026-05-21 | 7 (más el texto generado) | generado | sí (pie) |
| 126 | page | publish | Museos en el Mundo | museos-del-mundo | 2026-06-21 | 5 | vacía | sí (portada) |
| 854 | page | publish | Las_pinturas | elementor-854 | 2026-07-18 | 0 (más 22 de pies) | índice | sí (portada) |
| 925 | page | publish | Eclipse_solar | eclipse-solar-agosto-2026-filatelia-correos-espana | 2026-08-12 | 607 | real | sí (portada) |
| 821 | page | publish | Cuadro_1 | elementor-821 | 2026-07-27 | 193 | real | sí (854) |
| 827 | page | publish | Cuadro_2 | elementor-821-copy | 2026-07-27 | 228 | real | sí (854) |
| 836 | page | publish | Cuadro_3 | cuadro_1-copy | 2026-07-27 | 175 | real | sí (854) |
| 857 | page | publish | Cuadro_4 | cuadro_1-copy-2 | 2026-07-27 | 189 | real | sí (854) |
| 97 | page | publish | 11-Videoconferencias | video-conferencias-historia-postal-y-filatelia | 2026-05-20 | 0 | vídeos incrustados | sí (691) |
| 753 | page | publish | Una mujer sellando una carta | jean-baptiste-simeon-chardin | 2026-06-21 | 740 | real | **no** |
| 598 | page | publish | Museo_murcia | museo_murcia | 2026-07-24 | 0 | vacía | **no** |
| 59 | page | publish | Comparte_museo | pagina_wasap | 2026-05-21 | 32 | real, breve | **no** |
| 118 | page | publish | Proyecto_Aula_001 | la-tarjeta-del-soldado | 2026-08-10 | 0 | vacía, tapada por «tienda en obras» | **no** |
| 324 | page | publish | Formulario de Contacto | formulario_informacion | 2026-06-21 | 16 | formulario duplicado | **no** |
| 596 | page | publish | Padre_museo | padre_museo | 2026-05-21 | 0 | relleno roto | **no** |
| 748 | page | draft | Investigación - Copy | investigacion-copy | 2026-07-15 | 0 | maqueta | no (404) |
| 472 | post | publish | El wi-fi del Siglo XIX | el-wi-fi-del-siglo-xix | 2026-07-24 | 674 | real | sí (blog) |
| 717 | post | publish | El Correo Submarino | el-correo-submarino-2 | 2026-07-15 | 1.136 | real | sí (blog) |
| 382 | product | publish | 125 Aniversario Submarino Peral | producto/125-aniversario-submarino-peral | 2026-05-14 | 10 | ficha mínima | sí (548), tapada |
| 394 | product | publish | Marcas utilizadas por la Censura Postal Nacional de 1936 a 1945 | producto/marcas-utilizadas-por-la-censura-postal-nacional-de-1936-a-1945 | 2026-05-19 | 0 | ficha vacía | sí (548), tapada |
| 415-420 | product_variation | publish | Variantes de 382 | — | 2026-05-14 | — | — | — |
| 268 | wpcf7_contact_form | publish | Formulario de contacto 1 | — | 2026-05-07 | — | el de fábrica, sin uso | — |
| 798 | wpcf7_contact_form | publish | formulario_informacion | — | 2026-06-22 | — | en uso (697) | — |
| 7 | elementor_library | publish | Kit por defecto | kit-por-defecto | 2026-05-07 | — | ajustes globales | — |
| 686 | custom_css | publish | neve | — | 2026-06-06 | vacío | — | — |
| 25, 583, 584, 677 | wp_global_styles | publish | Custom Styles | — | abril y mayo | vacíos | restos | — |
| 30, 31, 32, 588 | wp_template_part | publish | Cabeceras y pie | — | abril y mayo | — | restos | — |
| 33 | wp_template | publish | Inicio del blog | home | 2026-04-30 | — | resto | — |
| 5, 29 | wp_navigation | publish | Navegación / Menú Cabecera | — | 2026-04-29/30 | — | restos (enlaces a 404) | — |
| 644, 645, 648, 702, 703 | nav_menu_item | publish | MENU PRINCIPAL | — | 2026-05-22 | — | en uso | — |
| 679, 680, 681 | nav_menu_item | publish | Menu_legal | — | 2026-05-21 | — | en uso | — |
| 602 a 636 (9 elementos) | nav_menu_item | draft | huérfanos | — | 2026-05-21 | — | restos | — |
| 818 | feedzy_categories | publish | Sitios de noticias | — | 2026-07-17 | — | demostración | — |
| 819 | feedzy_imports | draft | Asistente de configuración | — | 2026-07-17 | — | sin activar | — |

Categorías de entradas:

- «Sin categoría»: en uso.
- «Colecciones Adultos»: sin uso, con la descripción de demostración «Globos y actividades divertidas».

Ficheros auxiliares de este análisis (no son entregables), en `/tmp/felipe/research/`:

- `_items.json`: el export ya analizado.
- `_raw.md`: el texto extraído antes de limpiarlo.
- `_att.json`: los adjuntos.
- `_live/`: las 6 páginas descargadas el 28-09-2026.