# museopostal.org: contenido extraído (semilla para el nuevo sitio)

Fecha de extracción: 28-09-2026. Fuente principal: `/tmp/felipe/backup/museopostal-export-all-2026-09-28.xml` (WXR; el texto sale de `_elementor_data`, no de `content:encoded`, que en varias páginas está desfasado). Comprobado contra el HTML servido en `/tmp/felipe/mirror/` y `/tmp/felipe/home.html`.

Convenciones:

- Solo se incluye prosa real. Los textos de relleno (plantillas de plugins, «Please select a Menu From Setting!», el aviso «tienda en obras») aparecen en el mapa de contenido (`03-auditoria-contenido.md`), no aquí.
- Solo se han corregido erratas evidentes (tildes, letras cambiadas, espacios, signos de apertura). Donde la corrección no es segura se marca `[fix?: …]`.
- Imágenes: `![texto alternativo](fichero)` con el id de adjunto de WordPress. Si el original no tenía texto alternativo se indica «alt vacío». Varios adjuntos se sirven hoy como `.webp` aunque Elementor guarde la URL `.jpg`; se da el nombre real de la biblioteca de medios cuando difiere.
- Datos personales: se omiten el DNI y el domicilio completo del titular (están en las páginas legales originales). Se conservan el correo y el enlace de WhatsApp porque son canales de contacto publicados en el sitio.

---

## 0. Identidad del sitio

- **Nombre:** Museo Postal y Filatélico de la Región de Murcia
- **Dominio:** museopostal.org
- **Lema actual (ajustes de WordPress):** «Estamos construyendo y dándole contenido. Estás en un sitio de iniciativa privada. ¡El 1 de agosto comenzamos!» (caducado: el sitio abrió el 1 de agosto de 2026).
- **Autor que firma las entradas:** «Conservador del Museo» (usuario `felipe`).
- **Director / titular:** Felipe Martínez Soriano.
- **Canales publicados:** correo [correo personal del titular] (páginas legales); buzón del formulario informacion@museopostal.org; WhatsApp [enlace wa.me al móvil personal] (página «Comparte tu pieza»).
- **Logotipos en la biblioteca:** `LOGOMUSPOS1.jpg` (adjunto 587, logo de la cabecera), `LOGOMUSEOPOSTAL.png` (adjunto 586, sello redondo usado al pie de Portada, Investigación y Contacto), `logotipo-mupo.png` (149/207, antiguo, sin uso).

---

## 1. Portada (página 235, «Museos», https://museopostal.org/)

¡Bienvenida y bienvenido! Espero que disfrute de museopostal.org.

Se encuentra en un museo virtual de filatelia e historia postal, fundado en Murcia y, por ello, con vocación de proyectar e interpretar la filatelia y la historia postal desde y para la Región de Murcia. Se trata de un proyecto que inicia su andadura, por lo que aún estamos trabajando en dar contenido a algunos de los enlaces. Si desea recibir un correo mensual con nuestra newsletter, donde le informemos de las novedades, complete y envíe el formulario de contacto.

**Mosaico de salas (6 botones con imagen y pie):**

| Pie en el original | Imagen | Destino actual |
|---|---|---|
| Museo Postal de la Región | `5_murcia.png` (233), alt vacío | sin enlace (existe la página `/museo_murcia/`, huérfana) |
| Museos Postales del Mundo | `4_museos.png` (232), alt vacío | `/museos-del-mundo/` |
| Comparte tu pieza con el Museo | `5_murcia.png` (233, la misma imagen que el primero), alt vacío | sin enlace (existe `/pagina_wasap/`, huérfana) |
| La Historia Postal en la Pintura | `Logo_Museo_pintura.webp` (777), alt vacío | `/elementor-854/` |
| Juegos y Juguetes .... postales | `Logo_Museo_juguete.webp` (776), alt vacío | sin enlace, sala sin contenido |
| Los Eclipses Solares en la Filatelia | `botonEclipse.webp` (920), alt «Boton Filatelia y Eclipes» [fix: «Botón Filatelia y eclipses»] | `/eclipse-solar-agosto-2026-filatelia-correos-espana/` (se abre en pestaña nueva) |

Pie de la portada: `LOGOMUSEOPOSTAL.png` (586), alt vacío.

**Botones de una versión anterior de la portada** (subidos como hijos de la página 235, hoy sin uso; sirven como mapa de secciones que Felipe tenía previstas): `1_blog.png` (229), `2_revistas.png` (230), `3_tienda.png` (231), `4_museos.png` (232), `5_murcia.png` (233), `6_lineatiempo.png` (234), `7_exposicions.png` (237) [fix?: «exposiciones»], `8_ultimasemisiones.png` (238), `9_elinforme.png` (239), `10_contacto.png` (240, alt «Acceso Formulario de Contacto»), `11_conferencias.png` (241), `12_honorarios.png` (242). Hay una segunda serie en WebP también sin uso: `carteros-honorarios.webp` (704), `comparte.webp` (705), `informesemanal.webp` (706, alt «ULTIMAS NOTICIAS SOBRE FILATELIA HISTORIA POSTAL»), `museomurcia.webp` (707), `videoconferencias.webp` (709).

---

## 2. Salas del museo

### 2.1 La Historia Postal en la Pintura (página 854 «Las_pinturas», `/elementor-854/`)

Sin texto propio. Imagen de cabecera `CUADROS_EN_MUSEO.png` (863), alt «Sala museo». Galería de cuatro cuadros, cada uno con enlace a su ficha:

1. San Jerónimo leyendo una carta → página 821 (`Cuadro_1_res.jpg`, 823)
2. La carta de amor → página 827 (`cuadro_2_res.webp`, 829)
3. Las últimas diligencias del correo en Newcastle upon Tyne → página 836 (`cuadro_3_res.webp`, 843) [en la galería el pie dice «del correo de Newcastle»; la ficha dice «del correo en Newcastle»]
4. El cartero del pueblo → página 857 (`cuadro_4_res.jpg`, 858)

Una quinta obra, **Una mujer sellando una carta** (Chardin, página 753), existe pero no figura en la galería ni en ningún menú.

#### Obra 1: San Jerónimo leyendo una carta (página 821, título interno «Cuadro_1», `/elementor-821/`)

*Cuando lo espiritual se cruza con lo epistolar. Un motivo que trasciende lo religioso.*

Georges de la Tour, uno de los grandes maestros del tenebrismo francés, dirige aquí toda la fuerza dramática de su luz hacia un motivo sorprendentemente cotidiano: un santo, San Jerónimo, leyendo una misiva con una concentración casi mística.

El recurso es tan sencillo como efectivo: un haz de luz dirigido exclusivamente sobre el papel escrito, dejando el resto de la composición en penumbra. De esta manera, De la Tour combina la tradición de la pintura religiosa de santos con un objeto absolutamente terrenal, la carta, elevándolo, por la fuerza de la luz, a la categoría de revelación.

Más allá de su lectura espiritual, esta obra confirma que, ya en el primer tercio del siglo XVII, el acto de leer una carta se había convertido en un motivo pictórico lo bastante potente como para protagonizar incluso escenas de tema sacro, mucho antes de que los pintores de género holandeses lo convirtieran en su sello distintivo.

- Georges de la Tour (1593–1652)
- San Jerónimo leyendo una carta, 1627–1629
- Francia — Barroco francés (tenebrismo)
- Museo del Prado

![San Jerónimo leyendo una carta](Cuadro_1_res.jpg) (adjunto 823)

#### Obra 2: La carta de amor (página 827, título interno «Cuadro_2», `/elementor-821-copy/`)

