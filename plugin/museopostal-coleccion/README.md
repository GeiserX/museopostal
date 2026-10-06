# Plugin «Museo Postal: colección»

El modelo del museo, separado del tema para que sobreviva a cualquier cambio de diseño. Requiere WordPress 7.1 y PHP 8.1. Sin dependencias, sin `npm` y sin compilar.

## Qué registra

- **Tipo de contenido `pieza`**: archivo en `/coleccion/`, fichas en `/pieza/<slug>/`. Cada pieza nueva empieza con el patrón `museopostal/ficha-pieza` del tema.
- **Taxonomías** `sala`, `tipo`, `epoca`, `lugar` y `tema`, con los términos iniciales del BRIEF §5.2. `epoca`, `lugar` y `tema` sirven también para los artículos. Los términos se crean al activar y tras cada actualización; nunca se renombran ni se borran los que ya existen.
- **Metadatos `mp_*`**: los 44 campos del BRIEF §5.1, visibles en la API REST y editables por quien puede editar la pieza. Una sola definición (`museopostal_coleccion_campos()` en `includes/modelo.php`) alimenta el registro, la caja del editor y el bloque de datos. También `mp_piezas`, `mp_fuentes` y `mp_revisado` en los artículos, y los metadatos de término de salas y épocas.
- **Caja «Ficha técnica»** en la barra lateral del editor, en PHP y HTML. Los seis grupos (A-F) están plegados y siempre visibles: ocultarlos según el tipo de pieza no funcionaría sin JavaScript. Avisa de los campos obligatorios vacíos y de un número de inventario repetido.
- **Bloques** registrados solo en PHP:
  - `museopostal/sala-cabecera`: la imagen de cabecera de la sala que se está viendo (`mp_sala_cabecera_id`), a sangre y recortada para llenar la franja; sin imagen no pinta nada. Por ese recorte, la cabecera tiene que ser un detalle ampliado de una pieza (escaneo macro a 1200 ppp, BRIEF §3.3), nunca el anverso entero: en la muestra de Playground se usa el anverso solo porque aún no hay detalles escaneados, y queda en la lista de F3.
  - `museopostal/datos-pieza`: vistas `imagenes` (anverso y reverso sobre montura, enlace al original, licencia y descarga si la licencia lo permite), `clave` (4 datos según el tipo), `ficha` («Todos los datos» en un `<details>`, solo los campos rellenos), `cita` («Cómo citar esta pieza») y `anotaciones` (puntos numerados para el Aula).
  - `museopostal/video`: fachada de clic. Sin JavaScript es un enlace a youtube-nocookie.com; con JavaScript el clic incrusta el vídeo. Nada se pide a YouTube antes del clic, ni siquiera la miniatura.
  - `museopostal/cifras`: piezas publicadas y salas con alguna pieza.
  - `museopostal/efemeride`: la pieza cuyo día y mes coinciden con hoy o, si no hay, la próxima.
  - `museopostal/pieza-al-azar`: enlace a `/?pieza-al-azar`, que responde con una redirección 302 sin caché a una pieza cualquiera.
- **Buscador por catálogo**: el buscador de WordPress encuentra también las piezas cuyo `mp_catalogo` o `mp_inventario` contiene la búsqueda («4870», «Edifil 81»).
- **Orden**: las salas por `mp_orden_sala` y las épocas por fecha. Las relacionadas de la ficha («En la misma sala», «De la misma época») usan una consulta con `"mpRelacion"`.
- **Redirecciones 301** del sitio antiguo (`includes/redirecciones.php`, filtrable con `museopostal_coleccion_redirecciones`). Solo actúan cuando WordPress iba a dar 404. Mapa y forma de comprobarlo: [`docs/mapa-301.md`](../../docs/mapa-301.md).
- **Comentarios cerrados** en todo el sitio, también en el contenido antiguo.

Desactivar el plugin no borra nada: piezas, términos y metadatos se quedan en la base de datos.

## Pendiente: actualizaciones desde GitHub

TODO: `plugin-update-checker` v5 todavía no está incluido. El sitio exacto donde irá es `includes/actualizaciones.php`, que explica por qué espera: la API de GitHub sin autenticar admite 60 peticiones por hora por IP, compartidas en el servidor de Webempresa, y la alternativa es un JSON de metadatos publicado con cada Release. Hay que probar las dos desde el clon de pruebas y proteger antes los tags `v*`. Hasta entonces, cada versión se instala subiendo el zip de la Release desde wp-admin.
