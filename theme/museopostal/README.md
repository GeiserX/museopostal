# Tema «Museo Postal»

Tema de bloques del Museo Postal y Filatélico de la Región de Murcia. Requiere WordPress 7.1 y PHP 8.1. Las piezas, las salas y sus datos los registra el plugin `museopostal-coleccion`; sin él, el tema funciona pero las fichas salen vacías.

## Qué trae

- `theme.json` (versión 3) con paleta, tipos y tamaños cerrados: el editor no ofrece colores ni tamaños libres, así que el diseño no se rompe al publicar.
- `style.css`: cabecera del tema y el CSS que `theme.json` no cubre (montura de pieza, filete dentado, ficha, foco visible, objetivos táctiles de 44 px).
- `functions.php`: categorías de patrones, estilos de bloque y WebP para los tamaños intermedios de las imágenes.
- 15 plantillas y 2 partes (`header`, `footer`). La cabecera y el pie son patrones PHP (`patterns/cabecera.php`, `patterns/pie.php`) para que los enlaces salgan de `home_url()` y funcionen igual en museopostal.org, en el clon de pruebas y en Playground.
- Patrones del museo: `ficha-pieza`, `sala-intro`, `recorrido`, `actividad-aula`, `videoteca-item`, `recurso`, `museo-del-mundo`, `articulo`, `portada-hero`, `portada-puertas`, `portada-efemeride`, `portada-cifras` y el auxiliar `rejilla-piezas`.

El tema base usa las fuentes del sistema. Cada dirección visual (`styles/album.json`, `styles/estafeta.json`, `styles/sala-blanca.json`) trae sus woff2 en `assets/fonts/<slug>/`, y `functions.php` precarga los dos primeros de la variación activa.

## Logo

Las tres propuestas están en `assets/logo/` (`propuesta-{a,b,c}-{marca,horizontal,favicon}.svg`; el porqué de cada una, en [`docs/logo.md`](../../docs/logo.md)). La cabecera pinta en línea la horizontal que elige `settings.custom.logo` (por defecto `propuesta-a`; Álbum usa la A, Estafeta la B y Sala blanca la C), así el SVG toma el acento y el color principal de la variación. `functions.php` añade el favicon de la misma propuesta mientras no haya un icono del sitio subido en Ajustes › Identidad del sitio. Si `settings.custom.logo` está vacío, la cabecera vuelve al nombre del sitio en texto.

## Paleta: los siete colores que cambia cada variación

Las plantillas, los patrones y `style.css` solo usan estos slugs, nunca un color escrito a mano. Una variación en `styles/<slug>.json` cambia el aspecto entero redefiniendo estos siete valores.

| Slug | Uso | Valor base |
|---|---|---|
| `base` | Fondo de página; texto sobre `primary` y `accent` (botones) | `#FFFFFF` |
| `surface` | Fondo de tarjetas, pie y bloques destacados | `#F5F4F1` |
| `contrast` | Texto principal | `#1F1F1F` |
| `primary` | Titulares, enlaces y fondo de botones | `#1F3A5A` |
| `secondary` | Texto secundario: extractos, pies de foto, etiquetas de la ficha | `#5A5A5A` |
| `accent` | Acento: foco, hover, sala central, puntos del Aula, filete por defecto | `#8A1538` |
| `mount` | Montura: el fondo neutro sobre el que se ve cada pieza entera | `#E8E6E1` |

La CI comprueba 12 pares de texto y fondo (por ejemplo `contrast` sobre `base`, `secondary` sobre `surface`, `base` sobre `accent`) en `theme.json` y en cada variación, y falla por debajo de 4,5:1.

El color del filete dentado no está en la paleta, porque no es texto y puede ser un oro de 2,6:1: va en `settings.custom.filete` y sale como `--wp--custom--filete`. Por defecto usa `accent`.

El texto sobre la montura (pies de foto y sus enlaces) va en `settings.custom.textoMontura`, como `var(--wp--preset--color--<slug>)`; por defecto `contrast`, y Álbum usa `base` porque su montura es negra. La CI mide ese par (`textoMontura` sobre `mount`) con el slug que declare cada variación.

## Tipografía

Tres slugs de familia. Con dos familias, dos de ellos apuntan a la misma:

| Slug | Uso |
|---|---|
| `heading` | Titulares y nombre del sitio |
| `body` | Texto de lectura |
| `ui` | Menú, fichas, botones, migas, pies de foto |

Tamaños cerrados, fluidos entre móvil y escritorio: `small` (16 px), `medium` (18-20 px, el cuerpo), `large`, `x-large` y `xx-large`. Los números de inventario, catálogo y fechas usan cifras tabulares (`font-variant-numeric: tabular-nums`) de la misma familia.

## Cómo se añade una variación

Un fichero `styles/<slug>.json` con `"version": 3`, `"title"`, y lo que cambie: `settings.color.palette` (los siete slugs), `settings.typography.fontFamilies` (los tres slugs, con `fontFace` apuntando a `file:./assets/fonts/…woff2`), `settings.custom.filete`, `settings.custom.logo`, `settings.custom.textoMontura` y los `styles` que haga falta. La CI lo valida contra el esquema de WordPress 7.1, mide su contraste, el job de capturas lo fotografía solo (portada, sala y ficha a 1440 y 500 px, en la rama `capturas/pr-<n>`) y la vista previa de la PR le añade su propio enlace de Playground.

## Principios que el tema hace cumplir (BRIEF §6.1)

- La pieza entera sobre su montura: `object-fit: contain`, sin recortes ni esquinas redondeadas (estilo de bloque «Pieza sobre montura»).
- Un solo ornamento, el filete dentado (estilo de separador «Filete dentado»).
- Sin carruseles. Un H1 por página.
- Todo funciona sin JavaScript: «Todos los datos» es un `<details>`, el vídeo es un enlace hasta que se pulsa y la pieza al azar es una redirección del servidor. La única excepción es la hamburguesa del menú en móvil, que es la del núcleo de WordPress; sin JavaScript, cada entrada del menú lleva a su página índice.

## Para Felipe

Edita contenido y patrones, no plantillas: una plantilla cambiada en el Editor del sitio se guarda en la base de datos y tapa las actualizaciones del tema hasta que pulses «Restablecer».
