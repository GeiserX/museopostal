# 02 · Referentes web de museos: qué copiar y qué evitar en museopostal.org

Observado el 28-09-2026. Todas las URL se visitaron ese día salvo que se indique otra cosa.

## Resumen en llano

- **Los buenos museos postales tratan cada pieza como protagonista.** Le dan un título normalizado, una imagen grande sobre fondo neutro, una lista de datos y enlaces a piezas parecidas.
  - El Smithsonian titula así: «10ptas Black Rhinoceros single».
  - El Musée Postal de París añade valor facial, color, tirada, fechas de emisión y retirada, dibujante y grabador.
  - La Museumsstiftung alemana describe el recorrido de la carta, el remitente, el destinatario y los matasellos del anverso y del reverso.
  - Ese es el listón para la ficha de pieza de museopostal.org.
- **La portada de un museo es un vestíbulo, no un blog.** Lleva el nombre, una frase de misión, 3 o 4 puertas (salas, colección, aprender, actividades) y un gancho vivo, como la efeméride del día o una pieza al azar. Las noticias van al final, si van.
- **Los museos pequeños fallan por fragilidad, no por falta de diseño.** El 28-09-2026 encontramos:
  - un certificado caducado (MUFI, Oaxaca);
  - un dominio desaparecido (museodepostales.es);
  - un microsite de colección retirado (Cooper Hewitt);
  - enlaces de casas de apuestas en la portada del museo de Correos;
  - URL antiguas que dan 404 tras un cambio de nombre (Musée Postal);
  - un widget de Twitter roto a la vista (Museu de Lleida).

  Para museopostal.org, un sitio sobrio y bien mantenido pesa más que uno vistoso.
- **Propuesta:** 22 patrones concretos (§5), 10 antipatrones (§6) y tres direcciones visuales (§7):
  - **Álbum:** crema, granate y montura negra. Es continuista con la paleta actual.
  - **Estafeta:** kraft, lacre y tipografía de sello fechador. Es didáctica.
  - **Sala blanca:** blanco, gris y granate. Es contemporánea.

  Recomendación: **Álbum**, con la precisión de ficha de la Museumsstiftung y la portada-vestíbulo del Smithsonian.

---

## 0. Método, fuentes y límites

| Qué | Cómo |
|---|---|
| Navegación, estructura y fichas | Chromium real (Playwright MCP, perfil propio) con ventana de 1280×900 y, en dos casos, 390×844 para móvil. Leí el árbol de accesibilidad (encabezados, enlaces, formularios) e hice capturas. |
| Peso aproximado | `curl` del HTML con UA de Chrome: bytes transferidos comprimidos (`--compressed` en otra pasada) y bytes sin comprimir. Número de peticiones de la primera carga según el registro de red de Playwright, sin tocar el banner de cookies. **No hay bytes totales por página**: el registro no da tamaños, y medir cada recurso con `curl` no compensaba. Las cifras sirven para comparar, no para auditar. |
| Tipografías de Google | Metadatos oficiales `https://fonts.google.com/metadata/fonts` (campo `subsets`) y `unicode-range` del subconjunto `latin` servido por `fonts.googleapis.com/css2`. |
| Contrastes | Fórmula WCAG 2.x calculada en Python. Control positivo: negro sobre blanco da 21:1. El oro actual `#D4AF37` sobre la crema `#F4EAD5` da 1,76:1, el mismo valor que el [informe 04](04-auditoria-ux-ui.md). |

**Límites y bloqueos encontrados:**
- `postalmuseum.si.edu` y `www.postalmuseum.org` devuelven **403** a `curl` y a WebFetch. `www.metmuseum.org` devuelve **429** a WebFetch. `web.archive.org` no estaba disponible (429 y bloqueo). Todo eso se leyó con el navegador real.
- El menú de The Postal Museum va escondido tras una hamburguesa y el árbol de accesibilidad no lo expuso. Su arquitectura sale del pie y de las páginas internas.
- `mufi.org.mx` (Museo de Filatelia de Oaxaca): `NET::ERR_CERT_DATE_INVALID`. No se saltó el aviso.
- `museodepostales.es`: `DNS_PROBE_FINISHED_NXDOMAIN`, el dominio ya no existe.
- Mi conexión sale por un proxy local, así que los tiempos absolutos no valen (informe 04, §0). No se dan tiempos.
- Los tipos de letra exactos de cada web no se verificaron en su CSS. Se describen por familia: serif, sans, condensada.

---

## 1. Tabla resumen

| Referente | Menú principal (literal) | Peticiones 1.ª carga | HTML (transferido / sin comprimir) | Lección principal |
|---|---|---|---|---|
| Smithsonian National Postal Museum (NPM) | Visit · Exhibitions · Learn · Collections · About · Blog | ≈115 (portada) | 403 a `curl` | Portada-vestíbulo; ficha con número de catálogo en el título; imagen sobre fondo negro que enseña el dentado; exposición virtual en forma de álbum |
| The Postal Museum (Londres) | Hamburguesa + «Book now» | ≈82 | 403 a `curl` | «Pieza al azar del archivo» en el pie; «Reject all» al mismo nivel que «Accept all» |
| Museo Postal y Telegráfico (Correos) | Home · Historia · Salas Postales y Telegráficas · Exposiciones temporales / virtuales · Piezas Significativas (1…7) · Pinacoteca · Noticias · Biografías · Efemérides · Foro · Contacto | ≈84 | 403 a `curl` | Referente español directo y **antiejemplo**: menú de 11 entradas, «Piezas significativas 1…7», slider y bloque «ALIADOS» con enlaces de apuestas |
| Museum für Kommunikation Berlin | «MENÜ» (hamburguesa también en escritorio) + iconos | ≈66 | 64 KB / 393 KB | Horario y datos de visita en un bloque fijo; 4 carruseles apilados (antipatrón) |
| Museumsstiftung Post und Telekommunikation, Onlinesammlung | Stiftung · Museen · Sammlung › Sammlungsgebiete · Onlinesammlung · Detailsuche · Merkzettel | ≈24 (ficha) | 8,7 KB / 59,5 KB (portada) | **La mejor ficha de historia postal**: recorrido, remitente, destinatario, matasellos por cara, franqueo total, cita sugerida, CC BY-SA, CSV |
| Musée Postal (antes Musée de La Poste, París) | Visiter le musée · Expositions · Evénements & activités · Collections · Boutique en ligne · Privatisations + Billetterie | ≈114 | 11,7 KB / 72,8 KB | Ficha filatélica con facetas clicables; declaración de accesibilidad honesta; URL antiguas rotas tras el cambio de nombre |
| Rijksmuseum | Home · Discover · Art Explorer · Language · Login · Tickets (+ hamburguesa) | ≈110 (portada), >244 (colección) | 110 KB | Divulgación progresiva en la ficha (About / Data); relatos del público |
| The Met | Visit · Exhibitions and Events · Art · Learn with Us · Research · Shop | ≈192 (ficha) | 429 a WebFetch | Ficha con pestañas (Overview, Technical Notes, Provenance…); «More Artwork» por ejes; píxeles publicitarios en la ficha (antipatrón) |
| Cooper Hewitt | Visit · Exhibitions · Learning · National Design Awards · Calendar · About · Collection · Publications · Videos · Join & Support | ≈279 (colección en si.edu) | 15 KB / 86 KB (portada) | El microsite de colección `collection.cooperhewitt.org` hoy **redirige** a `si.edu/collections/cooper-hewitt` |
| Europeana | Inicio · Colecciones · Historias · Comparte tus colecciones · Iniciar sesión | ≈68 (búsqueda) | 403 a `curl` | Filtro en lenguaje llano «¿Puedo usar esto?»; títulos genéricos repetidos (antipatrón) |
| Google Arts & Culture | Página principal · Explorar · Jugar · Cercano · Favoritos | ≥23 (carga diferida) | 381 KB / 1,53 MB (portada) | Relato con detalle macro del grabado a sangre, índice y autoría |
| Museu de Lleida | Menú lateral de 11 entradas + «Informació» | ≈96 | 9,5 KB / 63 KB | Colección por periodos; widget de Twitter roto a la vista |
| Museo Salzillo (Murcia) | La Visita · El Museo · Colección · Exposiciones · Actualidad · Aprende · Servicios · Archivo | ≈74 | 29,6 KB transferido | Referente local; con el navegador en inglés redirige a `/en/`, que da 404 (también `/es/`); *overlay* de accesibilidad; «si continúa navegando, acepta» |
| Expobus (Universidad de Sevilla, Omeka S) | Inicio · Exposiciones del Fondo Antiguo · Otras exposiciones · Fondo Antiguo · ExpoBUS | ≈77 | 28 KB transferido | Exposiciones virtuales como tarjetas; aviso PHP visible en portada |
| **museopostal.org (hoy)** | ver informe 04 | **≈148** | 39 KB / 153 KB | Para comparar: más peticiones que el NPM y que el Musée Postal |

