# BRIEF · Rediseño de museopostal.org

Museo Postal y Filatélico de la Región de Murcia. Documento de producto único para la siguiente fase (maquetas, tema, plugin, migración). Fecha: 28-09-2026.

Fuentes: los cinco informes de investigación en `/tmp/felipe/research/` y sus ficheros hermanos. Las citas entre paréntesis remiten a ellos:

| Cita | Fichero |
|---|---|
| 01 | `01-filatelia-dominio.md` (materia, ficha de pieza, contexto murciano, modelo de contenido) |
| 02 | `02-referentes-web-museos.md` (referentes, 22 patrones, 10 antipatrones, 3 direcciones visuales) |
| 03 | `03-auditoria-contenido.md` (mapa de contenido, página a página) |
| 03b | `03b-contenido-extraido.md` (texto real ya limpio, semilla del nuevo sitio) |
| 04 | `04-auditoria-ux-ui.md` (problemas P0/P1/P2 y 10 objetivos medibles T1-T10) |
| 05 | `05-opciones-tecnicas.md` (opciones técnicas, despliegue, migración, plugins, staging, previsualización) |
| inv | `/tmp/felipe/inventory.md` (hosting, temas y 29 plugins; este fichero no existía cuando se escribieron 03, 04 y 05, que dedujeron los plugins del HTML y del export) |

Regla de este documento: cuando dos informes se contradicen, se dice cuál gana y por qué (§11). Ningún dato personal del titular (DNI, domicilio, correo personal, móvil) se reproduce aquí; están en las páginas legales originales y deben salir del sitio (§7.4).

---

## 1. Resumen ejecutivo

1. **Qué está mal hoy.** museopostal.org no funciona como museo: la portada no tiene H1, abre con 90 palabras en cursiva y 3 de sus 6 tarjetas no llevan a ninguna parte, entre ellas la sala de Murcia, que es la razón de ser del proyecto (04 P0-1). Las salas están vacías, rotas o tapadas: Museo_murcia son 3 imágenes sin texto, Museos del Mundo 8 fotos sin nombre, el Proyecto Aula queda oculto tras el aviso «Nuestra tienda está en obras» y Padre_museo muestra «Please select a Menu From Setting!» (04 P0-2; 03 §5). Seis páginas publicadas son huérfanas (03 §4).
2. La imagen del museo son medallones generados por IA con matasellos inventados («MURCIA 14 DE 1870», «Hala Hamylon Murcia»), lo peor que puede enseñar un museo de filatelia, donde la autenticidad es el producto (04 P0-5).
3. Técnicamente es una tienda grande sin tienda: 26 plugins activos de 29 (inv), 150 peticiones y 2,3 MB en móvil, LCP de 4,9 s, TTFB de 2 a 10 s con la microcaché siempre `EXPIRED`, 7 familias tipográficas, dos plugins de SEO, cuatro de analítica y tres de consentimiento; Clarity y Google Analytics envían datos antes de que el visitante acepte nada (04 §1, P0-4, P0-6).
4. Los textos legales están copiados de otro comerciante (remiten a estudifilatelic.com y a Barcelona), publican el DNI del titular y la política de privacidad termina a mitad de frase (03 §5.21-5.22).
5. **Lo que vale.** Unas 4.100 palabras de prosa real y buena (03 §Resumen): «El Correo Submarino», «El wi-fi del siglo XIX», la exposición de los eclipses, 5 fichas de pintura, la idea del Aula y la de «Comparte tu pieza», y unos 40 escaneos filatélicos auténticos sin publicar en la biblioteca de medios (03 §11). El nombre, el dominio, el concepto del logo granate y la paleta crema/granate/tinta también se quedan (04 §3).
6. **Qué será el nuevo sitio.** Un museo virtual con la Región de Murcia como sala central y cuatro salas de contexto, cuya unidad es la **pieza** con ficha filatélica completa (Edifil, fecha, técnica, dentado, marcas, estado, procedencia, anverso y reverso ampliables), organizada por época, lugar, tipo y tema, con un Aula para colegios y una sección de investigación (artículos, videoteca, biblioteca) (01 §5; 02 §3 y §5).
7. Portada-vestíbulo: nombre, misión en una frase, cinco puertas, la efeméride del día y una pieza al azar. Ningún carrusel, ninguna imagen generada, ningún tercero antes de que el visitante haga clic (02 patrones 1, 16, 17 y 22).
8. **Cómo se entrega.** Un tema de bloques propio (`museopostal`) y un plugin compañero (`museopostal-coleccion`) que registra el modelo del museo, desarrollados en el repositorio público `GeiserX/museopostal` (GPL-3.0). GitHub Actions publica los zips en cada Release; la primera instalación se sube por wp-admin y las siguientes llegan como actualización normal de WordPress (05 §0, §3).
9. Cada PR lleva un botón de WordPress Playground para que Felipe vea el tema real con contenido de muestra desde el móvil. Las tres direcciones visuales se maquetan como variaciones de estilo del mismo tema, no como maquetas aparte (05 §7; §6 de este brief).
10. La migración se ensaya en un clon (`pruebas.museopostal.org`) y se repite en producción con copia de Superbackup, WXR y Release fijada; volver a Neve es un clic mientras no se borren datos (05 §6). Elementor, sus tres packs de addons y unos 20 plugins más se retiran por tandas al final (05 §5).

---

## 2. Audiencias y objetivos

### 2.1 Quién visita un museo postal virtual

Un museo sin sede física pierde el 50 % de visitas que buscan «planificar la visita»; su público es el de interés personal, el de investigación y el de navegación casual (01 §4.3, con datos del Indianapolis Museum of Art, MW2012). Los investigadores son los más implicados y los que más vuelven (33 %).

| Audiencia | Qué viene a hacer | Qué necesita del sitio | Evidencia |
|---|---|---|---|
| **A. Coleccionistas y filatelistas** (Región de Murcia, España; socios del Hogar Filatélico de Cartagena, FASFILCOVA, FESOFI) | Identificar una pieza, comprobar un Edifil, ver una serie completa, encontrar el matasellos de su pueblo | Ficha con número de catálogo, fecha, dentado, técnica, tirada, estado; buscador y filtros por Edifil, año, lugar, tipo; anverso y reverso ampliables | 01 §2.1, §4.3; 02 patrones 4, 5, 6, 7, 14 |
| **B. Investigadores e historiadores locales** | Leer un estudio, citar una pieza, descargar un PDF, seguir una ruta postal | Cita sugerida con identificador estable, bibliografía, PDF de recursos, mapas y líneas de tiempo | 01 §4.2, §4.3; 02 patrón 12 |
| **C. Docentes y alumnado** (Primaria, ESO, Bachillerato) | Una actividad lista para el aula, con pieza real y solucionario | Fichas del Aula por nivel y materia, imagen anotada, descargable; antecedente: Programa de Correspondencia Epistolar Escolar de FESOFI (1998) | 01 §3.3, §5.1 tipo 5; 02 patrón 21 |
| **D. Público general murciano y curioso** | Curiosear, reconocer Cartagena, Lorca o Águilas, aportar una postal de la abuela | Salas con relato, efeméride del día, pieza al azar, «Comparte tu pieza» con formulario y foto | 01 §3.7; 02 patrones 16, 17; 04 §3 punto 8 |
| **E. Instituciones y prensa** (Correos, FESOFI, RAHF, ayuntamientos, Museo Naval de Cartagena) | Saber qué es el museo, quién lo dirige, cómo contactar, qué licencia tienen las imágenes | Página «El museo» seria, contacto con correo del dominio, créditos y licencias, accesibilidad declarada | 02 patrones 8, 22; 04 P1-11 |

**Quién edita:** Felipe, solo, sin conocimientos técnicos, desde España (el panel está geobloqueado fuera de España, inv). Todo lo que se diseñe debe poder publicarlo él desde el editor de bloques sin tocar código ni Elementor (01 §5 principio; 05 §2.1).

### 2.2 Objetivos y métricas de éxito

**Objetivos de contenido y uso** (se miden en el sitio, sin analítica de terceros):

| # | Objetivo | Hoy | Meta al lanzar | Meta a 6 meses |
|---|---|---|---|---|
| C1 | Piezas con ficha completa publicadas | 0 fichas de pieza (hay páginas de cuadro y páginas de galería) | **≥ 40** (hay ~30 piezas ya publicadas sin ficha y ~40 escaneos sin publicar; 03 §11) | ≥ 100 |
| C2 | Salas abiertas con ≥ 6 piezas y texto de sala | 0 (Museo_murcia y Museos del Mundo no tienen texto) | **5** | 6 (se abre «Juegos y juguetes» cuando tenga 6 piezas; 01 §5.4) |
| C3 | Páginas huérfanas, tarjetas sin destino, 404 internos, títulos o slugs internos visibles | 6 huérfanas, 5 tarjetas muertas, 1 404 interno, 10 títulos con «_», 6 slugs `elementor-N` (04 T10) | **0 en todo** | 0 |
| C4 | Imágenes generadas por IA de material postal | 10 medallones (04 P0-5) | **0** | 0 |
| C5 | Aportaciones recibidas por «Comparte tu pieza» | No medible (WhatsApp personal) | Formulario operativo | ≥ 10 aportaciones publicadas con crédito |
| C6 | Actividades del Aula | 1 página tapada por la tienda | 1 ficha guiada completa (la tarjeta del soldado) | 3 fichas y ≥ 1 centro que la haya usado |
| C7 | Autonomía de Felipe | No puede publicar una pieza sin romper el diseño | Publica una pieza nueva en < 15 min siguiendo la guía, sin ayuda | Publica salas y recorridos solo |

**Objetivos técnicos** (los diez del informe 04 §4, que se adoptan tal cual y se miden con las mismas herramientas):

| # | Métrica | Hoy (medido) | Objetivo |
|---|---|---|---|
| T1 | LCP portada, móvil (412 px, 1,6 Mbit/s, 150 ms, CPU ×4) | 4,90 s | **≤ 2,5 s** (≤ 1,5 s escritorio) |
| T2 | TTFB del HTML | 2,0-10,3 s; `server-timing rt` 1,25-3,3 s; microcaché `EXPIRED` | **≤ 0,6 s** con caché acertando |
| T3 | Peso transferido de la portada | 2.338 KB móvil | **≤ 500 KB** móvil; JS ≤ 80 KB comprimido |
| T4 | Peticiones de la portada | 150-151 | **≤ 25**; ≤ 3 CSS y ≤ 5 JS |
| T5 | Terceros antes del consentimiento | clarity.ms ×4, google-analytics, googletagmanager, fonts.googleapis | **0**; como máximo **1** herramienta de consentimiento (0 si no hay rastreo) |
| T6 | Tipografía | 7 familias, 307 `@font-face`, cuerpo en cursiva negrita | **≤ 2 familias autoalojadas**, cuerpo redonda ≥ 18 px, interlineado ≥ 1,5, 60-75 caracteres por línea |
| T7 | Contraste de texto | mínimo 2,35:1 | **≥ 4,5:1** texto; ≥ 3:1 bordes de controles |
| T8 | Estructura y alt | 6 páginas sin encabezados, 1 con dos H1, 118/143 medios sin alt | **1 H1 por página sin saltos**; **100 %** de imágenes de contenido con alt |
| T9 | Objetivos táctiles y banner en móvil | tarjetas ~147 px con pie de 12 px; banner al 44 % del alto | **≥ 44×44 px**; banner ≤ 25 % o ninguno |
| T10 | Integridad y plugins | 26 plugins activos | **0** roturas de navegación; **≤ 12 plugins activos** (meta propia de este brief: **≤ 8**, ver §8.3) |

