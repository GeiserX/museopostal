# Dirección «Sala blanca»

Una de las tres propuestas de aspecto para el nuevo museopostal.org. Las tres usan el mismo tema, las mismas páginas y el mismo contenido. Solo cambian colores, letras y el trato de la imagen, así que puedes compararlas mirando la portada, una sala y una ficha, en el ordenador y en el móvil.

## La idea en tres líneas

Una sala de exposición moderna, del estilo del Rijksmuseum o del Met.
Mucho blanco, mucho aire y cada pieza grande y entera sobre un paspartú gris claro.
Un único color con carácter, el granate del logo, y ningún adorno más.

## Paleta

Siete colores cerrados. En el editor no podrás elegir otros, y así el diseño no se rompe al publicar. Todos los textos cumplen el contraste mínimo de accesibilidad de 4,5:1, que hemos medido con la fórmula oficial de WCAG.

| Color | Hex | Para qué | Contraste |
|---|---|---|---|
| Blanco | `#FFFFFF` | Fondo de todas las páginas | fondo |
| Fondo alterno | `#F7F6F3` | Pie de página | fondo; el texto encima da 15,25:1 |
| Paspartú | `#EDEBE6` | Fondo gris sobre el que se ve cada pieza entera | fondo; el texto encima da 13,84:1 y el granate 7,85:1 |
| Texto | `#1F1F1F` | Texto de lectura, titulares y menú | 16,48:1 sobre blanco |
| Texto secundario | `#5E5E5E` | Extractos, pies de foto, etiquetas de la ficha | 6,48:1 sobre blanco, 6,00:1 sobre el fondo alterno |
| Granate | `#8A1538` | Enlaces, botones, la marca de sala central y el foco del teclado | 9,35:1 sobre blanco; el blanco sobre granate, también 9,35:1 |

Los titulares van en el mismo negro que el texto. El granate queda para lo que se puede pulsar y para señalar la sala de la Región de Murcia. Así es el único acento de la página.

El filete dentado, el separador con la perforación de un sello, sale en el gris del paspartú. Se ve, pero casi no se nota.

## Tipografía

Dos familias, guardadas en el propio sitio. El visitante no hace ninguna petición a Google al cargar la página.

- **Instrument Serif**, una letra de titular fina y elegante, solo para el título principal de cada página, los títulos de sección y el nombre del museo en la cabecera. Tiene un único grosor, así que nunca sale en negrita.
- **Atkinson Hyperlegible Next** para todo lo demás: el texto de lectura, el menú, los botones y los datos de la ficha. La diseñó el Braille Institute para personas con baja visión, y distingue bien letras que otras confunden, como la I mayúscula, la l minúscula y el 1. Los números de inventario, Edifil y fechas usan cifras de ancho fijo, así que las columnas quedan alineadas.

El cuerpo de texto mide entre 18 y 20 píxeles, con interlineado de 1,6 y líneas de entre 60 y 70 caracteres. Los subtítulos menores van en Atkinson negrita.

Los cuatro ficheros de letra pesan 102 KB en total. Una página normal descarga dos, unos 49 KB. Las cursivas solo se descargan si la página tiene una cita o un título de obra. Las dos familias traen todo el español: á, é, í, ó, ú, ü, ñ, ¿, ¡, «, » y €. A Instrument Serif le faltan ¼ y ¾, pero esos signos solo aparecen en el dentado de la ficha, que va en Atkinson.

Ficheros en [`theme/museopostal/assets/fonts/sala-blanca/`](../../theme/museopostal/assets/fonts/sala-blanca/), con la licencia OFL de cada familia al lado. La variación completa está en [`theme/museopostal/styles/sala-blanca.json`](../../theme/museopostal/styles/sala-blanca.json).

## Cómo se tratan las imágenes

- Cada pieza se ve entera, sin recortes ni esquinas redondeadas, sobre el paspartú gris con un margen ancho alrededor. En la ficha el margen llega a 4 rem en pantalla grande. En las rejillas de piezas es más estrecho para que quepan varias por fila.
- No hay sombras, texturas de papel ni marcos. Tampoco medallones ni imágenes generadas.
- Está previsto que cada sala abra con un detalle ampliado de una pieza real a todo lo ancho. En esta maqueta todavía no sale, porque falta un escaneo de detalle por sala.

## Qué vas a notar

**En la portada.** El nombre del museo en letra grande y fina, con la misión debajo en letra de lectura. Un botón granate, «Entrar en las salas», y otro con solo el borde, «Explorar la colección». Las cinco salas van como fichas blancas con una línea negra fina encima. La sala de la Región de Murcia lleva la línea en granate, más gruesa, y la etiqueta «Sala central». El pie va en gris muy claro.

**En una sala.** El nombre de la sala en grande, el texto de sala en letra cómoda y, debajo, las piezas en rejilla. Cada pieza está sobre su paspartú, con el título en negro. El título se vuelve granate al pasar por encima.

**En una ficha.** La pieza ocupa casi todo el ancho sobre el paspartú, con mucho margen. Debajo van los datos en columnas limpias y el botón «Todos los datos», que despliega el resto sin cargar otra página. Los enlaces van en granate subrayado y el foco del teclado se ve siempre.

Las capturas a 1440 y 500 píxeles de estas tres páginas aparecen en la PR, junto al botón para abrir el tema en tu móvil.

## A favor y en contra

A favor:

- Es la más fácil de mantener coherente, porque hay muy poco que pueda desentonar.
- Envejece bien. Dentro de diez años seguirá pareciendo un museo y no una moda.
- Atkinson Hyperlegible ayuda en el Aula y a los visitantes mayores.

En contra:

- Exige escaneos limpios y con el color calibrado. Sobre blanco no hay dónde esconder un mal recorte o un sobre con dominante amarilla.
- Puede resultar fría o genérica. Se parece a muchos museos grandes y menos a tu museo.
- Pierde la identidad cálida que ya elegiste, el crema y la tinta. Solo queda el granate.
- Instrument Serif tiene un solo grosor. Los titulares no pueden ir en negrita, y los subtítulos pasan a la otra familia.

La propuesta que recomendamos es «Álbum», que conserva tu paleta crema. «Sala blanca» es la alternativa si tus escaneos son uniformes y prefieres un aire más institucional.

## Qué supone decir que sí

1. «Sala blanca» pasa a ser el aspecto del tema. Quitamos las otras dos variaciones y sus letras, y el tema queda con dos familias y siete colores.
2. Los escaneos pasan a ser lo más importante. Cada pieza nueva necesita un escaneo a 600 ppp como mínimo, con fondo neutro, margen alrededor del dentado y color corregido. Cada sala necesita además un detalle a 1200 ppp para su cabecera, cinco en total para abrir.
3. El crema del sitio actual desaparece. El logo granate encaja sin cambios de color.
4. Tú sigues editando solo contenido y patrones. Colores, letras y tamaños están cerrados, así que una pieza nueva sale igual que las demás.
