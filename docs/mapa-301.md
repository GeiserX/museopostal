# Mapa de redirecciones 301

Cuando el sitio nuevo sustituya al antiguo, cada URL vieja lleva a su sitio nuevo con una redirección permanente (301). Así no se pierden los enlaces que ya circulan ni lo que Google tiene indexado.

La lista que manda es el array de `plugin/museopostal-coleccion/includes/redirecciones.php`. Esta página la explica; si cambia una, cambia la otra.

## Cómo funciona

- Solo actúa cuando WordPress iba a responder 404. Mientras una página antigua exista, se sirve ella. Cuando se convierte o se borra, su URL vieja empieza a redirigir sola, sin activar nada.
- Una URL inventada sigue dando 404: el mapa no tapa errores.
- Las claves son rutas (`/elementor-548/`), enlaces cortos (`?p=235`, `?page_id=235`) o prefijos terminados en `*` (`/producto/*`).
- Se puede ampliar sin tocar el plugin con el filtro `museopostal_coleccion_redirecciones`.

## Rutas

Sacadas de la BRIEF §4.4 y del sitemap público de museopostal.org (generado por All in One SEO, leído el 28-09-2026), que añade las categorías y etiquetas de producto y la categoría «Sin categoría».

| URL antigua | Destino |
|---|---|
| `/proximamente-pagina-principal/` | `/` |
| `/contenedor-de-blog/` | `/articulos/` |
| `/category/sin-categoria/` | `/articulos/` |
| `/elementor-548/`, `/carrito/`, `/tienda/` | `/el-museo/publicaciones/` |
| `/producto/…` (los dos productos y la base) | `/el-museo/publicaciones/` |
| `/categoria-producto/…` (`sellos`, `libros`, `filatelia`) | `/el-museo/publicaciones/` |
| `/etiqueta-producto/…` (`censura`, `guerra-civil`, `marcas-postales`, `nacional`, `ernstl-l-heller`) | `/el-museo/publicaciones/` |
| `/elementor-573/`, `/politica-privacidad/` | `/politica-de-privacidad/` |
| `/elementor-662/` | `/aviso-legal/` |
| `/politica-de-cookies-ue/` | `/politica-de-cookies/` |
| `/museos-del-mundo/` | `/investigacion/museos-postales-del-mundo/` |
| `/elementor-854/` | `/sala/el-correo-en-la-pintura/` |
| `/elementor-821/` | `/pieza/san-jeronimo-leyendo-una-carta/` |
| `/elementor-821-copy/` | `/pieza/la-carta-de-amor/` |
| `/cuadro_1-copy/` | `/pieza/las-ultimas-diligencias-del-correo-en-newcastle/` |
| `/cuadro_1-copy-2/` | `/pieza/el-cartero-del-pueblo/` |
| `/jean-baptiste-simeon-chardin/` | `/pieza/una-mujer-sellando-una-carta/` |
| `/museo_murcia/` | `/sala/region-de-murcia/` |
| `/eclipse-solar-agosto-2026-filatelia-correos-espana/` | `/articulos/los-eclipses-solares-en-la-filatelia/` |
| `/video-conferencias-historia-postal-y-filatelia/` | `/investigacion/videoteca/` |
| `/pagina_wasap/` | `/coleccion/comparte-tu-pieza/` |
| `/la-tarjeta-del-soldado/` | `/aula/la-tarjeta-del-soldado/` |
| `/formulario_informacion/` | `/contacto/` |
| `/padre_museo/`, `/investigacion-copy/` | `/` |
| `/el-wi-fi-del-siglo-xix/`, `/el-correo-en-los-ultimos-2000-anos/` | `/articulos/el-wi-fi-del-siglo-xix/` |
| `/el-correo-submarino-2/`, `/el-correo-submarino/` | `/articulos/el-correo-submarino/` |
| `/author/felipe/` | `/el-museo/` |

`/contacto/` e `/investigacion/` conservan su URL y no necesitan redirección.

## Enlaces cortos `?p=` y `?page_id=`

Cada página y entrada antigua tiene un número. Si ese número deja de existir, `/?p=N` y `/?page_id=N` llevan a su destino:

| N | Destino | N | Destino |
|---|---|---|---|
| 235 | `/` | 97 | `/investigacion/videoteca/` |
| 598 | `/sala/region-de-murcia/` | 126 | `/investigacion/museos-postales-del-mundo/` |
| 854 | `/sala/el-correo-en-la-pintura/` | 691 | `/investigacion/` |
| 821 | `/pieza/san-jeronimo-leyendo-una-carta/` | 748 | `/` |
| 827 | `/pieza/la-carta-de-amor/` | 59 | `/coleccion/comparte-tu-pieza/` |
| 836 | `/pieza/las-ultimas-diligencias-del-correo-en-newcastle/` | 531 | `/articulos/` |
| 857 | `/pieza/el-cartero-del-pueblo/` | 548, 382, 394 | `/el-museo/publicaciones/` |
| 753 | `/pieza/una-mujer-sellando-una-carta/` | 697, 324 | `/contacto/` |
| 925 | `/articulos/los-eclipses-solares-en-la-filatelia/` | 596 | `/` |
| 717 | `/articulos/el-correo-submarino/` | 573 | `/politica-de-privacidad/` |
| 472 | `/articulos/el-wi-fi-del-siglo-xix/` | 662 | `/aviso-legal/` |
| 118 | `/aula/la-tarjeta-del-soldado/` | 658 | `/politica-de-cookies/` |

## Cómo se comprueba (fases F4 y F5)

En el clon de pruebas y después en producción, con el plugin activo:

```bash
sitio=https://pruebas.museopostal.org
for ruta in /elementor-548/ /museo_murcia/ /el-correo-submarino-2/ /producto/125-aniversario-submarino-peral/ '/?page_id=596'; do
  printf '%s -> ' "$ruta"
  curl -s -o /dev/null -w '%{http_code} %{redirect_url}\n' "$sitio$ruta"
done
# Control negativo: una URL inventada tiene que seguir dando 404.
curl -s -o /dev/null -w '%{http_code}\n' "$sitio/esta-pagina-no-existe-$(date +%s)/"
```

Cada ruta del mapa debe dar `301` con su destino, y la inventada `404`. La lista completa de URL antiguas sale del sitemap, no se escribe a mano.