---

## 3. Concepto del museo

### 3.1 Marco: se mantiene «museo», y se afila

**Decisión: el sitio sigue siendo un museo virtual, no un blog ni un catálogo.** Tres razones:

1. Hay colección, interpretación y programa escolar, que son las tres cosas que distinguen un museo de un blog (01 §5.4; 02 §3, tabla «señal de museo / señal de blog»). Las dos entradas actuales son buenas, pero son artículos de sala, no el eje del sitio.
2. El hueco es real: el Museo Postal y Telegráfico de Correos cerró Aravaca a finales de 2023 y en mayo de 2026 Toledo seguía sin fecha de apertura; Murcia no tiene federación filatélica propia (va dentro de la valenciana) y la RAHF aprobó sus estatutos en una asamblea celebrada en Murcia en 1954 (01 §3.2-3.5). Ningún otro museo cubre «filatelia e historia postal desde y para la Región de Murcia».
3. El marco de museo obliga a lo que hoy falta: fichas normalizadas, salas con texto, créditos, licencias y una cita. Es la disciplina que el sitio necesita.

**Lo que se afila:** la Región de Murcia pasa a ser la **sala central** y las demás son salas de contexto (alternativa que ya propone 01 §5.4 y que aquí se adopta). El texto de bienvenida actual ya lo dice («vocación de proyectar e interpretar la filatelia y la historia postal desde y para la Región de Murcia», 03b §1). El nombre y el dominio no cambian (04 §3 punto 1).

Marcos descartados:
- **Blog de filatelia con secciones:** es lo que hay hoy y no distingue pieza de entrada (02 §3).
- **Solo catálogo/colección en línea sin salas:** con unas 140 piezas, sin relato el visitante casual no sabe por dónde entrar; los referentes pequeños que funcionan ordenan por salas o periodos (02 patrones 13 y 18; Museu de Lleida).
- **«Museo Postal de la Región de Murcia» de alcance solo regional:** los eclipses, las pinturas y el correo submarino no son murcianos y son lo mejor del sitio. Murcia es la sala central, no el límite.

### 3.2 Nombre, lema y voz

- **Nombre:** Museo Postal y Filatélico de la Región de Murcia. Dominio museopostal.org.
- **Lema propuesto (sustituye al caducado «Estamos construyendo... ¡EL 1 de Agosto comenzamos!», 03 §2):** «Filatelia e historia postal desde la Región de Murcia». Va en `og:site_name`, en el pie y bajo el logo; nunca fechas ni disculpas (04 P1-10).
- **Misión en una frase (portada):** «Un museo virtual que conserva, explica y comparte sellos, cartas y marcas postales, con la Región de Murcia como punto de partida.» (redacción de trabajo, a validar con Felipe).
- **Tratamiento: «tú».** Hoy se mezclan «usted» (portada) y «tú» (Contacto y los dos artículos: «Imagínate», «¿Te suenan los carruajes amarillos?», 03b §3.1). Se unifica en «tú», que es el de la prosa que mejor funciona. Vale para el Aula y para «Comparte tu pieza».
- **Vocabulario de museo** en fichas y salas: Inventario, Objeto, Datación, Lugar de producción, Iconografía, Inscripciones y marcas, Procedencia (la Normalización Documental de Museos y CER.es del Ministerio de Cultura, 01 §2.1).
- **Vocabulario filatélico** correcto y con glosario: las 64 entradas de 01 §2.4 se publican como página «Glosario» enlazada desde cada ficha.
- **Sin tasaciones.** El museo nunca da valoraciones económicas ni «cotización actual»; la historia de Afinsa y Fórum Filatélico (2006) se cuenta como historia, no como mercado (01 §2.3). El bloque «COTIZACION ACTUAL» del borrador «Investigación - Copy» se descarta (03 §5.4).
- **Firma:** los artículos y las salas llevan «Comisario: Felipe Martínez» o el nombre que él elija; el autor de WordPress deja de mostrar «Conservador del M» cortado (04 P1-3) y el slug `/author/felipe/` se cambia (04 P1-11).
- **Ortotipografía:** signos de apertura pegados («¡Bienvenido!»), © y no ®, «siglo» en minúscula, botones en minúscula («Añadir al carrito»), sin Title Case (04 P1-10, P2-4; 03 §12.6-12.7). La lista completa de erratas a corregir está en 03 §12.7.

### 3.3 Las salas

Cinco salas se abren con contenido que ya existe; una sexta espera. Nombres definitivos propuestos (fusión de 01 §5.4 y 05 §4.3):

| # | Sala (slug) | Qué cuenta | Con qué se abre (ya existe) | Qué falta |
|---|---|---|---|---|
| 1 | **Antes del sello** (`antes-del-sello`) | Prefilatelia: del cursus publicus (27 a. C.) al primer sello de España (1850) y el franqueo obligatorio (1856) | Artículo «El wi-fi del siglo XIX» (674 palabras, 03b §3.1); imágenes `cursuspublicus`, `tassis`; sello, HB y matasellos de los 300 años de Correos (adjuntos 878-880); vídeo «El Correo en la Administración Central de Madrid hasta 1800» | 1 o 2 cartas prefilatélicas murcianas; bibliografía López Jurado, *Prefilatelia de Murcia* (01 §3.7) |
| 2 | **La Región de Murcia** (`region-de-murcia`) · **sala central** | Correo, sellos y marcas de la Región: Cartagena naval (Peral, submarinos D-1 y B-2, Cantón de 1873), la carta de Águilas a Murcia de 1866, La Parranda, Narciso Yepes, el Cante de las Minas, la silla de Murcia, el mapa autonómico | Adjuntos 166 (carta 1866), 175-185, 167, 187-188, 199, 189-196 (Peral y SPD); ~15 escaneos por identificar (03 §11; 01 §3.7) | Una ficha por pieza con «Relación con la Región»; mapa de la Región con las piezas por localidad; recorrido «Cartagena y el mar» (§4.3) |
| 3 | **Correo en guerra** (`correo-en-guerra`) | 1918-1945: correo de campaña, censura, correo submarino, prisioneros | Artículo «El Correo Submarino» (1.136 palabras, 03b §3.2) con 6 sellos, HB, boceto de Rieusset, SPD de 1975 y 1988 y 2 PDF (430, 747); tarjeta italiana de 1918 (120-121); sobres de prisionero (209-210); libro de Heller; vídeos «La Guerra Civil Española en la Filatelia» y «El asedio de París» | Piezas con marcas de censura de Murcia o Cartagena; recuperar el original de `SOBRE_GUERRA` (solo hay miniatura de 140 px, 01 §3.7) |
| 4 | **El correo en la pintura** (`el-correo-en-la-pintura`) | Cómo los pintores contaron el correo: lacre, carta, diligencia, cartero | Las 5 fichas ya escritas: Chardin, De la Tour, Van der Kooi, Pollard, Hardy (03b §2.1); es el mejor contenido del sitio y el modelo de ficha (04 §3 punto 4) | Enlace a la ficha del museo depositario y licencia de cada imagen; campo «Qué nos cuenta del correo» (01 §2.1 C) |
| 5 | **Sellos que cuentan el mundo** (`sellos-que-cuentan-el-mundo`) | Filatelia temática: un tema contado con sellos de cualquier país | Los eclipses (emisión de Correos del 23-07-2026 más 15 sellos de 1965 a 2024, 03b §2.2); vídeo «Barcos en la Filatelia» | Otros temas a medida que lleguen (barcos, música, ferrocarril) |
| 6 | **Juegos y juguetes postales** (`juegos-y-juguetes-postales`) · **no se publica** hasta tener 6 piezas | Juguetes, juegos y objetos de correo | Solo el botón `Logo_Museo_juguete.webp` (03b §2.7) | Todo |

Cada sala tiene: cabecera con un detalle macro de una pieza real (02 patrón 19), texto de sala de 150 a 300 palabras, recorrido ordenado de 6 a 12 piezas, índice, y créditos (02 patrón 18). Las salas pueden crecer por entregas («Parte 2 de 4», 02 patrón 20).

**Fuera de las salas** (secciones, no salas): Colección, Aula, Investigación (artículos, videoteca, biblioteca, museos postales del mundo) y El museo (§4).

---

## 4. Arquitectura de la información

### 4.1 Menú principal (5 entradas, visible en escritorio, hamburguesa solo en móvil)

Fusión de 04 P0-3 y 02 patrón 2. Cinco entradas con nombre propio, sin ítems numerados, sin carrito y sin hamburguesa duplicada en escritorio (04 P0-3; 02 antipatrones 2 y 3). Buscador visible también en móvil.

```
Salas ▾        Colección ▾        Aula        Investigación ▾        El museo ▾                 [Buscar]
```

| Entrada | Desplegable |
|---|---|
| **Salas** | Antes del sello · La Región de Murcia · Correo en guerra · El correo en la pintura · Sellos que cuentan el mundo (y «Todas las salas») |
| **Colección** | Explorar la colección · Por época · Por lugar · Por tipo de pieza · Identifica tu pieza · Comparte tu pieza · Glosario |
| **Aula** | (sin desplegable) |
| **Investigación** | Artículos · Videoteca · Biblioteca · Museos postales del mundo |
| **El museo** | Quiénes somos · Publicaciones · Contacto · Accesibilidad · Créditos y licencias · Cómo citar |

Pie: lema, «Una pieza al azar» (02 patrón 17), enlaces legales (Aviso legal · Política de privacidad · Política de cookies), contacto con correo del dominio, declaración de accesibilidad, © 2026 Museo Postal y Filatélico de la Región de Murcia. Sin redes incrustadas (02 antipatrón 5). Boletín solo si Felipe decide tenerlo (§10, pregunta 9).

### 4.2 Mapa del sitio completo

Las URL nuevas son legibles y estables; todas las actuales redirigen con 301 (§4.4). Contenido dinámico marcado con `*`.

