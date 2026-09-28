# 05 · Opciones técnicas para el rediseño de museopostal.org

Informe de escritorio (sin logins nuevos). Fecha: 2026-09-28. Fuentes: ficheros locales en `/tmp/felipe/` y documentación pública citada al final de cada sección. Copia escrita en `/tmp/felipe/research/05-opciones-tecnicas.md`.

> Nota sobre las entradas: `/tmp/felipe/inventory.md` y `/tmp/felipe/theme-install.html` **no existían** cuando se redactó este informe. Los datos de servidor, tema y plugins salen de `sitehealth.html` (Salud del sitio › Información), `themes.html`, `plugins.html`, `orders.html`, `dup.html`/`build.html`, `mcp.json`, `home.html` y del export WXR `backup/museopostal-export-all-2026-09-28.xml`.

---

## 0. Resumen y recomendación

**Recomendación: opción A.** Un tema de bloques propio y escrito a mano (`museopostal`), más un plugin compañero diminuto (`museopostal-coleccion`) que registra el modelo del museo (piezas, salas, tipos, épocas y los metadatos de la ficha). El contenido pasa a bloques del núcleo. Elementor, sus 3 packs de addons y unos 20 plugins más se retiran.

Por qué:

1. **Felipe no puede romper el diseño.** Con `theme.json` se limitan paleta, tipografías y tamaños, y los patrones bloqueados solo dejan escribir el contenido. El desorden visual de hoy viene precisamente de la libertad total de Elementor.
2. **Rendimiento.** La portada carga hoy **63 CSS + 64 JS externos**, 42 scripts en línea y 16 `<style>` (`home.html`). Solo HUSKY, un filtro de productos para 2 productos, aporta 46 ficheros. Un tema de bloques limpio se queda en una decena.
3. **Coste cero y reversible.** No hay licencias. Cambiar de tema se deshace en un clic mientras no se borren datos.
4. **La migración es barata.** Las 23 páginas usan solo 11 tipos de widget, y Elementor ya guarda en `post_content` un HTML semántico limpio (p, h2–h5, figure/figcaption, img, listas, tablas). El «Convertir en bloques» nativo de WordPress lo transforma casi sin pérdidas (sección 3).

Despliegue: el repositorio público `GeiserX/museopostal` (GPL-3.0) genera en GitHub Actions dos zips en cada tag y los adjunta a una Release. La primera instalación se hace subiendo el zip en wp-admin. Las siguientes llegan como actualización normal de WordPress gracias a `plugin-update-checker`, apuntado a las Releases públicas.

Vista previa para Felipe: **botón de WordPress Playground en cada PR** (`WordPress/action-wp-playground-pr-preview@v3`). Enseña el tema real con contenido de muestra, gratis porque el repo es público. Las capturas con Playwright van como apoyo.

MCP: **no merece la pena ahora.** El endpoint `/wp-json/mcp/mcp-adapter-default-server` no viene del núcleo de WordPress 7.1. Casi seguro lo trae un plugin que incluye el MCP Adapter (muy probablemente WooCommerce 10.8). Por defecto solo expone 3 meta-herramientas sobre las abilities marcadas como públicas. Además, la contraseña de aplicación nunca llegó a autenticar (`last_used: null`).

---

## 1. Hechos verificados del entorno (con fuente local)

| Dato | Valor | Fuente |
|---|---|---|
| WordPress | 7.1.2, `es_ES`, Europe/Madrid, permalinks `/%postname%/`, entorno `production`, 1 usuario | `sitehealth.html` |
| Servidor | Linux CloudLinux (`lve`), «Servidor web: Apache» con **PHP SAPI `litespeed`**. Las páginas de error 502/423 las firma **nginx**, que va delante. Por tanto `.htaccess` sí se respeta (LiteSpeed lo lee) | `sitehealth.html`, `login-get.html`, `wpadmin-anon.html` |
| PHP | 8.4.17, `memory_limit` 1024M, `max_execution_time` 30 s, `max_input_vars` 1000 | `sitehealth.html` |
| Subidas | `upload_max_filesize` **128M**, `post_max_size` **256M**, máx. 20 ficheros simultáneos | `sitehealth.html` |
| Opcache | **Lleno**: 128 MB de 128 MB, cadenas internas al 100 %, tasa de acierto 63,85 %. Con 29 plugins no cabe el código; quitar plugins ayuda directamente | `sitehealth.html` |
| Base de datos | MariaDB 10.11.15, utf8mb4_unicode_520_ci, prefijo `w47fa_` | `sitehealth.html` |
| Permisos de ficheros | raíz, wp-content, plugins, temas y subidas: «Editable», así que la instalación por zip funciona por FS directo | `sitehealth.html` |
| Tema activo | **Neve 4.2.3** (hay 4.2.13 disponible), clásico, sin tema hijo | `themes.html` (`_wpThemeSettings`) |
| Tema huérfano | «MuseoPostal.org Child Theme» (`theme-1`), **tema de bloques hijo de Twenty Twenty-Four**, inactivo. Tiene `wp_template`/`wp_template_part`/`wp_global_styles` en la BD (IDs 30–33, 583, 588). Parece un intento anterior hecho con Create Block Theme | `themes.html`, WXR |
| Instalar temas | `settings.canInstall: true`, que es la capacidad `install_themes`. Esa capacidad pasa a falso si existe `DISALLOW_FILE_MODS`, así que **la subida de zips está permitida**. El enlace `wp_theme_preview` (Vista previa en vivo) aparece 10 veces | `themes.html` |
| Editor de ficheros de temas | 403 «Lo siento, no tienes permisos para acceder a esta página». Cuadra con `DISALLOW_FILE_EDIT` o con la opción de Really Simple Security «Disable the built-in file editors». **No bloquea** subir temas ni plugins | `theme-editor.html` |
| Plugins | **29**: 26 activos y 3 inactivos (tabla de la sección 4) | `sitehealth.html`, `plugins.html` |
| WooCommerce | 10.8.1 (hay 11.1.2), **0 pedidos** («0 elementos»), 2 productos (6 € con 6 variaciones; 60 €) | `orders.html`, WXR |
| Contenido | 22 páginas publicadas y 1 borrador, 2 entradas, 2 productos, 143 adjuntos, 2 formularios CF7, 3 formularios WPForms con 0 envíos, **0 comentarios** (pero «Estado por defecto de los comentarios: Abiertos») | WXR, `sitehealth.html` |
| SEO | Yoast **y** All in One SEO imprimen metadatos a la vez en la portada. Los 9 campos `_aioseo_*` del export están **vacíos** | `home.html`, WXR |
| Analítica | GA4 `G-DY7BN4YTKW` cargado **dos veces**: Site Kit mediante `GT-5RMB74JP` y MonsterInsights mediante `G-DY7BN4YTKW`, este bloqueado por Complianz (`data-cmplz-src`). Clarity también está presente | `home.html` |
| Copias | Duplicator 5.0.4 (Lite). Cuando se capturó `dup.html` había 0 copias; en `build.html` se estaba generando `museopostal20260928` | `dup.html`, `build.html` |
| Contraseña de aplicación | Creada el 2026-09-28 09:30 para el usuario administrador, **`last_used: null`**: nunca autenticó con éxito. El secreto no se reproduce aquí | `apppw.json` (solo se leyeron los metadatos) |

