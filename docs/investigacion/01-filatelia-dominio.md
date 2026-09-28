# Filatelia e historia postal como materia de museo: informe de dominio para el rediseño de museopostal.org

Fecha: 28-09-2026. Autor: agente de investigación (lectura de la exportación WXR y del espejo local, más fuentes web citadas).
Ámbito: qué es la materia, cómo se describe una pieza, contexto español y murciano, cómo lo presentan los museos postales en línea y qué modelo de contenidos conviene al nuevo WordPress.

Archivo: /tmp/felipe/research/01-filatelia-dominio.md

---

## 0. Resumen para quien tenga prisa

- **Qué es el museo hoy.** Por contenido publicado, museopostal.org tiene 2 entradas largas y buenas ("El Correo Submarino", "El wi-fi del Siglo XIX"), 5 fichas de pintura sobre el correo (Chardin, De la Tour, Van der Kooi, Pollard, Hardy), una página de emisión (eclipse solar 2026), una "sala" de Murcia hecha solo de imágenes de sellos, una tarjeta de campaña italiana de 1918 ("La tarjeta del soldado", Proyecto Aula), 6 vídeos de terceros, 8 imágenes de museos postales del mundo y 2 productos (sello Peral y libro de censura). El material está bien elegido y ya es de museo. Lo que falla es la estructura: no hay fichas de pieza, ni datos técnicos normalizados, ni recorridos.
- **Qué necesita un visitante de filatelia.** Una **ficha de pieza** con número de catálogo (Edifil en España), fecha, valor facial, técnica de impresión, dentado, papel, tirada, matasellos y marcas, estado y procedencia, con **anverso y reverso ampliables**. Sin eso, un coleccionista o un investigador no puede usar la web.
- **Cómo se ordena la materia.** Las clases de exposición de la FIP (Federación Internacional de Filatelia) dan un vocabulario reconocido: tradicional, historia postal, enteros postales, aerofilatelia, temática, maximofilia, fiscales, astrofilatelia, juvenil y literatura. Clase abierta y tarjeta postal ilustrada son clases nuevas. Sirven como taxonomía "clase filatélica".
- **Lo que hace única a esta web** es la Región de Murcia: Cartagena naval (Isaac Peral, los submarinos de la serie Correo Submarino construidos allí, el Cantón de 1873), la prefilatelia del Reino de Murcia, el cante de las Minas, Lorca y Águilas. Murcia no tiene federación filatélica propia (sus sociedades van dentro de la valenciana), así que un museo virtual murciano llena un hueco real.
- **Modelo recomendado:** 7 tipos de contenido (Pieza, Sala, Exposición/Recorrido, Artículo, Actividad educativa, Evento/Videoconferencia, Recurso) más el Producto de WooCommerce, y 6 taxonomías (época, clase filatélica, tema, lugar, técnica/tipo de objeto, fuente). El apartado 5.4 propone ocho salas, y todas se pueden abrir con contenido que ya existe.
- **Errores de datos encontrados** que conviene corregir en la migración (apartado 3.8):
  - El producto del sello Peral lleva SKU "Edifil 5317", pero el sello del 18-02-2014 es Edifil 4870.
  - El libro de censura guarda el ISBN en un atributo llamado "Cod EAN".
  - La tienda muestra "Tenemos grandes proyectos por anunciar" en las fichas de producto.
  - Solo 25 de las 143 imágenes tienen texto alternativo.

---

## 1. Qué son la filatelia y la historia postal

### 1.1 Definiciones de trabajo