```
/                                   Inicio (front-page.html)
/salas/                             Índice de salas
/sala/antes-del-sello/              * archivo del término «sala» (taxonomy-sala.html)
/sala/region-de-murcia/             *
/sala/correo-en-guerra/             *
/sala/el-correo-en-la-pintura/      *
/sala/sellos-que-cuentan-el-mundo/  *
/coleccion/                         * archivo del CPT pieza, con buscador y filtros (archive-pieza.html)
/pieza/<slug>/                      * ficha de pieza (single-pieza.html)
/epoca/<slug>/  /lugar/<slug>/  /tipo/<slug>/  /tema/<slug>/     * archivos de taxonomía
/coleccion/identifica-tu-pieza/     Página: cómo leer una pieza, catálogos gratuitos, por qué el museo no tasa (01 §4.3)
/coleccion/comparte-tu-pieza/       Página con formulario de aportación (foto anverso/reverso, localidad, permiso)
/coleccion/glosario/                Página: 64 términos (01 §2.4)
/recorridos/                        Índice de recorridos temáticos
/recorridos/cartagena-y-el-mar/     Página con patrón «Recorrido» (pasos que enlazan piezas)
/aula/                              Página índice del Aula, por nivel
/aula/la-tarjeta-del-soldado/       Página con patrón «Actividad»: ficha guiada anotada, actividad, solucionario, PDF
/investigacion/                     Página índice
/articulos/                         * página de entradas (Ajustes › Lectura)
/articulos/<slug>/                  * entradas (permalink /articulos/%postname%/)
/investigacion/videoteca/           Página: 6 vídeos con título, ponente, entidad, fecha (03 §5.5)
/investigacion/biblioteca/          Página: PDF propios (430, 747), libros y catálogos externos (Edifil, FESOFI, Heller)
/investigacion/museos-postales-del-mundo/   Página: directorio de 8 museos con nombre, ciudad, web y estado real
/el-museo/                          Quiénes somos: misión, director, historia del proyecto, cómo se hizo la web
/el-museo/publicaciones/            Los 2 artículos hoy en venta, con «pídelo por correo» (si se retira WooCommerce, §8.3)
/el-museo/accesibilidad/            Declaración honesta de accesibilidad (02 patrón 22)
/el-museo/creditos-y-licencias/     Créditos de imágenes de terceros, licencia de las propias
/el-museo/como-citar/               Cómo citar el museo y una pieza (02 patrón 12)
/contacto/                          Formulario CF7 único (se mantiene la URL actual)
/aviso-legal/                       Redactado de nuevo (03 §5.22)
/politica-de-privacidad/            Completa y sin frase cortada (03 §5.21)
/politica-de-cookies/               Texto fijo o generado por la única herramienta de consentimiento
/404                                Con buscador y enlaces a las 5 salas
```

### 4.3 Qué contenido actual va a dónde

Mapa de migración (fusión de 01 §5.5, 03 Anexo A y 05 §4.3). «Convertir» = «Volver al editor de WordPress» y «Convertir en bloques» sobre el HTML que Elementor ya guarda limpio en `post_content` (05 §4.2).

| id | Hoy | Destino | Cómo |
|---|---|---|---|
| 235 | Portada «Museos» (`/`) | `/` | Se rehace con `front-page.html` y patrones. El texto de bienvenida se reescribe (sin disculpa, sin newsletter no existente). |
| 598 | Museo_murcia | Sala **La Región de Murcia** + piezas | Término `sala` con texto nuevo; cada imagen pasa a una Pieza con ficha. |
| 854 | Las_pinturas | Sala **El correo en la pintura** | Término `sala`; `CUADROS_EN_MUSEO.png` (863) como cabecera provisional. |
| 821, 827, 836, 857, 753 | Cuadro_1..4 y Chardin | 5 **Piezas** `tipo=pintura` | Texto de 03b §2.1 tal cual (ya corregido); ficha: autor, título original, año, técnica, estilo, institución con enlace, licencia. La de Chardin se recorta al formato de las otras cuatro y su imagen se sube a la biblioteca (hoy enlaza a Wikimedia, 03 §5.12). |
| 925 | Eclipse_solar | Artículo **«Los eclipses solares en la filatelia»** + Pieza (emisión Correos 2026) + 15 Piezas (sellos de otros países, o una galería si no se quiere ficha por sello) + sala **Sellos que cuentan el mundo** | Convertir; corregir la ficha técnica (tamaño del sello 33 × 53 mm frente a la HB de 79,2 × 105,6, a confirmar con la ficha de Correos, 03 §5.13). |
| 717 | El Correo Submarino | Artículo en `/articulos/el-correo-submarino/` + 8-10 Piezas (6 sellos, HB, boceto, SPD 1975, SPD 1988) + 2 Recursos PDF | Convertir; arreglar la tabla «---}», los h5 que son párrafos, «colo y v valor», «Tunez», «Soller»; confirmar «Werner Kell» (03 §6.2). |
| 472 | El wi-fi del Siglo XIX | Artículo en `/articulos/el-wi-fi-del-siglo-xix/` + Piezas (sello, HB, matasellos 300 años) | Convertir; listas que reinician en 1, h6 como títulos, «Siglo» en minúscula (03 §6.1). |
| 118 | Proyecto_Aula_001 | `/aula/la-tarjeta-del-soldado/` + Pieza (tarjeta en franquicia del Regio Esercito, 29-05-1918, «Verificato per censura», 01 §3.7) | Primera ficha guiada del Aula con puntos numerados sobre la imagen. **Antes:** quitar a esta página el papel de tienda de WooCommerce (`woocommerce_shop_page_id`, 03 §5.16). |
| 97 | 11-Videoconferencias | `/investigacion/videoteca/` | Convertir en 6 vídeos con título, ponente, entidad y crédito (SOFIMA, Afinet/Ágora de Filatelia; títulos en 03b §4.1); fachada de clic que carga `youtube-nocookie.com`. |
| 126 | Museos en el Mundo | `/investigacion/museos-postales-del-mundo/` | Directorio con nombre, ciudad, web y estado real de cada museo (el Museo Postal y Telegráfico consta como cerrado hasta que abra en Toledo, 01 §3.2). Faltan los nombres: pedirlos a Felipe. |
| 691 | Investigación | `/investigacion/` | Convertir en índice con texto. Los botones «El informe semanal» y «Carteros Honorarios» se retiran hasta que tengan contenido; «Carteros honorarios» puede ser un artículo (glosario 01 §2.4 n.º 7). |
| 748 | Investigación - Copy (borrador) | Se borra | Su lista de secciones (Biblioteca, Hemeroteca, Revistas, En la pintura) ya está cubierta; «Informe AFINSA» y «Cotización» se descartan (01 §2.3). |
| 59 | Comparte_museo | `/coleccion/comparte-tu-pieza/` | Formulario CF7 con subida de 2 fotos, localidad, qué sabe de la pieza, permiso de publicación y crédito. Sin `wa.me` al móvil personal (04 P1-11). |
| 531 | Blog (`/contenedor-de-blog/`) | `/articulos/` | Página de entradas nativa; se elimina la rejilla de Essential Addons. |
| 548 | Tienda (`/elementor-548/`) | `/el-museo/publicaciones/` | Ver §8.3; decisión de Felipe (§10, pregunta 1). |
| 382, 394 | Productos Peral y libro Heller | Publicaciones (o productos si la tienda sigue) | Corregir SKU «Edifil 5317» → **Edifil 4870** (a confirmar, 01 §3.8), «Cod EAN» → ISBN 84-931717-0-0, «ERNSTL L. HELLER» → Ernst L. Heller, precio de la variante «Usado». |
| 697 | Contacto | `/contacto/` | Convertir; un solo formulario CF7 (798) con etiquetas asociadas, `Reply-To` del visitante, enlace a privacidad que funcione (03 §8.1). |
| 324 | Formulario de Contacto (WPForms) | Se borra, redirige a `/contacto/` | Duplicado (03 §5.19). |
| 596 | Padre_museo | Se borra, redirige a `/` | Prueba rota (03 §5.20). |
| 573 | Politica de privacidad (`/elementor-573/`) | `/politica-de-privacidad/` | Reescribir completa: proveedores reales, sin frase cortada, correo del dominio. |
| 662 | Condiciones de uso y envio (`/elementor-662/`) | `/aviso-legal/` | Reescribir desde cero: hoy está copiada de otro comercio (03 §5.22). Sin DNI si la actividad no lo exige (§10, pregunta 4). |
| 658 | Política de cookies (UE) | `/politica-de-cookies/` | Texto fijo si no hay cookies no exentas; si se conserva Complianz, su shortcode. |

**Se elimina:**
- Las 10 imágenes de sala generadas por IA: `5_murcia.png`, `4_museos.png`, `Logo_Museo_pintura.webp`, `Logo_Museo_juguete.webp`, `botonEclipse.webp`, `11_conferencias.png`, `9_elinforme.png`, `12_honorarios.png`, `videoconferencias.webp`, `carteros-honorarios.webp` y la serie de 12 botones PNG y 5 WebP de la primera portada (04 P0-5; 03b §1).
- Fotos de stock de Pexels (162-164), `bg88.jpg`, `enobras.webp`, `CARRITO.jpg/.png` y el marcador de WooCommerce (03 §11).
- 9 `nav_menu_item` huérfanos, `wp_navigation` 5 y 29, restos de plantillas de Twenty Twenty-Two y de «theme-1» (`wp_template_part` 30-32 y 588, `wp_template` 33), 4 `wp_global_styles` vacíos, el `custom_css` vacío (03 §3.3, §10, §2).
- La importación y la categoría de demostración de Feedzy (818, 819), la categoría «Colecciones Adultos», el formulario CF7 268 de fábrica (03 §8.2, §9, Anexo A).
- La etiqueta «Historia Postal Guerra Civil Española Correo submarino» se sustituye por las taxonomías nuevas.
- Duplicados de medios listados en 03 §11 (tras comprobar cuál se usa).

### 4.4 Redirecciones 301 (van en el plugin compañero, versionadas)

El mapa se guarda en `museopostal-coleccion` como array `viejo => nuevo` y se aplica en `template_redirect` antes del 404 (05 §4.3). Se comprueba con `curl -sI` sobre las 23 páginas y 2 entradas y se demuestra que el control negativo (una URL inventada) sigue dando 404.

| URL actual | Destino |
|---|---|
| `/proximamente-pagina-principal/` | `/` |
| `/contenedor-de-blog/` | `/articulos/` |
| `/elementor-548/`, `/carrito/`, `/tienda/`, `/producto/125-aniversario-submarino-peral/`, `/producto/marcas-utilizadas-por-la-censura-postal-nacional-de-1936-a-1945/` | `/el-museo/publicaciones/` |
| `/elementor-573/`, `/politica-privacidad` | `/politica-de-privacidad/` |
| `/elementor-662/` | `/aviso-legal/` |
| `/politica-de-cookies-ue/` | `/politica-de-cookies/` |
| `/museos-del-mundo/` | `/investigacion/museos-postales-del-mundo/` |
| `/elementor-854/` | `/sala/el-correo-en-la-pintura/` |
| `/elementor-821/` | `/pieza/san-jeronimo-leyendo-una-carta/` |
| `/elementor-821-copy/` | `/pieza/la-carta-de-amor/` |
| `/cuadro_1-copy/` | `/pieza/las-ultimas-diligencias-del-correo-en-newcastle/` |
| `/cuadro_1-copy-2/` | `/pieza/el-cartero-del-pueblo/` |
| `/jean-baptiste-simeon-chardin/` | `/pieza/una-mujer-sellando-una-carta/` |
| `/eclipse-solar-agosto-2026-filatelia-correos-espana/` | `/articulos/los-eclipses-solares-en-la-filatelia/` |
| `/video-conferencias-historia-postal-y-filatelia/` | `/investigacion/videoteca/` |
| `/museo_murcia/` | `/sala/region-de-murcia/` |
| `/pagina_wasap/` | `/coleccion/comparte-tu-pieza/` |
| `/la-tarjeta-del-soldado/` | `/aula/la-tarjeta-del-soldado/` |
| `/formulario_informacion/` | `/contacto/` |
| `/padre_museo/`, `/investigacion-copy/` | `/` |
| `/el-wi-fi-del-siglo-xix/`, `/el-correo-en-los-ultimos-2000-anos/` | `/articulos/el-wi-fi-del-siglo-xix/` |
| `/el-correo-submarino-2/`, `/el-correo-submarino/` | `/articulos/el-correo-submarino/` |
| `/author/felipe/` | `/el-museo/` (y se cambia el `user_nicename`) |