---

## 2. Opciones de reconstrucción (pregunta 1)

### 2.1 Comparativa

| Criterio | **A. Tema de bloques propio + plugin compañero** | B. Mantener Elementor y rehacer plantillas | C. Tema clásico PHP + CPT en plugin | D. Headless / exportación estática |
|---|---|---|---|---|
| Mantenimiento por un director no técnico | **Muy bueno.** Editor nativo, patrones bloqueados (`contentOnly`), plantillas de entrada por CPT y paleta cerrada en `theme.json`. Felipe tiene que aprender el editor de bloques (Gutenberg), pero con menos opciones que Elementor | Bueno en lo que ya conoce. **Malo para la coherencia**: puede cambiar colores, tipografías y márgenes en cada widget, que es el origen del problema actual | Regular. Edita el contenido en bloques, pero cabecera, pie y plantillas solo se tocan con código | **Malo.** La vista previa se rompe, cada publicación exige reconstruir y los formularios necesitan un servicio externo |
| Rendimiento | **Excelente.** CSS por bloque solo cuando se usa, sin jQuery ni frameworks | Malo. Núcleo de Elementor más los addons; la versión 4 (widgets «atómicos» `e-flexbox`, `e-heading`) convive con la 3 | Muy bueno si se escribe con cuidado | Excelente en el front |
| Coste | 0 € | 0 € (Pro no hace falta) o licencia Pro si se quiere Theme Builder | 0 € | 0 € en hosting estático, pero Actions, webhooks y más piezas que mantener |
| Reversibilidad | **Alta.** Activar Neve de nuevo es un clic; `_elementor_data` sigue en postmeta; cada conversión deja una revisión | Alta | Alta | Media: añade infraestructura fuera de WordPress |
| Modelo de museo (piezas, salas, itinerarios) | **Nativo**: CPT y taxonomías con `show_in_rest`, bloque Query Loop con filtro por taxonomía, *block bindings* a `core/post-meta` para la ficha técnica, plantillas `single-pieza.html` y `taxonomy-sala.html` | Con los widgets de listado de addons de terceros (Essential Addons, etc.), atado a ellos | Nativo, pero plantillas en PHP | Nativo en la API, pero hay que reconstruir cada vista |
| Dependencia de terceros | Ninguna | Elementor y 1–3 packs de addons, con actualizaciones y avisos de venta constantes | Ninguna | Generador estático y hosting |
| Encaje con «WordPress se queda» | Total | Total | Total | Parcial: WordPress queda como backend |

**Descartadas:** D añade maquinaria sin un problema que la justifique (el sitio tiene unas 25 páginas). C obliga a volver al código para cada ajuste de cabecera o pie que Felipe querría hacer en el Editor del sitio. B conserva justo lo que produjo el problema.

### 2.2 Qué ofrece WordPress 7.x para el modelo del museo (comprobado en la documentación)