*Aceptar la carta o no: la primera decisión importante.*

Más de un siglo después del Siglo de Oro de Vermeer, el motivo de la carta de amor seguía siendo terreno fértil para la pintura neerlandesa, aunque bajo un lenguaje estético completamente distinto: el equilibrio, la contención formal y la claridad compositiva del Neoclasicismo.

Willem Bartel van der Kooi centra la composición en el gesto íntimo de la lectura amorosa, pero despojado de los claroscuros y los ambientes domésticos abigarrados del Barroco. El resultado es una imagen más serena, casi idealizada, en la que el sentimiento romántico se expresa con la misma mesura que cualquier otro tema neoclásico. Es una de las pinturas más célebres de este autor y actualmente forma parte de la colección del Rijksmuseum de Ámsterdam.

La obra capta un momento de gran carga dramática y sutil: un joven mensajero entrega una carta cerrada con un sello de lacre rojo a una mujer de la alta burguesía, vestida con la moda estilo Imperio de la época. Lo fascinante del cuadro es la expresión expectante y algo melancólica de ella, que duda por un instante antes de tomar la carta, suspendiendo el gesto en el aire mientras el chico observa discretamente su reacción.

- Willem Bartel van der Kooi (1768–1836)
- La carta de amor (The Love Letter), 1808
- Países Bajos — Neoclasicismo
- Rijksmuseum, Ámsterdam

![La carta de amor. Cuadro Rijksmuseum, Ámsterdam, Países Bajos](cuadro_2_res.webp) (adjunto 829)

#### Obra 3: Las últimas diligencias del correo en Newcastle upon Tyne (página 836, título interno «Cuadro_3», `/cuadro_1-copy/`)

*Un funeral pictórico para la diligencia.*

James Pollard documenta aquí un momento de cambio de época muy concreto: el último viaje de la diligencia postal entre Edimburgo y Londres, en julio de 1847, justo cuando el ferrocarril empezaba a hacerse cargo del transporte de correspondencia a larga distancia en Gran Bretaña.

La escena, pintada en 1848, apenas un año después de los hechos, transmite una carga casi nostálgica: la diligencia y su escolta, con cuerno, pasajeros y cochero uniformado, aparecen retratados con el mismo cuidado de siempre, pero sabiendo el espectador de la época que se trata de una despedida.

Más allá de su valor estético, esta obra tiene un enorme interés documental para la historia postal británica: marca, casi con precisión de fecha, el momento de transición entre dos tecnologías de transporte del correo, la tracción animal y el ferrocarril.

- James Pollard (1792–1867)
- Las últimas diligencias del correo en Newcastle upon Tyne, 1848
- Reino Unido — Pintura británica de coaching (escenas de diligencias)
- Colección privada

![Las últimas diligencias del correo en Newcastle upon Tyne](cuadro_3_res.webp) (adjunto 843)

#### Obra 4: El cartero del pueblo (página 857, título interno «Cuadro_4», `/cuadro_1-copy-2/`)

*Antes del furgón y la moto, el correo rural llegaba a pie y a caballo, con una saca al hombro y un camino largo por delante, un homenaje a un oficio discreto.*

La pintura de género victoriana sintió una fascinación particular por los oficios populares, y Heywood Hardy dedica esta obra a una figura entrañable del paisaje rural británico: el cartero de pueblo, con su uniforme y su saca de reparto, recorriendo a pie los caminos entre granjas y aldeas.

En la Inglaterra victoriana, el cartero rural no era solo un funcionario que entregaba sobres: era, a menudo, una de las pocas conexiones regulares entre comunidades aisladas y el resto del país, portador de noticias, periódicos y correspondencia familiar en zonas donde el ferrocarril todavía no había llegado.

Hardy, conocido sobre todo por sus escenas con caballos y vida rural, retrata aquí ese oficio sin grandilocuencia, como parte natural del paisaje británico decimonónico, en una imagen que hoy resulta entrañable precisamente por su sencillez.

- Heywood Hardy (1842–1933)
- El cartero del pueblo (The Village Postman), siglo XIX
- Reino Unido — Pintura de género victoriana
- Colección privada

![Cuadro El cartero del pueblo o The Village Postman](cuadro_4_res.jpg) (adjunto 858)

#### Obra 5: Una mujer sellando una carta (página 753, `/jean-baptiste-simeon-chardin/`, huérfana)