---

## 5. Modelo de contenido

Principio: **pocos tipos, campos claros, todo editable por Felipe desde el editor de bloques** (01 §5). El contenido vive en el plugin `museopostal-coleccion`, no en el tema, para sobrevivir a cualquier cambio de tema (05 §2.2). Aquí se resuelve la diferencia entre 01 (7 tipos de contenido) y 05 (1 tipo): **un solo CPT `pieza`**, `sala` como taxonomía, y todo lo demás como páginas con patrones hasta que el volumen justifique otro tipo (regla: un CPT nuevo solo cuando haya más de 10 elementos de esa clase). Los recorridos, las actividades del Aula, la videoteca y la biblioteca empiezan como páginas.

### 5.1 Tipo de contenido `pieza`

```php
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
```

- **Título:** normalizado (02 patrón 4). Sellos: «[valor] [motivo], [formato], [país], [año]». Ejemplo: «0,54 € 125 aniversario del submarino Peral, sello suelto, España, 2014». Historia postal: «[Tipo] de [origen] a [destino], [fecha]». Ejemplo: «Carta de Águilas a Murcia, 18 de junio de 1866». Obras: título en español y original entre paréntesis.
- **Imagen destacada:** el **anverso** (obligatoria). Con margen de fondo alrededor del dentado (02 patrón 6).
- **Extracto:** resumen de una frase (aparece en tarjetas, resultados y `meta description`).
- **Contenido (editor):** el texto «Qué nos cuenta» (150-400 palabras, 01 §5.1) y, si hace falta, una galería `core/gallery` de detalles con pie.

**Metadatos** (`register_post_meta('pieza', …, ['type'=>'string','single'=>true,'show_in_rest'=>true,'auth_callback'=>…])`; clave con prefijo `mp_` y sin guion bajo inicial, condición de los *block bindings*, 05 §2.2). Solo los marcados **(obl.)** son obligatorios. Los grupos B, C y D se muestran u ocultan en el editor según el término de `tipo`.

| Grupo | Clave | Tipo | Contenido |
|---|---|---|---|
| **A. Identificación** | `mp_inventario` **(obl.)** | string | Número de inventario `MPF-AAAA-NNN` (año de alta + secuencia; 02 patrón 12). Único; el plugin avisa si se repite. |
| | `mp_fecha` **(obl.)** | string `AAAA-MM-DD` (se admite `AAAA` o `AAAA-MM`) | Fecha de emisión (sellos) o de circulación (piezas circuladas) o de creación (obras). Alimenta la efeméride del día y el orden cronológico. |
| | `mp_procedencia` **(obl.)** | enum: `coleccion-museo`, `donacion`, `prestamo`, `aportacion-visitante`, `imagen-terceros` | Origen (01 §5.2 «Fuente o colección», aquí como campo, no taxonomía). |
| | `mp_credito` | string | Crédito de la imagen o del aportante («Colección Felipe Martínez», «Aportación de M. P., Lorca»). |
| | `mp_derechos` **(obl.)** | enum: `cc-by-sa-4.0`, `cc-by-nc-4.0`, `dominio-publico`, `reservados` | Licencia de la imagen; decide si se muestra «Descargar» (02 patrón 8). Valor por defecto: el que elija Felipe (§10, pregunta 3). |
| | `mp_estado` | enum: `nuevo-sin-fijasellos`, `nuevo-con-fijasellos`, `nuevo-sin-goma`, `usado`, `pieza-completa`, `frontal`, `fragmento`, `no-aplica` | Conservación (01 §2.3). Se muestra en palabras, nunca solo con asteriscos. |
| | `mp_estado_obs` | string | «Sobre con doblez», «adelgazado», etc. |
| **B. Emisión** (tipo = sello, serie, hoja-bloque, pliego, spd, tarjeta-maxima, entero-postal) | `mp_pais` | string | «España, Correos» |
| | `mp_serie` | string | «Efemérides» |
| | `mp_catalogo` | string | Números de catálogo con prefijo, separados por «·»: «Edifil 4870 · Yvert 4590». Edifil siempre primero (01 §2.2). |
| | `mp_valor_facial` | string | «0,54 €», «4 cuartos», «tarifa A» |
| | `mp_color` | string | Para clásicos: «azul» |
| | `mp_formato` | string | «Sello», «Hoja bloque de 3 valores», «Carné» |
| | `mp_dimensiones` | string | «40,9 × 28,8 mm» |
| | `mp_dentado` | string | «13¾ × 13¼», «sin dentar» |
| | `mp_tecnica` | string | «Offset», «Calcografía», «Huecograbado», «Litografía», «Tipografía», «Combinada» (también se usa para la técnica de una obra) |
| | `mp_papel` | string | «Estucado, engomado, fosforescente» |
| | `mp_filigrana` | string | «Sin filigrana» |
| | `mp_diseno` | string | Diseñador o fuente de la imagen |
| | `mp_grabado` | string | Grabador |
| | `mp_imprenta` | string | «FNMT-RCM», «Oliva de Vilanova» |
| | `mp_pliego` | string | «25 sellos por pliego» |
| | `mp_tirada` | string | «70.000» |
| | `mp_variedades` | string | Variedades conocidas |
| **C. Circulación** (tipo = carta-sobre, tarjeta-postal, tarjeta-de-campana, entero-postal usado, matasellos-marca, documento) | `mp_origen` | string | «Águilas (Murcia)» |
| | `mp_destino` | string | «Murcia, Sociedad Minera La Generala» |
| | `mp_ruta` | enum múltiple en texto: `terrestre`, `ferrocarril-ambulante`, `maritimo`, `submarino`, `aereo`, `militar` | Medio |
| | `mp_franqueo` | string | «Edifil 81 + 85», «franquicia militar», «porte debido» |
| | `mp_tarifa` | string | Tarifa vigente y si es correcta |
| | `mp_marcas` | string multilínea | Una marca por línea: «Fechador ÁGUILAS 18 JUN 66, negro, frente»; «Verificato per censura, azul, reverso (Heller RC8.1)» |
| | `mp_censura` | string | «Sí: Posta Militare, 1918» o vacío |
| | `mp_transcripcion` | string multilínea | Transcripción o resumen del texto, solo si es histórico y público (01 §2.1 B: nunca datos de particulares vivos) |
| **D. Obra externa** (tipo = pintura, objeto, publicacion) | `mp_autor` | string | «Georges de la Tour (1593-1652)» |
| | `mp_titulo_original` | string | «Une femme qui cachette une lettre» |
| | `mp_estilo` | string | «Barroco francés (tenebrismo)» |
| | `mp_institucion` | string | «Museo del Prado» |
| | `mp_institucion_url` | string (URL) | Enlace a la ficha del museo depositario |
| **E. Imágenes** | `mp_reverso_id` | integer | ID de adjunto del reverso (opcional; en historia postal casi siempre existe, 01 §4.2) |
| | `mp_anotaciones` | string JSON `[{"n":1,"x":12.5,"y":40.2,"texto":"Fechador de Posta Militare"}]` | Puntos numerados sobre el anverso para las fichas guiadas del Aula (01 §4.2 punto 2). Coordenadas en % del ancho y alto. |
| **F. Interpretación y relaciones** | `mp_relacion_murcia` | string | Por qué está en la sala regional («Submarino construido en Cartagena») |
| | `mp_bibliografia` | string multilínea | Fuentes y enlaces |
| | `mp_orden_sala` | integer | Posición en el recorrido de su sala (1..n) |
| | `mp_relacionadas` | string CSV de IDs | Piezas relacionadas (boceto, SPD y TMAX de la misma emisión) |
| | `mp_articulo_id` | integer | Entrada que la estudia |

**Cómo se edita:** una caja «Ficha técnica» en la barra lateral del editor (meta box en PHP, sin JavaScript compilado), con los grupos plegables y los desplegables de los campos enumerados. Se aparta aquí del informe 05, que proponía *block bindings* para 5 campos, porque los enumerados (`mp_estado`, `mp_derechos`, `mp_procedencia`) y la ocultación por grupo no se resuelven con bindings; los bindings se usan solo en la tarjeta-resumen del patrón (4 datos clave). En el front, el bloque dinámico **`museopostal/datos-pieza`** (registrado solo en PHP con `render_callback`, 05 §2.2) pinta un `<dl>` con los campos rellenos y **oculta los vacíos** (02 patrón 5), en dos niveles: 4 datos clave arriba y un `<details>` «Todos los datos» debajo (02 patrón 9).

**Ficha impresa en la portada de cada pieza (patrón `ficha-pieza`)**, de arriba abajo: migas (Colección › Sala › Pieza) · H1 · tarjeta con anverso sobre montura y botones Anverso/Reverso/Detalle con zoom (lightbox del núcleo al principio, OpenSeadragon después si hace falta; 02 §8) · etiqueta de licencia y descarga · 4 datos clave · «Qué nos cuenta» · `<details>` con todos los datos · facetas enlazadas (época, lugar, tipo, tema; 02 patrón 10) · «En la misma sala» y «De la misma época», 4 piezas cada uno (Query Loop con «excluir la entrada actual», 05 §2.2; 02 patrón 11) · «Cómo citar esta pieza: [título]. Museo Postal y Filatélico de la Región de Murcia, n.º [inventario]. [URL], consultado el [fecha]» (02 patrón 12).

### 5.2 Taxonomías (todas con `show_in_rest => true`, asociadas a `pieza`; `epoca`, `lugar` y `tema` también a `post`)