---

## 2. Fichas por referente

### 2.1 Smithsonian National Postal Museum (NPM)

URL: https://postalmuseum.si.edu/ · colección: https://postalmuseum.si.edu/search-the-collection (el antiguo `arago.si.edu` redirige aquí con 302).

**Arquitectura.**
- Barra superior: logo Smithsonian, buscador, «Donate» e idioma.
- Barra de marca con el logo «Smithsonian National Postal Museum» y 6 entradas: *Visit, Exhibitions, Learn, Collections, About, Blog*. El blog es la última.
- Migas de pan en todas las páginas internas: *Home / Collections / Search the Collection / …*.

**Portada, de arriba abajo:**
1. Carrusel de 5 diapositivas con botón de pausa: próxima conferencia online, festival familiar, mes de la herencia hispana, 250 aniversario y exposiciones virtuales.
2. H1 «National Postal Museum» y bloque *Welcome!* con la misión en una frase: «Through the preservation and interpretation of our postal and philatelic collections…». Debajo, enlace al calendario y al boletín *Postmark*.
3. Bloque *Visit* con horario, entrada gratuita, dirección y mapa.
4. **«Today in Postal History»**: una pieza con su fecha. El 28-09 era el sello de Kermit (28-09-2005), con enlace a la exposición donde aparece.
5. *Highlights*: 11 tarjetas con imagen y dos líneas: Current Exhibitions, Public Programs, Museum Tours, Search the Collection, Object Spotlights, Special Topics, For Researchers, Stamp Collecting, For Educators, Virtual Exhibitions, Preservation y Host an Event.
6. Cuatro accesos visuales: Virtual Tour, Photographs, Blog y Shop.
7. Pie con horario, enlaces legales, redes, boletín y «Owney, the Railway Mail Service Mascot».

**Búsqueda y navegación de la colección.**
- La página muestra primero **4 desplegables de ayuda**: *Stamp Image Use Permission, About Scott Catalogue Numbers, Glossary of Philatelic & Postal History Terms* y *What is Open Access Media (CC0)?*.
- Debajo, la caja de búsqueda con la casilla «Open Access Media (CC0)».
- Luego **15 áreas temáticas** con botón *Explore*: New Acquisitions, U.S. Stamps, Transportation, Popular Culture, Covers & Letters, Mail Processing, Postal Employees, Customers & Commerce, International Stamps & Mail, Postal Administration, International Postal Operations, Printing & Production Equipment, Philatelic Hobby, U.S. Related Areas y Post Office Structures.
- Cada área tiene texto introductorio, buscador propio y un contador: «Your search found 5,501 result(s)» en International Stamps & Mail.
- Los resultados son tarjetas con imagen, **texto alternativo descriptivo** («Green stamp with illustration of a rhino walking left to right with palm trees in the background»), título y «Date».

