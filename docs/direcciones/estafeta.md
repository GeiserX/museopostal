# Dirección «Estafeta»

Es una de las tres direcciones visuales del museo ([BRIEF §6.2 B](../investigacion/BRIEF.md)). Técnicamente es una variación de estilo del tema `museopostal`. El contenido y las plantillas son los mismos; cambian los colores, las letras y algunos detalles. Todo está en [`theme/museopostal/styles/estafeta.json`](../../theme/museopostal/styles/estafeta.json).

## La idea en tres líneas

- Una oficina de correos y un archivo de trabajo, no un salón.
- Rótulos estrechos como los de una ventanilla, datos en letra de máquina de escribir, rojo lacre y azul de matasellos sobre papel kraft.
- Es la más didáctica de las tres. Encaja con el Aula y con «Comparte tu pieza».

## Paleta

Todos los pares de texto y fondo pasan de 4,5:1 (WCAG AA). Un script calcula cada contraste con la fórmula WCAG, y como control da 21:1 para negro sobre blanco.

| Color | Hex | Para qué | Contraste |
|---|---|---|---|
| Kraft | `#EDE3CF` | Fondo de página y montura de las piezas | fondo de referencia |
| Ficha blanca | `#FFFFFF` | Tarjetas de sala y bloques destacados | fondo de referencia |
| Negro tinta | `#1C1B19` | Texto y titulares; fondo del pie | 13,51:1 sobre kraft; 17,21:1 sobre blanco |
| Azul matasellos | `#24466B` | Enlaces, botones y el fechador | 7,62:1 sobre kraft; 9,71:1 sobre blanco; kraft sobre azul 7,62:1 |
| Grafito | `#55524C` | Texto secundario: extractos, pies, etiquetas de la ficha | 6,11:1 sobre kraft; 7,78:1 sobre blanco |
| Lacre | `#A4262C` | Acento: foco, paso del ratón, sala central, filete dentado | 5,70:1 sobre kraft; 7,26:1 sobre blanco; kraft sobre lacre 5,70:1 |
| Mostaza buzón | `#E3B23C` | Solo fondo de las etiquetas («Sala central», «Sala del museo»), siempre con texto negro | 8,77:1 con negro tinta. Sobre kraft da 1,54:1, así que nunca es texto |

El BRIEF da seis colores y el tema necesita siete. El séptimo es el blanco, que el BRIEF ya usa en los botones. La mostaza no está en la paleta del editor, así que nadie puede elegirla como color de texto por error. Es más apagada que el amarillo de Correos, y esta dirección no usa la corneta en ningún sitio.

## Tipografía

Son dos familias y las sirve el propio museo. Visitar la web no hace ninguna petición a Google.

| Familia | Uso | Ficheros |
|---|---|---|
| **Archivo** (variable, anchura 62-125 y peso 100-900) | Titulares estrechos y en negrita, cuerpo de lectura a 19 px con interlineado 1,6, menú y botones en mayúsculas espaciadas | Redonda 88 KB, cursiva 100 KB |
| **IBM Plex Mono** (400 y 600) | Datos de la ficha (inventario, fecha, Edifil, origen, destino), la cita, las cifras de la colección, la licencia y las etiquetas | 10 KB cada peso |

En total pesan 212 KB. Solo llevan el subconjunto latino, que cubre á é í ó ú ü ñ ¿ ¡ « » € × ¼ ½ ¾. Las dos tienen licencia SIL Open Font License ([Archivo](../../theme/museopostal/assets/fonts/estafeta/OFL-Archivo.txt), [IBM Plex Mono](../../theme/museopostal/assets/fonts/estafeta/OFL-IBM-Plex-Mono.txt)). La cursiva queda para citas y títulos de obra. Una serif para los textos largos sería la tercera familia, y el BRIEF pone el límite en dos, así que esta dirección no la usa.

## Tratamiento de la imagen

- Cada pieza va entera y sin recortar sobre el kraft, con una sombra mínima que sigue el borde del sello o del sobre.
- En los listados, las piezas se ordenan en filas separadas por un filete negro, como en un clasificador.
- La fecha de la efeméride de la portada es un fechador circular de doble aro en azul matasellos, ligeramente girado.
- Las fotos de archivo (personas, edificios, oficinas) se pueden pasar a duotono azul con el filtro «Foto de archivo en azul» del editor. Las piezas nunca, porque tienen que verse con su color real.
- El único ornamento es el filete dentado en lacre, en el pie y entre secciones.

## Qué notarás en cada página

**Portada.** Cabecera en kraft con el nombre del museo en mayúsculas estrechas y una línea negra gruesa debajo. El H1 es grande y estrecho. Las cinco puertas son fichas blancas con una franja azul arriba, y la sala central lleva borde lacre y la etiqueta mostaza «Sala central». La efeméride sale con el fechador. El pie es negro tinta con el filete dentado encima.

**Sala.** Etiqueta mostaza «Sala del museo», título de la sala muy grande y las piezas en filas de clasificador: filete negro, pieza sobre kraft, título en azul y una línea de contexto.

**Ficha.** La pieza grande sobre kraft, y a su lado los datos clave con la etiqueta en mayúsculas grafito y el valor en letra de máquina («MPF-2026-001», «18 de junio de 1866»). «Cómo citar esta pieza» también va en letra de máquina, como una referencia de archivo.

## A favor y en contra (BRIEF §6.2)

A favor:
- Identidad muy reconocible.
- La letra de máquina ordena los datos. Edifil, fechas e inventarios se leen de un vistazo.
- Atrae al público escolar.

En contra:
- La tematización puede parecer un disfraz. Es el riesgo más serio.
- El amarillo recuerda a la marca Correos. Por eso la mostaza solo aparece en etiquetas pequeñas y la corneta no se usa.
- El kraft baja el contraste de las fotos claras. Se nota en los escaneos con margen blanco. El sobre de Águilas de la muestra se ve como un rectángulo blanco sobre el kraft. Con esta dirección hay que recortar los escaneos al borde de la pieza o dejarlos con fondo neutro.
- Serían tres familias si se añade una serif. Esta propuesta no la añade.

## Qué implica decir «sí» a Estafeta

1. Se activa la variación «Estafeta» en *Apariencia › Editor › Estilos*. No cambia ninguna pieza ni ningún texto. Es un clic y se puede deshacer.
2. Los escaneos tienen que venir recortados o con fondo neutro, porque el kraft deja ver los márgenes blancos.
3. El fechador con la fecha de cada pieza, que el BRIEF propone en SVG, hoy solo sale en la efeméride de la portada. Ponerlo en cada ficha es un cambio pequeño en el plugin, y se haría después de elegir.
4. Los textos largos (salas, artículos) se leen en Archivo, una letra sin remates. Si prefieres leer en una serif, elige «Álbum» o «Sala blanca» en lugar de añadir una tercera familia aquí.
5. El logo granate se redibuja en SVG como dice el BRIEF §6.4, pero sin la corneta. Esta dirección ya recuerda a Correos y la corneta lo empeoraría. El granate del logo convive con el lacre y el azul, así que hay que probarlo sobre kraft antes de cerrarlo.