| Taxonomía | Jerárquica | Términos iniciales (slug) | Uso |
|---|---|---|---|
| **`sala`** | sí | `antes-del-sello`, `region-de-murcia`, `correo-en-guerra`, `el-correo-en-la-pintura`, `sellos-que-cuentan-el-mundo`; `juegos-y-juguetes-postales` (creado, sin publicar en menú) | La sala de cada pieza. Metadatos de término (`register_term_meta`): `mp_sala_cabecera_id` (imagen macro), `mp_sala_orden` (orden en el índice), `mp_sala_comisario`. La descripción del término es el texto de sala. Plantilla `taxonomy-sala.html`. Se elige taxonomía y no CPT (01 proponía CPT) porque el listado automático de piezas, las migas y las facetas salen gratis, y el texto de sala cabe en la descripción del término (05 §2.3). |
| **`tipo`** (tipo de objeto) | no | `sello`, `serie`, `hoja-bloque`, `pliego-minipliego`, `spd`, `tarjeta-maxima`, `entero-postal`, `carta-sobre`, `tarjeta-postal`, `tarjeta-de-campana`, `matasellos-marca`, `documento`, `pintura`, `objeto`, `publicacion` (01 §5.1) | Decide qué grupos de la ficha se muestran; archivo `/tipo/<slug>/`. |
| **`epoca`** | no (orden por término meta `mp_epoca_inicio`) | `antiguedad-y-edad-media` (hasta 1504) · `correo-de-postas` (1505-1716) · `correo-de-la-corona` (1717-1849) · `isabel-ii` (1850-1868) · `sexenio-y-primera-republica` (1868-1874) · `restauracion` (1875-1931) · `segunda-republica` (1931-1936) · `guerra-civil` (1936-1939) · `posguerra-y-franquismo` (1939-1975) · `democracia` (1975-2001) · `euro` (2002-hoy) | Se adopta la lista de 01 §5.2 (11 términos, cortes coincidentes con el catálogo FESOFI por reinados) y no la de 5 tramos de 02 patrón 13, porque el público filatélico busca por reinado; la portada de Colección agrupa visualmente en 5 bloques. |
| **`lugar`** | sí | `region-de-murcia` › `cartagena`, `murcia`, `lorca`, `aguilas`, `la-union`, `jumilla`, `molina-de-segura`, `torre-pacheco`, `cabo-de-palos`; `espana` › provincias según haga falta; `mundo` › países | Facetas y futuro mapa de la Región (01 §5.2). |
| **`tema`** | no | `submarinos-y-marina`, `guerra-y-censura`, `astronomia-y-eclipses`, `pintura-y-arte`, `musica`, `juegos-y-juguetes`, `ferrocarril`, `mineria`, `fiestas-y-tradiciones`, `personajes`, `deporte` (01 §5.2) | Navegación casual y recorridos temáticos. |

No se crean ahora: «clase filatélica» FIP (útil para expertos; se añade como término de `tema` o taxonomía propia cuando haya exposiciones en formato de competición, 01 §1.3), «persona» (grabador/dibujante; 02 patrón 10) ni «fuente» (es el campo `mp_procedencia`).

### 5.3 Páginas con patrón (en lugar de más CPT)

| Patrón (`patterns/*.php`, bloqueados `contentOnly`) | Para | Bloques |
|---|---|---|
| `recorrido` | `/recorridos/<slug>/`: relato ordenado de 6-12 piezas (01 §5.1 tipo 3; 02 patrón 18) | Cabecera macro · intro · pasos repetibles (imagen de la pieza enlazada + 80-150 palabras + fecha/lugar opcional) · créditos · PDF descargable opcional |
| `actividad-aula` | `/aula/<slug>/` (01 §5.1 tipo 5) | Nivel (Primaria/ESO/Bachillerato/adultos) · materias · duración · objetivos · pieza(s) con anotaciones numeradas (`mp_anotaciones`) · desarrollo · preguntas · solucionario (en `<details>`) · descargable |
| `videoteca-item` | Entradas de `/investigacion/videoteca/` (01 §5.1 tipo 6) | Título · ponente · entidad · fecha · duración · resumen · vídeo con fachada de clic (`museopostal/video`, §7.4) · piezas relacionadas |
| `recurso` | Entradas de `/investigacion/biblioteca/` (01 §5.1 tipo 7) | Tipo (PDF propio, libro, catálogo, revista, enlace) · autor · año · editorial · ISBN · archivo o URL · licencia |
| `museo-del-mundo` | Directorio (03 §13 punto 2) | Foto (alt ya correcto) · nombre · ciudad · web · estado real |
| `sala-intro`, `portada-*`, `articulo` | Portada y salas (05 §2.3) | Ver §6 |

**Entradas (`post`)**: los artículos. Categorías: «Artículos», «Exposiciones» (para efemérides como los eclipses, 05 §2.3). Campos añadidos al artículo: `mp_piezas` (CSV de IDs citadas), `mp_fuentes`, `mp_revisado` (fecha de revisión), según 01 §5.1 tipo 4.

**Aportación de visitante**: el formulario de «Comparte tu pieza» (CF7 con subida de 2 imágenes ≤ 10 MB, localidad, texto libre, casilla de permiso de publicación y de crédito, casilla de privacidad). Llega por correo; Felipe crea la Pieza en borrador con `mp_procedencia = aportacion-visitante`. Crear la pieza automáticamente (01 §5.1 tipo 9) queda para después: YAGNI hasta que lleguen aportaciones.

**Producto (WooCommerce)**: solo si Felipe decide mantener la tienda (§8.3). En ese caso, `mp_producto_id` en la pieza y un campo de relación en el producto.

### 5.4 Convenciones de archivo y nombres

- Ficheros de imagen: `{año}_{edifil}_{variante}.{ext}` con variante `SELLO`, `HB`, `SPD`, `SPD-MUR`, `TMAX`, `MAT`, `ANV`, `REV`, que es la costumbre que Felipe ya tiene (`775_sellos`, `3129_HB`, `1983_2690_SPDMurcia`; 01 §5.1).
- Escaneos a 600 ppp mínimo (1200 para detalles macro), con margen de fondo neutro alrededor del dentado; el original se guarda fuera del hosting (02 antipatrón 10).
- `alt` obligatorio y descriptivo en cada imagen de pieza («Sello azul de 4 cuartos, Isabel II, matasellado en Águilas»; 02 antipatrón 7). Hoy 118 de 143 medios no lo tienen (04 P1-7).

---

## 6. Principios de diseño y sistema visual

### 6.1 Principios

1. **La pieza es la protagonista.** Imagen grande sobre fondo neutro que deja ver el dentado entero; `object-fit: contain`; nunca `cover` ni esquinas redondeadas en imágenes de pieza (02 patrón 6).
2. **Ninguna imagen generada por IA de material postal, nunca.** Cada tarjeta de sala usa una pieza real escaneada (04 P0-5; 02 patrón 3).
3. **Portada-vestíbulo, no blog:** H1, misión en una frase, 5 puertas, efeméride del día, pieza al azar, cifras de la colección («142 piezas · 5 salas»). Sin carrusel (02 patrones 1, 15, 16, 17; antipatrón 1).
4. **Un sistema de tarjeta:** imagen real, título, una línea de contexto. Bordes finos o ninguno, mucho aire, el logo una sola vez (04 P1-3).
5. **Lectura:** cuerpo en redonda de 18-20 px, interlineado 1,5-1,6, 60-75 caracteres por línea; la cursiva solo para citas y títulos de obra (04 P1-1).
6. **Dos familias tipográficas autoalojadas** con 3-4 pesos; nada de caligráficas en títulos (04 P1-2, T6). Se resuelve aquí la duda de 02 §7.4 (tercera familia monoespaciada para números): **no**; los números de inventario y catálogo usan cifras tabulares de la sans (`font-variant-numeric: tabular-nums`).
7. **Un solo motivo gráfico ornamental**, el filete dentado (perforación) en CSS como separador, con moderación (02 §7.1).
8. **Contraste ≥ 4,5:1 en todo texto**; el oro solo en filetes, nunca texto ni fondo (04 §3 punto 3, T7).
9. **Coherencia entre páginas:** mismo ancho de contenido (máx. 1140 px; texto a 70 caracteres), migas en todas las interiores, 1 H1 visible en cada página (04 P2-8).
10. **Todo funciona sin JavaScript:** `<details>` para «todos los datos», fachada de vídeo con clic, pieza al azar por redirección 302 (02 patrones 9, 17). El JS total ≤ 80 KB comprimido (T3).

### 6.2 Tres direcciones candidatas

Las tres se implementan como **variaciones de estilo del mismo tema** (`styles/album.json`, `styles/estafeta.json`, `styles/sala-blanca.json`), de modo que la maqueta es el tema real en Playground y Felipe elige mirando la portada, una sala y una ficha en escritorio y móvil. Los contrastes están calculados con la fórmula WCAG en 02 §7 (control positivo: negro sobre blanco 21:1).

#### A. «Álbum» (gabinete del coleccionista) · **recomendada**

- **Idea:** un álbum de colección bien montado. Papel crema, piezas en montura negra, tinta azul y granate de sello antiguo. Continúa la paleta que Felipe eligió y que 04 §3 manda conservar.
- **Paleta:**

  | Uso | Hex | Contraste |
  |---|---|---|
  | Fondo papel | `#F4EAD5` | — |
  | Fondo claro (fichas, bloques) | `#FBF6EC` | — |
  | Texto | `#2B2320` | 12,89:1 sobre papel |
  | Titulares y enlaces (tinta) | `#1A2E44` | 11,58:1 |
  | Acento granate | `#8A1538` | 7,83:1; papel sobre granate 7,83:1 |
  | Texto secundario | `#6B5F55` | 5,18:1 |
  | Montura de pieza | `#1B1B1B` | papel sobre montura 14,42:1 |
  | Oro (solo filetes) | `#B08D2E` | 2,63:1 (por eso nunca texto) |

- **Tipografías:** **Newsreader** (serif con eje óptico 6-72) para titulares y cuerpo largo; **Public Sans** (sans institucional, 100-900) para menú, fichas y botones. Alternativa serif: Source Serif 4. Ambas con subconjunto `latin` (cubre á é í ó ú ü ñ ¿ ¡ « » €), autoalojadas en woff2 variable: 4-5 ficheros frente a los 46 actuales (02 §7.5).
- **Imagen:** piezas sobre montura negra con margen generoso, como el NPM; reverso junto al anverso; filete dentado como único ornamento; ni textura de papel ni medallones.
- **Mood:** sereno, cálido, de coleccionista.
- **A favor:** continuidad para Felipe y para quien ya conoce el sitio; la montura negra hace brillar sellos de cualquier color; dos familias; contrastes holgados.
- **En contra:** riesgo de «antiguo» si se abusa del ornamento; el crema ensucia fotos de sobres blancos (usar montura negra o gris `#EDEBE6` en las fichas); menos juvenil para el Aula.

#### B. «Estafeta» (documental, sello fechador)

- **Idea:** una oficina de correos y un archivo de trabajo. Rótulos condensados de ventanilla, datos en letra de máquina, rojo lacre y azul de matasellos sobre kraft.
- **Paleta:**

  | Uso | Hex | Contraste |
  |---|---|---|
  | Fondo kraft | `#EDE3CF` | — |
  | Texto (negro tinta) | `#1C1B19` | 13,51:1 |
  | Acento lacre | `#A4262C` | 5,70:1; blanco sobre lacre 7,26:1 |
  | Azul matasellos | `#24466B` | 7,62:1; blanco sobre azul 9,71:1 |
  | Grafito secundario | `#55524C` | 6,11:1 |
  | Mostaza buzón (solo fondo con texto negro) | `#E3B23C` | 8,77:1 con negro; 1,54:1 sobre kraft: prohibido como texto |