**Ficha de pieza** (https://postalmuseum.si.edu/object/npm_2011.2005.598):
- H1 normalizado: **«10ptas Black Rhinoceros single»** (valor, motivo y formato).
- A la izquierda, el sello **sobre fondo negro, con el dentado entero a la vista**. Debajo, los botones «Usage Conditions Apply», descarga, ampliar y, en móvil, un icono **IIIF**.
- A la derecha, *Object Details* como lista de definiciones:

  | Campo | Valor |
  |---|---|
  | Data Source | National Postal Museum |
  | Date | 1964 |
  | Object number | 2011.2005.598 |
  | Type | Postage Stamps |
  | Medium | paper; ink; adhesive |
  | Dimensions | 2.5 x 4.1 cm |
  | Place | Rio Muni (Spanish province) |
  | On View | Currently on exhibit |
  | Title | Scott Catalogue Rio Muni 43 |
  | Topic | International Stamps & Mail |
  | Record ID | npm_2011.2005.598 |
  | Usage | Not determined |
  | GUID | `http://n2t.net/ark:/65665/…` (identificador persistente ARK) |

- Arriba del todo, compartir, imprimir, correo y copiar enlace.

**Exposiciones.**
- Por ejemplo https://postalmuseum.si.edu/exhibition/international-philately.
- Van con migas, H1, «Virtual Exhibit», agradecimiento a los voluntarios, una introducción de 2 párrafos y un **«virtual stamp album»** de unas 950 piezas organizado por continentes.
- Tienen mapa interactivo, índice (*Outline*) y **versión en español, francés y portugués**.
- Los pies de foto siguen un patrón fijo: «*$2 Olympic Volleyball stamp, Mexico, 1968*».
- Algunas exposiciones virtuales salen por entregas: *Women on Stamps*, partes 1 a 4.

**Tipografía y color.** Serif cursiva en la marca, sans negra y grande para los H1, serif azul marino para «Object Details», fondo gris muy claro en el bloque de ficha y granate para «Donate». Es sobrio e institucional.

**Accesibilidad.** Enlace «Skip to main content», migas, carrusel con botón de pausa y listas de definiciones semánticas (`term`/`definition`). Todo el material observado lleva texto alternativo descriptivo.

**Rendimiento.** Unas 115 peticiones en la portada, con analítica de Google y el script de donaciones `fndrsp.net`.

**Móvil (390 px).** Hamburguesa, migas en dos líneas, H1 en 3 líneas y la imagen a todo el ancho. La ficha se lee bien.

**Museo o blog.** Museo. El blog es una entrada más del menú y la portada nunca es un listado cronológico.

### 2.2 The Postal Museum (Londres)

URL: https://www.postalmuseum.org/ · colecciones: https://www.postalmuseum.org/collections/

**Arquitectura.** En escritorio, el menú va detrás de una hamburguesa. Solo quedan visibles el logo (un sobre que forma una «M») y «Book now». El pie hace de mapa: *Accessibility, About us, Support us, Contact, News, Press office, Jobs and opportunities, Venue hire, Sustainability*.

**Portada:**
1. Vídeo a sangre con H1 «A ride for their imagination» y «Book now».
2. *What's on*: tarjetas con etiqueta de público («Families •») y fecha.
3. *What's making us curious?*: 3 entradas del blog con la etiqueta «blog».
4. *Support us*: patrocinar una traviesa del Mail Rail, hacerse socio o donar.
5. Alquiler de espacios.
6. Pie con boletín, horario y dirección, y un bloque **«Archive»** que muestra **una pieza al azar** («Travelling Post Office, 1881 · POST 118/792») con el botón **«View another item»** y el enlace «View the archive». En una segunda visita salió «Post Office Home Guard, 1941 · POST 56/83».

**Página de colecciones.**
- Frase de escala: «over 60,000 objects and thousands of records detailing 500 years of postal history».
- Dos puertas: *Highlights* (selección curada) y *Search the catalogue*.
- Bloques *Research*, *Professional Services* y «Something to donate?».

**Cookies.** Diálogo con *Manage cookies / Reject all / Accept all*, los tres al mismo nivel visual.

**Tipografía y color.** Sans geométrica ancha en gris claro sobre el vídeo, turquesa de marca y botones con contorno.

**Museo o blog.** Es un sitio de visita física muy orientado a vender entradas. Para un museo virtual interesan dos ideas: la pieza al azar y las dos puertas «Destacados / Buscar».

### 2.3 Museo Postal y Telegráfico (Correos)

URL: https://museopostalytelegrafico.es/ (la página de Correos `correos.es/…/museo-postal-y-telegrafico` da 404).

**Arquitectura.** Once entradas: *Home, Historia, Salas Postales y Telegráficas, Exposiciones temporales / virtuales, Piezas Significativas, Pinacoteca, Noticias, Biografías, Efemérides, Foro, Contacto*. El submenú de «Piezas Significativas» son **7 enlaces llamados «Piezas significativas 1» … «Piezas significativas 7»**. Al abrir `/piezas-significativas/` en el navegador acabé en la portada.

**Portada:**
1. Slider de sala con el texto «Todas las actividades son gratuitas / Infórmate», repetido 4 veces en el DOM.
2. H1 «MUSEO POSTAL Y TELEGRÁFICO» con un párrafo de misión.
3. «AVISO IMPORTANTE»: la sede de Aravaca cerró el 1 de febrero por el traslado a Toledo.
4. Accesos rápidos.
5. Un desplegable **«ALIADOS»** con texto y enlaces a casas de apuestas y casinos (Legalbet.co, Legalbet.mx y «casinos con depósito mínimo 5 euros»).
6. Última noticia y pie «Creado con GeneratePress», un tema de WordPress.

**Lectura.**
- Es el referente español más cercano por materia y el que más avisa de lo que no hay que hacer:
  - arquitectura de la información plana y larga;
  - menús sin semántica;
  - enlaces de spam SEO en un museo público;
  - 14 errores en consola.
- Se salvan dos ideas: **Efemérides** y **Biografías**, que para museopostal.org pueden ser grabadores, dibujantes y carteros de la Región.

### 2.4 Museum für Kommunikation Berlin y Onlinesammlung de la Museumsstiftung

URL: https://www.mfk-berlin.de/ · colección en línea: https://onlinesammlung.museumsstiftung.de/

**Web del museo (MfK Berlin, WordPress).**
- Una fila de iconos de acceso rápido arriba (inicio, búsqueda, calendario y dos más) y «MENÜ» desplegable.
- H1 «Das Museum für Kommunikation Berlin» con el lema «Kommunikation – gestern, heute und morgen» y un párrafo que nombra las joyas: «Blaue Mauritius, Rohrpost oder Enigma».
- A la derecha, un **bloque fijo de visita**: horario, taquillas y enlaces a entradas, familias y educación.
- Debajo, **cuatro carruseles seguidos**: exposiciones, actividades, familias y educación.
- El banner de consentimiento ocupa media pantalla con un texto de unas 200 palabras.

**Onlinesammlung (portada).**
- Gran buscador sobre una foto de detalle: «Suchen, finden, entdecken…», con enlace a *Detailsuche*.
- Cifras de colección: **«erfasste Objekte: 237.644 · Online Objekte: 74.866 · ausgestellte Objekte: 2.813»**.
- *Highlights* con botón de «Merkzettel», que es la lista personal de favoritos.
- Bloque «Oft gesucht» (lo más buscado).
- Enlace a **«Onlinesammlung in Leichter Sprache»**, es decir, en lectura fácil.

**Ficha de pieza** (https://onlinesammlung.museumsstiftung.de/detail/collection/83b9acb7-c12e-4803-bf3c-45dc0a324787):
- Imagen del sobre recortada sobre blanco, con «Vollbild» (pantalla completa) y «Download», y la licencia **«© CC BY SA 4.0 Museumsstiftung Post und Telekommunikation»** bajo la imagen.
- Acciones: *Teilen, Kontakt, Drucken, **CSV**, Auf den Merkzettel*.
- H1 largo y preciso: «Brief von Helgoland nach Kopenhagen als Ganzsache Helgoland … Umschlag Nr. U 1 mit den Freimarken … Nr. 14 a, 17 a».
- Campos, que son los que necesita una ficha de historia postal:

  | Campo | Valor |
  |---|---|
  | Datierung | 02.01.1878 |
  | Absender | unbekannt |
  | Adressat | Herrn Jul. Monies, Kopenhagen |
  | Geografischer Bezug | Helgoland; Kopenhagen |
  | **Laufweg** | Helgoland - Kopenhagen |
  | Material / Farbe / Technik | Papier; verschiedenfarbig; Prägedruck, Buchdruck |
  | Blattmaß | 147 x 85 mm |
  | **Systematik** | Philatelie > Ganzsachen > Umschläge, Faltbriefe > Amtliche Umschläge |
  | Markenart / Markentyp | Ganzsache / Umschlag |
  | **Gesamtfrankatur** | 29 Pfennig |
  | **Entwertung** | «Vorderseite: vier Kreisformstempel … schwarz \| Rückseite: Ellipsenstempel, schwarz» |
  | Inhalt / Beschriftung | ohne Briefinhalt / «I. Auflage» (a lápiz) |
  | Inventar-Nr. / Schlagworte | 2.2002.3519 / Ganzsache, Brief, Helgoland |
  | **Zitiervorschlag** | título, institución, inventario, URL y «zuletzt aktualisiert: 27.9.2026» |

- Una frase de comentario: «Ganzsachenumschlag … freigemacht mit schöner Zusatzfrankatur».

**Rendimiento.** Unas 24 peticiones y ningún tercero en la ficha: solo `museumsstiftung.de`. Es la ficha más ligera de toda la muestra.

**Móvil.** El icono del menú no carga y se ve su texto alternativo «Menü öffne», y queda un hueco blanco grande sobre la imagen. En móvil hay pulido pendiente.

**Tipografía y color.** Sans grotesca negra en azul oscuro para los títulos, gris para el submenú y mucho blanco. Parece un archivo más que una revista.

### 2.5 Musée Postal (París; antes Musée de La Poste)

URL: https://www.museepostal.fr/fr (`museedelaposte.fr` redirige aquí) · colecciones: https://collections.museepostal.fr/fr/

**Web del museo.**
- Logo: una «M» hecha de teselas con pictogramas postales (globo, corazón, sobre), en azul.
- Menú: *Visiter le musée, Expositions, Evénements & activités, Collections, Boutique en ligne, Privatisations*, con buscador y botón «Billetterie».
- Una **banda de aviso** bajo el menú da la información práctica («Le musée est ouvert tous les jours de 11h à 18h, sauf le mardi») y los avisos puntuales («La boutique … sera fermée le mercredi 7 octobre»).
- *A la une*: actividades con tipo, público («À partir de 8 ans»), fecha, precio y duración.
- *Nos expositions*: dos temporales, una de ellas sobre el timbre gravé en taille-douce.
- Pie con el enlace **«[Accessibilité du site web : non conforme]»**. En el sitio de colecciones pone «partiellement conforme».
- Analítica declarada con Matomo, anónima.

**Colecciones en línea.**
- Menú: *Collections par thématique, Exposition permanente, Expositions temporaires, Centre de ressources, Musée Postal*, con buscador y panier.
- La portada explica cómo buscar en tres viñetas, da noticias de colección y un carrusel «Ajouts récents». En ese carrusel, **los enlaces de las imágenes no tienen texto accesible**.
- **Ficha** (https://collections.museepostal.fr/fr/notice/2010-0-265-jules-verne-f0756e8f-5fdd-4074-876a-487de99e9118):
  - H1 «Jules Verne - Timbre-poste - Timbre-poste à l'unité - France - 1026».
  - Imagen del sello con el dentado sobre gris.
  - Botones Imprimir, Añadir al panier (reproducciones) y Copiar enlace.
  - Campos: Désignation, **Auteur/Exécutant: Pheulpin Jean-Paul — Dessinateur; Graveur**, **Date de création: «1955, juin 4 : Date d'émission ; 1955, octobre 15 : Date de retrait»**, Domaine, **Matière et technique: Papier gommé; Taille-douce**, Mesures (2,6 × 4 cm, «Forme : Paysage»), Description, Sujet / thème, Personne représentée, Département, Propriétaire, Crédits, **Particularité: «Valeur faciale : 30 F ; Couleur : Bleu noir ; Tirage : 2 200 000»** y Numéro d'inventaire.
  - Bloque **«Facettes»**: «Cliquez sur un terme pour voir toutes les œuvres de nos collections associées à ce dernier», seguido de unos 25 términos enlazados (grabador, siglo, año, técnica, papel, persona representada, tema…).
- **URL rotas.** La antigua `https://collections.museedelaposte.fr/fr/les-collections/les-collections-philateliques`, que aún sale en buscadores, acaba en **«ERREUR 404»** en `museepostal.fr`.

### 2.6 Rijksmuseum

URL: https://www.rijksmuseum.nl/en · colección: https://www.rijksmuseum.nl/en/collection

- **Portada:** banner «Visit the highlights. Book your ticket today», cuatro exposiciones y actividades, horario y dirección. Pie con *Accessibility Statement*.
- **Página de colección:**
  - fondo oscuro con un detalle de bodegón y la palabra «COLLECTION» en mayúsculas condensadas enormes;
  - temas destacados (Johannes Vermeer, Independence of Indonesia, Judith Leyster, Delftware);
  - **«Visitor stories»**, selecciones hechas por el público («Summer Landscapes · 25 artworks»);
  - «Create your own Gallery of Honour»;
  - buscador único para obras, biblioteca y relatos, con botón «Filter».
- **Ficha** (Vermeer, *The Love Letter*, SK-A-1595):
  - imagen a pantalla completa sobre oscuro con «Download image»;
  - pestañas **About / Data**;
  - bajo el título, autor y fecha, un párrafo de 70 palabras y **solo 4 datos** (Artwork type, Object number, Dimensions, Physical characteristics) con el botón **«View all data»**;
  - luego *Stories* (audio de 1 minuto: «What makes this letter a love letter?») y *Discover more* («more by Johannes Vermeer»).
- **Rendimiento:** unas 110 peticiones en la portada y más de 244 en la colección. Terceros: publicidad, Reddit, LinkedIn, Clarity y un píxel de OpenAI.
- **Lección:** divulgación progresiva. El visitante casual lee el relato y el investigador pulsa «ver todos los datos».

### 2.7 The Met

URL de la ficha: https://www.metmuseum.org/art/collection/search/436535

- **Menú:** *Visit, Exhibitions and Events, Art, Learn with Us, Research, Shop*, con idioma, Donate, Membership y Tickets.
- **Ficha, de arriba abajo:**
  1. Migas (*The Met Collection / Search Art / …*).
  2. Título en serif grande, autor enlazado, nacionalidad y fecha.
  3. «On view at The Met Fifth Avenue in Gallery 822».
  4. Texto curatorial con «View more».
  5. A la derecha, imagen en un marco gris con **«Public Domain»**, *View in 3D, Download Image, Buy a print, Share, Enlarge* y miniaturas de otras vistas.
  6. *Artwork Details* en **pestañas**: Overview, Technical Notes, Provenance, Exhibition History, References, Notes. Overview muestra Title, Artist, Date, Medium, Dimensions, Classification, Credit Line, Object Number y Curatorial Department.
  7. *Audio* con reproductor y **«Show Transcript»**.
  8. **«More Artwork»** con cinco ejes: *Related, By [artista], In the same gallery, In the same medium, From the same time and place*.
  9. *Related Content*: artículos, cronología y publicaciones.
- **Antipatrón:** la ficha cargó unas 192 peticiones, con `ad.doubleclick.net`, `pixel.quantserve.com`, `alb.reddit.com`, `px.ads.linkedin.com`, `api2.amplitude.com`, `ingest.quantummetric.com` y `bzr.openai.com`, sin tocar el banner. Es una carga publicitaria impropia de una página de estudio.

### 2.8 Cooper Hewitt

URL: https://www.cooperhewitt.org/

- **Portada:**
  - cabecera negra con 10 entradas en rejilla y fila naranja de acciones (*Reserve tickets, Become a member, Join newsletter, Shop, Search*);
  - tipografía propia condensada en mayúsculas sobre recuadros blancos encima de la foto;
  - bloques «Shop», «Programs», «Hours Today 10 AM-6 PM», «Become a member» y «Learning Resources»;
  - pie con enlace «Open Source».
- **Accesibilidad:** la portada tiene **7 encabezados H1**.
- **Colección:** `https://collection.cooperhewitt.org/` **redirige a `https://www.si.edu/collections/cooper-hewitt`**, el buscador genérico del Smithsonian, con filtros Topic, Date, Object Type, Place y Group, casilla CC0 y rejilla de 25 resultados («Displaying 25 of 163,510 results»). El microsite propio desapareció.
- **Lección:** una colección en línea hecha a medida puede no sobrevivir a su equipo. En WordPress, los tipos de contenido estándar y la exportación WXR son el seguro.

### 2.9 Europeana

URL de búsqueda probada: https://www.europeana.eu/es/search?query=sello%20postal

- **Menú en español:** *Inicio, Colecciones, Historias, Comparte tus colecciones, Iniciar sesión / Registrarse*.
- **Resultados:** «18.482 resultados para sello postal». Tarjetas con imagen, título e institución, y vistas en rejilla o lista. Se puede «Habilitar la búsqueda multilingüe». Aparecen galerías y colecciones relacionadas.
- **Filtros:** *Tema*, *Tipo de medio* y **«¿Puedo usar esto?»** (reutilización), más «Mostrar filtros adicionales».
- **Antipatrón:** decenas de resultados se llaman igual, «Sello de Correos», con la institución debajo («The Digital Network of Museum Collections in Spain», es decir, CER.ES). Sin el valor y el año, la lista no se puede leer.
- **Oportunidad:** una ficha bien titulada en museopostal.org destaca frente a eso. Si algún día se quisiera agregar a Europeana, el camino son CER.ES o Hispana, fuera de este alcance.

### 2.10 Google Arts & Culture

Relato del NPM: https://artsandculture.google.com/story/american-art-on-postage-stamps-telling-the-story-of-a-nation-national-postal-museum/kwUR4SFBkDIEKQ

- **Portada del relato:** un **detalle macro del grabado de un sello** a sangre (se ven las líneas de la talla dulce) con el título en blanco centrado, la institución y «Created by Clifford R. Haimann and Alexander T. Haimann».
- **Estructura:**
  - entradilla;
  - **índice** con unas 30 secciones: Introduction, The Founding Fathers… Credits;
  - diapositivas de imagen grande con texto corto, una por sección.
- **Series:** *Women on Stamps* sale en 4 partes. Hay más relatos del NPM en la plataforma.
- **Lección para las salas:** portada con un detalle ampliado, índice visible, autoría y créditos al final.

### 2.11 Museos y archivos pequeños

**Museu de Lleida** (https://www.museudelleida.cat/)
- Web en catalán, castellano e inglés con menú lateral: *Visita al museu, El Museu, Col·leccions, Educació, Exposicions, Multimèdia, Notícies, Serveis, Publicacions, Cercle d'Amics…*.
- Portada: 4 tarjetas con foto (El Museu, Notícies i activitats, Educació, Col·leccions) y la tienda.
- La colección se ordena **por periodos**: Paleolític i Neolític, Edat del bronze, Edat del ferro i estat ilerget, Roma, Antiguitat tardana, Al-Àndalus, Romànic, Gòtic, Renaixement i Barroc, Ingressos recents. Además hay «La col·lecció online».
- En el pie se lee **«Twitter outputted an error: Invalid or expired token..»**.
- Todas las tarjetas son H1. El diseño parece de hace una década.
- Lección: ordenar las salas por periodo funciona. El widget roto es lo que no puede pasar.

**Museo Salzillo** (Murcia) (https://www.museosalzillo.es/)
- Menú: *La Visita, El Museo, Colección, Exposiciones, Actualidad, Aprende, Servicios, Archivo*. Utilidades: *Visita Virtual, Cita Previa, Contacto, Preguntas frecuentes, Newsletter, Amigos*.
- La raíz responde 200 a `curl`. Con el navegador en inglés redirige a `/en/`, que da **404**, y `/es/` también da 404.
- Tiene una barra flotante de accesibilidad (*overlay*) con «Increase text», «Grayscale», «Readable Font»…
- El banner dice «Si continua navegando, consideramos que acepta su uso».
- Lección: nombres de menú en castellano claros y cortos («Aprende», «Colección», «La Visita») que se pueden reutilizar. Lo demás no.

**Expobus, Biblioteca de la Universidad de Sevilla** (https://expobus.us.es/s/expobus/page/inicio, Omeka S)
- Portada con un mapa antiguo a sangre («Descripción geográfica del estado antiguo del Rio Betis o Guadalquivir»), buscador y lema («Durante cientos de años hemos protegido este lugar para ti… Adéntrate, explora, conoce…»).
- Debajo, unas 40 exposiciones como tarjetas con marco dorado y título: «Cartografía histórica en la BUS», «Relaciones de Sucesos en la BUS. Antes de que existiera la prensa…».
- En portada se ve **«Notice: Undefined offset: 96 in /home/expobus/modules/Mosaico/src/Block/SiteGrid.php on line 130»**.
- Lección: el formato de exposición virtual de Omeka (tarjeta, página de introducción y piezas con ficha) se puede imitar en WordPress sin Omeka. También recuerda no mostrar nunca errores PHP en producción (`WP_DEBUG_DISPLAY` a falso).

**Museos filatélicos pequeños que ya no están.**
- `mufi.org.mx` (Museo de Filatelia de Oaxaca) sirve un certificado caducado (`NET::ERR_CERT_DATE_INVALID`).
- `museodepostales.es`, un «museo de postales» virtual que aún aparece en buscadores, no resuelve en DNS.
- Es la advertencia más relevante para un museo virtual privado: **el dominio, el certificado y las copias de seguridad son parte de la colección.**

---

## 3. Qué hace que una web parezca «museo» y no «blog»

| Señal de museo | Señal de blog |
|---|---|
| La unidad es la **pieza**, con número, título normalizado y ficha | La unidad es la **entrada**, con fecha y autor |
| Portada-vestíbulo: nombre, misión y puertas (salas, colección, aprender) | Portada con las últimas entradas en orden cronológico inverso |
| Salas y exposiciones con introducción, recorrido ordenado y créditos | Categorías y nube de etiquetas |
| Datos en lista de definiciones (fecha, técnica, medidas, procedencia) | Metadatos de publicación («publicado el…», «3 comentarios») |
| Migas de pan jerárquicas (Colección › Área › Pieza) | «Entrada anterior / siguiente» |
| Imagen protagonista sobre fondo neutro, con zoom y licencia | Imagen destacada decorativa recortada a 16:9 |
| Citas, identificadores estables y cifras de la colección | Barra lateral con widgets, redes y archivo por meses |
| Tipografía sobria, mucho aire, color al servicio de la pieza | Varios estilos por bloque, sombras y bordes decorativos |

Aplicado a museopostal.org:
- Las 2 entradas actuales pueden seguir como «Artículos» o «Cuadernos», pero **no deben marcar la portada**.
- La portada la marcan las salas y las piezas.
- La sección de noticias pasa al pie o a una página propia.

---

## 4. Contexto para los patrones

- **Modelo técnico:** el [informe 05](05-opciones-tecnicas.md) recomienda un tema de bloques propio y un plugin con el tipo de contenido `pieza`, las salas y taxonomías con `show_in_rest`. Los patrones siguientes se piensan para ese modelo. Cada uno lleva su «cómo en WordPress».
- **Campos de ficha:** el [informe 01](01-filatelia-dominio.md) (§2.1) define los campos de una ficha filatélica. Aquí solo se indica cómo presentarlos.
- **Público:** sin sede física no existe el 50 % de visitas que buscan «planificar la visita» (informe 01, §4.3). Sobran los bloques de horario y entradas, y sobra el menú «Visita». Su hueco lo ocupan «Cómo usar el museo» y las videoconferencias.

---

## 5. (a) Patrones que conviene adoptar (22)

Cada patrón indica qué es, de dónde sale, por qué sirve y cómo se hace en WordPress.

1. **Portada-vestíbulo con H1 y misión en una frase.**
   - *Ref.:* NPM («Welcome!» y la misión en una línea) y MfK Berlin (H1, lema y joyas nombradas: «Blaue Mauritius, Rohrpost oder Enigma»).
   - *Por qué:* hoy la portada no tiene H1 y abre con 90 palabras en cursiva (informe 04).
   - *WP:* plantilla `front-page.html` con un patrón bloqueado: H1 «Museo Postal y Filatélico de la Región de Murcia», una frase de misión y 3 joyas con enlace a su ficha. Por ejemplo: el correo submarino de 1938, la tarjeta de 1918 por las dos caras y un sello de Murcia.

2. **Menú de 5 entradas con nombres de museo.**
   - *Ref.:* NPM (6 entradas), Museo Salzillo («La Visita, El Museo, Colección, Exposiciones, Actualidad, Aprende») y The Met.
   - *Por qué:* frente a las 11 del museo de Correos y a la hamburguesa en escritorio de Londres y Berlín, cinco palabras visibles bastan.
   - *WP:* navegación **visible en escritorio** con **Salas · Colección · Aula · Actividades · El museo**, más Buscar a la derecha. La tienda y el boletín van en la barra de utilidades o en el pie.

3. **Tres o cuatro puertas grandes bajo el vestíbulo.**
   - *Ref.:* *Highlights* del NPM (11 tarjetas) y Museu de Lleida (4).
   - *Por qué:* es la forma más rápida de entender qué contiene el museo. Con un museo de ~140 piezas, 4 puertas bastan: 11 sería inventar.
   - *WP:* bloque Consulta o columnas con Salas, Colección, Aula y Videoconferencias. Cada tarjeta lleva una pieza real como imagen, **nunca** un medallón generado por IA.

4. **Título normalizado de pieza.**
   - *Ref.:* NPM «10ptas Black Rhinoceros single», pies «$2 Olympic Volleyball stamp, Mexico, 1968» y Musée Postal «Jules Verne - Timbre-poste - … - France - 1026». Europeana, en cambio, repite «Sello de Correos».
   - *Por qué:* el título es lo que se lee en resultados, migas, pestaña y buscadores.
   - *WP:* regla editorial con plantilla de título. Para sellos: **«[valor] [motivo], [formato], [país], [año] (Edifil n.º)»**, por ejemplo «6 cuartos Isabel II, sello suelto, España, 1850 (Edifil 1)». Para historia postal: **«[Tipo] de [origen] a [destino], [fecha]»**, por ejemplo «Tarjeta postal de Cartagena a …, 1918». Se puede asistir con un campo «título sugerido» calculado a partir de los metadatos.

5. **Ficha como lista de definiciones con los campos propios de la filatelia.**
   - *Ref.:* Onlinesammlung (Laufweg, Absender, Adressat, Entwertung por cara, Gesamtfrankatur, Systematik), Musée Postal (valeur faciale, couleur, tirage, émission/retrait, dessinateur/graveur) y NPM (Scott en «Title»).
   - *Por qué:* es lo que separa una ficha de museo de una entrada de blog, y lo que busca el público filatélico (informe 01, §4.3).
   - *WP:* bloque dinámico «Datos de la pieza» que pinta un `<dl>` con los metadatos del CPT y **oculta los campos vacíos**. Los campos concretos están en el informe 01, §2.1.

6. **Imagen protagonista sobre fondo neutro que deja ver el dentado.**
   - *Ref.:* NPM (sello sobre negro con el dentado entero; ver captura del 28-09) y Musée Postal (sello sobre gris).
   - *Por qué:* el dentado, los márgenes y el centrado son información filatélica. Un recorte a 16:9 o con esquinas redondeadas la destruye.
   - *WP:* `object-fit: contain` sobre un «paspartú» de color fijo del `theme.json`. **Nunca `cover` ni `border-radius`** en imágenes de pieza. Hay que escanear con margen de fondo.

7. **Anverso, reverso y detalle, con zoom.**
   - *Ref.:* Met (miniaturas de vistas y «Enlarge»), Onlinesammlung («Vollbild») y NPM (ampliar e IIIF).
   - *Por qué:* en historia postal, el reverso lleva los fechadores de tránsito y llegada (informe 01, §4.2).
   - *WP:* galería de 2 o 3 imágenes con etiquetas «Anverso / Reverso / Detalle» y visor de zoom ligero cargado solo en la ficha (OpenSeadragon o el lightbox nativo de WordPress). IIIF no hace falta al principio.

8. **Licencia y descarga bajo la imagen.**
   - *Ref.:* Onlinesammlung («© CC BY SA 4.0» y Download), NPM («Usage Conditions Apply» y la casilla CC0) y Met («Public Domain»).
   - *Por qué:* un museo privado debe decir qué se puede hacer con sus imágenes. Además, eso le da credibilidad.
   - *WP:* campo «Derechos» con 3 valores (CC BY-SA 4.0, Dominio público, Todos los derechos reservados) mostrado como etiqueta bajo la imagen. La descarga aparece solo si la licencia lo permite. Qué licencia elegir es decisión de Felipe.

9. **Divulgación progresiva: resumen arriba, datos completos abajo.**
   - *Ref.:* Rijksmuseum (4 datos y «View all data»; pestañas About / Data) y Met (pestañas Overview, Technical Notes, Provenance…).
   - *Por qué:* sirve a la vez al curioso y al filatelista.
   - *WP:* arriba, 3 o 4 datos clave (fecha, lugar, tipo, catálogo) y un texto de 60 a 120 palabras. Debajo, un `<details>` nativo «Todos los datos» con la lista completa, sin JavaScript.

10. **Facetas clicables en la ficha.**
    - *Ref.:* Musée Postal («Facettes: cliquez sur un terme pour voir toutes les œuvres…»).
    - *Por qué:* convierte cada ficha en un punto de partida (grabador, año, lugar, tema) y aprovecha los archivos de taxonomía que WordPress ya genera.
    - *WP:* taxonomías `epoca`, `lugar`, `tipo-pieza`, `tema` y `persona` (grabador o dibujante) enlazadas desde la ficha. Cada archivo de término es una página de colección con intro opcional.

11. **«Más piezas» por ejes.**
    - *Ref.:* Met («Related / By artist / In the same gallery / In the same medium / From the same time and place») y Rijksmuseum («more by…»).
    - *Por qué:* con una colección pequeña, los ejes aseguran que ninguna ficha acabe en callejón sin salida.
    - *WP:* bloque de consulta al pie con dos ejes, «En la misma sala» y «De la misma época», con 4 piezas cada uno. Pestañas no hacen falta.

12. **Cita sugerida e identificador estable.**
    - *Ref.:* Onlinesammlung («Zitiervorschlag» con inventario, URL y fecha de actualización) y NPM (GUID ARK).
    - *Por qué:* el público investigador es el más implicado y el que más vuelve (informe 01, §4.3).
    - *WP:* línea final «Cómo citar esta pieza: [título]. Museo Postal y Filatélico de la Región de Murcia, n.º [inventario]. [permalink], consultado el [fecha]». El número de inventario es un campo propio con formato `MPF-AAAA-NNN` y los permalinks no cambian.

13. **Colección por áreas y periodos.**
    - *Ref.:* NPM (15 áreas con «Explore» e intro por área), Museu de Lleida (periodos: Roma, Al-Àndalus, Gòtic…) y Musée Postal («Collections par thématique»).
    - *Por qué:* permite recorrer la colección sin saber qué buscar.
    - *WP:* página «Colección» con dos rejillas. Por tipo: Sellos, Historia postal, Tarjetas postales, Pintura y arte postal, Documentos. Por época: Antes del sello (prefilatelia), 1850-1900, 1900-1939, Guerra y censura 1936-1945, 1945 a hoy. Las salas propuestas en el informe 01, §5.4 encajan aquí.

14. **Buscador con ayuda y filtros en lenguaje llano.**
    - *Ref.:* NPM (desplegables «About Scott Catalogue Numbers», glosario y permisos, encima de la caja), Europeana («¿Puedo usar esto?») y Musée Postal («Pour effectuer une recherche, vous pouvez…»).
    - *Por qué:* el público general no sabe qué es un número Edifil ni un entero postal.
    - *WP:* búsqueda nativa restringida al CPT `pieza`, con filtros por taxonomía (formulario GET) y, encima, 3 `<details>`: «Qué es el número Edifil», «Glosario» (enlace al glosario del informe 01) y «Qué puedo hacer con las imágenes».

15. **Cifras de colección a la vista.**
    - *Ref.:* Onlinesammlung («erfasste 237.644 · online 74.866 · ausgestellte 2.813») y The Postal Museum («over 60,000 objects… 500 years»).
    - *Por qué:* dicen la escala con honestidad y se actualizan solas.
    - *WP:* un bloque que cuenta las piezas publicadas y las salas («142 piezas en línea · 6 salas»). Es un shortcode o bloque dinámico de 20 líneas.

16. **Efeméride del día.**
    - *Ref.:* NPM («Today in Postal History» con pieza y fecha) y museo de Correos («Efemérides»).
    - *Por qué:* hace que la portada cambie cada día sin que Felipe publique nada.
    - *WP:* campo «fecha de emisión o circulación» (día y mes) en la pieza. La portada muestra la pieza cuyo día y mes coincide con hoy o, si no hay, la más cercana. Es una consulta en PHP, sin cron.

17. **Pieza al azar.**
    - *Ref.:* The Postal Museum (bloque «Archive» del pie con «View another item»).
    - *Por qué:* invita a explorar y hace que el sitio parezca vivo incluso con poco contenido.
    - *WP:* bloque «Una pieza al azar» en el pie, con enlace «Ver otra» a `/?pieza-al-azar` (redirección 302 a una ficha aleatoria). Sin JavaScript y compatible con la caché de página.

18. **Salas como exposiciones con introducción, recorrido e índice.**
    - *Ref.:* NPM (*International Philately*: intro, álbum por continentes, *Outline*, mapa y traducciones), Google Arts & Culture (índice de secciones, autoría y créditos) y Expobus (tarjeta, intro y piezas).
    - *Por qué:* es lo que convierte un conjunto de fichas en un museo.
    - *WP:* CPT `sala` o página con plantilla propia:
      - cabecera con un detalle ampliado de una pieza (patrón 19);
      - texto de sala de 150 a 300 palabras;
      - índice de secciones;
      - recorrido ordenado de 6 a 12 piezas (relación ordenada `sala → piezas`);
      - créditos («Comisario: Felipe Martínez»).

19. **Detalle macro como imagen de cabecera.**
    - *Ref.:* Google Arts & Culture (líneas de la talla dulce a sangre) y Expobus (mapa antiguo a sangre).
    - *Por qué:* un sello a 30 mm no llena una cabecera. Su detalle ampliado sí, y es auténtico, no generado.
    - *WP:* campo «imagen de cabecera» en la sala con recorte manual de un escaneo a 1200 ppp o más, y texto sobre banda sólida para mantener el contraste.

20. **Series por entregas.**
    - *Ref.:* NPM (*Women on Stamps*, partes 1 a 4, en su web y en Google Arts & Culture).
    - *Por qué:* es un calendario editorial asumible para una sola persona. Una sala puede crecer por partes en vez de esperar a estar completa.
    - *WP:* taxonomía o campo «Serie» con navegación «Parte 2 de 4».

21. **Aula con puerta propia, por edades, y una versión en lectura fácil.**
    - *Ref.:* NPM («For Educators», *Design It!*), Musée Postal (actividades con «À partir de 8 ans») y Onlinesammlung («Leichte Sprache»).
    - *Por qué:* el Proyecto Aula es uno de los activos que el informe 04 manda conservar. La lectura fácil llega a públicos que las webs de museo suelen dejar fuera.
    - *WP:* página «Aula» con fichas por nivel (Primaria, Secundaria, Adultos). Cada ficha tiene objetivo, actividad, piezas usadas y PDF. Más adelante, una página «El museo en lectura fácil», validable con Plena inclusión.

22. **Pie honesto: accesibilidad, consentimiento y datos de contacto.**
    - *Ref.:* Musée Postal («Accessibilité du site web : non conforme / partiellement conforme» y Matomo anónimo declarado), Rijksmuseum («Accessibility Statement»), The Postal Museum y Expobus («Reject all» o «Rechazar todas» al mismo nivel que aceptar).
    - *Por qué:* hoy el sitio manda datos a Clarity y Google Analytics antes de pedir permiso (informe 04).
    - *WP:*
      - página «Accesibilidad» con el estado real y un contacto;
      - analítica sin cookies y autoalojada, o ninguna, para no necesitar banner;
      - si hace falta banner, «Rechazar» y «Aceptar» con el mismo peso visual;
      - fuentes autoalojadas.

---

## 6. (b) Antipatrones que hay que evitar (10)

1. **Carrusel automático como portada y carruseles apilados.**
   - NPM (5 diapositivas en la cabecera) y MfK Berlin (4 carruseles seguidos). En el museo de Correos, el slider repite «Todas las actividades son gratuitas» 4 veces en el DOM.
   - Un museo pequeño tiene una sola cosa importante que decir en cada bloque.
   - *Regla:* ningún carrusel en portada.

2. **Menús sin semántica o demasiado largos.**
   - Museo de Correos: 11 entradas y «Piezas significativas 1 … 7».
   - *Regla:* 5 entradas con nombre propio y ningún ítem numerado.

3. **Menú escondido tras la hamburguesa en escritorio.**
   - The Postal Museum y MfK Berlin («MENÜ»).
   - Con 5 entradas caben en cualquier escritorio. La hamburguesa, solo en móvil.

4. **Enlaces ajenos o spam en la portada.**
   - Museo de Correos: bloque «ALIADOS» con casas de apuestas y casinos.
   - Es el síntoma de un WordPress abandonado o vendido para SEO.
   - *Regla:* ningún bloque de «amigos» o enlaces patrocinados. Revisar enlaces salientes con cada release.

5. **Errores técnicos a la vista.**
   - «Twitter outputted an error: Invalid or expired token..» (Museu de Lleida), «Notice: Undefined offset: 96 in …/SiteGrid.php» (Expobus) y el «Please select a Menu From Setting!» que ya tiene museopostal.org (informe 04).
   - *Regla:* ningún *embed* de redes sociales y `WP_DEBUG_DISPLAY=false`.

6. **Romper URL al migrar o renombrar.**
   - Musée Postal: las rutas antiguas de `collections.museedelaposte.fr` acaban en «ERREUR 404». Museo Salzillo: `/en/` y `/es/` dan 404.
   - *Regla:* antes de publicar el rediseño, un mapa 301 de todas las URL actuales de museopostal.org (23 páginas y 2 entradas, [informe 03](03-auditoria-contenido.md)) a las nuevas, comprobado con `curl`. Sin redirecciones de idioma automáticas.

7. **Títulos genéricos y enlaces de imagen sin texto.**
   - Europeana: «Sello de Correos» repetido. Musée Postal: «Ajouts récents» con enlaces de imagen sin nombre accesible.
   - *Regla:* título normalizado (patrón 4), `alt` descriptivo en cada pieza (como hace el NPM) y enlaces de tarjeta con texto.

8. **Rastreadores publicitarios y *overlays* de accesibilidad.**
   - Rastreadores: la ficha del Met cargó DoubleClick, Reddit, LinkedIn, Quantserve y Amplitude.
   - *Overlay:* el del Museo Salzillo, «Increase text / Grayscale / Readable Font».
   - Consentimiento: «Si continúa navegando, consideramos que acepta» no es consentimiento válido (EDPB, *Guidelines 05/2020 on consent*, §86: https://www.edpb.europa.eu/our-work-tools/our-documents/guidelines/guidelines-052020-consent-under-regulation-2016679_en).
   - *Regla:* cero rastreadores de publicidad y ningún *overlay*. La accesibilidad la da el tema.

9. **Jerarquía de encabezados rota.**
   - Cooper Hewitt: 7 H1 en la portada. Museu de Lleida: cada tarjeta es un H1. Museo de Correos: varios H1.
   - *Regla:* un H1 por página y H2 y H3 en orden. Se comprueba en CI con un linter de accesibilidad (axe o pa11y) sobre las plantillas.

10. **Infraestructura frágil.**
    - Certificado caducado (MUFI), dominio perdido (museodepostales.es) y microsite retirado (collection.cooperhewitt.org).
    - *Regla:*
      - renovación automática del dominio a nombre del museo;
      - TLS automático en Webempresa;
      - contenido en tipos estándar de WordPress con exportación WXR periódica;
      - copia de los escaneos originales fuera del hosting.

---

## 7. (c) Tres direcciones visuales

Contrastes calculados con la fórmula WCAG. El mínimo para texto normal es 4,5:1 y para texto grande o elementos de interfaz, 3:1.

### 7.1 «Álbum» (gabinete del coleccionista)

- **Idea:** la web es un álbum de colección bien montado. Papel crema, piezas en montura negra, tinta azul y granate de sello antiguo. Parte de la paleta actual que el informe 04 manda conservar.
- **Paleta:**

  | Uso | Color | Contraste |
  |---|---|---|
  | Fondo papel | `#F4EAD5` | fondo de referencia |
  | Fondo claro (fichas, bloques) | `#FBF6EC` | fondo de referencia |
  | Texto | `#2B2320` | 12,89:1 sobre papel; 14,29:1 sobre claro |
  | Titulares y enlaces, tinta | `#1A2E44` | 11,58:1 |
  | Acento granate | `#8A1538` | 7,83:1 sobre papel; papel sobre granate 7,83:1 |
  | Texto secundario | `#6B5F55` | 5,18:1 |
  | Montura de pieza | `#1B1B1B` | papel sobre montura 14,42:1 |
  | Oro, **solo filetes y ornamento, nunca texto** | `#B08D2E` | 2,63:1 |

- **Tipos:**
  - **Newsreader** (Google Fonts, serif con eje óptico 6-72) para titulares y cuerpo largo;
  - **Public Sans** (sans neutra de origen institucional, pesos 100-900) para menú, fichas y botones;
  - alternativa serif: **Source Serif 4** (eje óptico 8-60).
- **Imágenes:**
  - piezas sobre montura negra con el dentado entero, como en el NPM, y un margen generoso;
  - reverso junto al anverso;
  - un único motivo gráfico: un filete dentado (perforación) en CSS como separador de secciones, usado con moderación;
  - ningún medallón IA ni textura de papel en imagen: el color crema basta.
- **Tono:** sereno, cálido, de coleccionista.
- **A favor:**
  - continuidad para Felipe y para quien ya conoce el sitio;
  - la montura negra hace brillar sellos de cualquier color;
  - dos familias, que cumple el objetivo T6 del informe 04;
  - contrastes holgados.
- **En contra:**
  - riesgo de caer en lo «antiguo» o lo recargado si se abusa del ornamento;
  - el crema ensucia las fotos de sobres blancos si el paspartú no es neutro (usar montura negra o gris `#EDEBE6` en las fichas);
  - menos juvenil para el Aula.

### 7.2 «Estafeta» (documental, sello fechador)

- **Idea:** la web es una oficina de correos y un archivo de trabajo. Rótulos condensados como los de las ventanillas, datos en letra de máquina como los fechadores, rojo lacre y azul de matasellos sobre papel kraft.
- **Paleta:**

  | Uso | Color | Contraste |
  |---|---|---|
  | Fondo kraft | `#EDE3CF` | fondo de referencia |
  | Texto, negro tinta | `#1C1B19` | 13,51:1 |
  | Acento lacre | `#A4262C` | 5,70:1 sobre kraft; blanco sobre lacre 7,26:1 |
  | Azul matasellos | `#24466B` | 7,62:1; blanco sobre azul 9,71:1 |
  | Grafito, secundario | `#55524C` | 6,11:1 |
  | Mostaza buzón, **solo como fondo con texto negro o sobre negro** | `#E3B23C` | 8,77:1 con negro; **1,54:1 sobre kraft: prohibido** |

- **Tipos:**
  - **Archivo** (eje de anchura 62-125 y peso 100-900) para titulares condensados y cuerpo en anchura normal;
  - **IBM Plex Mono** para metadatos (fechas, números Edifil, inventario), que imita el fechador;
  - alternativa para textos largos: **Source Serif 4**.
- **Imágenes:**
  - piezas a tamaño real sobre kraft con sombra mínima, en una rejilla de clasificador;
  - un sello fechador circular en SVG con la fecha de cada pieza como marca de ficha;
  - fotos de oficinas y carteros de archivo en duotono azul.
- **Tono:** didáctico, activo, cercano a un taller. Encaja con el Aula y con «Comparte tu pieza».
- **A favor:**
  - identidad muy reconocible;
  - la letra de máquina ordena bien los datos;
  - atrae a público joven y escolar;
  - se distingue de cualquier web de museo de arte.
- **En contra:**
  - la tematización puede parecer disfraz si se abusa;
  - el amarillo recuerda a la marca Correos: hay que mantener la mostaza y no usar el amarillo corporativo ni la trompa;
  - el kraft reduce el contraste de las fotos claras;
  - tres familias si se añade la serif (hay que elegir entre Archivo solo o Archivo con serif).

### 7.3 «Sala blanca» (museo contemporáneo)

- **Idea:** la web es una sala de exposición moderna, como el Rijksmuseum o el Met. Blanco, mucho aire, piezas grandes sobre gris claro y un solo acento granate.
- **Paleta:**

  | Uso | Color | Contraste |
  |---|---|---|
  | Fondo | `#FFFFFF` | fondo de referencia |
  | Fondo alterno | `#F7F6F3` | fondo de referencia |
  | Fondo de pieza (paspartú) | `#EDEBE6` | granate sobre él 7,85:1 |
  | Texto | `#1F1F1F` | 16,48:1; 15,25:1 sobre alterno |
  | Texto secundario | `#5E5E5E` | 6,48:1; 6,00:1 sobre alterno |
  | Acento granate | `#8A1538` | 9,35:1; blanco sobre granate 9,35:1 |

- **Tipos:**
  - **Instrument Serif** (serif de display con regular y cursiva) solo para H1 y H2 grandes;
  - **Atkinson Hyperlegible Next** (Braille Institute, pesos 200-800, diseñada para lectores con baja visión) para todo lo demás;
  - alternativa: **Inter**.
- **Imágenes:**
  - pieza muy grande sobre paspartú gris claro;
  - cabeceras de sala con detalle macro a sangre (patrón 19);
  - ningún adorno.
- **Tono:** sobrio, moderno, «museo de verdad».
- **A favor:**
  - es la más fácil de mantener coherente;
  - envejece bien;
  - hace que cualquier escaneo parezca de museo nacional;
  - Atkinson Hyperlegible Next ayuda en el Aula y a mayores.
- **En contra:**
  - exige escaneos buenos (fondo limpio, color calibrado), porque sin ornamento no hay dónde esconder un mal recorte;
  - puede resultar fría o genérica;
  - pierde la identidad cálida actual que Felipe ya eligió;
  - Instrument Serif solo tiene un peso.

### 7.4 Recomendación

**«Álbum»**, por tres razones:
- conserva la paleta que ya funciona (granate sobre crema 7,83:1) y la que Felipe eligió;
- la montura negra resuelve cómo presentar sellos de cualquier color;
- con dos familias y un solo motivo gráfico se cumple el límite de tipografías del informe 04.

De «Estafeta» se puede tomar solo la letra de máquina para números de inventario y catálogo (IBM Plex Mono, que ya tiene latin). Eso sube a tres familias, así que hay que decidirlo con una maqueta delante.

### 7.5 Tipografías de Google Fonts seguras para el castellano

- **Qué cubre el subconjunto `latin`:** es el que sirve `fonts.googleapis.com/css2` y abarca `U+0000-00FF, U+0131, U+0152-0153, …, U+2000-206F, U+20AC, …`. Incluye `á é í ó ú ü ñ Á É Í Ó Ú Ü Ñ ¿ ¡ « » ª º ·` y el euro `€`. **Cualquier familia con `latin` sirve para castellano, catalán y valenciano.** `latin-ext` solo hace falta para otras lenguas (por ejemplo, la «ő» húngara).
- **Comprobado en `https://fonts.google.com/metadata/fonts`:** todas estas tienen `latin` y `latin-ext`:
  - **Serif:** Newsreader, Source Serif 4, Literata, Fraunces, EB Garamond, Cormorant Garamond, Libre Baskerville, Libre Caslon Text, Spectral, Crimson Pro, Lora, Merriweather, Noto Serif, Alegreya, Playfair Display, Bodoni Moda, DM Serif Display, Instrument Serif, Young Serif, Gloock, Old Standard TT, IBM Plex Serif, Zilla Slab, Roboto Slab, Cinzel, Ultra.
  - **Sans:** Public Sans, Inter, IBM Plex Sans, Work Sans, Archivo, Archivo Narrow, Barlow Condensed, Oswald, Libre Franklin, Chivo, DM Sans, Manrope, Figtree, Atkinson Hyperlegible, Atkinson Hyperlegible Next, Instrument Sans, Noto Sans, Open Sans, Roboto, Montserrat, Poppins, Josefin Sans, Alegreya Sans, Bebas Neue, Anton.
  - **Monoespaciadas y máquina de escribir:** IBM Plex Mono, Chivo Mono, Courier Prime, Space Mono, Special Elite.
- **Solo `latin`:** IM Fell English e IM Fell DW Pica (sin `latin-ext`). Valen para castellano, pero no para textos con caracteres de Europa central.
- **Cómo verificar antes de decidir:** escribir en la vista previa de la familia «¿Añoranza? ¡Ñandú! Pingüino, cigüeña, ÁÉÍÓÚ, 1,50 €» y mirar las mayúsculas acentuadas. Algunas display apretadas, como Bebas Neue o Anton, montan el acento sobre la línea superior.
- **Cómo cargarlas:** **autoalojadas** (woff2 dentro del tema, declaradas en `theme.json` › `fontFamilies`), nunca desde `fonts.googleapis.com`. Así no se envía la IP del visitante a Google (LG München I, 20-01-2022, 3 O 17493/20, citado en el informe 04). Solo el subconjunto `latin` y los pesos usados: 2 familias con 4 o 5 ficheros woff2 variables, frente a los 46 actuales.

---

## 8. Lo que queda abierto

| Decisión | Quién | Por qué importa |
|---|---|---|
| Dirección visual (Álbum, Estafeta o Sala blanca) | Felipe, con maqueta de portada y ficha | Todo lo demás cuelga de ella |
| Licencia de las imágenes propias (CC BY-SA 4.0, CC BY-NC o todos los derechos) | Felipe | Decide si hay botón de descarga (patrón 8) |
| Formato del número de inventario (`MPF-AAAA-NNN` propuesto) | Felipe | Hace falta para la cita (patrón 12) y los títulos |
| Analítica: ninguna o autoalojada sin cookies | Sergio y Felipe | Decide si hace falta banner (patrón 22) |
| Visor de zoom: el lightbox del núcleo o OpenSeadragon | Implementación | Solo afecta a la ficha; se puede empezar con el núcleo |

## Resumen

- Los referentes coinciden en un museo en línea sencillo: portada-vestíbulo, 5 entradas de menú, salas como exposiciones con recorrido y una ficha de pieza precisa con imagen sobre fondo neutro, datos en lista, facetas enlazadas, licencia y cita.
- Las mejores fichas postales son las de la Museumsstiftung (historia postal), el Musée Postal (sellos) y el NPM (títulos y montura negra). Hay que copiar sus campos y su presentación, no su tecnología.
- Los peores fallos observados son de mantenimiento, no de estética:
  - spam de apuestas en el museo de Correos;
  - widgets rotos y errores PHP a la vista;
  - URL que dan 404 tras migrar;
  - un certificado caducado y un dominio perdido.

  Un sitio sobrio, con redirecciones 301 y sin terceros, ya supera a la mayoría.
- Dirección recomendada: **«Álbum»** (crema `#F4EAD5`, tinta `#1A2E44`, granate `#8A1538` y montura `#1B1B1B`, con Newsreader y Public Sans autoalojadas). «Estafeta» y «Sala blanca» quedan como alternativas con pros y contras medidos.
- **Siguiente paso:** una maqueta de portada y de ficha en cada dirección para que Felipe elija, y el mapa 301 de las URL actuales antes de tocar nada en producción.
