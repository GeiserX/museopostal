# Muestra para WordPress Playground

Lo necesario para ver el tema y el plugin con contenido real, en el navegador o en la CI, sin tocar museopostal.org.

| Fichero | Qué es |
|---|---|
| `blueprint.json` | Receta de Playground: WordPress 7.1 con PHP 8.4 en español, activa plugin y tema, copia las imágenes, importa la muestra y la completa. Espera que el tema y el plugin ya estén en `wp-content`. |
| `muestra.xml` | Exportación WXR con 8 piezas, 2 artículos y 6 páginas. |
| `muestra/` | Las 13 imágenes de la muestra. Los nombres siguen la costumbre `{año}_{edifil}_{variante}` (BRIEF §5.4). |
| `muestra.php` | Segundo paso: crea los adjuntos con su texto alternativo, pone anverso y reverso a cada pieza y fija la portada y la página de artículos. Si algo falta, para el blueprint en rojo. |
| `vista-previa.mjs` | Genera el blueprint del botón de cada PR: instala tema y plugin desde el commit de la PR y cambia cada recurso local por su URL de ese commit. |

## Qué contenido lleva

Solo contenido ya publicado en museopostal.org y copiado en este repositorio (`archive/2026-09-28-original/` y `docs/investigacion/03b-contenido-extraido.md`):

- **Piezas**: la carta de Águilas a Murcia de 1866, el sobre de primer día del submarino Peral (2014), la hoja bloque del eclipse de 2026, *San Jerónimo leyendo una carta* de Georges de la Tour, *La carta de amor* de Van der Kooi, la tarjeta del soldado de 1918 (con reverso y puntos para el Aula), el libro de Heller sobre la censura postal y la hoja bloque de los 300 años de Correos.
- **Artículos**: «El wi-fi del siglo XIX» y «El Correo Submarino».
- **Páginas**: Inicio, Artículos, Salas, El museo, Aula y Contacto (estas tres, marcadas como en preparación).
- **Términos**: las cinco salas y los lugares que faltan (Francia, Países Bajos, Italia).

Ningún dato personal: la CI busca DNI, NIE, correos personales, enlaces `wa.me` y móviles en esta carpeta y falla si encuentra alguno. La procedencia de cada pieza y la licencia de sus imágenes (todas «derechos reservados» por ahora) están pendientes de Felipe (BRIEF §10.2, pregunta 3).

El menú no va en la muestra: está en la cabecera del tema (`patterns/cabecera.php`), así que aparece igual con o sin importación.

## Arrancarla en local

En una máquina con Node 20.18 o superior:

```bash
npx @wp-playground/cli@3 server \
  --mount="$PWD/theme/museopostal:/wordpress/wp-content/themes/museopostal" \
  --mount="$PWD/plugin/museopostal-coleccion:/wordpress/wp-content/plugins/museopostal-coleccion" \
  --blueprint=playground/blueprint.json --blueprint-may-read-adjacent-files
```

El job `Capturas` hace exactamente esto en cada PR.