- **Tipografías:** **Archivo** (eje de anchura 62-125 y peso 100-900) para titulares condensados y cuerpo; **IBM Plex Mono** para metadatos (fechas, Edifil, inventario), que imita el fechador. Con serif para lectura larga serían tres familias: habría que elegir.
- **Imagen:** piezas a tamaño real sobre kraft con sombra mínima en rejilla de clasificador; fechador circular en SVG con la fecha de cada pieza; fotos de archivo en duotono azul.
- **Mood:** didáctico, activo, de taller. Encaja con el Aula y «Comparte tu pieza».
- **A favor:** identidad muy reconocible; la letra de máquina ordena los datos; atrae al público escolar.
- **En contra:** la tematización puede parecer disfraz; el amarillo recuerda a la marca Correos (hay que evitar su amarillo corporativo y la corneta); el kraft baja el contraste de fotos claras; tres familias si se añade serif.

#### C. «Sala blanca» (museo contemporáneo)

- **Idea:** una sala de exposición moderna, como el Rijksmuseum o el Met. Blanco, aire, piezas grandes sobre gris claro y un solo acento granate.
- **Paleta:**

  | Uso | Hex | Contraste |
  |---|---|---|
  | Fondo | `#FFFFFF` | — |
  | Fondo alterno | `#F7F6F3` | — |
  | Paspartú de pieza | `#EDEBE6` | granate sobre él 7,85:1 |
  | Texto | `#1F1F1F` | 16,48:1 |
  | Texto secundario | `#5E5E5E` | 6,48:1 |
  | Acento granate | `#8A1538` | 9,35:1; blanco sobre granate 9,35:1 |

- **Tipografías:** **Instrument Serif** (display, solo H1 y H2) y **Atkinson Hyperlegible Next** (diseñada para baja visión, 200-800) para todo lo demás. Alternativa: Inter.
- **Imagen:** pieza muy grande sobre paspartú gris; cabeceras de sala con detalle macro a sangre; ningún adorno.
- **Mood:** sobrio, moderno, «museo de verdad».
- **A favor:** la más fácil de mantener coherente; envejece bien; Atkinson ayuda en el Aula y a mayores.
- **En contra:** exige escaneos limpios y calibrados porque no hay dónde esconder un mal recorte; puede resultar fría o genérica; pierde la identidad cálida que Felipe ya eligió; Instrument Serif solo tiene un peso.

### 6.3 Recomendación: «Álbum»

Tres razones (02 §7.4): conserva la paleta que ya funciona (granate sobre crema 7,83:1) y que Felipe eligió; la montura negra resuelve cómo presentar sellos de cualquier color, que es el problema central de un museo filatélico; con dos familias y un solo motivo gráfico cumple T6 sin discusión. «Sala blanca» es la reserva si los escaneos resultan uniformes y Felipe prefiere un aire más institucional; «Estafeta» aporta una idea que se puede tomar prestada en Álbum sin cambiar de dirección: el fechador SVG con la fecha de la pieza como marca de ficha, si la maqueta demuestra que no sobrecarga.

### 6.4 Logo y favicon

Se conserva el concepto del logo granate (sello dentado, lupa sobre el mapa de Murcia, corona de laurel y corneta; `LOGOMUSPOS1.jpg`, 587) y se redibuja en SVG con fondo transparente, más una versión horizontal para la cabecera y un favicon. El azul «MUPO» (`logotipo-mupo.png`) queda descartado. Hoy no hay favicon y el logo es un JPEG con fondo verdoso que se ve como un cuadrado (04 P2-1; 03 §2). El logo aparece una sola vez por pantalla.

---

## 7. Requisitos no funcionales

### 7.1 Rendimiento (T1-T4)

- LCP ≤ 2,5 s móvil, TTFB ≤ 0,6 s, ≤ 500 KB y ≤ 25 peticiones en portada, ≤ 3 CSS y ≤ 5 JS (04 §4).
- Caché de página real que acierte (`x-microcache: HIT` o equivalente de Webempresa) y `cache-control` en el HTML; hoy siempre `EXPIRED` (04 §1.1). Con 6-8 plugins el opcache deja de estar lleno (hoy 128 de 128 MB, 05 §1).
- Fuentes autoalojadas en woff2 variable, subconjunto `latin`, `font-display: swap`, precarga de las dos primeras.
- Imágenes en WebP generadas por Imagick del servidor con `image_editor_output_format` en el plugin; `srcset` del núcleo; `loading="lazy"` salvo en el LCP; el logo en SVG (05 §5; 04 §1.3: hoy el logo de 293 px pesa 156 KB).
- Sin jQuery, sin frameworks, sin CSS de bloques que no se usan (el tema de bloques carga CSS por bloque solo cuando aparece, 05 §2.1).
- CLS ≤ 0,01, que ya se cumple y hay que mantener (04 §1.2).

### 7.2 Accesibilidad (WCAG 2.2 AA; T7-T9)

- 1 H1 por página, sin saltos de nivel; `lang="es-ES"`; «Saltar al contenido» (ya existe) (04 P1-7).
- Alt descriptivo en el 100 % de imágenes de contenido; `alt=""` en decorativas.
- Contraste ≥ 4,5:1 texto, ≥ 3:1 bordes; objetivos táctiles ≥ 44×44 px.
- Formularios con `<label for>` asociado (hoy CF7 no lo hace, 04 P1-7); mensajes de error en texto.
- Sin *overlay* de accesibilidad: la accesibilidad la da el tema (02 antipatrón 8; Pojo Accessibility se retira).
- Listas de definiciones semánticas en la ficha (`<dl>`), migas con `aria-label`, enlaces que abren pestaña nueva avisándolo (04 P2-5).
- Página «Accesibilidad» con el estado real (02 patrón 22). Más adelante, «El museo en lectura fácil» (02 patrón 21).
- Comprobación en CI: axe o pa11y sobre las plantillas renderizadas en Playground, con un control que falle a propósito la primera vez (02 antipatrón 9).

### 7.3 SEO

- **Un solo plugin de SEO** (Yoast; AIOSEO se retira tras comprobar que su tabla propia no guarda títulos personalizados, 05 §5 y §10). Un canónico, un bloque Open Graph, un JSON-LD (04 P1-6).
- Títulos editoriales por plantilla: pieza «[Título] · [Sala] · Museo Postal de la Región de Murcia»; `meta description` = extracto, escrito a mano en cada sala y pieza.
- Slugs legibles y mapa 301 completo (§4.4). `robots.txt` con un solo grupo y un solo sitemap; Padre_museo y compañía desaparecen del `page-sitemap.xml` (04 P1-6).
- JSON-LD `Museum` en «El museo» y `CreativeWork`/`VisualArtwork` en las piezas, con `identifier` = inventario. `og:site_name` con el lema nuevo, no el caducado.
- Search Console: si Site Kit se retira, volver a verificar por DNS antes de quitarlo (05 §5).

### 7.4 Privacidad y consentimiento (T5)

- **0 peticiones a terceros sin acción del visitante.** Fuera Clarity, MonsterInsights, el píxel de Reddit, UserFeedback y Google Fonts (04 P0-4; 05 §5). Hoy la IP del visitante llega a Google por las fuentes sin consentimiento (LG München I, 20-01-2022, 3 O 17493/20).
- **Un solo banner de cookies como máximo, y solo si hace falta.** Recomendación: analítica sin cookies y autoalojada (Koko Analytics con la cookie desactivada, a verificar, 05 §5 (b)) o ninguna, de modo que no haya cookies no exentas y **no haga falta banner**; la política de cookies pasa a texto fijo. Si Felipe quiere conservar GA4, se conserva **solo Complianz** con Site Kit, con «Rechazar» y «Aceptar» del mismo peso visual y texto ≥ 14 px, según la guía de cookies de la AEPD (04 P1-5; 02 patrón 22). WPConsent y «Protección de datos RGPD» se retiran en cualquier caso (04 P0-4). Antes de retirar el banner conviene una confirmación con criterio legal (05 §10 punto 5).
- **Vídeos:** bloque `museopostal/video` (PHP) con póster local y carga de `youtube-nocookie.com` solo al hacer clic; así la videoteca se ve sin aceptar nada, al contrario que hoy (04 P0-2).
- **Datos del titular:** correo del dominio (p. ej. `contacto@museopostal.org`) en lugar del Gmail personal; formulario en lugar del móvil por WhatsApp; DNI y domicilio completo solo si la LSSI lo exige por actividad económica, y eso depende de la decisión sobre la tienda (04 P1-11; 03 §12.1).
- **Formularios:** `Reply-To` del visitante, doble opt-in si hay boletín, enlace a privacidad que funcione, sin CSS incrustado (03 §8.1).
- **Comentarios cerrados** en todo el sitio (hoy abiertos con Akismet inactivo, 04 P1-12).
- `WP_DEBUG_DISPLAY` a falso; ningún *embed* de redes (02 antipatrón 5).

### 7.5 Móvil

- Menú hamburguesa solo en móvil, con buscador dentro (hoy el buscador no existe en móvil, 04 P0-3).
- Tarjetas a 1 o 2 columnas, objetivos ≥ 44 px, texto ≥ 16 px en todo control (04 T9).
- Banner, si lo hay, ≤ 25 % del alto; hoy tapa el 44 % (04 P1-4).
- Ficha de pieza legible a 390 px: imagen a todo el ancho, `<dl>` en una columna, botones Anverso/Reverso visibles sin desplazar.
- Capturas automáticas a 1440 y 500 px en cada PR para comparar con `/tmp/felipe/shots/*.png` (05 §7).

### 7.6 Robustez y continuidad (02 antipatrón 10)

- Dominio con renovación automática a nombre del museo; TLS automático de Webempresa.
- Contenido en tipos estándar de WordPress con exportación WXR mensual guardada fuera del hosting; copia de los escaneos originales fuera del hosting.
- Sin dependencias de terceros en el tema ni en el plugin salvo `plugin-update-checker` (MIT).
- Revisión de enlaces salientes en cada release (el museo de Correos acabó con enlaces de casas de apuestas en portada, 02 §2.3).

---

## 8. Ruta técnica recomendada

Se adopta la **opción A** del informe 05: tema de bloques propio + plugin compañero, sin Elementor, sin licencias, reversible (05 §0, §2.1). Se descartan mantener Elementor (conserva la causa del problema), un tema clásico PHP (cada ajuste de cabecera vuelve al código) y headless/estático (maquinaria sin problema que la justifique para 25 páginas).

### 8.1 Tema `museopostal` (tema de bloques, `theme.json` v3)