- **Filatelia**: estudio y coleccionismo de los sellos de correos y de los objetos postales afines (enteros postales, matasellos, sobres, tarjetas). Estudia el sello como objeto producido: diseño, impresión, papel, dentado, filigrana, variedades y tiradas.
- **Historia postal**: estudio del funcionamiento del correo a través de las piezas que circularon. La guía de la FIP dice que una colección de historia postal "comprende cartas y sobres circulados, enteros postales usados, sellos usados y otros documentos postales ... con el fin de desarrollar cualquier aspecto de la historia postal". Pone el acento en "tarifas, rutas, reglamentos, marcas, usos y otros aspectos postales" ([FIP, Revised Postal History Guidelines, mayo 2022](https://www.f-i-p.ch/wp-content/uploads/Revised-Postal-History-Guidelines-Final-May2022.pdf), 1.1).
- **Prefilatelia**: el correo anterior al sello adhesivo.
  - En España termina con el primer sello: enero de 1850, Isabel II, 6 cuartos negro. Las fuentes discrepan entre el 1 y el 8 de enero.
  - El franqueo previo pasó a ser obligatorio para toda la correspondencia desde el 1-7-1856 (Real Decreto de 19-2-1856) ([Museo Postal y Telegráfico, "Enero de 1850, se emite el primer sello de España"](https://museopostalytelegrafico.es/enero-de-1850-se-emite-el-primer-sello-de-espana/)).
  - La entrada del sitio "El wi-fi del Siglo XIX" trata justo este periodo: el cursus publicus, el Itinerario de Antonino con Cartagena, Lorca y Águilas, los Tassis, Felipe V en 1706, la Superintendencia General de Correos en 1716 y el porte pagado por el destinatario.
- **Marcofilia**: estudio de las marcas postales y los matasellos. En la FIP es la subclase 2B de historia postal (ibíd., 1.8.2).

### 1.2 Grandes ramas del coleccionismo (vista del público)

| Rama | Qué colecciona la gente | Ejemplo con material del sitio |
|---|---|---|
| Por país y época ("tradicional") | Sellos de España por reinados o años, series completas, Edifil en mano | Serie Correo Submarino 1938 (Edifil 775-780 y hoja bloque) |
| Historia postal | Cartas circuladas, rutas, tarifas, marcas, censura, correo militar | Carta de Águilas a Murcia, 18-06-1866; tarjeta de franquicia militar italiana 1918; sobre de prisionero de guerra (`SOBRE_GUERRA.webp`) |
| Temática | Un tema (barcos, astronomía, música, pintura) con cualquier material | Eclipses en la filatelia (Islas Cook 1965 a Gambia 2024); "Barcos en la filatelia" (vídeo) |
| Enteros postales | Tarjetas, sobres y aerogramas con franqueo impreso | Tarjeta prefranqueada del eclipse (A Coruña, 12-08-2026) |
| Maximofilia | Tarjetas máximas: tarjeta ilustrada + sello del mismo motivo + matasellos relacionado | Archivo `1983_2690_TMAX` (TMAX = tarjeta máxima) |
| Primer día y conmemorativos | SPD (sobres de primer día) y matasellos especiales | SPD Peral 18-02-2014 Madrid; SPD Barcelona y Murcia; matasellos "Cante de las Minas" 08-05-2014 |
| Marcofilia local | Matasellos de un pueblo o comarca | La página "Comparte tu pieza" pide "un sobre con un matasellos local" |
| Literatura filatélica | Catálogos, monografías, revistas | Libro de Heller sobre censura 1936-1945 (producto 394) |

### 1.3 Clases de competición FIP y qué muestra cada una

La FIP organiza las exposiciones por clases.

- El Reglamento General de Exposiciones (GREX, versión en español publicada por FESOFI) enumera como clases de competición: Campeones FIP, Filatelia Tradicional, Historia Postal, Enteros Postales, Aerofilatelia, Filatelia Temática, Maximofilia, Literatura Filatélica, Filatelia Juvenil, Sellos Fiscales y Astrofilatelia ([GREX, FESOFI](https://fesofi.es/wp-content/uploads/2022/03/Reglamento-Gral-Expo-GREX.pdf), art. 5.7-5.8).
  - Las colecciones de "Un Cuadro" existen dentro de cada clase, salvo Literatura.
  - El art. 5.8 admite "cualquier otra clase que promocione la filatelia".
- La federación australiana, que sigue a la FIP, añade como experimentales **Clase Abierta**, **Tarjetas Postales Ilustradas** y **Filatelia Moderna** ([APF, Classes](https://apf.org.au/classes/)).
- Según FESOFI, la Clase Abierta y la de Tarjeta Postal Ilustrada ya aparecen en algunas competiciones europeas ([FESOFI, búsqueda sobre EXFILNA](https://fesofi.es/expo-exfilna-2/)).

| Clase (nombre en español) | Qué muestra | Material típico | Encaje en museopostal.org |
|---|---|---|---|
| Filatelia tradicional | El sello como objeto: emisiones, tipos, planchas, variedades, ensayos, pruebas, dentados, papeles | Sellos nuevos y usados, bloques, pliegos, ensayos | Serie Correo Submarino y su boceto rechazado de Rieusset con Peral y Monturiol; Isabel II (vídeo del 2 reales azul 1851) |
| Historia postal (2A servicios, 2B marcofilia, 2C historia social) | Desarrollo y funcionamiento del correo: tarifas, rutas, reglamentos, marcas, usos. La FIP lista como temas 2A: correo prefilatélico, tarifas, rutas, correo militar y de campaña, de prisioneros, marítimo, ferroviario, ambulantes, correo de catástrofe, desinfectado, **censura**, tasas y franquicias ([FIP 2022](https://www.f-i-p.ch/wp-content/uploads/Revised-Postal-History-Guidelines-Final-May2022.pdf), 1.8.1) | Cartas y sobres circulados, marcas, documentos | Casi todo lo que ya tiene el sitio: correo submarino, censura 1936-45, tarjeta del soldado 1918, carta Águilas-Murcia 1866, prefilatelia |
| Enteros postales | Piezas con el franqueo impreso: tarjetas postales oficiales, sobres, aerogramas, fajas | Tarjetas y sobres con sello impreso | Tarjeta prefranqueada del eclipse; tarjetas de campaña con franquicia |
| Aerofilatelia | Desarrollo del correo aéreo: primeros vuelos, zepelines, correo por cohete o globo | Sobres de vuelo con marcas, sellos de correo aéreo | Hoy nada; posible sala futura |
| Astrofilatelia | Exploración espacial en material postal | Sobres de lanzamientos, sellos espaciales | Eclipses (más bien temática astronómica) |
| Filatelia temática | Un argumento desarrollado con plan lógico usando cualquier material postal | Sellos, matasellos, enteros, tarjetas de cualquier país | Eclipses solares; "La historia postal en la pintura"; juegos y juguetes postales; "Barcos en la filatelia" |
| Maximofilia | Tarjetas máximas: el motivo coincide en sello, tarjeta y matasellos ([FIP, guías de maximofilia 2019](https://www.f-i-p.ch/wp-content/uploads/FIP-Guidelines-MA-Final-28.8.2019.pdf)) | Tarjetas máximas | `1983_2690_TMAX` |
| Sellos fiscales | Sellos de impuestos y timbres, no postales ([FIP, SREV fiscales](https://www.f-i-p.ch/wp-content/uploads/SREVS-and-Guidelines-Revenues-Final.pdf)) | Timbres móviles, papel sellado | Nada hoy |
| Clase abierta | Filatelia más material no filatélico (hasta un porcentaje limitado) para contar un tema | Sellos con fotos, documentos, objetos planos | Encaja con las fichas de pintura y con Cantón o Peral |
| Tarjeta postal ilustrada | La tarjeta postal como imagen: editores, vistas, temas | Postales ilustradas | "Comparte tu pieza" pide postales; el formulario de boletín ofrece "Tarjeta postal" como interés |
| Filatelia juvenil | Colecciones de expositores de 10 a 21 años en grupos de edad | Cualquiera | Proyecto Aula (la tarjeta del soldado) |
| Literatura filatélica | Libros, catálogos, revistas, webs sobre filatelia | Publicaciones | Libro de Heller; biblioteca y hemeroteca previstas en el borrador "Investigación - Copy" |
| Un Cuadro / Moderna | Colecciones de 16 hojas; material reciente | Cualquiera | Formato útil para "vitrinas" cortas en la web |

**Cómo juzga la FIP** (sirve para explicar al público qué hace valiosa una colección):

- **Criterios** ([FIP GREV](https://www.f-i-p.ch/wp-content/uploads/GREV-English.pdf), art. 4-5, versión descargada hoy):

  | Criterio | Puntos |
  |---|---|
  | Tratamiento e importancia filatélica | 30 |
  | Conocimiento, estudio personal e investigación | 35 |
  | Condición y rareza | 30 |
  | Presentación | 5 |

- **Medallas:**

  | Medalla | Puntos |
  |---|---|
  | Oro Grande | 95-100 |
  | Oro | 90-94 |
  | Vermeil Grande | 85-89 |
  | Vermeil | 80-84 |
  | Plata Grande | 75-79 |
  | Plata | 70-74 |
  | Plata-Bronce | 65-69 |
  | Bronce | 60-64 |

- Versiones anteriores del GREV repartían los puntos en 20/10/35/10/20/5 y ponían el Oro Grande en 90. Esa escala antigua sigue circulando en webs.
- La unidad física de exposición es el **cuadro o marco de 16 hojas** ([GREX](https://fesofi.es/wp-content/uploads/2022/03/Reglamento-Gral-Expo-GREX.pdf), art. 6.1).
- En EXFILNA, FESOFI exige 8 marcos a las colecciones con Vermeil Grande o más ([Reglamento EXFILNA 2019](https://fesofi.es/reglamento-exfilna-2019/)).

**Qué significa para el diseño:** una **exposición virtual** del museo puede presentarse de dos formas. Para el público filatélico, como una colección de competición (plan, hojas numeradas, de 1 a 8 cuadros), que es el formato que reconoce. Para el público general, como un relato ilustrado. EXPONET, la exposición virtual internacional, usa el primer formato ([exponet.info](https://www.exponet.info/en)).

---

## 2. Cómo se describe correctamente una pieza

### 2.1 Qué campos necesita una ficha de objeto

Hay tres tipos de pieza y cada uno lleva metadatos distintos. El museo tiene de los tres:

- **Sello o emisión**: el objeto producido.
- **Pieza circulada**: carta, sobre o tarjeta, es decir, el objeto ya usado.
- **Objeto no filatélico**: cuadro, buzón, uniforme, juguete.

**A. Emisión o sello** (datos que publica Correos y que recoge el catálogo).

Ejemplo real, la emisión "Efemérides. Revolución Cantonal de Cartagena" ([sellosfilatelicos.com](https://www.sellosfilatelicos.com/2025/07/sello-de-correo-postal-revolucion-cantonal-de-cartagena.html); ficha oficial en [Correos](https://www.correos.es/es/es/particulares/filatelia/productos-filatelicos/sellos/espana/2025/cartagena)):
- Edifil 5848, emitido el 12-07-2025.
- Offset sobre papel estucado, engomado y fosforescente.
- 40,9 x 28,8 mm, dentado 13¾ horizontal y 13¼ vertical, 25 sellos por pliego.
- 1,85 €, tirada 70.000.
- Diseño a partir de fondos del Archivo General de la Región de Murcia.

La página del eclipse del sitio ya usa ese formato ("Procedimiento de impresión: Offset; Papel: Estucado, engomado, fosforescente; ... Valor postal ... 4 euros; Tirada: 65.000").

| Campo | Descripción | Obligatorio | Ejemplo |
|---|---|---|---|
| Título de la emisión | Nombre oficial | Sí | Efemérides. Revolución Cantonal de Cartagena |
| País / administración postal | Quién emite | Sí | España, Correos |
| Serie | Serie de Correos o agrupación | No | Efemérides |
| Fecha de emisión | Día de puesta en circulación | Sí | 2025-07-12 |
| Números de catálogo | Edifil (España) y, si se conocen, Yvert et Tellier, Michel, Scott, Stanley Gibbons | Edifil sí | Edifil 5848 |
| Valor facial | Con la moneda de la época (cuartos, reales, céntimos de escudo, pesetas, euros, tarifa A) | Sí | 1,85 € |
| Color | Color principal según catálogo | Para clásicos | 4 cuartos azul |
| Formato | Sello, hoja bloque, minipliego, carné, rollo, entero | Sí | Sello |
| Dimensiones | mm del sello y de la hoja | No | 40,9 x 28,8 mm |
| Dentado | Medida del odontómetro, o "sin dentar", "troquelado" | Sí | 13¾ x 13¼ |
| Técnica de impresión | Calcografía, huecograbado, offset, litografía, tipografía, combinadas | Sí | Offset |
| Papel | Estucado, fosforescente, con o sin filigrana, autoadhesivo | No | Estucado, engomado, fosforescente |
| Filigrana | Descripción o "sin filigrana" | Para clásicos | Sin filigrana |
| Diseño / grabado | Diseñador, grabador, fuente de la imagen | No | Archivo General de la Región de Murcia |
| Imprenta | FNMT-RCM, Oliva de Vilanova, etc. | No | FNMT-RCM |
| Efectos en pliego | Número de sellos por pliego | No | 25 |
| Tirada | Ejemplares | No | 70.000 |
| Motivo e iconografía | Qué representa | Sí | Grabado de prensa del asedio de Cartagena |
| Variedades conocidas | Errores, dentados desplazados, colores | No | — |
| Relación con Murcia | Por qué está en la sala de la Región | Si procede | Cantón de Cartagena 1873-1874 |

**B. Pieza circulada (historia postal).**

Ejemplo real del sitio, el archivo `81y85-1866-18-jun-aguilas-a-murcia-4-cuartos-azul-y-20-centimos-de-escudo-lila-mat-fechador-aguilas-murcia...jpg` (lectura de la imagen en `/tmp/felipe/mirror/wp-content/uploads/2026/05/`):
- Carta de Águilas a Murcia del 18-06-1866.
- Franqueada con Edifil 81 y 85 (4 cuartos azul y 20 céntimos de escudo lila, según el nombre del archivo).
- Matasellos fechador de Águilas, repetido en el frente.
- Dirigida al presidente de la Sociedad Minera La Generala, en Murcia.

| Campo | Descripción | Ejemplo |
|---|---|---|
| Tipo de pieza | Carta, sobre, frontal, tarjeta postal, entero, tarjeta de campaña, envuelta, faja, telegrama, documento | Carta circulada |
| Fecha de circulación | Del fechador o del texto | 1866-06-18 |
| Origen | Oficina, localidad | Águilas (Murcia) |
| Destino | Localidad y, si interesa, destinatario institucional | Murcia, Sociedad Minera La Generala |
| Ruta y medios | Tránsitos, ambulante, barco, submarino, avión | — |
| Franqueo | Sellos con sus números Edifil, o franquicia, o porte debido | Edifil 81 + 85 |
| Tarifa aplicada | Tarifa vigente y si es correcta | Por completar |
| Matasellos y marcas | Cada marca con tipo, texto, color, posición | Fechador "ÁGUILAS 18 JUN 66" |
| Marcas de censura | Texto, color, forma, número de catálogo (Heller en España 1936-45) | "Verificato per censura" (tarjeta de 1918) |
| Otras marcas | Certificado, urgente, tasa, llegada, tránsito, manuscritas | Anotación manuscrita "Lª 18 Junio 66" |
| Remitente / destinatario | Solo si es histórico y público; nunca datos de particulares vivos | — |
| Contenido del texto | Transcripción o resumen si es relevante | "Un gentile pensiero dalla fronte" (1918) |
| Estado de conservación | Ver 2.3 | Bueno, sobre con doblez |
| Procedencia | Colección particular, donación, compra, préstamo; "Colección Felipe Martínez" si lo acepta | — |
| Imágenes | Anverso, reverso, detalles (matasellos, marcas), con escala | La tarjeta de 1918 ya está escaneada por las dos caras |

**C. Objeto no filatélico** (pinturas, juguetes, buzones, uniformes).

Las 5 fichas de pintura ya usan casi la ficha de un museo de arte: autor y fechas, título original y traducción, año, escuela o estilo, técnica y museo depositario. Faltan tres cosas:
- Enlace a la ficha del museo que custodia la obra.
- Licencia de la imagen.
- "Qué nos cuenta del correo" como campo propio.

**Referencia española de catalogación.**

- El Ministerio de Cultura mantiene la **Normalización Documental de Museos** (1996) y el sistema **DOMUS**, con estructuras de información para inventario y catalogación ([Ministerio de Cultura, Normalización Documental](https://www.cultura.gob.es/cultura/areas/museos/mc/ndm/presentacion.html); [DOMUS, revisión PDF](https://www.cultura.gob.es/dam/jcr:0d6d309f-6835-46bf-8ccd-cd18258c84a3/domusrev0.pdf)).
- Sus fichas públicas en **CER.es** muestran inventario, objeto, autor, título y lugar de procedencia, con "Ver ficha completa". Se navega por tipo de objeto, autor, iconografía, lugar y contexto cultural ([CER.es](https://ceres.mcu.es/)).
- **Recomendación:** nombrar los campos de la web con ese vocabulario ("Inventario", "Objeto", "Datación", "Lugar de producción", "Iconografía", "Inscripciones y marcas", "Procedencia"). Así suena a museo y facilita un intercambio futuro.

**Cómo lo muestra el National Postal Museum (Smithsonian).**

- Sus fichas incluyen: descripción, fecha, número de objeto, tipo (p. ej., "Postage Stamps", "Covers & Associated Letters"), material, dimensiones, lugar, título con número Scott, identificador persistente (ARK), tema, derechos de uso y si está expuesto.
- Fuentes: [NPM, Collections Search Center](https://postalmuseum.si.edu/collections-search-center); ejemplos [npm_2005.2001.281](https://postalmuseum.si.edu/object/npm_2005.2001.281) y [npm_2000.2011.2](https://postalmuseum.si.edu/object/npm_2000.2011.2).
- La página devolvió 403 a la descarga directa; los campos salen del resumen del buscador.

### 2.2 Catálogos y sus números

| Catálogo | País / editor | Uso | Nota |
|---|---|---|---|
| **Edifil** | España (Edifil S.A.) | Referencia estándar para sellos de España y dependencias. El unificado cubre desde 1850 e incluye enteros, aerogramas, pruebas, locales de guerra, telégrafos, hojas y SPD ([Edifil, catálogos](https://www.edifil.es/es/24-catalogos-de-sellos)) | En España se cita "Edifil 775/780"; en la web, usar siempre el prefijo |
| **Yvert et Tellier** | Francia, fundada en 1900 | Mundial, fuerte en Francia y excolonias | Numeración distinta ([Wikipedia](https://en.wikipedia.org/wiki/Yvert_et_Tellier)) |
| **Michel** | Alemania | Europa y mundial, ordenado por geografía | ([Stamp catalog](https://en.wikipedia.org/wiki/Stamp_catalog)) |
| **Scott** | EE. UU. | Mundial, referencia en América | El NPM usa Scott en sus fichas |
| **Stanley Gibbons** | Reino Unido | Commonwealth | — |
| **Catálogo FESOFI** | España, FESOFI | Catálogo en línea de sellos de España por reinados, con filtro por año ([catalogodesellos.fesofi.es](https://catalogodesellos.fesofi.es/product-category/isabel-ii/)) | Buen enlace externo gratuito |
| **Heller** | Ernst L. Heller | Marcas de censura: "Marcas utilizadas por la censura postal nacional de 1936 a 1945" (Lindner Filatélica Ibérica, 2000, ISBN 84-931717-0-0, 547 págs., trilingüe), y otro volumen para la censura republicana ([Dialnet](https://dialnet.unirioja.es/servlet/libro?codigo=71503); [Filatelia Hobby](https://filateliahobby.es/es/bibliografia/325-marcas-utilizadas-por-la-censura-postal-nacional-de-1936-a-1945.html)) | Las marcas se citan como "Heller RC8.1" |

Cada catálogo numera distinto y da distinto peso al papel, el dentado y la filigrana ([Stamp numbering system](https://en.wikipedia.org/wiki/Stamp_numbering_system)). Por eso la ficha debe admitir varios números, cada uno con su catálogo.

**Aviso de fuente:** el dominio `philatelicos.com`, que sale en los buscadores como librería filatélica, hoy redirige a un casino (`batman138.club`, comprobado el 28-09-2026). No hay que enlazarlo.

### 2.3 Estado de conservación

Categorías de uso común en el comercio español ([ejemplos de uso: sellosonline](https://www.sellosonline.com/EDIFIL-GENERAL-FRANCO-N-920-NUEVO-SIN-FIJASELLOS-LUJO); [guía de valoración](https://realesdea8.com/valor-de-sellos-antiguos/)):

| Término | Abreviatura habitual | Significado |
|---|---|---|
| Nuevo sin fijasellos | ** (MNH en inglés) | Sin usar, goma original intacta, sin huella de charnela |
| Nuevo con fijasellos | * (MH) | Sin usar, con charnela o su huella |
| Nuevo sin goma | (*) | Sin usar y sin goma (emitido así o perdida) |
| Usado | ⊙ o "us." | Con matasellos |
| Sobre / carta | — | Pieza completa circulada |
| Fragmento | — | Sello sobre un trozo del sobre |

- **Calificativos:** lujo, muy bonito, bonito; centrado; márgenes (en los sin dentar).
- **Defectos:** adelgazado, dientes cortos, manchas, doblez, óxido.
- **Piezas circuladas:** se describe el soporte (sobre completo, frontal, con o sin contenido).
- Los asteriscos cambian de un catálogo a otro, así que la web debe usar palabras y dejar el símbolo solo como ayuda.

**Nota ética:** el museo no debe dar valoraciones económicas.
- En España, la "filatelia de inversión" terminó con la intervención de Afinsa y Fórum Filatélico el 9-5-2006. Afectó a más de 400.000 personas, y el Supremo confirmó las condenas en 2020 ([CMM](https://www.cmmedia.es/noticias/castilla-la-mancha/caso-forum-filatelico-afinsa-17-anos-mayor-estafa-piramidal-espana.html); [Wikipedia, Fórum Filatélico](https://es.wikipedia.org/wiki/F%C3%B3rum_Filat%C3%A9lico)).
- El borrador "Investigación - Copy" (id 748) incluye los bloques "Informe AFINSA" y "COTIZACION ACTUAL". Si se publican, que sean historia del caso, no cotizaciones.

### 2.4 Glosario (castellano de España)

1. **Aerograma**: hoja de papel ligero con franqueo impreso que se pliega y se cierra como un sobre; entero postal de correo aéreo.
2. **Ambulante**: oficina de correos que viajaba en el tren y clasificaba en marcha; sus matasellos llevan el nombre de la línea. El último de España, Madrid-Málaga, circuló hasta el 30-06-1993 ([Los trenes postales, PDF](https://sanfilatelio.afinet.org/biblioteca/trenpostal/bibliografia/TRENES%20POSTALES%20HISTORIA.pdf)).
3. **Bloque**: cuatro o más sellos sin separar, normalmente 2 x 2.
4. **Boceto**: dibujo previo del diseño; el sitio muestra los bocetos rechazados de Rieusset para el correo submarino.
5. **Calcografía**: impresión en hueco con plancha grabada a buril; el relieve de la tinta se nota al tacto.
6. **Carta prefilatélica**: carta anterior al sello adhesivo, con marcas de origen y porte manuscrito.
7. **Cartero honorario**: distinción que da Correos a personas ajenas a la empresa y que permite franquear con una marca especial. El primero fue Doctor Thebussem (1880); lo recibieron también Cela (1982), Mingote (1998), la Reina Sofía (2013) y Cruz Novillo (2019) ([Wikipedia](https://es.wikipedia.org/wiki/Cartero_honorario); [Gràffica](https://graffica.info/cruz-novillo-cartero-honorario-de-correos/)). El sitio tiene un bloque "Carteros Honorarios" en Investigación.
8. **Censura postal**: control de la correspondencia por una autoridad; deja marcas, cierres y fajas. En España empieza en julio de 1936 y dura hasta finales de 1945 ([Wikipedia, Censura postal](https://es.wikipedia.org/wiki/Censura_postal)).
9. **Certificado**: envío con registro y justificante; lleva la marca "Certificado" o una etiqueta con número.
10. **Charnela o fijasellos**: papelito engomado para montar los sellos en el álbum.
11. **Correo de campaña**: servicio postal militar en guerra; tarjetas y marcas de unidad.
12. **Correo submarino**: servicio republicano Barcelona-Mahón de 1938 y su serie (Edifil 775-780, hoja bloque 781).
13. **Dentado**: perforaciones que separan los sellos; se mide con el odontómetro por el número de agujeros en 2 cm.
14. **Efemérides**: serie de Correos que conmemora aniversarios (Peral 2014, Cantón 2025).
15. **Emisión**: conjunto de sellos puestos en circulación a la vez por una misma disposición.
16. **Ensayo**: diseño no aprobado, o prueba de diseño previa a la emisión.
17. **Entero postal**: pieza con el franqueo impreso (tarjeta, sobre, aerograma, faja).
18. **Error**: fallo de producción (color cambiado, dentado omitido, impresión invertida).
19. **Estafeta**: oficina de correos menor; también la valija o el correo que se despacha.
20. **Expertización**: examen de autenticidad por un experto, con certificado.
21. **Falso postal / falso filatélico**: falsificación hecha para defraudar al correo (postal) o para engañar al coleccionista (filatélico). El vídeo "Sellos de Isabel II: sus marcas y sus falsos" trata el tema.
22. **Faja**: tira de papel para envolver impresos; en censura, tira que cierra la carta después de abrirla.
23. **Fechador**: matasellos con localidad y fecha.
24. **Filigrana**: marca de agua del papel, visible a trasluz o con filigranoscopio.
25. **Franqueo**: pago del envío; es **franqueo previo** si lo paga el remitente.
26. **Franquicia**: exención de pago (correo oficial, militar); por ejemplo, las tarjetas "in franchigia" como la de 1918 del sitio.
27. **Frontal**: parte delantera de un sobre o carta que se conserva sin el resto.
28. **Goma**: adhesivo del reverso; "goma original".
29. **Grabador**: autor de la plancha en calcografía; firma en el margen inferior del sello.
30. **Habilitación o sobrecarga**: impresión añadida a un sello ya emitido para cambiarle el valor o el uso.
31. **Hoja bloque (HB)**: hoja pequeña con uno o varios sellos y márgenes decorados (la HB del correo submarino tuvo 12.500 ejemplares, según el sitio).
32. **Huecograbado**: impresión en hueco con trama fotográfica; a la lupa se ven puntos.
33. **Litografía**: impresión plana con piedra o plancha; se usó en los primeros sellos de España.
34. **Lacre**: pasta para cerrar cartas antes de que existiera el sobre; aparece en el cuadro de Chardin.
35. **Marca postal**: cualquier señal que aplica el correo (origen, porte, certificado, tasa, llegada).
36. **Marcofilia**: estudio de las marcas postales.
37. **Matasellos**: marca que anula el sello para que no se pueda reutilizar.
38. **Matasellos conmemorativo**: matasellos especial de un acontecimiento (eclipse de A Coruña 2026).
39. **Maximofilia / tarjeta máxima**: tarjeta ilustrada con un sello del mismo motivo y un matasellos coherente.
40. **Minipliego**: pliego reducido con pocos sellos y márgenes ilustrados.
41. **Nuevo**: sello sin usar (ver 2.3).
42. **Odontómetro**: regla para medir el dentado.
43. **Offset**: impresión plana indirecta; es la de la mayoría de los sellos actuales.
44. **Paquebote**: marca de la correspondencia depositada a bordo de un barco.
45. **Pareja, tira**: una pareja son dos sellos unidos; una tira, tres o más en línea.
46. **Pliego**: hoja completa de impresión.
47. **Porte**: precio del transporte de la carta; es **porte debido** si paga el destinatario, lo normal antes de 1850.
48. **Prefilatelia**: periodo y piezas anteriores al sello.
49. **Prueba**: impresión de control antes de la tirada.
50. **Sello (adhesivo)**: justificante de pago del franqueo. En la Edad Media era una marca de autenticidad en metal o piedra (Partidas de Alfonso X, citado en "El wi-fi del Siglo XIX").
51. **Sello fiscal**: timbre de impuestos, no postal.
52. **Serie**: conjunto de valores de una emisión (los 6 del correo submarino).
53. **Sin dentar**: sello sin perforaciones, que se separa a tijera.
54. **SPD (sobre de primer día)**: sobre con el sello matasellado el día de la emisión (SPD Peral, Madrid, 18-02-2014).
55. **Tarifa**: precio vigente según peso, destino y servicio.
56. **Tarjeta postal**: pieza sin sobre. Si lleva el franqueo impreso es un entero postal; si tiene imagen es una **tarjeta postal ilustrada**.
57. **Tasa**: marca con la cantidad que debe pagar el destinatario por franqueo insuficiente.
58. **Tête-bêche**: pareja en la que un sello está invertido respecto al otro.
59. **Tipografía**: impresión en relieve.
60. **Tirada**: número de ejemplares impresos.
61. **Tránsito / llegada**: marcas de las oficinas intermedias o de destino, normalmente en el reverso.
62. **Tu Sello**: sello personalizado de Correos (tarifa A en A Coruña 2026, página del eclipse).
63. **Valor facial**: valor nominal impreso; distinto del valor de mercado.
64. **Variedad**: diferencia respecto al tipo normal (color, papel, dentado, plancha).

---

## 3. Contexto español y murciano

### 3.1 Correos

- Correos emite los sellos de España y los imprime con la FNMT-RCM.
- Publica la ficha técnica de cada emisión en su web de filatelia (ejemplo: [Revolución Cantonal de Cartagena, 2025](https://www.correos.es/es/es/particulares/filatelia/productos-filatelicos/sellos/espana/2025/cartagena)) y vende en [Correos Market](https://www.market.correos.es/product/sello-revolucion-cantonal-de-cartagena-serie-efemerides-pack-2).
- En 2026 presentó un sello por el centenario del Real Murcia C.F. ([Murcia Confidencial, mayo de 2026](https://www.murciaconfidencial.es/2026/05/correos-presenta-el-sello-dedicado-al.html); [Real Murcia](https://www.realmurcia.es/el-real-murcia-y-correos-presentan-la-nueva-emision-filatelica-dedicada-a-los-clubes-centenarios-del-futbol-espanol/)).
- **Oportunidad:** una sección fija "Últimas emisiones con relación con la Región". La portada ya tiene el botón `8_ultimasemisiones.png`.

### 3.2 Museo Postal y Telegráfico

- **Historia** ([Wikipedia](https://es.wikipedia.org/wiki/Museo_Postal_y_Telegr%C3%A1fico_(Espa%C3%B1a))):
  - Nace del Museo de Telégrafos (1865) y del Museo Postal (principios del siglo XX).
  - Está en el Palacio de Comunicaciones desde 1919 y abre al público allí el 9-10-1980.
  - Pasa a Aravaca en 2006.
  - Cierra Aravaca para trasladarse a Toledo: en diciembre de 2023 según Wikipedia, el 1 de febrero según la prensa local.
- **Toledo** ([Correos](https://www.correos.com/en/sala-prensa/toledo-sera-la-sede-del-nuevo-museo-postal-y-telegrafico-de-correos/)):
  - Anunciado el 25-03-2021, en el edificio de Correos de la calle de la Plata.
  - Más de 2.300 m² y más de 8.000 piezas; apertura prevista "a finales de 2022".
  - En mayo de 2026 seguía sin fecha de apertura, y el grupo municipal popular de Toledo pidió que se abriera de inmediato ([La Cerca, 27-05-2026](https://www.lacerca.com/noticias/toledo/grupo-municipal-popular-apertura-museo-postal-telegrafico-toledo-815950-1.html)).
  - No he encontrado ninguna noticia de apertura hasta hoy.
- **Colecciones:** primeras emisiones de 1850, Penny Black, uniformes, telegrafía y telefonía, y pintura (retrato de María Cristina por Sorolla). Web: [museopostalytelegrafico.es](https://museopostalytelegrafico.es/) (devolvió 403 a la descarga automática).
- **Implicación:** con el museo nacional cerrado desde finales de 2023, un museo virtual bien hecho tiene ahora mismo un hueco real. La página "Museos en el Mundo" del sitio debe enlazarlo e indicar su estado real.

### 3.3 FESOFI

- **Qué es:** la Federación Española de Sociedades Filatélicas ([fesofi.es](https://fesofi.es/)). Publica reglamentos, palmarés y publicaciones (Cuadernos de Filatelia), organiza formación y conferencias, y mantiene un catálogo de sellos en línea y un catálogo de matasellos. La URL `catalogodematasellos.fesofi.es/matasellos/murcia/` devolvió 404 hoy.
- **EXFILNA 2026** (exposición filatélica nacional anual): Mérida, del 24 al 27 de septiembre de 2026; terminó ayer ([fesofi.es](https://fesofi.es/)). EXFILNA reúne todas las clases salvo la juvenil ([Expo. EXFILNA](https://fesofi.es/expo-exfilna-2/)).
- **Campeonato Europeo de Filatelia Temática 2027**, anunciado por FESOFI ([noticia](https://fesofi.es/noticias/campeonato-europeo-de-filatelia-tematica-2027/)).
- **Murcia no tiene federación territorial propia.** FESOFI indica "Murcia, integrada en la Federación Valenciana" ([Federaciones y Sociedades](https://fesofi.es/federaciones-y-sociedades-general/)). Esa federación es FASFILCOVA, la Federación de Asociaciones Filatélicas de la Comunidad Valenciana ([Benissa Digital](https://benissadigital.es/art/11411/la-federacion-de-asociaciones-filatelicas-de-la-c-valenciana-presenta-nueva-junta-directiva-en-benissa); [El Periòdic, Calp](https://www.elperiodic.com/calpe/filatelia-valenciana-reune-calp_1068558)).
- **Precedente educativo: el Programa de Correspondencia Epistolar Escolar** ([FESOFI, PDF](https://fesofi.es/wp-content/uploads/2024/07/PROGRAMA-DE-CORRESPONDENCIA-EPISTOLAR-ESCOLAR.pdf)).
  - Lo impulsaron la Comisión de Juventud de FESOFI, Correos y el Ministerio de Educación en el curso 1998/1999.
  - Tenía una tarifa reducida de 20 pesetas para las cartas entre colegios.
  - Se acompañó de una serie de 24 sellos de Mingote sobre el Quijote, emitida el 25-09-1998.
  - Es el antecedente directo del Proyecto Aula.

### 3.4 Real Academia Hispánica de Filatelia e Historia Postal (RAHF)

Datos de [RAHF, Historia](https://www.rahf.es/historia/):
- Idea de Pedro Monge Pineda en 1930.
- Estatutos aprobados en una **asamblea nacional celebrada en Murcia en 1954**.
- Inscrita como Academia Hispánica de Filatelia el 27-5-1977; sesión inaugural el 13-5-1978.
- En Madrid desde 1992; título de "Real" en septiembre de 2006.
- Revista *Academvs* desde 2001 y biblioteca "Juan de Linares"; sede en C/ Esparteros 11, Madrid.

La conexión de 1954 con Murcia es un buen dato para la sala regional.

### 3.5 Sociedades en la Región de Murcia

- **Hogar Filatélico de Cartagena**, C/ Uruguay 30, Cartagena, con el lema "Cultura y divulgación de los sellos a través de la filatelia" ([Sociedad Filatélica y Numismática Alicantina](https://filalacant.org/cartagena/)). La prensa de la federación valenciana la describe como la única sociedad inscrita de la provincia, porque no hay federación murciana ([El Periòdic](https://www.elperiodic.com/calpe/filatelia-valenciana-reune-calp_1068558)).
- **Asociación Filatélica y Numismática Jumillana** (Jumilla): aparece entre las sociedades de FASFILCOVA en los resultados de búsqueda, pero no he podido confirmarlo en una página propia.
- No he encontrado sociedades activas con web en Murcia capital ni en Lorca. Conviene preguntar a Felipe antes de publicar un directorio.
- **Marcofilia murciana reciente** recogida por la Sociedad Valenciana de Filatelistas ([SOVAFIL, Marcofilia Valenciano-Murciana](https://www.sovafil.es/Marcofilia.htm)):
  - Águilas 2012 (Paco Rabal, cine).
  - Lorca 2012 ("Todos con Lorca", terremoto).
  - Torre Pacheco 2007 (Fiestas Trinitarias-Berberiscas).
  - Cabo de Palos 2007 (Faros).
  - Molina de Segura 2005.

### 3.6 Edifil

- Editorial y catálogo de referencia para los sellos de España ([edifil.es](https://www.edifil.es/es/24-catalogos-de-sellos)).
- Tiene catálogos especializados de la guerra civil, por ejemplo el de sellos políticos de la zona republicana de Julio Allepuz ([Edifil](https://www.edifil.es/es/catalogos/1727-catalogo-de-los-sellos-politicos-de-la-zona-republicana-de-la-guerra-civil-espanola-1936-1939-tomo-ii-julio-allepuz.html)).
- Felipe ya nombra muchos archivos por su número Edifil (`775_sellos`, `3129_sello`, `3460_HB`, `SPD_5040_BIS`, `1983_2690_SPDMurcia`). Esa costumbre es la base natural del campo "Edifil" del nuevo modelo.

### 3.7 Historia postal de la Región de Murcia: temas y fuentes

| Tema | Datos | Fuente | Material del sitio |
|---|---|---|---|
| Prefilatelia del Reino de Murcia | Luis Felipe López Jurado, *Prefilatelia de Murcia: historia postal del Reino de Murcia desde 1569 hasta 1861*, Editora Regional de Murcia, 2006; Vermeil Grande en la Mundial España 2006 (Málaga) | [Amazon](https://www.amazon.es/Prefilatelia-Murcia-historia-postal-Reino/dp/8475643477); [CCBAE](http://www.mcu.es/ccbae/es/consulta/registro.cmd?id=197937) | "El wi-fi del Siglo XIX" |
| Rutas antiguas | Itinerario de Antonino: ruta costera Alicante, Cartagena, Lorca, Águilas; en época andalusí, Lorca como nudo con ramales a Granada y Almería | Texto del sitio (post 472) | `cursuspublicus.jpg`, `tassis.jpg` |
| Ferrocarril y ambulantes | Murcia-Cartagena en 1863; Chinchilla-Cartagena completa el 27-04-1865; Alcantarilla-Lorca en 1885; Lorca y Águilas-Almendricos en 1890 | [Wikipedia, Línea Chinchilla-Cartagena](https://es.wikipedia.org/wiki/L%C3%ADnea_Chinchilla-Cartagena); [Línea Murcia-Águilas](https://es.wikipedia.org/wiki/L%C3%ADnea_Murcia-%C3%81guilas) | Ninguno aún: sala futura de ambulantes |
| Minería y correo | Carta de Águilas a la Sociedad Minera La Generala (Murcia), 1866 | Imagen local | `81y85-1866-...jpg` |
| Cantón de Cartagena | Del 12-07-1873 al 12-01-1874; moneda propia y periódico "El Cantón Murciano"; sello Edifil 5848 (2025, 1,85 €, 70.000) | [Wikipedia](https://en.wikipedia.org/wiki/Canton_of_Cartagena); [sellosfilatelicos](https://www.sellosfilatelicos.com/2025/07/sello-de-correo-postal-revolucion-cantonal-de-cartagena.html); [FESOFI](https://fesofi.es/noticias/efemerides-revolucion-cantonal-de-cartagena/) | `CANTONAL.jpg/.webp` en Museo_murcia |
| Isaac Peral | Nacido en Cartagena en 1851; submarino botado en La Carraca (Cádiz) el 8-9-1888; sello Efemérides Edifil 4870, emitido el 18-02-2014, 0,54 €, tirada 220.000, presentado en el Museo Naval de Cartagena | [Armada](https://armada.defensa.gob.es/ArmadaPortal/page/Portal/ArmadaEspannola/conocenosnoticias/prefLang-es/00noticias--2014--03--NT-045-SELLO-ISAAC-PERAL-es?_selectedNodeID=1598040&_pageAction=selectItem); [FNMT](https://www.fnmt.es/coleccionista/emisiones-2013/125-aniversario-del-submarino-isaac-peral/-/asset_publisher/Nu3RzZHRksrh/content/125-aniversario-del-submarino-isaac-peral/pop_up); [infimar, 4870](https://infimar.com/es/sellos-de-espana-de-2014/5323-4870-aniversario-botadura-del-submarino-peral.html) | Producto 382 y sus 6 variantes; SPD en `Image_20251108_0001.jpg` (Madrid, 18 febrero 2014, 0,54 €) |
| Correo submarino 1938 | Orden de 11-05-1938 (Gaceta del 14-05); serie Edifil 775-780 (1, 2, 4, 6, 10 y 15 pesetas; submarinos D-1, A-1 y B-2) y hoja bloque de 3 valores (12.500); el único viaje, del C-4, salió de Barcelona el 12-08-1938; D-1 y B-2 se construyeron en Cartagena; el A-1 se dio de baja en Cartagena en 1934 | Post 717 del sitio; [luistarre, 781HB](https://luistarre.com/EC10781a781); [Catawiki 775/780](https://www.catawiki.com/es/l/17923157-espana-1938-correo-submarino-edifil-775-780) | Post 717, 6 sellos, HB, bocetos, SPD 1975 y 1988, dos PDF (`correo-submarino.pdf`, `CorreoSubmarinoBofarull-1.pdf`) |
| Censura postal 1936-1945 | Censura desde los primeros días de la guerra hasta finales de 1945; en la zona nacional, al principio sin norma que la regulara; catálogos de Heller para las dos zonas; ejemplo de carta de Camuñas (Toledo) a Cartagena con marcas Heller RC8.1 y RC8.2 | [Wikipedia](https://es.wikipedia.org/wiki/Censura_postal); [Filatelia Hobby](https://filateliahobby.es/es/hp-zona-republicana/12987-guerra-civil-marca-de-censura-de-camunas-toledo.html) | Producto 394 (libro); vídeo "La Guerra Civil Española en la Filatelia" |
| Cartagena en la guerra | Base de la flota republicana; sublevación de Cartagena del 4-3-1939; el C-4 se refugió en Bizerta | Post 717 | — |
| Música y cultura | Narciso Yepes (Lorca 1927-Murcia 1997), sello "Personajes" del 01-07-2015; Festival del Cante de las Minas de La Unión (matasellos del 08-05-2014, junto a Patios de Córdoba) | [Correos, Narciso Yepes](https://filatelia.correos.es/es/es/rincon-correos/filatelia/productos/sellos/espana/2015/personajes-narciso-yepes) | Página 598 "Narciso García Yepes"; `488_matasellospd.jpg` |
| Artesanía y tradición | Sello de 1991 "Silla, circa s. XIX, Murcia" (archivo `3129_sello`); "La Parranda" 1983, zarzuela de ambiente murciano (archivo `1983_2697`) | Imágenes locales | Museo_murcia |
| Mar | Sello de 1991 "Tratado Antártico" con el buque A-52 (archivo `3151_SELLO`) | Imagen local | Museo_murcia; conviene documentar la relación con Cartagena antes de publicarla |
| Estado autonómico | HB "Mapa Oficial del Estado Autonómico" (archivo `3460_HB`) | Imagen local | Museo_murcia |

**La tarjeta del soldado (Proyecto Aula).**

Las dos imágenes de la página 118 (`tarjeta1gm1.jpg`, `tarjeta1gm2.jpg`) son una **tarjeta postal en franquicia del Regio Esercito Italiano**:
- Rótulo "Corrispondenza in franchigia" y lema "Cittadini e soldati siate un esercito solo – V. Emanuele III".
- Fechador de "Posta Militare" del 29-5-1918 y marca azul "Verificato per censura".
- Texto: "Zona di guerra 28 maggio 1918 – Un gentile pensiero dalla fronte".

Es una pieza excelente para enseñar a leer una pieza. Reúne franquicia militar, oficina de campaña, censura, remitente con su unidad y destino civil, todo con anverso y reverso. Encaja en historia postal 2A (correo militar y censura).

**Recomendación:** hacer de ella la primera "ficha guiada" del Aula, con puntos numerados sobre la imagen.

**Otras piezas de guerra en la biblioteca de medios:** `SOBRE_GUERRA.webp` y `SOBRE_GUERRA2.webp`, un sobre "Prisoner of War". Solo existe como miniatura de 140 px; conviene recuperar el original.

### 3.8 Errores y huecos detectados en el contenido actual

1. **Producto 382 "125 Aniversario Submarino Peral"**: lleva el SKU "Edifil 5317". El SPD del propio sitio (`Image_20251108_0001.jpg`) muestra el sello de 0,54 € emitido el 18-02-2014, que es **Edifil 4870** ([infimar](https://infimar.com/es/sellos-de-espana-de-2014/5323-4870-aniversario-botadura-del-submarino-peral.html)). Hay que comprobarlo con Felipe antes de cambiarlo.
2. **Producto 394 (libro de censura)**:
   - El atributo "Cod EAN" vale `8493171700`, que es el ISBN-10 84-931717-0-0 del libro de Heller, no un EAN.
   - El precio en meta es 60 €, que con IVA al 21 % da los 72,60 € que muestra la tienda, así que cuadra.
   - Stock 2, peso 1,1 kg.
3. **La tienda está en modo "próximamente"**: las fichas de producto del espejo muestran "Tenemos grandes proyectos por anunciar ... Nuestra tienda está en obras" (`/tmp/felipe/mirror/producto/*/index.html`). La captura `shots/aula-desktop.png` muestra el mismo texto en la URL de Aula.
4. **Página de Videoconferencias**: son 6 vídeos de YouTube de terceros, pegados como URLs sin título. Los títulos se obtuvieron por oEmbed de YouTube. Deben presentarse con título, autor, duración y tema.
   - SOFIMA Sociedad Filatélica de Madrid: "La Guerra Civil Española en la Filatelia", "El Correo en la Administración Central de Madrid hasta 1800", "Barcos en la Filatelia" y "El asedio de París durante la Guerra Franco Prusiana".
   - Afinet/Ágora de Filatelia: "Sellos de Isabel II, sus marcas y sus falsos (parte 1)", por Manuel Gago, y "El secreto del mítico 2 reales azul de 1851".
5. **Texto alternativo**: solo 25 de las 143 imágenes tienen `alt_text` (`/tmp/felipe/media/media-index.json`).
6. **Erratas y datos dudosos**:
   - En el post 717: "de diferente colo y v valor".
   - En la ficha técnica del eclipse, los tamaños parecen cruzados: dice sello de 79,2 x 105,6 mm y hoja bloque de 33 x 53 mm. Comprobarlo con la ficha de Correos.
7. **Páginas vacías o de relleno**:
   - "Padre_museo" ("Please select a Menu From Setting!").
   - "Investigación - Copy" (borrador con Lorem ipsum).
   - "Museos en el Mundo" (solo 8 imágenes sin texto).
8. **Datos personales en páginas legales**: las condiciones de uso publican datos identificativos del titular. Es una obligación legal (LSSI art. 10), pero conviene revisar qué es imprescindible. No se reproducen aquí.

---

## 4. Cómo presentan bien los objetos los museos postales en línea

### 4.1 Referencias

| Institución | Qué hace bien | Fuente |
|---|---|---|
| Smithsonian National Postal Museum: **Arago** | Imágenes de alta resolución ampliables, descripciones detalladas, exposiciones en línea, modos "navegar" y "relato", buscador; colecciones destacadas temáticas ("The Art of Christmas Stamps", "The Free Franks") | [Nota de lanzamiento](https://postalmuseum.si.edu/about/press/national-postal-museum-to-launch-research-web-site); [Free Franks](https://www.si.edu/newsdesk/releases/national-postal-museum-launches-arago-featured-collection-free-franks) |
| NPM: fichas de colección | Campos normalizados, Scott en el título, identificador persistente, derechos de uso | [Collections Search Center](https://postalmuseum.si.edu/collections-search-center) |
| NPM: exposiciones virtuales por partes | Series como "Women on Stamps" publicadas en varias entregas | [Women on Stamps, parte 3](https://postalmuseum.si.edu/exhibits/virtual/women-on-stamps-part-3.html) |
| NPM: educación | Guías curriculares con lecciones, actividades sueltas y formación de profesorado. En "Design It!" el alumnado diseña su sello; en otras lecciones analiza cartas para deducir quién las escribió y monta un correo en clase | [Classroom Resources](https://postalmuseum.si.edu/classroom-resources); [Design It!](https://postalmuseum.si.edu/design-it); [Curriculum Guides](https://postalmuseum.si.edu/curriculum-guides) |
| The Postal Museum (Londres) | Catálogo en línea con más de 120.000 registros (expedientes, objetos, sellos, carteles, fotos); todos los sellos británicos desde 1840, con ensayos y pruebas; recursos de aprendizaje; investigación desde casa | [Online catalogue](https://www.postalmuseum.org/collections/catalogue/); [Philatelic collection](https://www.postalmuseum.org/collections/highlights/philatelic-collection/); [Learning resources](https://www.postalmuseum.org/visit-us/schools/learning-resources/) |
| Museumsstiftung Post und Telekommunikation (Alemania) | Base de objetos en línea; colección filatélica de millones de piezas con originales de diseño, pruebas, enteros y cartas usadas; colección de cartas privadas | [Onlinesammlung](https://onlinesammlung.museumsstiftung.de/); [Philatelie](https://www.museumsstiftung.de/sammlung_philatelie/); [Briefsammlung](https://www.briefsammlung.de/) |
| CER.es (España) | Fichas normalizadas, navegación por tipo de objeto, autor, iconografía, lugar y contexto; descarga de fichas | [ceres.mcu.es](https://ceres.mcu.es/) |
| EXPONET | Exposición virtual permanente de colecciones completas, hoja a hoja; búsqueda que combina territorio, tema, periodo y clase | [exponet.info](https://www.exponet.info/en) |
| Catálogo FESOFI | Catálogo de sellos de España en línea por reinados, con filtro por año | [catalogodesellos.fesofi.es](https://catalogodesellos.fesofi.es/product-category/isabel-ii/) |
| IIIF + OpenSeadragon / Mirador | Estándar abierto de imágenes con zoom profundo; el Nationalmuseum sueco usa IIIF con OpenSeadragon; Mirador permite comparar imágenes lado a lado | [IIIF viewers](https://iiif.io/get-started/iiif-viewers/); [Cuberis, caso OpenSeadragon](https://cuberis.com/a-case-study-of-deep-zoom-with-openseadragon/) |

### 4.2 Patrones de presentación que conviene adoptar

1. **Zoom profundo y anverso/reverso.**
   - En historia postal, el reverso lleva las marcas de tránsito y de llegada, y el texto. La tarjeta de 1918 ya está escaneada por las dos caras.
   - Mínimo: una galería con "Anverso / Reverso / Detalle" y zoom (OpenSeadragon sobre imágenes grandes, o un visor IIIF si se quiere un estándar).
   - Los escaneos del sitio tienen buena resolución (archivos `img2025...-scaled.jpg` de 0,7 a 1,7 MB).
2. **Detalle anotado.** Puntos numerados sobre la imagen que explican cada marca ("1. Fechador de Posta Militare", "2. Marca de censura", "3. Franquicia impresa"). Es la herramienta más útil para el Aula.
3. **Comparaciones.**
   - Boceto frente a sello emitido (correo submarino, bocetos de Rieusset).
   - Sello nuevo frente a usado.
   - Sello frente a SPD frente a tarjeta máxima (serie `1983_2690`: SPD Murcia, SPD Barcelona, TMAX).
   - Original frente a falso (vídeo de Isabel II).
4. **Itinerarios temáticos.** Recorridos de 6 a 12 piezas con un hilo: "Cartagena y el mar", "Correo en guerra 1918-1945", "Antes del sello", "El correo en la pintura", "Eclipses".
5. **Líneas de tiempo.** La historia postal es cronológica por naturaleza. Hitos disponibles:
   - Cursus publicus (27 a. C.) y Partidas de Alfonso X.
   - Tassis (1505), Felipe V (1706) y Superintendencia (1716).
   - Primer sello (1850) y franqueo obligatorio (1856).
   - Cantón (1873), Peral (1888), censura (1936-1945) y correo submarino (1938).

   El sitio ya tiene un botón `6_lineatiempo.png` sin destino.
6. **Mapas.**
   - Rutas: Barcelona-Mahón del C-4, Itinerario de Antonino, Chinchilla-Cartagena.
   - Origen y destino de cada pieza circulada.
   - Un mapa de "matasellos de la Región" alimentado por "Comparte tu pieza".
7. **Rutas educativas.** Por edad y materia, con ficha para el profesorado, actividad y descargable. El antecedente español es el programa de correspondencia escolar de 1998.
8. **Formato de colección de exposición.** Para el público filatélico, una exposición en hojas numeradas con un plan inicial, igual que en EXPONET y en las colecciones FIP.
9. **Relación entre piezas.** Cada ficha enlaza su emisión, su sala, su recorrido, su artículo y, si existe, su producto en la tienda.

### 4.3 Qué buscan los visitantes

- **Motivaciones medidas** en el Indianapolis Museum of Art ([Fantoni, Stein y Bowman, MW2012](https://museumsandtheweb.com/mw2012/papers/exploring_the_relationship_between_visitor_mot)):

  | Motivación | Porcentaje |
  |---|---|
  | Planificar la visita | 50 % |
  | Información específica por interés personal | 21 % |
  | Información para investigación o trabajo | 16 % |
  | Navegación casual | 10 % |
  | Transacción | 2,6 % |

  - Los investigadores son los más implicados y los que más vuelven (33 %).
  - Las cinco identidades de Falk (explorador, facilitador, buscador de experiencias, profesional o aficionado, recargador) se han aplicado a webs de museos ([MW2016](https://mw2016.museumsandtheweb.com/proposal/falk-meets-online-motivation-results-from-a-nationwide-survey-project/index.html)).
  - Un museo sin sede física no tiene ese 50 % de "planificar la visita": su público es sobre todo interés personal, investigación y navegación.
- **Aficionados muy dedicados:** buscan información ligada a su afición de forma continuada ([Information Research 18(4), paper 597](https://informationr.net/ir/18-4/paper597.html)).
- **Búsquedas típicas del público filatélico.** Es una inferencia a partir de las guías comerciales que dominan los buscadores y del formulario actual del sitio, no de datos de tráfico:
  - "Cuánto vale mi sello" y "valor de sellos antiguos" ([ejemplo](https://realesdea8.com/valor-de-sellos-antiguos/)).
  - Identificar un sello por imagen, país o número Edifil.
  - Un matasellos de su pueblo.
  - Emisiones nuevas.
  - Temas (barcos, astronomía, fútbol).
  - La historia de un episodio (correo submarino, censura).

  Los intereses que ofrece el formulario de boletín del sitio son "Sellos España", "Historia Postal y Prefilatelia", "Tarjeta postal" y "Filatelia temática".
- **Respuesta recomendada:**
  - Buscador y filtros por Edifil, año, lugar, tema y tipo de pieza.
  - Página "Identifica tu pieza": cómo leer una pieza, catálogos gratuitos y por qué el museo no tasa.
  - "Comparte tu pieza" convertido en formulario de aportación con foto de anverso y reverso, localidad, fecha y permiso de publicación.

---

## 5. Modelo de contenidos recomendado

Principio: **pocos tipos, campos claros y todo editable por Felipe desde el editor de WordPress, sin Elementor**. Cada pieza se escribe una vez y aparece en su sala, en sus recorridos y en los artículos que la citan.

### 5.1 Tipos de contenido

**1. Pieza** (`pieza`): el objeto del museo. Es un único tipo, con un campo "Tipo de objeto" que activa los grupos de campos que tocan.

| Grupo | Campos |
|---|---|
| Identificación | Título; Número de inventario del museo (p. ej. MP-0001); Tipo de objeto (sello, serie, hoja bloque, pliego o minipliego, SPD, tarjeta máxima, entero postal, carta o sobre circulado, tarjeta postal, tarjeta de campaña, marca o matasellos, documento, pintura (reproducción), objeto o juguete, publicación); Resumen de una frase |
| Emisión (si es sello, serie, HB, SPD, TMAX) | País o administración; Serie; Fecha de emisión; Números de catálogo (repetible: catálogo + número, Edifil primero); Valor facial y moneda; Color; Formato y dimensiones; Dentado; Técnica de impresión; Papel; Filigrana; Diseño; Grabado; Imprenta; Efectos en pliego; Tirada; Variedades |
| Circulación (si es pieza circulada) | Fecha; Origen; Destino; Ruta o medio (terrestre, ferrocarril o ambulante, marítimo, submarino, aéreo, militar); Franqueo (sellos con Edifil), franquicia o porte debido; Tarifa; Marcas (repetible: tipo, texto, color, posición, referencia de catálogo como Heller); Censura (sí/no, con detalle); Transcripción o resumen del texto |
| Obra externa (pintura) | Autor y fechas; Título original; Año; Técnica; Estilo o escuela; Institución depositaria con enlace; Licencia de la imagen |
| Estado y procedencia | Estado de conservación (nuevo sin fijasellos, con fijasellos, sin goma, usado, pieza completa, frontal, fragmento) y observaciones; Procedencia (colección del museo, donación, préstamo, aportación de visitante, imagen de terceros); Crédito; Derechos de la imagen |
| Imágenes | Anverso (obligatoria); Reverso; Detalles (repetible, con pie); Anotaciones (repetible: número, coordenadas, texto) |
| Interpretación | "Qué nos cuenta" (texto de museo, de 150 a 400 palabras); Relación con la Región de Murcia; Bibliografía y enlaces |
| Relaciones | Sala(s); Recorridos; Artículos; Piezas relacionadas (boceto, SPD, TMAX de la misma emisión); Producto de la tienda |

Convención de nombres de archivo, basada en la que ya usa Felipe: `{año}_{edifil}_{variante}.{ext}`, con variante `SELLO`, `HB`, `SPD`, `SPD-MUR`, `TMAX`, `MAT` (matasellos), `ANV` o `REV`.

**2. Sala** (`sala`): espacio permanente del museo.
- Campos: nombre, subtítulo, texto de sala (introducción corta), imagen de cabecera, orden, piezas destacadas (selección manual), recorridos de la sala y artículos de la sala.
- Listado automático de piezas por taxonomía.

**3. Exposición o recorrido** (`recorrido`): relato ordenado de piezas, temporal o permanente.
- Campos: título, tipo (exposición temporal, recorrido temático, colección en formato de competición), fechas si es temporal, plan o índice, pasos ordenados (repetible: pieza + texto del paso + mapa o fecha opcional), autor o comisario, clase filatélica, número de hojas o cuadros si es formato de competición, y PDF descargable.

**4. Artículo** (`post`, entrada de WordPress): investigación y divulgación ("El Correo Submarino", "El wi-fi del Siglo XIX", eclipses).
- Campos añadidos: piezas citadas, fuentes y bibliografía, autor y fecha de revisión.

**5. Actividad educativa** (`aula`): el Proyecto Aula.
- Campos: título, nivel (ciclo de Primaria, ESO, Bachillerato, adultos), materias (Historia, Geografía, Lengua, Plástica), duración, objetivos, piezas usadas, desarrollo de la actividad, preguntas para el alumnado, solucionario para el profesorado, descargables (ficha imprimible) y número de la serie.
- La página actual se llama "Proyecto_Aula_001".

**6. Evento o videoconferencia** (`evento`): conferencias propias y vídeos de terceros.
- Campos: título, tipo (videoconferencia, presentación de emisión, exposición física, matasellos especial), fecha, ponente, entidad (SOFIMA, Afinet), enlace al vídeo, duración, resumen, piezas y salas relacionadas, y estado (próximo o pasado).

**7. Recurso** (`recurso`): biblioteca y descargas.
- Campos: título, tipo (PDF de artículo, catálogo externo, libro, revista, informe semanal, enlace), autor, año, editorial, ISBN, archivo o URL, y licencia.
- Los PDF actuales `correo-submarino.pdf` y `CorreoSubmarinoBofarull-1.pdf` van aquí.

**8. Producto** (WooCommerce, ya existe).
- Añadir un campo de relación con la Pieza o la Emisión. Así la ficha de museo puede decir "disponible en la tienda" sin mezclar el museo con la venta.
- Corregir el SKU y los atributos (apartado 3.8).
- Las variantes actuales del Peral (NUEVO, USADO, BLOQUE 4, SPD MAD, SPD BNA, SPD Presentación) encajan con el campo "Tipo de objeto" de la pieza.

**9. Aportación de visitante** (opcional): un formulario que crea una Pieza en borrador.
- Campos: nombre o seudónimo, localidad, foto de anverso y reverso, qué sabe de la pieza, y permiso de publicación y de crédito.
- Sustituye el enlace de WhatsApp de "Comparte tu pieza".

### 5.2 Taxonomías

| Taxonomía | Tipo | Valores iniciales |
|---|---|---|
| **Época** | Jerárquica | Antigüedad y Edad Media; Correo de postas (1505-1716); Correo de la Corona (1716-1849); Isabel II (1850-1868); Sexenio y Primera República (1868-1874); Restauración (1875-1931); Segunda República (1931-1939); Guerra Civil (1936-1939); Posguerra y franquismo (1939-1975); Democracia (1975-2001); Euro (2002-hoy). Los cortes de los sellos coinciden con los del catálogo FESOFI por reinados |
| **Clase filatélica** | Plana | Filatelia tradicional; Historia postal; Marcofilia; Enteros postales; Aerofilatelia; Astrofilatelia; Filatelia temática; Maximofilia; Fiscales; Clase abierta; Tarjeta postal ilustrada; Literatura filatélica; Juvenil |
| **Tema** | Plana | Submarinos y marina; Guerra y censura; Astronomía y eclipses; Pintura y arte; Música; Juegos y juguetes; Ferrocarril; Minería; Fiestas y tradiciones; Personajes; Deporte |
| **Lugar** | Jerárquica | Región de Murcia > Cartagena, Murcia, Lorca, Águilas, La Unión, Jumilla, Molina de Segura, Torre Pacheco...; España > otras provincias; Mundo > país. Sirve para el mapa |
| **Tipo de objeto y técnica** | Dos taxonomías planas o campos | Tipo (ver 5.1); Técnica de impresión (calcografía, huecograbado, offset, litografía, tipografía, combinada) |
| **Fuente o colección** | Plana | Colección del museo; Aportación de visitante; Imagen de terceros (con crédito); Préstamo |

Nota de alcance: **Época**, **Lugar** y **Clase filatélica** son las taxonomías que el público usa para filtrar, y **Tema** es la de la navegación casual. Al principio no hace falta más.

### 5.3 Páginas fijas

- Inicio: qué es el museo, salas, recorrido destacado, última emisión y última pieza aportada.
- Visita: cómo recorrer el museo virtual.
- Identifica tu pieza.
- Comparte tu pieza.
- Aula.
- Investigación: biblioteca, videoconferencias, informe semanal y carteros honorarios.
- Museos postales del mundo: directorio con el estado real de cada museo (p. ej., el Museo Postal y Telegráfico, cerrado hasta que abra en Toledo).
- Tienda.
- Sobre el museo y contacto.
- Páginas legales.

### 5.4 Salas propuestas, con lo que ya existe

Mantener el marco de **museo** tiene sentido: hay colección, interpretación y un programa escolar. Propuesta de salas, en orden de recorrido:

| # | Sala | Contenido existente para abrirla | Qué falta |
|---|---|---|---|
| 1 | **Antes del sello** (prefilatelia, del cursus publicus a 1850) | "El wi-fi del Siglo XIX"; imágenes `cursuspublicus` y `tassis`; sello y HB de 300 años (`sello_300anos`, `HB_300ANOS`, `mats_300anos`, adjuntos del post 472); vídeo "El Correo en la Administración Central de Madrid hasta 1800" | Una o dos cartas prefilatélicas murcianas; bibliografía de López Jurado |
| 2 | **Sala de la Región de Murcia** (hoy "Museo Postal de la Región") | Águilas-Murcia 1866; Cantón (Edifil 5848); Peral (SPD 2014 y variantes); silla de Murcia 1991; La Parranda 1983 (con SPD Murcia, SPD Barcelona y TMAX); Narciso Yepes; Cante de las Minas 2014; `cartagena.jpg`; varias decenas de escaneos `img2025...` e `Image_2025...` por catalogar | Una ficha por pieza con su "relación con Murcia"; mapa de la Región |
| 3 | **Cartagena y el mar** (subsala o recorrido dentro de la 2) | Peral; submarinos D-1 y B-2 construidos en Cartagena; A-1; C-4; Cantón; buque del Tratado Antártico (verificar la relación) | Mapa de rutas; enlace al Museo Naval de Cartagena |
| 4 | **Correo en guerra** (1918-1945: campaña, censura, submarino, prisioneros) | "El Correo Submarino" con serie, HB, bocetos, SPD de aniversario de 1975 y 1988 y dos PDF; tarjeta italiana de 1918; sobres de prisionero de guerra; libro de Heller; vídeos "La Guerra Civil Española en la Filatelia" y "El asedio de París" | Piezas con marcas de censura de Murcia o Cartagena |
| 5 | **El correo en la pintura** | Chardin, De la Tour, Van der Kooi, Pollard y Hardy (5 fichas ya escritas); `CUADROS_EN_MUSEO.png` | Enlace a la ficha de cada museo depositario y licencias de imagen |
| 6 | **Sellos que cuentan el mundo** (filatelia temática) | Eclipses (España 2026 más 20 imágenes de 1965 a 2024); vídeo "Barcos en la filatelia" | Otros temas a medida que lleguen |
| 7 | **Juegos y juguetes postales** | Botón y logotipo (`Logo_Museo_juguete`) sin contenido | Todo; abrir cuando haya 6 piezas |
| 8 | **Aula** (Proyecto Aula) | "La tarjeta del soldado" (anverso y reverso) | Ficha guiada con anotaciones, actividad y ficha del profesorado |
| — | Fuera de salas: **Investigación y biblioteca**, **Museos postales del mundo**, **Comparte tu pieza**, **Tienda** | Videoconferencias, Carteros honorarios, Informe semanal; 8 imágenes de museos (París, Japón, Londres, España, EE. UU., Suecia, Chile, Canadá) | Texto y estado de cada museo; el informe semanal como tipo Artículo o Recurso |

**Alternativa de marco, por si Sergio la prefiere:** presentar el museo como **"Museo Postal de la Región de Murcia"**, con la sala 2 como sala principal y el resto como salas de contexto. El texto de bienvenida ya habla de una "vocación de proyectar e interpretar la Filatelia y la Historia Postal desde y para la Región de Murcia", y ningún otro museo cubre eso.

### 5.5 Migración del contenido actual

| Actual (id) | Nuevo tipo | Sala o sección |
|---|---|---|
| Post 717 El Correo Submarino | Artículo + 8 a 10 Piezas (6 sellos, HB, boceto, SPD 1975, SPD 1988) + 2 Recursos PDF | Correo en guerra; Cartagena y el mar |
| Post 472 El wi-fi del Siglo XIX | Artículo + Piezas (sello, HB y matasellos de 300 años) | Antes del sello |
| Página 925 Eclipse solar | Artículo + Pieza (emisión 2026) + Piezas de otros países + Evento (matasellos de A Coruña) | Sellos que cuentan el mundo |
| Páginas 753, 821, 827, 836, 857 (cuadros) y 854 (índice) | Piezas de tipo "pintura" + Sala | El correo en la pintura |
| Página 598 Museo_murcia | Sala + Piezas | Región de Murcia |
| Página 118 Proyecto_Aula_001 | Actividad educativa + Pieza (tarjeta 1918) | Aula |
| Página 97 Videoconferencias | 6 Eventos (vídeos de terceros con crédito) | Investigación |
| Página 126 Museos en el Mundo | Página con directorio | Museos postales del mundo |
| Página 59 Comparte_museo | Página con formulario de aportación | Comparte tu pieza |
| Página 691 Investigación y borrador 748 | Página índice de Investigación; descartar el Lorem ipsum y la "cotización" | Investigación |
| Productos 382 y 394 | Productos con relación a Pieza o Recurso; corregir el SKU y el atributo ISBN | Tienda |
| Página 596 Padre_museo, 324 y 697 duplicadas | Eliminar o unificar | — |

---

## 6. Fuentes principales

- **FIP:** [GREV](https://www.f-i-p.ch/wp-content/uploads/GREV-English.pdf); [Revised Postal History Guidelines 2022](https://www.f-i-p.ch/wp-content/uploads/Revised-Postal-History-Guidelines-Final-May2022.pdf); [Guías de maximofilia 2019](https://www.f-i-p.ch/wp-content/uploads/FIP-Guidelines-MA-Final-28.8.2019.pdf); [SREV fiscales](https://www.f-i-p.ch/wp-content/uploads/SREVS-and-Guidelines-Revenues-Final.pdf); [Guías de filatelia tradicional](https://www.f-i-p.ch/wp-content/uploads/TRGuidelines-New-approved-final.pdf)
- **FESOFI:** [inicio](https://fesofi.es/); [GREX en español](https://fesofi.es/wp-content/uploads/2022/03/Reglamento-Gral-Expo-GREX.pdf); [Reglamento EXFILNA 2019](https://fesofi.es/reglamento-exfilna-2019/); [Federaciones y Sociedades](https://fesofi.es/federaciones-y-sociedades-general/); [Correspondencia Epistolar Escolar](https://fesofi.es/wp-content/uploads/2024/07/PROGRAMA-DE-CORRESPONDENCIA-EPISTOLAR-ESCOLAR.pdf); [Catálogo de sellos](https://catalogodesellos.fesofi.es/product-category/isabel-ii/)
- **Clases y exposiciones virtuales:** [APF, clases](https://apf.org.au/classes/); [EXPONET](https://www.exponet.info/en)
- **Academia:** [RAHF, Historia](https://www.rahf.es/historia/)
- **Museo Postal y Telegráfico:** [Wikipedia](https://es.wikipedia.org/wiki/Museo_Postal_y_Telegr%C3%A1fico_(Espa%C3%B1a)); [Correos, Toledo](https://www.correos.com/en/sala-prensa/toledo-sera-la-sede-del-nuevo-museo-postal-y-telegrafico-de-correos/); [La Cerca, 27-05-2026](https://www.lacerca.com/noticias/toledo/grupo-municipal-popular-apertura-museo-postal-telegrafico-toledo-815950-1.html)
- **Murcia:** [Hogar Filatélico de Cartagena](https://filalacant.org/cartagena/); [SOVAFIL](https://www.sovafil.es/Marcofilia.htm); [Cantón, sellosfilatelicos](https://www.sellosfilatelicos.com/2025/07/sello-de-correo-postal-revolucion-cantonal-de-cartagena.html); [Peral, Armada](https://armada.defensa.gob.es/ArmadaPortal/page/Portal/ArmadaEspannola/conocenosnoticias/prefLang-es/00noticias--2014--03--NT-045-SELLO-ISAAC-PERAL-es?_selectedNodeID=1598040&_pageAction=selectItem); [Peral, infimar 4870](https://infimar.com/es/sellos-de-espana-de-2014/5323-4870-aniversario-botadura-del-submarino-peral.html); [Prefilatelia de Murcia](https://www.amazon.es/Prefilatelia-Murcia-historia-postal-Reino/dp/8475643477); [Narciso Yepes, Correos](https://filatelia.correos.es/es/es/rincon-correos/filatelia/productos/sellos/espana/2015/personajes-narciso-yepes); [Línea Chinchilla-Cartagena](https://es.wikipedia.org/wiki/L%C3%ADnea_Chinchilla-Cartagena)
- **Censura:** [Heller, Dialnet](https://dialnet.unirioja.es/servlet/libro?codigo=71503); [Censura postal, Wikipedia](https://es.wikipedia.org/wiki/Censura_postal)
- **Catálogos:** [Edifil](https://www.edifil.es/es/24-catalogos-de-sellos); [Stamp catalog](https://en.wikipedia.org/wiki/Stamp_catalog); [Stamp numbering system](https://en.wikipedia.org/wiki/Stamp_numbering_system)
- **Museos en línea:** [NPM Arago](https://postalmuseum.si.edu/about/press/national-postal-museum-to-launch-research-web-site); [NPM Collections](https://postalmuseum.si.edu/collections-search-center); [NPM Classroom Resources](https://postalmuseum.si.edu/classroom-resources); [The Postal Museum, catálogo](https://www.postalmuseum.org/collections/catalogue/); [Museumsstiftung, Onlinesammlung](https://onlinesammlung.museumsstiftung.de/); [CER.es](https://ceres.mcu.es/); [IIIF viewers](https://iiif.io/get-started/iiif-viewers/)
- **Público:** [Fantoni y otros, MW2012](https://museumsandtheweb.com/mw2012/papers/exploring_the_relationship_between_visitor_mot); [Falk online, MW2016](https://mw2016.museumsandtheweb.com/proposal/falk-meets-online-motivation-results-from-a-nationwide-survey-project/index.html); [Information Research 18(4)](https://informationr.net/ir/18-4/paper597.html)
- **Contexto:** [Cartero honorario](https://es.wikipedia.org/wiki/Cartero_honorario); [Afinsa y Fórum, CMM](https://www.cmmedia.es/noticias/castilla-la-mancha/caso-forum-filatelico-afinsa-17-anos-mayor-estafa-piramidal-espana.html)

**Archivos locales usados (solo lectura):**
- `/tmp/felipe/backup/museopostal-export-all-2026-09-28.xml`: títulos, prosa, postmeta de productos, adjuntos y menús.
- `/tmp/felipe/pages.json` y `/tmp/felipe/posts.json`.
- `/tmp/felipe/mirror/`: páginas y `wp-content/uploads/2026/04-05/`.
- `/tmp/felipe/shots/{home,museo_murcia,aula}-desktop.png`.
- `/tmp/felipe/media/media-index.json`.
- `/tmp/felipe/inventory.md` no existía cuando se ejecutó.

## Resumen

- **Qué es este informe.** He leído el export y el espejo del sitio, lo he contrastado con fuentes web y he guardado el informe en `/tmp/felipe/research/01-filatelia-dominio.md`. No he tocado ningún repositorio.
- **Vocabulario.** La materia tiene un vocabulario reconocido (clases FIP, Edifil, estado de conservación y el glosario de 64 términos de arriba), y la web debe usarlo. Sin una ficha de pieza con Edifil, fecha, técnica, dentado, marcas, estado y anverso/reverso ampliables, ni un coleccionista ni un investigador puede usarla.
- **Lo diferencial es Murcia:** Cartagena naval, Peral, el Cantón y la prefilatelia del Reino de Murcia. Además, llega en un momento en que el Museo Postal y Telegráfico sigue cerrado y Murcia no tiene federación propia.
- **Modelo:** Pieza, Sala, Recorrido, Artículo, Actividad educativa, Evento, Recurso y Producto. Taxonomías de época, clase filatélica, tema, lugar, tipo o técnica y fuente. Ocho salas que se pueden abrir con el contenido actual.
- **Siguiente paso:** confirmar con Felipe tres cosas:
  - El número Edifil del producto Peral (5317 o 4870).
  - Qué piezas son de su colección y cuáles son imágenes de terceros.
  - Si prefiere el marco "Museo Postal de la Región de Murcia".