- **CPT y taxonomías** (`register_post_type`, `register_taxonomy` con `show_in_rest => true`) en el plugin, no en el tema. Así el contenido sobrevive a un cambio de tema. El argumento `template` del CPT da a Felipe una pieza nueva ya maquetada.
- **Block bindings** con fuentes del núcleo `core/post-meta`, `core/post-data`, `core/term-data` y `core/pattern-overrides`. Bloques enlazables: `core/image` (id, url, title, alt, caption), `core/heading` y `core/paragraph` (content), `core/button` (url, text, linkTarget, rel), `core/navigation-link`/`core/navigation-submenu` (url) y `core/post-date` (datetime). Requisitos: meta registrado con `show_in_rest => true` y **clave sin guion bajo inicial**. Desde 6.7 el valor se edita desde el propio bloque en el editor; 6.9 mejoró la interfaz de selección de campos y añadió el filtro `block_bindings_supported_attributes_{$block_type}`. Resultado: la ficha técnica (fecha, catálogo Edifil, procedencia, técnica, dimensiones) funciona **sin ACF**.
- **Pattern overrides**: desde 7.0 valen para cualquier atributo enlazable, también en bloques propios. Los bloques dentro de patrones `contentOnly` necesitan `"role": "content"` en `block.json`.
- **Registro de bloques solo en PHP** (7.0, `supports.autoRegister => true` más `render_callback`). Permite un bloque «Ficha de la pieza» sin compilar JavaScript ni usar npm.
- **Query Loop**: filtro por tipo de contenido y taxonomía; **«excluir la entrada actual»** en 7.1 (#65373), útil para «otras piezas de esta sala».
- **7.0**: bloque de migas de pan (Breadcrumbs), visibilidad de bloques por dispositivo, revisiones visuales, página propia de Font Library, paleta de comandos.
- **7.1**: estilos responsive en Estilos globales y en cada bloque, *viewports* configurables, estados pseudo o personalizados, sombra de texto, degradados de fondo y ancho mínimo.
- **Vista previa en vivo** de temas de bloques inactivos (`site-editor.php?wp_theme_preview=<slug>`). Felipe puede ver el tema nuevo con su contenido real **antes de activarlo**; el enlace ya aparece en `themes.html`.

### 2.3 Modelo de contenido propuesto (mínimo)

- CPT **`pieza`** (`/pieza/<slug>/`, archivo `/coleccion/`). Admite title, editor, thumbnail, excerpt, custom-fields y revisions.
- Taxonomía jerárquica **`sala`** (`/sala/<slug>/`). La plantilla `taxonomy-sala.html` muestra título, descripción del término y un Query Loop que hereda la consulta (`inherit: true`).
- Taxonomías **`tipo`** (sello, sobre, tarjeta postal, matasellos, marca postal, pintura…) y **`epoca`**.
- Metadatos (`register_post_meta('pieza', …, ['show_in_rest' => true, 'single' => true, 'type' => 'string'])`): `mp_fecha`, `mp_catalogo`, `mp_procedencia`, `mp_tecnica`, `mp_dimensiones`.
- **Itinerarios**: al principio, *páginas* con el patrón «Itinerario» (pasos que enlazan piezas). Un CPT `itinerario` solo si Felipe llega a tener más de un puñado.
- **Exposiciones temporales o efemérides** (por ejemplo, «Eclipse solar»): entradas con la categoría «Exposiciones».

Boceto del plugin (`museopostal-coleccion/museopostal-coleccion.php`, unas 120 líneas en total):

```php
<?php
/**
 * Plugin Name: Museo Postal · Colección
 * Description: Piezas, salas, tipos y épocas del Museo Postal y Filatélico de la Región de Murcia.
 * Version: 1.0.0
 * Requires at least: 7.1
 * Requires PHP: 8.1
 * License: GPL-3.0-or-later
 * Update URI: https://github.com/GeiserX/museopostal
 */
add_action( 'init', function () {
    register_post_type( 'pieza', [
        'labels'       => [ 'name' => 'Piezas', 'singular_name' => 'Pieza', 'add_new_item' => 'Añadir pieza' ],
        'public'       => true,
        'show_in_rest' => true,
        'has_archive'  => 'coleccion',
        'rewrite'      => [ 'slug' => 'pieza' ],
        'menu_icon'    => 'dashicons-email-alt',
        'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ],
        'template'     => [ [ 'core/pattern', [ 'slug' => 'museopostal/ficha-pieza' ] ] ],
    ] );
    foreach ( [ 'sala' => true, 'tipo' => false, 'epoca' => false ] as $tax => $hier ) {
        register_taxonomy( $tax, [ 'pieza' ], [ 'hierarchical' => $hier, 'show_in_rest' => true, 'rewrite' => [ 'slug' => $tax ] ] );
    }
    foreach ( [ 'mp_fecha', 'mp_catalogo', 'mp_procedencia', 'mp_tecnica', 'mp_dimensiones' ] as $key ) {
        register_post_meta( 'pieza', $key, [
            'type' => 'string', 'single' => true, 'show_in_rest' => true,
            'auth_callback' => fn() => current_user_can( 'edit_posts' ),
        ] );
    }
} );
register_activation_hook( __FILE__, fn() => flush_rewrite_rules() );
```

Estructura del tema (`museopostal/`):

```
style.css            cabecera: Theme Name, Version, Requires at least: 7.1, Requires PHP: 8.1,
                     License: GPL-3.0-or-later, Text Domain: museopostal, Update URI
theme.json           version 3 (válida desde 6.6; comprobar si 7.x publica una versión nueva);
                     settings.color.custom=false, typography.customFontSize=false, fontFace local
functions.php        mínimo: categorías de patrones, estilos de bloque, formato WebP
templates/           index, front-page, home, single, page, archive, search, 404,
                     single-pieza, archive-pieza, taxonomy-sala
parts/               header.html, footer.html
patterns/            ficha-pieza.php, sala-intro.php, itinerario-paso.php, articulo.php, portada-*.php
assets/fonts/        woff2 servidas localmente (fuera las llamadas a fonts.googleapis.com, que hoy son 4)
screenshot.png
```

Una trampa que conviene conocer: si Felipe edita una **plantilla** en el Editor del sitio, WordPress guarda una copia en la BD (`wp_template`) que **tapa** el fichero del tema. Las actualizaciones por zip ya no se verán en esa plantilla hasta pulsar «Restablecer». La regla para él: editar contenido y patrones, no plantillas. Create Block Theme (`create-block-theme`) permite traer esos cambios de la BD al repo si alguna vez hace falta. El tema nuevo usará un slug distinto (`museopostal`) para no heredar las plantillas guardadas de `theme-1`.

Fuentes: [Block Bindings (handbook)](https://developer.wordpress.org/block-editor/reference-guides/block-api/block-bindings/) · [Bindings 6.9](https://make.wordpress.org/core/2025/11/12/block-bindings-improvements-in-wordpress-6-9/) · [Bindings 6.7](https://make.wordpress.org/core/2024/10/21/block-bindings-improvements-to-the-editor-experience-in-6-7/) · [Pattern overrides 7.0](https://make.wordpress.org/core/2026/03/16/pattern-overrides-in-wp-7-0-support-for-custom-blocks/) · [PHP-only block registration](https://make.wordpress.org/core/2026/03/03/php-only-block-registration/) · [Field Guide 7.0](https://make.wordpress.org/core/2026/05/14/wordpress-7-0-field-guide/) · [Field Guide 7.1](https://make.wordpress.org/core/2026/08/05/wordpress-7-1-field-guide/) · [Estilos responsive 7.1](https://make.wordpress.org/core/2026/08/05/responsive-block-styles-and-configurable-viewports-in-wordpress-7-1/) · [Plantillas desde plugins (6.7)](https://developer.wordpress.org/news/2024/08/registering-block-templates-via-plugins-in-wordpress-6-7/) · [WordPress 7.1 «Mary Lou»](https://wordpress.org/news/2026/08/mary-lou/)

---

## 3. Despliegue desde GitHub sin SFTP (pregunta 2)

### 3.1 Primera instalación

- **Tema**: Apariencia › Temas › Añadir tema › Subir tema (`theme-install.php?browse=upload`), fichero `museopostal.zip`.
- **Plugin**: Plugins › Añadir plugin › Subir plugin, fichero `museopostal-coleccion.zip`.
- **Límites**: el zip puede pesar hasta 128 MB (`upload_max_filesize`). El tema con fuentes woff2 pesará menos de 2 MB. El límite de 30 s de PHP basta para descomprimir.
- **Geobloqueo**: fuera de España, Sergio tiene que pasar por el túnel SOCKS de watchtower. Felipe, desde España, puede subirlo directamente.
- **Actualizar subiendo el zip otra vez**: desde WordPress 5.5, si la carpeta del zip coincide con la del tema o plugin instalado, WordPress ofrece «Reemplazar el actual por el subido».
- **Trampa del zip**: **nunca uses el «Source code (zip)» que genera GitHub.** Su carpeta raíz se llama `museopostal-v1.0.0/`, WordPress la instala como otro tema y la sustitución no funciona. Los zips deben construirse con la carpeta raíz fija (`museopostal/`, `museopostal-coleccion/`).
- **No verificado**: si el WAF de Webempresa rechaza algún zip. Se prueba antes con un zip mínimo en el clon de pruebas.

### 3.2 GitHub Actions: construir y publicar la Release

El repo es público, así que va en `runs-on: ubuntu-latest` (gratis). Boceto de `.github/workflows/release.yml`:

```yaml
name: release
on:
  push:
    tags: ['v*']
permissions:
  contents: write
jobs:
  build:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - name: Lint PHP
        run: find theme plugin -name '*.php' -print0 | xargs -0 -n1 php -l
      - name: Versión del tag = versión de las cabeceras
        run: |
          v="${GITHUB_REF_NAME#v}"
          grep -q "^Version: $v$" theme/museopostal/style.css
          grep -q "Version: $v$" plugin/museopostal-coleccion/museopostal-coleccion.php
      - name: Zips con carpeta raíz fija
        run: |
          mkdir dist
          (cd theme  && zip -r ../dist/museopostal.zip museopostal -x '*.DS_Store')
          (cd plugin && zip -r ../dist/museopostal-coleccion.zip museopostal-coleccion -x '*.DS_Store')
          unzip -l dist/museopostal.zip | grep -q ' museopostal/style.css$'
      - run: gh release create "$GITHUB_REF_NAME" dist/*.zip --generate-notes
        env:
          GH_TOKEN: ${{ github.token }}
```

Hay que demostrar que la comprobación de versión puede fallar: se empuja un tag con una versión que no coincide y el job debe ponerse en rojo.

### 3.3 Cómo actualizará Felipe más adelante

| Vía | Cómo | Pros | Contras |
|---|---|---|---|
| Volver a subir el zip | Descargar el zip de la Release y subirlo con «Reemplazar» | Cero código | Manual; Sergio tiene que pasar por el túnel |
| **`plugin-update-checker` (recomendada)** | Librería [YahnisElsts/plugin-update-checker](https://github.com/YahnisElsts/plugin-update-checker) v5, MIT, incluida en el plugin y en el tema. `PucFactory::buildUpdateChecker('https://github.com/GeiserX/museopostal/', __FILE__, 'museopostal-coleccion')` más `->getVcsApi()->enableReleaseAssets('/museopostal-coleccion\.zip/')`, y lo mismo para el tema con su expresión regular | La actualización aparece en Escritorio › Actualizaciones y Felipe pulsa «Actualizar». No necesita token porque el repo es público | Consulta la API de GitHub sin autenticar (60 peticiones/h por IP; comprueba cada 12 h). Quien controle la cuenta de GitHub controla el código del sitio: 2FA y tags protegidos |
| Git Updater (afragen) | Plugin aparte | Sin código propio | Un plugin más; no se ha verificado su licencia actual |

Añadir `Update URI` en las cabeceras impide que WordPress.org confunda el slug con otro producto (WordPress 5.8 o posterior).

Fuentes: [WordPress 5.5 (actualizar subiendo un ZIP)](https://wordpress.org/news/2020/08/eckstine/) · [plugin-update-checker](https://github.com/YahnisElsts/plugin-update-checker) · [Releases de PUC](https://github.com/YahnisElsts/plugin-update-checker/releases)

---

## 4. Migración del contenido (pregunta 3)

### 4.1 Qué hay realmente (medido en el WXR)

- Widgets usados en todo el sitio: 80 `container`, **68 `image`** (37 con pie de foto), 20 `text-editor`, 11 `heading`, 7 `e-flexbox` (v4), 6 `video` (YouTube), 1 `image-carousel`, 1 `wpforms`, 1 `eael-post-grid` (Blog), 1 `eicon-woocommerce`/grid de productos de Essential Addons (Tienda), 1 `bdt-navbar` (Padre_museo), 1 `bdt-contact-form-7` (Contacto), 1 `e-heading`, 1 `e-image`.
- Royal Elementor Addons y Templately **no aportan ningún widget**. Royal solo añade clases `wpr-*` a los contenedores y Element Pack guarda ajustes vacíos («This is Tooltip») en cada widget.
- **Elementor ya escribe un HTML limpio en `post_content`**: 127 `<p>`, 85 `<img>`, 47 `<figure>` con 39 `<figcaption>`, h2–h5, listas y 5 tablas. Excepción: la página de vídeos (97) guarda **solo las 6 URL de YouTube pegadas sin separador**.

### 4.2 Opciones

| Vía | Cómo | Veredicto |
|---|---|---|
| **Nativa (recomendada)** | Por página: abrirla en el editor de bloques, pulsar «Volver al editor de WordPress» (quita `_elementor_edit_mode`), y en el bloque Clásico elegir **«Convertir en bloques»**, que es el `rawHandler` del núcleo. El HTML semántico se convierte en `core/heading`, `core/paragraph`, `core/image` con pie, `core/list` y `core/table`. Después se aplican los patrones nuevos. Cada guardado deja una revisión | 22 páginas, unos 15–30 min cada una. Sin código que mantener. Se pierden colores y tipografías inline de Elementor, que es justo lo que se busca |
| Script `_elementor_data` → bloques | Python sobre el WXR: container→`core/group`/`core/columns`, heading→`core/heading`, text-editor→bloques del HTML, image→`core/image` + caption, video→`core/embed`, image-carousel→`core/gallery`, eael-post-grid→`core/query`, formularios→bloque o shortcode de CF7. Se aplicaría por REST con cookie + nonce a través del túnel, o pegándolo en el editor de código | Viable (11 tipos de widget), pero con este volumen **YAGNI**. Solo compensa si aparecen muchas más páginas |
| Conversores de terceros | WebRitual Block Bridge; Nelio Unlocker está discontinuado | Otro plugin más para usar una vez; no aporta nada frente a la vía nativa |

Casos que hay que rehacer a mano en cualquier vía: vídeos (separar las 6 URL, una por línea, para que sean `core/embed`), carrusel de «Museos en el Mundo» (→ `core/gallery`), rejilla del blog (→ plantilla `home.html` con Query Loop), tienda (→ sección 5), barra de navegación de Padre_museo (→ se elimina) y formularios (→ un solo formulario CF7).

### 4.3 Destino de cada página

| ID | Título actual → URL | Destino propuesto |
|---|---|---|
| 235 | Museos → `/` (portada) | Se rehace como `front-page.html` + patrones; no se convierte |
| 598 | Museo_murcia → `/museo_murcia/` | «El museo» `/el-museo/`, convertir |
| 596 | Padre_museo → `/padre_museo/` | Borrar (solo tiene una barra `bdt-navbar`) y redirigir a `/` |
| 854 | Las_pinturas → `/elementor-854/` | Sala «La carta en la pintura» (término `sala`) |
| 753, 821, 827, 836, 857 | Chardin, Cuadro_1…4 | 5 **piezas** (`tipo=pintura`) de esa sala; se reescriben como piezas con ficha |
| 925 | Eclipse_solar | Entrada (categoría Exposiciones) o sala temporal; convertir |
| 691 | Investigación | Convertir |
| 748 | Investigación - Copy (borrador) | Borrar |
| 118 | Proyecto_Aula_001 (La tarjeta del soldado) | Itinerario o sección «Aula»; convertir |
| 126 | Museos en el Mundo | Convertir (galería) |
| 97 | 11-Videoconferencias | Convertir (6 `core/embed`) |
| 59 | Comparte_museo (WhatsApp) | «Comparte tu pieza»; convertir (enlace `wa.me`) |
| 531 | Blog → `/contenedor-de-blog/` | Página de entradas en Ajustes › Lectura, `/blog/` |
| 548 | Tienda → `/elementor-548/` | «Publicaciones» (sección 5) |
| 662 | Condiciones de uso y envío | Se conserva solo si sigue habiendo venta |
| 573 | Política de privacidad → `/elementor-573/` | Convertir, `/politica-de-privacidad/` |
| 658 | Política de cookies (UE) → shortcode `[cmplz-document …]` | Depende de Complianz (sección 5) |
| 324 | Formulario de Contacto (WPForms) | Fusionar con 697 y redirigir |
| 697 | Contacto (CF7) | Convertir; un solo formulario CF7 |
| Entradas 472, 717 | «El wi-fi del Siglo XIX», «El Correo Submarino» | Convertir (la 717 ya tuvo bloques) |

**Redirecciones 301**: muchos slugs son feos (`elementor-548`, `cuadro_1-copy-2`…) y cambiarán. Como no hay acceso a ficheros, el mapa va **en el plugin compañero** (`template_redirect` con `is_404()` y un array `viejo => nuevo`), versionado en git. La redirección automática de slugs antiguos del núcleo (`wp_old_slug_redirect`) no hay que darla por buena en páginas: se comprueba en Playground. Incluye `/producto/*` si se retira WooCommerce.

---

## 5. Plugins: retirar, sustituir o conservar (pregunta 4)

Estado final objetivo: **Yoast SEO, Contact Form 7, Really Simple Security, `museopostal-coleccion`** y, según la decisión sobre la analítica, **Complianz + Site Kit** o **una analítica sin cookies**. Duplicator se queda solo mientras dure la migración.

| Plugin (slug) | Acción | Motivo | Riesgo al retirarlo |
|---|---|---|---|
| `elementor` 4.3.2 | Retirar **después** de convertir | Sustituido por bloques | Una página sin convertir sigue mostrando su HTML de reserva, sin estilo. `_elementor_data` permanece en postmeta, así que se puede reactivar |
| `essential-addons-for-elementor-lite` | Retirar | Solo la rejilla del blog y la de productos | Ninguno tras la migración |
| `bdthemes-element-pack-lite` | Retirar | Una navbar y un envoltorio de CF7 | Ninguno |
| `royal-elementor-addons` | Retirar | Ningún widget; 7 ficheros en la portada | Ninguno |
| `templately` | Retirar | Biblioteca de plantillas sin uso | Ninguno |
| `woocommerce-products-filter` (HUSKY) | **Retirar ya** | 46 de los 127 ficheros de la portada, para filtrar 2 productos | Ninguno |
| `reddit-for-woocommerce` | Retirar | Píxel de Reddit, sin campañas | Ninguno |
| `woocommerce` 10.8.1 | **Decisión de Felipe. Recomendado: sustituir** por una página «Publicaciones» (o CPT) con botón a pago externo (enlace de pago de Stripe o PayPal) o «pídelo por correo o WhatsApp» | 0 pedidos, 2 productos. Sin él desaparecen el carrito, el checkout, las cuentas, las páginas legales de envío y un plugin grande desactualizado | Perder la venta integrada; redirigir `/producto/*`. Probablemente se va también el endpoint MCP (sección 8) |
| `complianz-gdpr` | **Conservar uno** si queda analítica con cookies | Hoy ya bloquea MonsterInsights y genera la página 658 | Si se retira, la 658 debe pasar a texto fijo |
| `complianz-terms-conditions` | Retirar si no hay tienda | Generador de condiciones | Revisar si genera la 662 |
| `wpconsent-cookies-banner-privacy-suite` | Retirar | Tercer gestor de consentimiento | Ninguno (no aparece en `home.html`) |
| `proteccion-datos-rgpd` (ABCdatos) | Retirar tras revisar sus ajustes | Duplica la función legal | Puede inyectar avisos o textos legales; revisar antes |
| `all-in-one-seo-pack` | Retirar | Duplica a Yoast y sus campos `_aioseo_*` están vacíos | Comprobar en wp-admin si su tabla propia tiene títulos o descripciones personalizados |
| `wordpress-seo` (Yoast) | Conservar | Un solo SEO; Felipe tiene la caja de metadatos | — |
| `google-analytics-for-wordpress` (MonsterInsights) | Retirar | Carga GA4 por segunda vez (misma propiedad) | Ninguno |
| `google-site-kit` | Conservar **o** retirar según la analítica | Estadísticas de GA4 y Search Console en el escritorio | Search Console está verificado «a través de un archivo» de Site Kit: si se retira, volver a verificar por DNS |
| `microsoft-clarity` | Retirar | Graba sesiones: privacidad, y está desactualizado | Ninguno |
| `userfeedback-lite` | Retirar | Encuestas sin uso | Ninguno |
| `feedzy-rss-feeds` | Retirar | Solo un asistente de importación en borrador y una categoría; ningún contenido lo usa; desactualizado | Ninguno |
| `cool-timeline`, `timeline-block` | Retirar | Ningún contenido los usa; cargan recursos en la portada | Ninguno |
| `wpforms-lite` | Retirar | 3 formularios, 0 envíos; duplica CF7 | Fusionar la página 324 con Contacto |
| `contact-form-7` | Conservar | Formulario de Contacto | — |
| `image-optimization` (Elementor) | Retirar | Conversión a WebP/AVIF en la nube de Elementor. Imagick del servidor ya genera WebP/AVIF; el filtro `image_editor_output_format` del plugin compañero lo hace en local | Las imágenes ya optimizadas se quedan como están |
| `really-simple-ssl` | Conservar | HTTPS y endurecimiento | Revisar su opción de contraseñas de aplicación (sección 8) |
| `duplicator` | Conservar durante la migración | Copia antes de los cambios | La restauración Lite necesita subir `installer.php` y el archivo por FTP o gestor de ficheros; la importación por arrastre es de pago |
| `akismet` (inactivo) | Retirar y **cerrar comentarios** (hoy «Abiertos», 0 comentarios) | Sin uso | Ninguno |
| `optimole-wp` (inactivo) | Retirar | Sin uso | Ninguno |
| `pojo-accessibility` (inactivo) | Retirar | Un *overlay* no arregla la accesibilidad; la arregla el tema | Ninguno |

**Analítica y consentimiento: dos caminos que decide Felipe.**
- **(a) Conservar GA4 con Site Kit y Complianz.** Hay que mantener el banner: en España las cookies analíticas requieren consentimiento según la guía de cookies de la AEPD (no se revisó el texto exacto para este informe).
- **(b) Simplificar.** Una analítica sin cookies dentro de WordPress (por ejemplo `koko-analytics` con la opción de cookie desactivada; comprobarlo), sin GA ni Clarity. Así se podría prescindir del banner y de Complianz, dejando una política de cookies en texto fijo. Los vídeos de YouTube, mejor con `youtube-nocookie`. Antes de retirar el banner conviene que alguien con criterio legal lo confirme.

Orden recomendado para retirar plugins: HUSKY, Reddit, Royal, Templately, timelines, Feedzy, UserFeedback, Clarity, MonsterInsights y los inactivos (sin riesgo, se puede hacer ya). **Después** de la migración: los addons de Elementor y Elementor. Por último, WooCommerce y los plugins legales o SEO duplicados, uno a uno, comprobando la portada y el registro de errores después de cada uno.

---

## 6. Staging y vuelta atrás (pregunta 5)

- **Webempresa no tiene un staging con «publicar en producción».** WePanel › **WP Center** ofrece **«Clonar»** (copia a otro dominio o subdominio), «Mover WordPress», actualizaciones, plugins y temas (WP Center está en beta). El blog de Webempresa remite a plugins como WP STAGING para hacer staging; en la versión gratuita no se pueden devolver los cambios a producción. Uso recomendado: clonar a `pruebas.museopostal.org`, ensayar allí la migración completa y **repetir los mismos pasos** en producción (zips iguales, misma lista de retirada de plugins). Comprobar si el geobloqueo también afecta al subdominio clonado.
- **Superbackup** (WePanel › Aplicaciones Webempresa › SuperBackup): restauración por fecha desde un calendario. Retención según el plan: 10, 20 o 30 días más 12 mensuales. Es la **red principal** porque no necesita subir ficheros.
- **Duplicator Lite 5.0.4**: sirve como copia descargable. Restaurar con Lite exige el instalador clásico (subir `installer.php` y el archivo). La importación por arrastre y «restaurar desde el escritorio» son de las versiones de pago.
- **El cambio de tema es reversible al instante** (Apariencia › Temas › activar Neve) mientras Elementor y los datos sigan ahí. Una página convertida también se revierte con **Revisiones**, y `_elementor_data` no se borra al desactivar Elementor.
- **Ensayo local gratuito**: WordPress Playground con el tema, el plugin y un WXR de muestra (sección 7).
- **Secuencia segura**:
  1. Superbackup del día, WXR (ya existe), paquete de Duplicator (en curso) y una Release fijada en GitHub.
  2. Clonar a pruebas y ensayar todo allí.
  3. En producción, instalar el plugin y el tema **sin activarlos**, y enseñárselos a Felipe con la Vista previa en vivo.
  4. Convertir el contenido: las páginas en bloques se ven bien también con Neve.
  5. Activar el tema.
  6. Retirar plugins por tandas.
  7. Activar el mapa de redirecciones.

Fuentes: [Webempresa: staging en WordPress](https://www.webempresa.com/blog/como-crear-un-staging-en-wordpress.html) · [WP Center](https://guias.webempresa.com/preguntas-frecuentes/wpcenter/) · [Instalar web en WePanel](https://guias.webempresa.com/preguntas-frecuentes/instalar-web-automaticamente-en-wepanel/) · [Superbackup](https://guias.webempresa.com/preguntas-frecuentes/gestionar-copias-seguridad-superbackup/) · [Copias de seguridad Webempresa](https://guias.webempresa.com/preguntas-frecuentes/copias-de-seguridad/) · [Duplicator: importación por arrastre](https://duplicator.com/drag-drop-import-wordpress-tool/) · [Duplicator: restaurar](https://duplicator.com/knowledge-base/restoring-your-backup/)

---

## 7. Vista previa de los diseños en una PR (pregunta 6)

| Opción | Qué ve Felipe | Coste y complejidad |
|---|---|---|
| **Playground PR Preview (recomendada)** | Un botón en la PR abre **WordPress real en su navegador** con el tema y el plugin de esa rama y contenido de muestra: puede navegar, abrir el editor y probar a crear una pieza | Una acción oficial: `WordPress/action-wp-playground-pr-preview@v3`, `pull_request` (no `pull_request_target`), permisos `contents: read`, `pull-requests: write`. **Necesita un repo público**, que ya lo es. La primera carga en móvil tarda (WASM) |
| Maquetas estáticas en GitHub Pages | HTML suelto, no el tema | Doble trabajo: maqueta y luego tema. Pages sirve un único despliegue; las vistas por PR necesitan algo como `rossjrw/pr-preview-action` |
| Capturas con Playwright (ubuntu-latest) | Imágenes en la PR | Útiles como antes y después frente a `/tmp/felipe/shots/*.png` (1440 y 500 px), pero estáticas |

Recomendación: **no hacer maquetas aparte.** Los patrones del tema *son* la maqueta. Cada PR lleva su botón de Playground y un job opcional que arranca Playground en el runner (`@wp-playground/cli`) y publica en la PR capturas a 1440 y 500 px como artefacto o comentario, para que Felipe las vea de un vistazo desde el móvil.

Boceto del blueprint (`playground/blueprint.json`; los nombres de campo hay que validarlos contra `https://playground.wordpress.net/blueprint-schema.json`):

```json
{
  "$schema": "https://playground.wordpress.net/blueprint-schema.json",
  "landingPage": "/",
  "preferredVersions": { "php": "8.4", "wp": "latest" },
  "steps": [
    { "step": "installPlugin", "pluginData": { "resource": "git:directory", "url": "https://github.com/GeiserX/museopostal", "ref": "<rama>", "path": "plugin/museopostal-coleccion" } },
    { "step": "installTheme",  "themeData":  { "resource": "git:directory", "url": "https://github.com/GeiserX/museopostal", "ref": "<rama>", "path": "theme/museopostal" }, "options": { "activate": true } },
    { "step": "importWxr", "file": { "resource": "url", "url": "https://raw.githubusercontent.com/GeiserX/museopostal/<rama>/playground/muestra.xml" } }
  ]
}
```

Qué **no** debe ir al repo público: el WXR completo (`backup/…xml`, que lleva el correo del administrador y metadatos internos), capturas del escritorio de wp-admin, `apppw.json` ni ningún `.html` del admin. `muestra.xml` debe ser un WXR saneado con contenido que ya es público (unas pocas piezas, una sala, dos entradas) y con las imágenes enlazadas a sus URL públicas.

Fuentes: [Guía PR Preview](https://developer.wordpress.org/playground/handbook/guides/github-action-pr-preview/) · [action-wp-playground-pr-preview](https://github.com/WordPress/action-wp-playground-pr-preview) · [Cambios de la v3](https://make.wordpress.org/playground/2026/06/02/pr-preview-with-wordpress-playground-what-changes-in-version-3-of-the-github-action/) · [Playground para desarrolladores de temas](https://developer.wordpress.org/playground/handbook/guides/for-theme-developers/)

---

## 8. MCP, Abilities API y la cabecera Authorization (pregunta 7)

### 8.1 Qué es realmente el endpoint

- `mcp.json` confirma que existen `/wp-json/mcp` y `/wp-json/mcp/mcp-adapter-default-server` (métodos POST, GET y DELETE).
- **No es del núcleo.** El MCP Adapter es un paquete o plugin aparte (`wordpress/mcp-adapter`). La hoja de ruta de 7.2 (18-09-2026) sigue planteando «publicarlo en el directorio de plugins». **WooCommerce lo incluye** y lo arranca con el *feature flag* `mcp_integration`; su documentación indica este mismo endpoint por defecto y marca como obsoleto `/wp-json/woocommerce/mcp`. Inferencia: aquí casi seguro lo trae WooCommerce 10.8.1, aunque podría ser otro plugin que incluya el paquete. Se comprueba en WooCommerce › Ajustes › Avanzado › Características, o viendo si el endpoint desaparece en el clon al desactivar WooCommerce.
- **Qué ofrece**: el servidor por defecto expone 3 meta-herramientas (`mcp-adapter/discover-abilities`, `mcp-adapter/get-ability-info`, `mcp-adapter/execute-ability`) sobre las **abilities marcadas como públicas** (`meta.mcp.public = true`). El núcleo (6.9) trae `core/get-site-info`, `core/get-user-info` y `core/get-environment-info`, todas de lectura. WooCommerce añade, con el flag activo, productos (consultar, crear, actualizar, borrar) y pedidos (consultar, cambiar estado, notas). **No hay abilities para crear o editar páginas o entradas** si no las registra alguien.
- **Transporte y autenticación**: JSON-RPC por HTTP POST con cabecera `Mcp-Session-Id`, o STDIO por WP-CLI. En remoto se autentica con **contraseñas de aplicación** (Basic); el proxy local es `@automattic/mcp-wordpress-remote`. La Abilities API tiene su propia REST en `/wp-json/wp-abilities/v1` y se registra con `wp_register_ability()` en el hook `wp_abilities_api_init`.

### 8.2 Por qué falla Basic y cómo arreglarlo

- `rest_not_logged_in` significa que WordPress **no vio ninguna credencial**. Con una contraseña incorrecta devolvería `incorrect_password` o `invalid_username`. Eso, junto con `last_used: null`, apunta a que **la cabecera `Authorization` no llega a PHP**.
- Que Really Simple Security tenga las contraseñas de aplicación desactivadas es menos probable, porque la creación funcionó. Aun así, hay que revisar su opción de endurecimiento que «impide generar y usar» contraseñas de aplicación.
- **Diagnóstico**: Herramientas › Salud del sitio › **Estado** tiene la prueba «Authorization header». `sitehealth.html` es la pestaña Información, así que no la incluye.
- **Arreglo en `.htaccess`** (LiteSpeed y Apache; aquí lo respeta LiteSpeed). Desde WordPress 5.6 el bloque `# BEGIN WordPress` ya incluye la regla, así que primero hay que mirar si está:

```apache
# Encima de "# BEGIN WordPress"
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
</IfModule>
<IfModule mod_setenvif.c>
SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1
</IfModule>
# Solo Apache >= 2.4.13 (LiteSpeed puede ignorarlo):
# CGIPassAuth On
```

  WordPress rellena `PHP_AUTH_USER` y `PHP_AUTH_PW` a partir de `HTTP_AUTHORIZATION` o `REDIRECT_HTTP_AUTHORIZATION`.
- **Cómo editarlo sin SFTP**: con el gestor de archivos de WePanel. Guardar Ajustes › Enlaces permanentes regenera solo el bloque de WordPress. El editor de ficheros de Yoast no sirve con `DISALLOW_FILE_EDIT`.
- **Si sigue fallando**, el que quita la cabecera es el **nginx de delante** o el WAF de Webempresa. Eso no se puede tocar desde un alojamiento compartido: hay que abrir un ticket a Webempresa preguntando si su proxy elimina `Authorization` en `/wp-json/`.

### 8.3 ¿Conectarlo a Executor?

**No, por ahora.**
1. El rediseño no lo necesita: el despliegue son zips y la migración es de una sola vez.
2. El MCP por defecto no permite editar contenido.
3. Tendría que salir por watchtower por el geobloqueo, y la autenticación Basic hoy no funciona.

Si más adelante se quiere ayudar a Felipe de forma continuada (por ejemplo, redactar fichas de piezas):
1. Arreglar la cabecera (8.2).
2. Crear un usuario dedicado con rol **Editor**, no el administrador.
3. Usar la REST normal `wp/v2` (`/wp/v2/pieza`, `/wp/v2/media`, `/wp/v2/pages`) o registrar en el plugin compañero 2–3 abilities propias (`museopostal/crear-pieza`, `museopostal/listar-salas`) con `meta.mcp.public = true`.

Mientras tanto, lo higiénico es **revocar la contraseña de aplicación `executor-sergio-2026-09-28`** si no se va a usar.

Fuentes: [MCP Adapter (dev blog)](https://developer.wordpress.org/news/2026/02/from-abilities-to-ai-agents-introducing-the-wordpress-mcp-adapter/) · [WordPress/mcp-adapter](https://github.com/WordPress/mcp-adapter) · [Hoja de ruta 7.2](https://make.wordpress.org/core/2026/09/18/roadmap-to-7-2/) · [MCP en WooCommerce](https://developer.woocommerce.com/docs/features/mcp/) · [Abilities API](https://developer.wordpress.org/news/2025/11/introducing-the-wordpress-abilities-api/) · [Guía de contraseñas de aplicación](https://make.wordpress.org/core/2020/11/05/application-passwords-integration-guide/) · [Trac #51723 (regla .htaccess en 5.6)](https://core.trac.wordpress.org/ticket/51723) · [Wiki «Basic Authorization Header Missing»](https://github.com/WordPress/application-passwords/wiki/Basic-Authorization-Header----Missing) · [Endurecimiento de Really Simple Security](https://really-simple-ssl.com/instructions/about-hardening-features/)

---

## 9. Estructura del repositorio propuesta (`GeiserX/museopostal`, público, GPL-3.0)

```
theme/museopostal/                 tema de bloques
plugin/museopostal-coleccion/      CPT, taxonomías, meta, redirecciones, PUC, formato WebP
playground/blueprint.json          vista previa en PR
playground/muestra.xml             WXR saneado (solo contenido público)
.github/workflows/ci.yml           php -l y validación de theme.json con su esquema
.github/workflows/release.yml      zips y Release en cada tag v*
.github/workflows/pr-preview.yml   botón de Playground
.github/workflows/screenshots.yml  opcional: capturas a 1440 y 500 px
LICENSE                            GPL-3.0
```

Todo se ejecuta en `ubuntu-latest`, gratis por ser un repo público. Ni credenciales ni exportaciones completas en el repo.

---

## 10. Riesgos y comprobaciones pendientes

1. Confirmar en el clon qué plugin sirve el endpoint MCP y si desaparece sin WooCommerce.
2. Verificar si AIOSEO tiene datos en su tabla propia antes de retirarlo, aunque su postmeta esté vacío.
3. Revisar qué inyecta «Protección de datos - RGPD» antes de retirarlo.
4. Comprobar que el WAF de Webempresa acepta la subida de los zips (probar con uno mínimo).
5. Confirmar con alguien con criterio legal la decisión sobre el banner de cookies si se opta por analítica sin cookies.
6. Comprobar si el geobloqueo de wp-admin se aplica también al subdominio clonado.
7. `WP_MEMORY_LIMIT` en el front es 40M. Hoy no da problemas con 1024M de máximo en admin, pero conviene vigilarlo si algo pesado sigue activo.
8. Las plantillas editadas desde el Editor del sitio tapan las del tema (sección 2.3): hay que explicárselo a Felipe.