```
theme/museopostal/
  style.css            Theme Name, Version, Requires at least: 7.1, Requires PHP: 8.1, License: GPL-3.0-or-later, Text Domain, Update URI
  theme.json           settings.color.custom=false, typography.customFontSize=false, fontFace local, paleta cerrada, tamaños cerrados
  styles/album.json  styles/estafeta.json  styles/sala-blanca.json     las tres direcciones (§6.2)
  functions.php        categorías de patrones, estilos de bloque, formato WebP, tabular-nums
  templates/           index, front-page, home (artículos), single, page, archive, search, 404,
                       single-pieza, archive-pieza, taxonomy-sala, taxonomy-epoca, taxonomy-lugar, taxonomy-tipo, taxonomy-tema
  parts/               header.html, footer.html
  patterns/            ficha-pieza, sala-intro, recorrido, actividad-aula, videoteca-item, recurso, museo-del-mundo, articulo, portada-*
  assets/fonts/        woff2 (Newsreader, Public Sans; latin)
  screenshot.png
```

Reglas: paleta y tipografías cerradas para que Felipe no pueda romper el diseño (05 §2.1); patrones bloqueados `contentOnly`; slug distinto de `theme-1` para no heredar las plantillas guardadas del intento anterior (05 §2.3). Regla para Felipe: **editar contenido y patrones, no plantillas**, porque una plantilla editada en el Editor del sitio se guarda en la BD y tapa las actualizaciones del tema hasta «Restablecer» (05 §2.3, §10 punto 8).

### 8.2 Plugin `museopostal-coleccion`

Registra: CPT `pieza`, las 5 taxonomías y sus términos iniciales, los metadatos `mp_*` y sus metaboxes, los bloques PHP `museopostal/datos-pieza`, `museopostal/video`, `museopostal/cifras` (piezas y salas publicadas, 02 patrón 15), `museopostal/efemeride` (pieza cuyo día y mes coincide con hoy, 02 patrón 16) y `museopostal/pieza-al-azar` (redirección 302 en `/?pieza-al-azar`, 02 patrón 17); el mapa de redirecciones 301 (§4.4); el formato WebP; el cierre de comentarios; el patrón de título sugerido; y `plugin-update-checker` apuntando a las Releases públicas de `GeiserX/museopostal` (05 §3.3). Cabecera con `Update URI`. Unas pocas centenas de líneas de PHP, sin `npm`, sin compilar (05 §2.2).

### 8.3 Plugins: estado final

Objetivo: **≤ 8 activos** (frente a 26). Lista final:

| Se queda | Motivo |
|---|---|
| `museopostal-coleccion` | El modelo del museo |
| `wordpress-seo` (Yoast) | Un solo SEO; caja de metadatos para Felipe (05 §5) |
| `contact-form-7` | Contacto y «Comparte tu pieza» |
| `really-simple-ssl` | HTTPS y endurecimiento (revisar su opción de contraseñas de aplicación) |
| Analítica sin cookies (`koko-analytics`, a verificar) **o** `complianz-gdpr` + `google-site-kit` | Según la decisión de Felipe (§7.4) |
| `duplicator` | **Solo durante la migración**; se desactiva después |

**Se retiran** (05 §5, tabla completa con riesgos): `elementor`, `essential-addons-for-elementor-lite`, `bdthemes-element-pack-lite`, `royal-elementor-addons`, `templately`, `woocommerce-products-filter` (HUSKY: 46 de los 127 ficheros de la portada para 2 productos), `reddit-for-woocommerce`, `all-in-one-seo-pack`, `google-analytics-for-wordpress` (MonsterInsights), `microsoft-clarity`, `userfeedback-lite`, `feedzy-rss-feeds`, `cool-timeline`, `timeline-block`, `wpforms-lite`, `image-optimization`, `wpconsent-cookies-banner-privacy-suite`, `proteccion-datos-rgpd`, `complianz-terms-conditions`, `akismet`, `optimole-wp`, `pojo-accessibility`.

**WooCommerce: decisión de Felipe, recomendación retirar.** 0 pedidos, 2 productos, sin carrito ni checkout ni cuenta, fichas en «tienda en obras» (03 §7.2). Sustituto: página «Publicaciones» con los dos artículos y un botón «Pídelo por correo» (o un enlace de pago externo), y redirección de `/producto/*` (05 §5). Si se mantiene, hay que completarla (carrito, pago, desistimiento y devoluciones, precio de la variante «Usado») y relegarla al pie, nunca al menú ni a la cabecera (04 P1-9). Al retirar WooCommerce desaparece probablemente el endpoint MCP `/wp-json/mcp`, que no se necesita (05 §8).

**Orden de retirada** (05 §5): primero los sin riesgo (HUSKY, Reddit, Royal, Templately, timelines, Feedzy, UserFeedback, Clarity, MonsterInsights, inactivos); después de convertir el contenido, los addons de Elementor y Elementor; por último WooCommerce, los legales y el SEO duplicado, uno a uno, comprobando portada y registro de errores tras cada uno.

### 8.4 Repositorio, CI y despliegue desde GitHub (sin SFTP)

Repositorio público **`GeiserX/museopostal`**, GPL-3.0 (05 §9):

```
theme/museopostal/                  plugin/museopostal-coleccion/
playground/blueprint.json           playground/muestra.xml (WXR saneado, solo contenido ya público)
docs/                               decisiones, guía de Felipe (fase 6), mapa 301
.github/workflows/ci.yml            php -l, validación de theme.json contra su esquema, axe/pa11y en Playground
.github/workflows/release.yml       zips con carpeta raíz fija + Release en cada tag v*
.github/workflows/pr-preview.yml    botón de WordPress Playground (WordPress/action-wp-playground-pr-preview@v3)
.github/workflows/screenshots.yml   capturas 1440/500 px como comentario de la PR
LICENSE
```

- Todo en `runs-on: ubuntu-latest` (repo público, gratis).
- **Release:** en cada tag `v*`, lint PHP, comprobación de que la versión del tag coincide con la de `style.css` y del plugin, zips `museopostal.zip` y `museopostal-coleccion.zip` con carpeta raíz fija (nunca el «Source code (zip)» de GitHub, cuya raíz `museopostal-v1.0.0/` rompe la sustitución), y `gh release create` con los zips (05 §3.2). La comprobación de versión se prueba en rojo una vez con un tag deliberadamente mal versionado: un check que no puede fallar no es un check.
- **Primera instalación:** Apariencia › Temas › Subir tema y Plugins › Subir plugin desde wp-admin (límite 128 MB; el tema pesará < 2 MB). Felipe puede hacerlo desde España sin túnel (05 §3.1).
- **Actualizaciones:** `plugin-update-checker` v5 en tema y plugin, con `enableReleaseAssets`; la actualización aparece en Escritorio › Actualizaciones y Felipe pulsa «Actualizar» (05 §3.3). Riesgo: quien controle la cuenta de GitHub controla el código del sitio; 2FA y tags protegidos obligatorios.
- **Acceso de Felipe al repositorio:** se le da **acceso de administrador** (usuario GitHub `felipemarsor-spain`) para que vea en directo todo lo que se hace y pueda hacer lo mismo. Como el repo es público, no contiene credenciales, exportaciones completas ni capturas de wp-admin (05 §7).
- **Previsualización en PR:** cada PR lleva el botón de Playground con el tema y el plugin de esa rama y `muestra.xml`; un job opcional arranca Playground en el runner y publica capturas a 1440 y 500 px. **No se hacen maquetas aparte:** los patrones y las variaciones de estilo son la maqueta (05 §7).

### 8.5 Staging y vuelta atrás (05 §6)

1. Superbackup del día, WXR (ya existe), paquete de Duplicator y Release fijada en GitHub.
2. WePanel › WP Center › **Clonar** a `pruebas.museopostal.org`; comprobar si el geobloqueo del panel afecta al clon. Ensayar allí la migración completa y anotar cada paso.
3. En producción, instalar plugin y tema **sin activarlos**; enseñárselos a Felipe con la **Vista previa en vivo** del Editor del sitio (05 §2.2).
4. Convertir el contenido (las páginas en bloques se ven bien también con Neve).
5. Activar el tema.
6. Retirar plugins por tandas.
7. Activar el mapa 301 y verificarlo con `curl`.

Vuelta atrás: reactivar Neve es un clic mientras Elementor y `_elementor_data` sigan ahí; cada conversión deja una revisión; Superbackup restaura por fecha sin subir ficheros (red principal); Duplicator Lite exige subir `installer.php` por el gestor de archivos (05 §6).

### 8.6 Lo que no se hace ahora

- MCP/Executor conectado al WordPress: no lo necesita el rediseño; el MCP por defecto no edita contenido; la cabecera `Authorization` no llega a PHP (revocar la contraseña de aplicación creada el 28-09 si no se usa) (05 §8).
- Script de conversión `_elementor_data` → bloques: con 22 páginas y 11 tipos de widget, la vía nativa «Convertir en bloques» basta (05 §4.2).
- IIIF y OpenSeadragon: el lightbox del núcleo primero (02 §8).
- CPT para recorridos, actividades, eventos y recursos: páginas con patrón hasta superar 10 elementos (§5).

---

## 9. Plan de fases con entregables verificables

| Fase | Qué | Entregable | Cómo se verifica |
|---|---|---|---|
| **F0 · Decisiones** (esta semana) | Felipe responde las 10 preguntas de §10; se fija la sala central, el tratamiento, la tienda y la analítica | `docs/decisiones.md` en el repo con cada respuesta y fecha | Las 10 tienen respuesta o «pendiente» explícito |
| **F1 · Cimientos** | Repo público con LICENSE GPL-3.0, tema esqueleto, plugin con CPT/taxonomías/meta/redirecciones, CI, release `v0.1.0`, Playground en PR, Felipe como administrador del repo | PR #1 con CI verde y botón Playground que abre el tema con `muestra.xml`; Release con los dos zips; instalación del zip probada en el clon | `unzip -l` muestra `museopostal/style.css`; el job de versión se ha visto en rojo una vez; el zip mínimo pasa el WAF de Webempresa (05 §10 punto 4) |
| **F2 · Tres direcciones** | `styles/album.json`, `estafeta.json`, `sala-blanca.json`; patrones de portada, sala y ficha con 6 piezas reales de muestra | 3 PR (una por dirección) con Playground y capturas 1440/500 | Felipe elige mirándolas en el móvil; contraste de cada variación verificado por script (≥ 4,5:1) |
| **F3 · Contenido** | Fichas de ≥ 40 piezas (texto de 03b más los ~40 escaneos sin publicar), términos, 5 textos de sala, textos legales nuevos, alt del 100 %, erratas de 03 §12.7 corregidas, videoteca con créditos, directorio de museos | `muestra.xml` ampliado; hoja de cálculo de piezas (inventario, título, sala, fecha, Edifil, estado, procedencia, derechos) | Script sobre el WXR: 0 alt vacíos en piezas, 0 campos obligatorios vacíos, ≥ 6 piezas por sala, inventarios únicos |
| **F4 · Migración en pruebas** | Clon en `pruebas.museopostal.org`; conversión de las 22 páginas y 2 entradas; activación del tema; retirada de plugins tanda 1 y 2; redirecciones | Guion de migración paso a paso (`docs/migracion.md`) probado de principio a fin en el clon | T1-T10 medidos en el clon con CDP y `curl`; `wget --spider` sin 404 internos; 0 dominios de terceros sin clic; mapa 301 al 100 % con control negativo |
| **F5 · Producción** | Superbackup, instalación, vista previa con Felipe, activación, retirada de plugins tanda 3 (WooCommerce, legales, SEO), redirecciones, Search Console, revocar contraseña de aplicación, desactivar Duplicator | Sitio en vivo con tema nuevo; `docs/post-lanzamiento.md` con las medidas | Repetir todas las medidas de F4 en producción y compararlas con las de 04 §1; `wp plugin list --status=active` ≤ 8 (o la lista equivalente de wp-admin) |
| **F6 · Guía y continuidad** (se escribe al final, como pidió Sergio) | Guía para Felipe: publicar una pieza, abrir una sala, un recorrido, una actividad del Aula, actualizar tema y plugin, qué no tocar (plantillas), copia mensual | `docs/guia-felipe.md` en el repo; sesión de 1 hora | Felipe publica una pieza nueva en < 15 min siguiendo la guía sin ayuda (C7) |