![Jean-Baptiste-Siméon Chardin, Una mujer sellando una carta](Jean-Baptiste_Siméon_Chardin_013.jpg) (imagen externa, enlazada desde Wikimedia Commons: https://upload.wikimedia.org/wikipedia/commons/d/d5/Jean-Baptiste_Sim%C3%A9on_Chardin_013.jpg; no está en la biblioteca de medios)

### El secreto en el lacre: el día que Chardin pintó el alma del correo en el siglo XVIII

¿Alguna vez te has parado a pensar en lo que significaba enviar un mensaje antes de la invención del sello adhesivo? Hoy en día, un clic basta para cruzar el océano. Pero en el siglo XVIII, el acto de enviar una carta era un ritual casi sagrado, un proceso físico lleno de suspense, privacidad y destreza.

Para entender la magia de la **historia postal**, a veces tenemos que dar un paso atrás y mirar a través de los ojos de los grandes maestros del arte. Hoy nos detenemos ante una obra maestra que captura a la perfección la esencia del correo antiguo: **"La carta"** (*Une femme qui cachette une lettre*), pintada por el genio francés **Jean-Baptiste-Siméon Chardin** hacia **1733**.

### Los datos clave de la obra

- **Título original:** *Une femme qui cachette une lettre* (Una mujer sellando una carta).
- **Autor:** Jean-Baptiste-Siméon Chardin (1699–1779).
- **Año de creación:** hacia 1733.
- **Técnica:** Óleo sobre lienzo.
- **¿Dónde verla?** Pertenece a las prestigiosas colecciones del Castillo de Charlottenburg, en Berlín.

### La escena: Cuando el correo era un arte manual

A primera vista, Chardin nos regala una escena íntima y silenciosa. Una joven sirvienta o dama de la burguesía aparece concentrada, casi absorta, en una tarea muy específica. Frente a ella, sobre una mesa de madera, se despliegan las herramientas del oficio postal de la época: un tintero, plumas, papel y, el gran protagonista invisible, el fuego.

La mujer sostiene un pliego de papel cuidadosamente doblado (lo que hoy entenderíamos como el sobre primitivo) y está aplicando **lacre caliente** para sellar la correspondencia.

### Ideas sobre Historia Postal: El "sobre" antes del sobre

Para los apasionados de la filatelia y la historia postal que visitáis **museopostal.org**, este cuadro es una mina de oro histórica.

En 1733 **no existían los sobres comerciales** como los conocemos hoy (estos no se popularizaron hasta mediados del siglo XIX con la llegada del *Penny Black* y la reforma postal). Las cartas se escribían en una hoja, se doblaban sobre sí mismas dejando la parte exterior en blanco para la dirección, y se aseguraban con lacre fundido.

El sello de lacre no era un simple adorno; era la única garantía de que nadie leería el mensaje en el trayecto. Un sello roto equivalía a una flagrante violación de la privacidad. Además, las marcas de los anillos sigilares o cuños identificaban al remitente antes incluso de abrir el papel.

### La gran curiosidad: ¿Por qué hay un sirviente esperando al fondo?

Si te fijas bien en la penumbra del cuadro, detrás de la joven, emerge la figura de un lacayo o sirviente que espera pacientemente con la mirada baja. Esta sutil adición de Chardin encierra una de las mayores curiosidades de la logística postal del siglo XVIII.

En aquella época, **el sistema de postas no funcionaba como el actual**. No había buzones amarillos en cada esquina. Para enviar una carta, tenías dos opciones principales:

1. Pagar a un mensajero privado (el sirviente de la escena) para que la llevara en mano directamente al destinatario si era un trayecto local.
2. Enviar al criado a la oficina de correos (*bureau de poste*) más cercana para entregarla al correo real.

Chardin congela el tiempo justo en el instante previo a que la carta cambie de manos. La tensión dramática del cuadro radica en esa espera: el mensaje está a punto de dejar de ser secreto para iniciar su viaje por los caminos de Europa.

### Enfoque Artístico: La belleza de lo cotidiano

Mientras que otros pintores de la época (como Fragonard o Boucher) se dedicaban a pintar los excesos de la aristocracia y escenas mitológicas, Chardin se convirtió en el rey de la "cotidiana realidad". Su manejo de la luz, que cae suavemente sobre las manos de la mujer y el papel blanco, nos obliga a mirar lo que la sociedad de su tiempo consideraba banal. Chardin nos dice: *"Escribir y enviar una carta es un acto hermoso que merece ser inmortalizado"*.

### ¿Por qué este cuadro es un icono para los amantes del correo?

"La carta" de Chardin es mucho más que un óleo del rococó francés; es un documento histórico visual. Nos recuerda que el correo, antes de ser una industria masiva o un puñado de bytes electrónicos, fue una **extensión de las relaciones humanas hechas a mano**. Cada carta requería tiempo, fuego, cera y paciencia.

### 2.2 Los eclipses solares en la filatelia (página 925 «Eclipse_solar», `/eclipse-solar-agosto-2026-filatelia-correos-espana/`)

*El cielo, la tierra y las oficinas de Correos se preparan para un espectáculo que no se repite todos los días*

![HB Correos eclipse solar](eclipse_HB.jpg) (adjunto 929)

![eclipse en España](eclipse_Sello.jpg) (adjunto 930)

Imagina poder mirar hacia arriba y ver cómo, en pleno día, el Sol desaparece durante unos segundos. Eso es exactamente lo que va a pasar en España, y no una, sino tres veces en menos de tres años. Entre 2026 y 2028 nuestro país se convierte en un auténtico mirador astronómico mundial: dos eclipses solares totales —el 12 de agosto de 2026 y el 2 de agosto de 2027— y uno anular, el 26 de enero de 2028. Que se junten tantos eclipses observables desde un mismo territorio en tan poco tiempo es rarísimo, y por eso Correos ha querido dejar constancia de este momento con un sello dedicado a lo que ya se conoce como el Trío de Eclipses.

Pero, ¿qué tiene un eclipse solar que lo hace tan especial? Pues básicamente que es uno de los espectáculos más impresionantes que nos regala la naturaleza. Cuando la Luna se coloca justo delante del Sol y lo tapa por completo, el mundo cambia de golpe: baja la temperatura, el cielo se oscurece como si fuera de noche, empiezan a asomar estrellas y planetas... y, lo más fascinante, se hace visible la corona solar, esa capa exterior del Sol que normalmente el propio brillo del astro nos impide ver. Son apenas unos minutos, pero suficientes para dejar huella en quien lo presencia.

Y no es solo espectáculo: los eclipses han sido también un laboratorio natural para la ciencia. A lo largo de la historia han servido para estudiar el Sol de cerca y hasta para poner a prueba teorías astronómicas que de otra forma habría sido imposible comprobar. Así que cuando llegue el Trío de Eclipses, España no solo va a llenarse de curiosos con la mirada al cielo, sino también de astrónomos, investigadores y viajeros de medio mundo que no querrán perderse la cita.

El sello recoge todo esto en su diseño: la imagen de un eclipse total en plena fase de totalidad, acompañada del logotipo oficial creado para representar este trío de fenómenos, y un mapa de la península ibérica con la franja exacta por la que pasará la sombra de la Luna el 12 de agosto de 2026. Un pequeño trocito de papel que guarda la memoria de algo que muy pocas generaciones llegan a vivir.

### Detalles técnicos de la emisión

**Serie:** Ciencia. Eclipse total España 12 de agosto de 2026.

**Fecha de emisión:** 23 de julio de 2026

**Procedimiento de impresión:** Offset

**Papel:** Estucado, engomado, fosforescente.

**Tamaño:** 79,2 x 105,6 mm [fix?: probablemente es el tamaño de la hoja bloque; el sello mide 33 x 53 mm]

**Efectos en pliego:** hoja bloque de 1 sello de 33 x 53 mm

**Valor postal de los sellos:** 4 euros

**Tirada:** 65.000

Al final, esta emisión de Correos es mucho más que un sello coleccionable: es una invitación a levantar la vista y ser parte de un fenómeno que va a marcar un antes y un después en la historia de la observación astronómica en España.

![Tarjeta postal sobre el eclipse](ecli_tjCoruna.jpg) (adjunto 927)

![Matasellos de Correos](ecli_tjCoruna2.jpg) (adjunto 928)

### El eclipse en A Coruña

El Puerto de A Coruña, en colaboración con la Sociedad Filatélica de A Coruña, pondrá en circulación el día 12 de agosto diferente material filatélico con motivo del eclipse solar que se verá desde esta ciudad.

Con tal motivo se emitirá un TuSello tarifa A, una tarjeta postal prefranqueada de tarifa A y un matasellos conmemorativo.

A Coruña se une en una iniciativa postal con el Grupo Filatélico y Numismático Las Pintaderas [fix?: el original dice «Las Pintadera»] de La Orotava para conmemorar este interesante acontecimiento científico.

## Otros eclipses, otros países, otros sellos

Cómo las administraciones postales han grabado para la historia los eclipses solares que han ido aconteciendo.

![](ecli_1965_islascook.webp) (adjunto 932) — pie: «1965 - Islas Cook»

![](ecli_1965_islascook2.webp) (adjunto 931)

![](ecli_1998_antillas.webp) (adjunto 936) — pie: «1998 - Antillas Holandesas»

![](ecli_1999_austria.webp) (adjunto 937) — pie: «1999 - Austria»

![](ecli_1999_maldivas-1.webp) (adjunto 939) — pie: «1999 - Maldivas»

![](ecli_1999_rumania.webp) (adjunto 940) — pie: «1999 - Rumanía»

![](ecli_2002_angola.webp) (adjunto 941) — pie: «2002 - Angola»

![](ecli_2005_portugal.webp) (adjunto 942) — pie: «2005 - Portugal»

![](ecli_2016_indonesia.webp) (adjunto 943) — pie: «2016 - Indonesia»

![](ecli_2016_tanzania.webp) (adjunto 944) — pie: «2016 - Alemania / Tanzania»

![](ecli_2024_canada1.webp) (adjunto 945)

![](ecli_2024_canada2.webp) (adjunto 946) — pie: «2024 - Canadá» [fix?: el pie original está cortado en «2024 - Cá»]

![](ecli_2024_canada3.webp) (adjunto 947)

![](ecli_2024_gambia-1.webp) (adjunto 949) — pie: «2024 - Gambia»

![](ecli_2024_gambia2.webp) (adjunto 950)

### 2.3 Museo Postal de la Región (página 598 «Museo_murcia», `/museo_murcia/`, huérfana)

Sin texto. Solo tres imágenes, ninguna con texto alternativo:

- `1983_2697.jpg` (178): sello «España Correos 4 pta, La Parranda, 1983» (leído en la captura `/tmp/felipe/shots/museo_murcia-desktop.png`).
- `CANTONAL.jpg` (187): sello «España Correos, Efemérides, 1,85 €, Revolución Cantonal de Cartagena» (leído en la misma captura).
- `img20250708_13160778.jpg` (199), pie: «Narciso García Yepes (Lorca, 1927 - Murcia, 1997)».

Material murciano en la biblioteca sin publicar (candidato para esta sala): `1983_2690_SPDMurcia` (176 y 11), `1983_2690_SPDBarcelona` (175), `1983_2690_TMAX` (177), `1983_2697_SPD` (179), `3129_HB`, `3129_MATASELLOS`, `3129_sello` (180-182), `3151_matasellos`, `3151_SELLO` (183-184), `3460_HB` (185), `488_matasellospd` (167), `cartagena.jpg` (188), `81y85-1866-18-jun-aguilas-a-murcia-4-cuartos-azul-y-20-centimos-de-escudo-lila-mat-fechador-aguilas-murcia…jpg` (166, el nombre del fichero ya describe la pieza: carta de Águilas a Murcia del 18 de junio de 1866, 4 cuartos azul y 20 céntimos de escudo lila, matasellos fechador de Águilas), `SOBRE_GUERRA.webp` y `SOBRE_GUERRA2.webp` (209-210), `SPD_5040_BIS.jpg` (211), `468359497.jpg` (186), y los escaneos `img20250708_*` / `img20250711_*` (12-14, 26-28, 197-206).

### 2.4 Museos postales en el mundo (página 126, `/museos-del-mundo/`)

Encabezado: «Museos Postales en el Mundo». Sin más texto. Carrusel de ocho fotos sin pie ni texto alternativo; el país sale solo del nombre del fichero:

- `museo_paris.jpg` (110): París
- `museo_japon.jpg` (108): Japón
- `museo_londres.avif` (109): Londres
- `museo_espana-scaled.webp` (107): España
- `museo_eeuu.jpg` (106): Estados Unidos
- `museo_suecia.jpg` (111): Suecia
- `museo_chile.jpg` (105): Chile
- `museo_canada.webp` (104): Canadá

[fix?: faltan el nombre de cada museo, la ciudad y el enlace oficial; hay que pedírselos a Felipe]

### 2.5 Comparte tu pieza con el Museo (página 59 «Comparte_museo», `/pagina_wasap/`, huérfana)

¿Te gustaría ver tu tarjeta postal, un sobre con un matasellos local u otra pieza postal singular? Comparte una foto a través de WhatsApp pinchando en el enlace desde tu teléfono móvil.

- Botón: `wasap.png` (483), alt vacío, enlace [enlace wa.me al móvil personal]
- Ejemplos: `img20250711_18435472-scaled.jpg` (205) y `img20250711_18211656-scaled.jpg` (204), alt vacío.

### 2.6 Proyecto Aula 001: la tarjeta del soldado (página 118 «Proyecto_Aula_001», `/la-tarjeta-del-soldado/`, huérfana)

Sin texto. Dos escaneos: `tarjeta1gm1.jpg` (120) y `tarjeta1gm2.jpg` (121), ambos titulados «EPSON MFP image» y sin alt. Por el nombre del fichero y el slug, una tarjeta de soldado de la Primera Guerra Mundial [fix?: confirmar con Felipe]. Hoy esta página no muestra nada de esto: está configurada como página de tienda de WooCommerce y enseña el aviso «tienda en obras».

### 2.7 Juegos y juguetes postales

Sala anunciada en la portada (imagen `Logo_Museo_juguete.webp`, 776) sin página ni contenido.

---

## 3. Artículos del blog (entradas)

### 3.1 El wi-fi del siglo XIX (entrada 472, `/el-wi-fi-del-siglo-xix/`, publicada el 18-05-2026, modificada el 24-07-2026)

Imagen destacada: `cursuspublicus.jpg` (473). Categoría: «Sin categoría». Slug anterior: `el-correo-en-los-ultimos-2000-anos` (redirige con 301).

*La fascinante historia de cómo nos comunicábamos antes de la llegada de los sellos*

Imagínate por un momento la siguiente escena: escribes una carta urgente a un amigo que vive a trescientos kilómetros, la entregas a un mensajero y, cuando llega a su destino semanas después, **es tu amigo quien tiene que pagar la factura**. Si no tiene dinero o se niega a pagar, ¡tu mensaje se queda en el aire!

Hoy estamos acostumbrados a la velocidad del Wi-Fi, la instantaneidad de WhatsApp y la comodidad de las tarifas planas. Pero hubo un tiempo en que enviar un simple mensaje requería caballos desbocados, intrigas palaciegas y verdaderas redes de infraestructura imperial.

Bienvenido a la era prefilatélica: la época antes de que el 1 de enero de 1850 el primer sello de correos llegase a España para revolucionar las comunicaciones para siempre.

### 1. Los pioneros: de la red de calzadas romanas al trayecto del Sureste

Mucho antes de que existieran las estafetas modernas, el imperio romano ya sabía que mantener un territorio unido requería información rápida. En el año 27 a. C., el emperador Augusto creó el *cursus publicus*, una red de comunicaciones militar y estatal que utilizaba caballos, mensajeros a pie (cursores) y estaciones de descanso (mansiones) a lo largo de las calzadas.

Hacia el año 290 d. C., el célebre Itinerario de Antonino marcaba una ruta postal costera que conectaba Alicante, Cartagena, Lorca y Águilas. Siglos más tarde, en época andalusí, la **Ruta Murciana** tomó el relevo, situando a Lorca como un auténtico nudo estratégico de comunicaciones con bifurcaciones hacia Granada y Almería.

![carreta romana cursus publicus](cursuspublicus.jpg) (adjunto 473)

### 2. El «sello» que no pegaba: autenticidad en tiempos de Alfonso X

Cuando pensamos en un sello, nos viene a la mente un trozo de papel engomado con una ilustración bonita. Sin embargo, en el siglo XIII, en las Siete Partidas de Alfonso X el Sabio, la definición era completamente diferente:

> *«Sello es señal que el Rey u otro ome qualquier, manda fazer en metal, o en piedra, para firmar sus cartas con el»*

Aquel sello medieval no servía para pagar el envío, sino que actuaba como el precursor del certificado digital actual: una marca infalsificable grabada que garantizaba la identidad del emisor.

### 3. La familia Taxis: los gigantes de la logística medieval

¿Te suenan los carruajes amarillos? Todo empezó con la familia Taxis (o Tassis), una dinastía de emprendedores que logró monopolizar el correo en las cortes europeas mediante un eficiente sistema de carreras de postas y relevos.

Llegaron a gestionar más de **20.000 empleados, miles de caballos y carruajes amarillos y negros**. En 1505, Felipe el Hermoso nombró a Francesco II de Tassis Maestro de Postas de los Países Bajos y Borgoña, extendiendo su red a Castilla. Un movimiento envuelto en cierta polémica, pues esquivaba la recomendación explícita de la reina Isabel la Católica de no otorgar altos cargos civiles a extranjeros.

![Sello conmemorativo del Día del Sello, año 1988](tassis.jpg) (adjunto 474)

### 4. Cuando pagar el correo antes de tiempo era de «mal gusto»

Durante siglos, el transporte de cartas se pactaba de forma privada entre el remitente y el mensajero. No fue hasta noviembre de 1706 cuando Felipe V decidió recuperar el control del correo para la Corona, profesionalizándolo y convirtiéndolo en un servicio público y estratégico. En 1716 nació la **Superintendencia General de Correos**, regulando por primera vez las tarifas públicas.

Pero lo más curioso era la etiqueta social de la época: **el porteo lo pagaba casi siempre el destinatario**. Pagar la carta por adelantado se consideraba una falta de educación o un gesto de condescendencia, ya que insinuaba que la persona que la recibía no tenía solvencia económica para costearla.

![Sello 300 años de Correos en España](sello_300anos.jpg) (adjunto 880)

![Hoja bloque 300 años de Correos, 2016](HB_300ANOS.jpg) (adjunto 878)

![Matasellos 2016 300 años de Correos](mats_300anos.jpg) (adjunto 879)

### Un reflejo de nuestra necesidad de conectar

El periodo prefilatélico terminó en España en 1850 con el nacimiento del sello engomado de pago previo. Sin embargo, el estudio de aquellos antiguos sobres, marcas de tinta, tarifas y rutas nos recuerda algo fundamental: aunque la tecnología cambie —del pergamino a la posta a caballo, del sello al Wi-Fi—, **la necesidad humana de transmitir información, historias y afecto a través de la distancia sigue siendo exactamente la misma.**

### 3.2 El Correo Submarino (entrada 717, `/el-correo-submarino-2/`, publicada el 22-05-2026, modificada el 15-07-2026)

Imagen destacada: `775_sellos.jpg` (170). Categoría: «Sin categoría». Etiqueta existente pero no asignada: «Historia Postal Guerra Civil Española Correo submarino». El slug `/el-correo-submarino/` redirige aquí.

*Guerra Civil, Correo Submarino y Cartagena*

El 11 de mayo de 1938 se emite una Orden Ministerial que aparece publicada en la Gaceta de la República el 14 de mayo. Esa orden regula una emisión de sellos para sufragar un servicio postal singular hasta el día de hoy: establecer el servicio de correos mediante el transporte submarino.

![Serie de 6 sellos de la serie Correo Submarino](775_sellos.jpg) (adjunto 170)
*Pie: Los seis sellos de la serie Correo Submarino, de distinto color y valor.*

En plena Guerra Civil, surge la necesidad de mantener la comunicación postal con la isla de Menorca, que para este tiempo es la única isla balear fiel a la República. La Agencia Filatélica Oficial idea una forma de cubrir el pago de este servicio: En lugar de usar para el franqueo los sellos existentes, se utilizarán sellos emitidos exclusivamente para la correspondencia transportada de esta manera, con un objetivo que iba más allá de cubrir la tasa postal del servicio submarino: Sería un medio de obtener ingresos extras para comprar armamentos, munición y sobre todo alimentos y medicinas, sin olvidar el efecto propagandístico que tendría esta emisión de sellos para la República en un momento que el coleccionismo de sellos estaba de moda.

Los sellos se vendieron a través de la Agencia Filatélica Oficial de Barcelona, pagándose con moneda extranjera, y se publicitó su singularidad para atraer a coleccionistas de sellos de todo el mundo. Fue un éxito económico inesperado: aunque su valor nominal era relativamente bajo, la demanda en el mercado filatélico internacional se disparó, y se llegaron a pagar importantes sumas en el extranjero por estas series.

Estaban destinados a franquear correspondencia que teóricamente habría de ser transportada en submarino entre Barcelona y Mahón (Menorca), prácticamente aislada por el bloqueo franquista.

Los sellos fueron impresos en Barcelona, a donde se había trasladado el Gobierno de la República, por la imprenta Oliva de Vilanova. Estos diseños corresponden a unos dibujos de Antonio Serra que fueron aceptados tras el rechazo de los diseños proyectados por la empresa Rieusset de Barcelona, donde aparecían las efigies de Isaac Peral y Narciso Monturiol, y cuyos bocetos mostramos como curiosidad.

![Sellos Correo Submarino. Boceto no emitido](corresubmarino_bocet.png) (adjunto 718, en la biblioteca figura como corresubmarino_bocet.webp)
*Pie: Bocetos de la emisión de correo submarino propuesta y no realizada.*

Los diseños aceptados fueron convertidos en valores postales con facial de 1, 2, 4, 6, 10 y 15 pesetas, con diseños que representaban submarinos en superficie o en inmersión. También se lanzó una hoja-bloque conmemorativa con tres de los sellos, cuya tirada fue de 12 500 ejemplares. En total, se colocaron en circulación hasta 75 000 sellos.

La tirada y el sobrante de cada valor fue:

| Valor | Submarino representado | Emitidos | Sobrantes |
|---|---|---|---|
| 1 peseta | D1 | 20.000 | 6.265 |
| 2 pesetas | A1 | 15.000 | 5.776 |
| 4 pesetas | B2 | 12.000 | 3.443 |
| 6 pesetas | A1 | 10.000 | 1.904 |
| 10 pesetas | B2 | 10.000 | 1.907 |
| 15 pesetas | D1 | 8.000 | 277 |
| Hoja bloque, 3 valores (4, 6 y 15 pesetas) | | 12.500 | 1.673 |

A diferencia de lo que podría parecer, solo se realizó un viaje real de correo submarino entre Barcelona y Mahón. El submarino C-4 realizó el viaje. Era un sumergible de la Armada Republicana botado en 1929, y que no era ninguno de los submarinos que aparecían en los sellos. Este zarpó el 12 de agosto de 1938 de Barcelona y emprendió un arriesgado viaje hacia la isla, desafiando el bloqueo militar de los nacionales. Además de sacas de cartas, el submarino llevaba noticias del curso de la guerra, víveres de primera necesidad y sobre todo, la esperanza de la resistencia. Entre los tripulantes se encontraba un oficial de correos, D. Tomás Orós Jiménez que custodió los más de 400 sobres, la mayoría de ellos puestos en circulación con destino a comerciantes filatélicos y coleccionistas. También viajaba un periodista norteamericano, Werner Kell [fix?: comprobar el apellido del corresponsal], corresponsal de guerra de *The Saturday Evening Post* que se encargó de relatar la aventura en primera persona, en un artículo que apareció publicado el 11 de marzo de 1939 con el título Stamp War (Guerra de sellos). En su relato mencionó que solo hizo dos inmersiones: Una para esquivar un avión y otra para entrar en Mahón sin ser vistos por la patrullera nacional. Es muy probable que el periodista realizara esta travesía a petición de algún miembro del gobierno para ejercer de testigo y asegurar la cobertura a escala internacional.

El 17 de agosto a las 22 horas salió de Mahón y entró en Barcelona a las 22.30 del día siguiente.

Conozcamos algunos detalles de los submarinos que aparecían en los sellos.

#### Submarino D1

Este submarino se encontraba en construcción en Cartagena. Se dio la orden de construcción en noviembre de 1932 y por diversas razones, se realizó la entrega a la Armada en marzo de 1947. Estuvo en servicio hasta marzo de 1965.

![Sello de 1 peseta de la serie Correo Submarino](SUBMARINO_1PTA-e1779789486950.webp) (adjunto 734; alt vacío en el original)

![Sello de 15 pesetas de la serie Correo Submarino](SUBMARINO_15PTA-e1779789348921.webp) (adjunto 739; alt vacío en el original)

#### Submarino A1

Este submarino ya había causado baja al empezar la guerra. Fue comprado a Italia junto con otros dos submarinos, A2 y A3, siendo botado el 16 de abril de 1917 y entregado a España el 25 de agosto del mismo año. Se le conoce como el A1-Monturiol. Al finalizar su periodo útil viajó de la base de Mahón a la de Cartagena, donde causó baja en la Armada en enero de 1934.

![Sello de 2 pesetas de la serie Correo Submarino](SUBMARINO_2PTA-e1779789450833.webp) (adjunto 735; alt vacío en el original)

![Sello de 6 pesetas de la serie Correo Submarino](SUBMARINO_6PTA-e1779789314265.webp) (adjunto 737; alt vacío en el original)

#### Submarino B2

Fue uno de los seis submarinos de la clase B que fueron construidos en Cartagena por la Sociedad Española de Construcciones Navales (en la actualidad Navantia) para la Armada española en 1917, siendo su botadura en 1922. Al finalizar la contienda, se hallaba semihundido en Cartagena. Después de ser reflotado, se utilizó durante un tiempo en la Escuela Naval de Mecánicos de Ferrol, y a partir de 1948 como “central eléctrica flotante”, hasta 1951 cuando fue vendido para desguace. Cuando era trasladado de Ferrol a Avilés para su desguace, se hundió cuando se rompieron los cables de remolque.

![Sello de 4 pesetas de la serie Correo Submarino](SUBMARINO_4PTA-e1779789419437.webp) (adjunto 736; alt vacío en el original)

![Sello de 10 pesetas de la serie Correo Submarino](SUBMARINO_10PTA-e1779789289485.webp) (adjunto 738; alt vacío en el original)

El C-4 fue el protagonista de esta original peripecia, pero no tuvo el lucimiento de aparecer en ninguno de los sellos. Este submarino fue el encargado de realizar el viaje de ida y vuelta entre Barcelona y Mahón. Fue construido en el astillero de Cartagena y botado en julio de 1929. Durante la guerra civil tuvo un papel muy activo en diversas misiones. El 4 de marzo de 1939, un mes antes de finalizar la Guerra Civil, se produce la denominada Sublevación de Cartagena, que obliga al C-4 a abandonar la plaza. El 7 de marzo la tripulación pide asilo político en el puerto de Bizerta en Túnez. El 2 de abril de 1939, una vez finalizada la Guerra, el submarino navega rumbo a España a las órdenes de las tropas vencedoras. El 27 de junio de 1946 en el transcurso de unas maniobras frente al puerto de Sóller, impacta con el destructor Lepanto. El impacto partió la nave en dos y causó su hundimiento, falleciendo los 44 tripulantes.

Material relacionado en la biblioteca, sin publicar: `775_HB.jpg` (168, alt «Hoja Bloque Correo submarino»), `775_matasellos1.jpg` (169), `775_sobre_aniversario1975.jpg` (171), `775_sobre50aniv.jpeg`, `775_sobre50aniv1.jpeg` (alt «Aniversario primer viaje del Correo Submarino»), `775_sobre50aniv2.jpeg` (172-174), y dos PDF: `correo-submarino.pdf` (430, «Articulo Correo Submarino») y `CorreoSubmarinoBofarull-1.pdf` (747).

---

## 4. Investigación (página 691, `/investigacion/`)

Sin texto. Tres botones:

- **Videoconferencias** (`11_conferencias.png`, 241) → `/video-conferencias-historia-postal-y-filatelia/`
- **El informe semanal** (`9_elinforme.png`, 239): sin enlace. Iba a alimentarse con Feedzy desde FESOFI.ES, SOFIMA.ONLINE y rahf.es (importación en borrador, nunca activada).
- **Carteros Honorarios** (`12_honorarios.png`, 242): sin enlace ni contenido.

Secciones previstas en el borrador «Investigación - Copy» (página 748, no publicada): En la Pintura, Biblioteca, Hemeroteca, Revistas del mes, Informe AFINSA, Cotización actual.

### 4.1 Videoconferencias (página 97, título «11-Videoconferencias», `/video-conferencias-historia-postal-y-filatelia/`)

Sin texto. Seis vídeos de YouTube. Títulos y canal sacados del oEmbed público de YouTube el 28-09-2026 (el sitio no los muestra):

1. «La Guerra Civil Española en la Filatelia»: SOFIMA, Sociedad Filatélica de Madrid. https://youtu.be/UN_5rG_dqiQ
2. «Sellos de Isabel II: sus marcas y sus falsos (parte 1)», por Manuel Gago (Tintero) [fix?: YouTube dice «Manual Gago»]: Afinet / Ágora de Filatelia. https://youtu.be/zq1xeiuCDTM
3. «¡Ese sello es de 2 reales! El secreto del mítico 2 reales azul de 1851, por fin explicado»: Afinet / Ágora de Filatelia. https://youtu.be/Urkw7vTvUek
4. «El Correo en la Administración Central de Madrid hasta 1800»: SOFIMA. https://youtu.be/pbXu3SvLHb0
5. «Barcos en la Filatelia» (presentación del libro, Marcelino González Fernández): SOFIMA. https://youtu.be/89N1gaPyb1c
6. «El asedio de París durante la Guerra Franco-Prusiana»: SOFIMA. https://youtu.be/6iQwRhxRvxU

---

## 5. Tienda (página 548 «Tienda», `/elementor-548/`)

Sin texto propio; rejilla de productos (widget de Essential Addons).

### 5.1 125 Aniversario Submarino Peral (producto 382, variable)

- **Descripción corta:** «Sello aniversario de la botadura del submarino de Isaac Peral».
- **Descripción larga:** vacía.
- **Referencia (SKU):** «Edifil 5317».
- **Categoría:** Sellos.
- **Variantes (atributo «SELLO»):**

| Variante | Precio | Existencias | Imagen |
|---|---|---|---|
| Nuevo | 3,00 € | 2 | `Image_20251112_0006.jpg` (195) |
| Usado | **sin precio** (no se puede comprar) | 2 | 195 |
| Bloque de 4 | 6,00 € | 2 | 195 |
| SPD Madrid («SPD MAD») | 6,00 € | sin control | `Image_20251108_0001.jpg` (189) |
| SPD Barcelona («SPD BNA») | 6,00 € | 1 | 189 |
| SPD presentación [fix: «Presentación»] | 6,00 € | 2 | `Image_20251112_0007-scaled.jpg` (196) |

- **Textos alternativos** (sí están rellenados): 195 «Sello donde aparece la imagen de Isaac Peral y un submarino con fondo color turquesa»; 189 «Sello donde aparece la imagen de Isaac Peral y un submarino pegado en sobre conmemorativo»; 196 «… pegado en sobre conmemorativo de Cartagena».
- Escaneos de la misma serie sin usar: `Image_20251108_0002` a `_0005` (190-193), `Image_20251112_0005` (194).

### 5.2 Marcas utilizadas por la Censura Postal Nacional de 1936 a 1945 (producto 394, simple)

- **Precio:** 60,00 €. **Existencias:** 2. **Peso:** 1,1 kg. **Medidas:** 24 x 17 x 3 cm.
- **Descripción corta y larga:** vacías.
- **Código («Cod EAN» / GTIN):** 8493171700 [fix?: 10 dígitos; parece un ISBN-10 (84-931717-0-0), no un EAN-13].
- **Categorías:** Libros, FILATELIA. **Etiquetas:** CENSURA, ERNSTL L. HELLER [fix?: probablemente «Ernst L. Heller», autor], GUERRA CIVIL, MARCAS POSTALES, NACIONAL.
- **Imágenes:** `librocensura1.jpeg` (396, portada, alt vacío), `librocensura2.jpeg` (397, alt «Contra portada libro Censura postal Nacional» [fix: «Contraportada»]).

---

## 6. Contacto y boletín

### 6.1 Página Contacto (697, `/contacto/`)

Sin texto. Logo `LOGOMUSEOPOSTAL.png` (586) y el formulario Contact Form 7 n.º 798 («formulario_informacion»). Campos:

- Nombre* (marcador: «Escribe tu nombre completo»)
- Correo electrónico* (marcador: «ejemplo@correo.com»)
- Temas de interés (opcional, varios): Historia Postal, Filatelia, Tarjeta Postal, Filatelia Temática, Literatura Postal
- Comentarios (marcador: «Escribe aquí tus comentarios, consultas o sugerencias sobre el museo…»)
- Casilla obligatoria: «He leído y acepto la Política de Privacidad de museopostal.org» (el enlace apunta a `/politica-privacidad`, que da 404)
- Botón: «Enviar mensaje»
- Destino: informacion@museopostal.org. Asunto: «Nuevo mensaje de contacto - Museopostal.org».

### 6.2 Página Formulario de Contacto (324, `/formulario_informacion/`, huérfana)

Si deseas estar informado [fix?: el original dice «informad@»] de las novedades del sitio web, rellena y envía el siguiente formulario.

Formulario WPForms n.º 325 (no viene en el export; campos leídos del HTML servido): Nombre, Correo electrónico, un campo de texto con la etiqueta rota «interés de», Comentario o mensaje, «¿Qué asuntos son de tu interés?» (opción única: Sellos España, Historia Postal y Prefilatelia, Tarjeta postal, Filatelia temática, Otro) y la casilla «Acepto las políticas de privacidad de este sitio seguro». Botón «Enviar».

---

## 7. Textos legales

### 7.1 Política de privacidad (página 573, `/elementor-573/`)

Texto propio, pegado desde un PDF con saltos de línea duros (aquí ya unidos). Termina con una frase cortada.

El cumplimiento de la normativa sobre protección de datos personales es una prioridad para nosotros. A través de este documento, se informa a los usuarios del sitio web sobre el tratamiento de los datos que faciliten o que se recojan durante la navegación, de conformidad con el Reglamento General de Protección de Datos (RGPD) y la Ley Orgánica de Protección de Datos Personales y garantía de los derechos digitales (LOPDGDD).

Responsable: FELIPE MARTINEZ SORIANO

Domicilio: Calle [omitido], 30570, Murcia, España

Sitio Web: MUSEOPOSTAL.ORG

Contacto: [[email-omitido]]

#### 1. Datos que se recopilan

Este sitio web puede recoger datos de carácter personal de las siguientes formas:

- **Formularios de contacto o consultas:** Datos identificativos básicos como nombre, apellidos y dirección de correo electrónico, aportados de manera voluntaria por el usuario para resolver dudas o procesar solicitudes.
- **Datos de navegación:** Dirección IP, tipo de navegador, páginas visitadas y duración de la visita, recopilados de forma automatizada mediante cookies analíticas con el fin de optimizar la experiencia de usuario y medir el tráfico.

#### 2. Finalidad del tratamiento

Los datos personales facilitados por los usuarios serán tratados con las siguientes finalidades específicas:

- Atender, gestionar y responder de manera eficiente a las consultas, sugerencias o solicitudes de información recibidas a través de las vías habilitadas en la web.
- Garantizar el correcto funcionamiento técnico del sitio web, adaptando los contenidos de navegación a los dispositivos utilizados.
- Realizar estudios estadísticos anónimos sobre el comportamiento de las visitas dentro de la plataforma para implementar mejoras estructurales y de contenido.

#### 3. Legitimación para el tratamiento

La base legal que legitima el tratamiento de los datos personales es el consentimiento explícito del propio usuario. Al rellenar un formulario de contacto, marcar la casilla de aceptación legal correspondiente o consentir la política de cookies, el usuario autoriza expresamente el uso de su información de acuerdo con los términos expuestos en este documento. Este consentimiento puede ser revocado en cualquier momento sin carácter retroactivo.

#### 4. Plazo de conservación de los datos

Los datos personales se conservarán únicamente durante el tiempo estrictamente necesario para cumplir con la finalidad para la que fueron recabados, mientras no se solicite su supresión por parte del interesado, o bien durante los plazos legalmente establecidos por la normativa administrativa y fiscal aplicable para la atención de posibles responsabilidades.

#### 5. Destinatarios de los datos y cesión

Bajo ningún concepto se venderán, alquilarán ni cederán datos personales de los usuarios a terceras empresas o entidades ajenas sin un consentimiento previo y documentado. Únicamente se comunicarán datos a terceros cuando exista una obligación legal (Fuerzas y Cuerpos de Seguridad, Agencia Tributaria u órganos judiciales competentes) o a proveedores de servicios tecnológicos esenciales (como el proveedor de alojamiento web o hosting) que actúen bajo la estricta figura de encargados de tratamiento.

#### 6. Derechos del usuario

La normativa vigente otorga a los usuarios plenos derechos de control sobre sus datos de carácter personal. Estos derechos son los siguientes:

- **Acceso:** Derecho a saber si se están tratando sus datos y qué información concreta está almacenada.
- **Rectificación:** Derecho a solicitar la modificación de los datos cuando estos sean inexactos, incompletos o desactualizados.
- **Supresión (Olvido):** Derecho a requerir la eliminación definitiva de sus datos personales del sistema.
- **Oposición y Limitación:** Derecho a oponerse a un tratamiento concreto o solicitar que se suspenda temporalmente el uso de los datos bajo supuestos determinados por la ley.
- **Portabilidad:** Derecho a recibir sus datos en un formato estructurado y de uso común para transmitirlos a otro responsable de tratamiento.

Para ejercitar cualquiera de estos derechos, el usuario deberá remitir una solicitud por escrito adjuntando copia de su documento de identidad (DNI o equivalente) dirigida al domicilio postal del Titular indicado en el encabezado de este documento, o bien a través de la dirección de correo electrónico habilitada para tal fin.

#### 7. Medidas de seguridad

El sitio web cuenta con medidas de seguridad técnicas y organizativas proporcionales al riesgo del tratamiento de la información, tales como protocolos de cifrado de datos (HTTPS / SSL), cortafuegos y sistemas de almacenamiento seguro. Todo ello con el firme propósito de evitar cualquier alteración, pérdida, acceso no autorizado o fuga de los datos personales gestionados.

**Nota legal:** Esta declaración de privacidad se actualiza periódicamente para cumplir con los cambios normativos y de funcionalidad del sitio web. Se aconseja al usuario revisar este… [fix?: la frase está cortada en el original]

### 7.2 Condiciones de uso y de envío (página 662, `/elementor-662/`)

Plantilla genérica copiada de la web de otro comerciante filatélico. Arrastra datos de esa empresa (enlace y correo de estudifilatelic.com, domicilio «BARCELONA») y está guardada con tildes descompuestas (Unicode NFD, 103 marcas sueltas; aquí ya normalizadas a NFC). Hay que redactarla de nuevo; el texto se conserva solo como referencia.

### Condiciones de envío

Todos los envíos se realizan por correo certificado.

Si no está seguro con los gastos de envío a pagar solícitenos el total y lo más rápido posible le enviaremos por email factura con los gastos.

### Condiciones de uso

En cumplimiento de la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Información y de Comercio Electrónico (LSSI-CE), Felipe Martínez Soriano informa que es titular del sitio web www.museopostal.org [fix?: en el original «WWW.» enlaza a estudifilatelic.com, resto de una plantilla copiada]. De acuerdo con la exigencia del artículo 10 de la citada Ley, Felipe Martínez Soriano informa de los siguientes datos:

El titular de este sitio web es Felipe Martínez Soriano, con DNI [omitido en este documento; ver original] y domicilio en Murcia (C. P. 30570) [domicilio completo: ver original]. La dirección de correo electrónico de contacto con la empresa es: [[email-omitido]](<mailto:[email-omitido]>).

#### Usuario y régimen de responsabilidades

La navegación, acceso y uso por el sitio web de Felipe Martínez Soriano confiere la condición de usuario, por la que se aceptan, desde la navegación por el sitio web de Felipe Martínez Soriano, todas las condiciones de uso aquí establecidas sin perjuicio de la aplicación de la correspondiente normativa de obligado cumplimiento legal según el caso.

El sitio web de Felipe Martínez Soriano proporciona gran diversidad de información, servicios y datos. El usuario asume su responsabilidad en el uso correcto del sitio web. Esta responsabilidad se extenderá a:

- La veracidad y licitud de las informaciones aportadas por el usuario en los formularios extendidos por Felipe Martínez Soriano para el acceso a ciertos contenidos o servicios ofrecidos por el web.
- El uso de la información, servicios y datos ofrecidos por Felipe Martínez Soriano contrariamente a lo dispuesto por las presentes condiciones, la Ley, la moral, las buenas costumbres o el orden público, o que de cualquier otro modo puedan suponer lesión de los derechos de terceros o del mismo funcionamiento del sitio web.

#### Política de enlaces y exenciones de responsabilidad

Felipe Martínez Soriano no se hace responsable del contenido de los sitios web a los que el usuario pueda acceder a través de los enlaces establecidos en su sitio web y declara que en ningún caso procederá a examinar o ejercitar ningún tipo de control sobre el contenido de otros sitios de la red. Asimismo, tampoco garantizará la disponibilidad técnica, exactitud, veracidad, validez o legalidad de sitios ajenos a su propiedad a los que se pueda acceder por medio de los enlaces.

Felipe Martínez Soriano declara haber adoptado todas las medidas necesarias para evitar cualquier daño a los usuarios de su sitio web, que pudieran derivarse de la navegación por su sitio web. En consecuencia, Felipe Martínez Soriano no se hace responsable, en ningún caso, de los eventuales daños que por la navegación por Internet pudiera sufrir el usuario.

#### Modificaciones

Felipe Martínez Soriano se reserva el derecho a realizar las modificaciones que considere oportunas, sin aviso previo, en el contenido de su sitio web. Tanto en lo referente a los contenidos del sitio web, como en las condiciones de uso del mismo, o en las condiciones generales de contratación. Dichas modificaciones podrán realizarse a través de su sitio web por cualquier forma admisible en derecho y serán de obligado cumplimiento durante el tiempo en que se encuentren publicadas en el web y hasta que no sean modificadas válidamente por otras posteriores.

#### Servicios de contratación por internet

Ciertos contenidos de el sitio web de Felipe Martínez Soriano contienen la posibilidad de contratación por Internet. El uso de los mismos requerirá la lectura y aceptación obligatoria de las condiciones generales de contratación establecidas al efecto por Felipe Martínez Soriano.

#### Protección de datos

De conformidad con lo establecido en la normativa vigente en Protección de Datos de Carácter Personal, le informamos que sus datos serán incorporados al sistema de tratamiento titularidad de Felipe Martínez Soriano con CIF [fix?: el original pone «CIF» con el número del DNI; omitido] y domicilio en Murcia (C. P. 30570) [fix?: el original dice «30570-BARCELONA»], con la finalidad de poder facilitar, agilizar y cumplir los compromisos establecidos entre ambas partes. En cumplimiento con la normativa vigente, Felipe Martínez Soriano informa que los datos serán conservados durante el plazo estrictamente necesario para cumplir con los preceptos mencionados con anterioridad.

Le informamos que el tratamiento de sus datos está legitimado en el consentimiento del interesado y la ejecución correcta de un contrato.

Mientras no nos comunique lo contrario, entenderemos que sus datos no han sido modificados, que usted se compromete a notificarnos cualquier variación.

Felipe Martínez Soriano informa que procederá a tratar los datos de manera lícita, leal, transparente, adecuada, pertinente, limitada, exacta y actualizada. Es por ello que Felipe Martínez Soriano se compromete a adoptar todas las medidas razonables para que estos se supriman o rectifiquen sin dilación cuando sean inexactos.

De acuerdo con los derechos que le confiere la normativa vigente en protección de datos podrá ejercer los derechos de acceso, rectificación, limitación de tratamiento, supresión, portabilidad y oposición al tratamiento de sus datos de carácter personal así como del consentimiento prestado para el tratamiento de los mismos, dirigiendo su petición a la dirección postal indicada más arriba o al correo electrónico [[email-omitido]](<mailto:[email-omitido]>). Podrá dirigirse a la Autoridad de Control competente para presentar la reclamación que considere oportuna.

#### Propiedad intelectual e industrial

Felipe Martínez Soriano por sí misma o como cesionaria, es titular de todos los derechos de propiedad intelectual e industrial de su página web, así como de los elementos contenidos en la misma (a título enunciativo, imágenes, sonido, audio, vídeo, software o textos; marcas o logotipos, combinaciones de colores, estructura y diseño, selección de materiales usados, programas de ordenador necesarios para su funcionamiento, acceso y uso, etc.), titularidad de Felipe Martínez Soriano. Serán, por consiguiente, obras protegidas como propiedad intelectual por el ordenamiento jurídico español, siéndoles aplicables tanto la normativa española y comunitaria en este campo, como los tratados internacionales relativos a la materia y suscritos por España.

Todos los derechos reservados. En virtud de lo dispuesto en la Ley de Propiedad Intelectual, quedan expresamente prohibidas la reproducción, la distribución y la comunicación pública, incluida su modalidad de puesta a disposición, de la totalidad o parte de los contenidos de esta página web, con fines comerciales, en cualquier soporte y por cualquier medio técnico, sin la autorización de Felipe Martínez Soriano.

El usuario se compromete a respetar los derechos de Propiedad Intelectual e Industrial titularidad de Felipe Martínez Soriano. Podrá visualizar los elementos del portal e incluso imprimirlos, copiarlos y almacenarlos en el disco duro de su ordenador o en cualquier otro soporte físico siempre y cuando sea, única y exclusivamente, para su uso personal y privado. El usuario deberá abstenerse de suprimir, alterar, eludir o manipular cualquier dispositivo de protección o sistema de seguridad que estuviera instalado en las páginas de Felipe Martínez Soriano.

#### Acciones legales, legislación aplicable y jurisdicción

Felipe Martínez Soriano se reserva, asimismo, la facultad de presentar las acciones civiles o penales que considere oportunas por la utilización indebida de su sitio web y contenidos, o por el incumplimiento de las presentes condiciones.

La relación entre el usuario y el prestador se regirá por la normativa vigente y de aplicación en el territorio español. De surgir cualquier controversia las partes podrán someter sus conflictos a arbitraje o acudir a la jurisdicción ordinaria cumpliendo con las normas sobre jurisdicción y competencia al respecto. Felipe Martínez Soriano tiene su domicilio en Murcia, España. [fix?: el original dice «BARCELONA»]

### 7.3 Política de cookies (UE) (página 658, `/politica-de-cookies-ue/`)

La genera el plugin Complianz con el shortcode `[cmplz-document type="cookie-statement" region="eu"]`; no hay texto propio que conservar. Versión servida: «actualizada por última vez el 21 de mayo de 2026».

---

## 8. Pie de página (Neve)

«Todos los derechos reservados ®2026» [fix: «© 2026 Museo Postal y Filatélico de la Región de Murcia. Todos los derechos reservados.»] y el menú legal: Política de privacidad · Condiciones de uso y envío · Política de cookies (UE).
