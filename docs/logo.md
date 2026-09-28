# Logo: tres propuestas

Felipe, aquí tienes tres propuestas para el logo nuevo. Las tres parten del logo granate de siempre, con su sello dentado, la lupa, el mapa de la Región y el laurel. Ninguna lleva corneta ni corona, por el motivo que explicamos al final. Cada propuesta tiene tres piezas:

- **Marca.** El símbolo solo, en cuadrado, para redes, el pie y las fichas.
- **Horizontal.** La marca con el nombre al lado. Es la que va en la cabecera de la web.
- **Favicon.** La versión de 32 × 32 píxeles para la pestaña del navegador.

Cada una encaja con una de las tres direcciones visuales del [brief](investigacion/BRIEF.md): Álbum, Estafeta y Sala blanca. Se pueden mezclar, y la C quedaría igual de bien con Álbum.

## Las tres, lado a lado

| | A · Sello y lupa | B · Fechador | C · Dentado |
|---|---|---|---|
| Marca | ![Propuesta A, marca](../theme/museopostal/assets/logo/propuesta-a-marca.svg) | ![Propuesta B, marca](../theme/museopostal/assets/logo/propuesta-b-marca.svg) | ![Propuesta C, marca](../theme/museopostal/assets/logo/propuesta-c-marca.svg) |
| Favicon | ![Propuesta A, favicon](../theme/museopostal/assets/logo/propuesta-a-favicon.svg) | ![Propuesta B, favicon](../theme/museopostal/assets/logo/propuesta-b-favicon.svg) | ![Propuesta C, favicon](../theme/museopostal/assets/logo/propuesta-c-favicon.svg) |
| Dirección | Álbum | Estafeta | Sala blanca |

**A · Sello y lupa**

![Propuesta A, horizontal](../theme/museopostal/assets/logo/propuesta-a-horizontal.svg)

**B · Fechador**

![Propuesta B, horizontal](../theme/museopostal/assets/logo/propuesta-b-horizontal.svg)

**C · Dentado**

![Propuesta C, horizontal](../theme/museopostal/assets/logo/propuesta-c-horizontal.svg)

## La idea de cada una

### A · Sello y lupa

Es el logo actual redibujado con líneas limpias. Un sello granate con dentado y marco interior, una lupa azul tinta sobre el mapa de la Región y dos ramas de laurel debajo. La corneta del centro desaparece. Es la más fiel a lo que ya tienes y la que más cuenta, pero también la más cargada. El nombre va en Newsreader, una serif de lectura, y «de la Región de Murcia» en mayúsculas de Public Sans. Son las dos letras de Álbum.

### B · Fechador

Es un matasellos redondo de estafeta. Arriba dice «MUSEO POSTAL», abajo «MURCIA», con una estrella a cada lado y el mapa de la Región en el centro. En la horizontal lo acompañan las líneas onduladas del rodillo. Huele a oficina de correos y a taller, y eso le va bien al Aula. El nombre va en Archivo Narrow y la segunda línea en IBM Plex Mono, una letra de máquina de escribir, como en Estafeta.

### C · Dentado

Es la más sencilla. Un sello granate macizo con el mapa de la Región recortado, sin lupa, sin laurel y sin letras. Es sobria y moderna, se reconoce de lejos y se puede estampar, bordar o grabar en una sola tinta. Para mi gusto es la que mejor envejece. El nombre va en Instrument Serif y la segunda línea en Atkinson Hyperlegible Next, una letra diseñada para personas con baja visión. Son las de Sala blanca.

## Cómo se ven a 32 píxeles

A 32 píxeles, que es el tamaño de la pestaña del navegador, el laurel y el marco se vuelven ruido. Por eso cada propuesta lleva un favicon propio, más simple que la marca.

- **A.** El sello con la lupa y la mancha del mapa. A 32 px se lee bien. A 16 px queda un cuadrado granate con un círculo claro, que todavía se distingue entre pestañas.
- **B.** El aro del fechador sobre un disco crema, con el mapa dentro y sin letras ni estrellas. Es el que mejor aguanta en pestañas oscuras, porque el disco crema lo separa del fondo.
- **C.** El sello macizo con el mapa recortado. A 16 px es la silueta más clara de las tres. En una pestaña oscura el recorte toma el color del fondo y el mapa se ve oscuro dentro del sello granate.

Revisamos cada favicon a 32 y a 16 px sobre blanco y sobre el gris oscuro `#202124` de las pestañas en modo oscuro.

## Detalles técnicos

- **SVG sin imágenes dentro ni fuentes incrustadas.** Las letras están convertidas a trazos, así que el logo se ve igual en un ordenador que no tenga esas fuentes. Las seis familias tienen licencia SIL Open Font License, que permite usarlas en un logo. Ningún fichero pasa de 16 KB.
- **El mapa es real.** La silueta sale del contorno de la Región de Murcia en [Natural Earth](https://www.naturalearthdata.com/) a escala 1:10 millones, que es de dominio público y no pide atribución. La simplificamos para que se lea en pequeño, con unos 57 puntos en la marca y unos 30 en el favicon. El Mar Menor no aparece, porque a estos tamaños se queda en una muesca que parece un error.
- **Los colores siguen al tema.** Por defecto el granate es `#8A1538` y la tinta `#1A2E44`, los del brief. Cuando el SVG va incrustado en la página, toma el acento y el color principal de la variación de estilo activa, `--wp--preset--color--accent` y `--wp--preset--color--primary`. La misma marca sirve así para Álbum, Estafeta y Sala blanca. El favicon usa colores fijos, porque el navegador lo pinta fuera de la página.
- **Fondo transparente.** La marca y la horizontal no tienen fondo, y sus huecos dejan ver el color de la página: la lente en A y el mapa en C. El favicon B lleva su propio disco crema.

## Precaución con las marcas de Correos

La identidad de Correos es una corneta de posta con corona sobre fondo amarillo, y esa corneta figura en sus marcas registradas. Un museo postal que la use puede pasar por un museo de Correos o meterse en un conflicto de marca. Por eso las tres propuestas:

- no llevan corneta, ni sola ni con corona;
- no llevan corona;
- no usan el amarillo de Correos, solo el granate y el azul tinta del museo.

El laurel, el sello dentado, la lupa, el fechador y el mapa son motivos comunes de la filatelia. Aun así, todavía no hemos buscado en la Oficina Española de Patentes y Marcas. Antes de cerrar el logo hay que buscar allí las marcas de Correos y las que contengan «Museo Postal».

## Ojo con el nombre

El artículo 17 de la [Ley 5/1996 de Museos de la Región de Murcia](https://www.boe.es/buscar/act.php?id=BOE-A-1996-25660) pide autorización para usar en el nombre de un museo expresiones que abarquen toda la Comunidad Autónoma, como «de la Región de Murcia». Si hubiera que cambiar el nombre, las marcas A y C no llevan letras y se quedan como están. La B solo dice «MUSEO POSTAL» y «MURCIA». En las horizontales bastaría con rehacer la línea del nombre.

## Qué falta cuando elijas

- El PNG de 512 px para el icono del sitio en WordPress, en Ajustes › Identidad del sitio, y el de 180 px para iPhone. Salen del SVG elegido.
- Poner la horizontal elegida en la cabecera del tema, en lugar del nombre en texto.
- Quitar del repositorio las dos propuestas que no elijas.