Cada fase termina con una Release etiquetada y un comentario en la PR con las cifras medidas, no con «debería funcionar».

---

## 10. Riesgos y preguntas abiertas para Felipe

### 10.1 Riesgos

| Riesgo | Mitigación |
|---|---|
| El WAF de Webempresa rechaza la subida de zips o el geobloqueo también cubre el clon | Probar un zip mínimo antes de F1; Felipe sube desde España; ticket a Webempresa si hace falta (05 §3.1, §10) |
| AIOSEO o «Protección de datos RGPD» guardan datos o inyectan textos que solo se ven en wp-admin | Revisar sus ajustes antes de retirarlos (05 §10 puntos 2 y 3) |
| Quitar Site Kit rompe la verificación de Search Console | Verificar por DNS antes (05 §5) |
| Felipe edita una plantilla en el Editor del sitio y las actualizaciones dejan de verse | Regla en la guía: contenido y patrones, no plantillas; «Restablecer» si ocurre (05 §2.3) |
| Curva de aprendizaje del editor de bloques | Patrones bloqueados, opciones cerradas en `theme.json`, guía con capturas, Playground para practicar sin riesgo |
| Derechos de las imágenes de pintura (Pollard y Hardy son «colección privada»; las de museos suelen ser dominio público) y de las fotos de museos del mundo | Campo `mp_derechos` y `mp_credito` obligatorios; página de créditos; retirar la imagen si no se puede acreditar (01 §2.1 C) |
| Retirar el banner sin cobertura legal | Confirmación con criterio legal antes de F5; mientras, Complianz solo (05 §10 punto 5) |
| Un solo administrador y una sola cuenta de GitHub controlan el sitio | 2FA en WordPress y GitHub, tags protegidos, WXR mensual fuera del hosting |
| Retirar WooCommerce elimina el endpoint MCP y las páginas legales de envío | Comprobarlo en el clon; no se necesita ninguno de los dos (05 §8, §10 punto 1) |

### 10.2 Preguntas para Felipe (10)

1. **Tienda:** ¿la retiramos y dejamos los dos artículos en «Publicaciones» con «pídelo por correo», o la completamos de verdad (carrito, pago, gastos de envío, desistimiento, precio de la variante «Usado»)? De esto dependen el menú, el pie, el aviso legal y el DNI (04 P1-9; 03 §7.2, §13).
2. **Analítica:** ¿aceptas prescindir de Google Analytics y Clarity a cambio de no tener banner de cookies (analítica sin cookies dentro de WordPress), o quieres conservar GA4 con un único banner de Complianz? (04 P0-4; 05 §5).
3. **Licencia de las imágenes propias:** CC BY-SA 4.0, CC BY-NC 4.0 o todos los derechos reservados. Decide si hay botón de descarga (02 patrón 8). Y: ¿qué piezas son de tu colección y cuáles son imágenes de terceros? (01 §Resumen).
4. **Datos legales:** ¿el museo es una persona física o va a ser asociación? ¿Podemos publicar solo nombre, domicilio de contacto y correo del dominio (`contacto@museopostal.org`), sin DNI ni móvil personal? (04 P1-11; 03 §12.1).
5. **Marco y voz:** ¿de acuerdo con «La Región de Murcia» como sala central y con el tratamiento de «tú» en todo el sitio? ¿Cómo quieres firmar: «Felipe Martínez, comisario» o «Conservador del Museo»? (§3.2).
6. **Dirección visual:** tras ver las tres en Playground (F2), ¿Álbum, Estafeta o Sala blanca? (§6).
7. **Datos que faltan para abrir salas:** nombre, ciudad y web de los 8 museos del carrusel; permiso o crédito de los 6 vídeos (SOFIMA, Afinet); quién fue Narciso García Yepes y qué cuentan «La Parranda» y el Cantón; qué son «Carteros honorarios», «El informe semanal» y «Juegos y juguetes postales»; qué pieza exacta es la tarjeta del soldado (03 §13).
8. **Tres comprobaciones filatélicas:** el Edifil del sello del Peral (la tienda dice 5317; el SPD del propio sitio apunta a 4870, emitido el 18-02-2014); el tamaño del sello del eclipse (33 × 53 mm frente a 79,2 × 105,6 de la HB); y el apellido del corresponsal del correo submarino («Werner Kell») (01 §3.8; 03 §13).
9. **Boletín:** ¿quieres una newsletter real? Si sí, ¿con qué servicio y con doble opt-in? Si no, quitamos la promesa de la portada (03 §5.1; 04 P1-8).
10. **Inventario y títulos:** ¿aceptas el formato `MPF-AAAA-NNN` (año de alta y secuencia) y la plantilla de título normalizado («0,54 € 125 aniversario del submarino Peral, sello suelto, España, 2014»)? ¿Quieres que los escaneos originales se guarden también fuera del hosting (dónde)? (02 patrones 4 y 12; §5.4).

---

## 11. Contradicciones entre informes y cómo se resuelven

| Punto | Informes | Resolución |
|---|---|---|
| Número de vídeos en Videoconferencias | 04 P0-2 dice «11 vídeos»; 03 §5.5 y 05 §4.1 dicen 6 (widgets `video` ×6 en el WXR, títulos por oEmbed) | **6.** El WXR es la fuente de verdad; el «11» viene del nombre del botón `11_conferencias.png` y de los marcadores de Complianz. |
| Tipos de contenido | 01 §5.1 propone 7 CPT + Producto; 05 §2.3 propone 1 CPT (`pieza`) y páginas | **1 CPT `pieza`** con todos los campos de 01, `sala` como taxonomía, el resto como páginas con patrón; un CPT nuevo solo al superar 10 elementos (§5). |
| `sala` como CPT o taxonomía | 01 CPT; 05 y 02 patrón 18 admiten ambas | **Taxonomía** con term meta (cabecera, orden, comisario): listados, migas y facetas gratis. |
| Períodos de `epoca` | 01 §5.2: 11; 02 patrón 13: 5 | **11 términos de 01** (coinciden con los reinados del catálogo FESOFI); la página Colección los agrupa en 5 bloques visuales. |
| Formato de inventario | 01 §5.1 `MP-0001`; 02 patrón 12 `MPF-AAAA-NNN` | **`MPF-AAAA-NNN`**: el año de alta documenta la procedencia, como hacen el NPM (`2011.2005.598`) y la Museumsstiftung (`2.2002.3519`). Pendiente de Felipe (§10.2 n.º 10). |
| Familias tipográficas | 04 T6 ≤ 2; 02 §7.4 sugiere una tercera monoespaciada | **2.** Cifras tabulares de la sans para números. |
| Analítica y banner | 04 recomienda ninguna o sin cookies; 05 deja dos caminos | **Recomendación: sin cookies y sin banner**; si Felipe conserva GA4, un único banner (Complianz). Nunca tres herramientas. |
| Edición de la ficha | 05 §2.2: block bindings a `core/post-meta` | **Meta box en PHP + bloque dinámico `datos-pieza`**; bindings solo para los 4 datos clave. Motivo: enumerados y grupos ocultos por tipo. |
| Nombre de la sala de Murcia | 05 §4.3 «El museo» (`/el-museo/`); 01 §5.4 «Sala de la Región de Murcia» | **«La Región de Murcia»** en `/sala/region-de-murcia/`; `/el-museo/` queda para «Quiénes somos». |
| Destino del Eclipse | 05 §4.3: entrada con categoría Exposiciones o sala temporal; 01 §5.5: artículo + piezas | **Artículo en «Exposiciones» + piezas** dentro de la sala «Sellos que cuentan el mundo». |
| `inventory.md` | 03, 04 y 05 dicen que no existía | Ahora existe y confirma 29 plugins, 26 activos, WordPress 7.1.2, PHP 8.4.17 y que la subida de zips funciona. Los tres informes dedujeron lo mismo del HTML, así que no hay conflicto de datos. |
| Premium Addons | 03 §10 detecta ajustes `pa_*` en el export | No está entre los 29 plugins (inv): son restos de un plugin ya desinstalado. Nada que retirar. |

---

## Resumen

- Hoy el sitio no es un museo: portada sin H1 y con tarjetas muertas, salas vacías o tapadas, medallones generados por IA con matasellos falsos, 26 plugins, 150 peticiones, rastreo antes del consentimiento y textos legales copiados de otro comercio.
- El nuevo sitio es un museo virtual con la Región de Murcia como sala central y cuatro salas de contexto (Antes del sello, Correo en guerra, El correo en la pintura, Sellos que cuentan el mundo), cuya unidad es la **pieza** con ficha filatélica completa, más Aula, Investigación y El museo. Menú de 5 entradas, portada-vestíbulo, ninguna imagen generada.
- Modelo: un CPT `pieza` con ~45 metadatos `mp_*` agrupados (identificación, emisión, circulación, obra, imágenes, relaciones) y 5 taxonomías (`sala`, `tipo`, `epoca`, `lugar`, `tema`); recorridos, Aula, videoteca y biblioteca como páginas con patrón.
- Dirección visual recomendada: **Álbum** (crema `#F4EAD5`, tinta `#1A2E44`, granate `#8A1538`, montura `#1B1B1B`; Newsreader + Public Sans autoalojadas), maquetada como variación de estilo junto a Estafeta y Sala blanca para que Felipe elija en Playground.
- Ruta técnica: tema de bloques `museopostal` + plugin `museopostal-coleccion` en `GeiserX/museopostal` (público, GPL-3.0, Felipe administrador), Releases con zips, actualizaciones vía `plugin-update-checker`, Playground en cada PR, ensayo en `pruebas.museopostal.org`, vuelta atrás con Superbackup y Neve. Plugins finales ≤ 8; WooCommerce se retira salvo que Felipe decida completarlo.
- **Siguiente paso:** F0, las 10 preguntas de §10.2 a Felipe; en paralelo, F1 (repo, esqueleto, CI, Playground). Las decisiones 1 (tienda), 2 (analítica) y 4 (datos legales) cambian el menú, el pie y la necesidad de banner, así que van primero.
