#!/usr/bin/env bash
# Busca datos personales en el código, la muestra, el archivo y los documentos:
# DNI o NIE, correos de proveedores personales, enlaces wa.me y móviles
# españoles, también escritos con entidades HTML. El repositorio es público: nada de eso puede entrar. Uso: privacidad.sh [rutas…]
set -euo pipefail
raiz="$(cd "$(dirname "$0")/../.." && pwd)"
if [ "$#" -eq 0 ]; then
	set -- "$raiz/theme" "$raiz/plugin" "$raiz/playground" "$raiz/archive" "$raiz/docs"
fi

patron='\b[0-9]{8}-?[A-HJ-NP-TV-Za-hj-np-tv-z]\b|\b[XYZxyz][0-9]{7}[A-Za-z]\b|[A-Za-z0-9._%+-]+@(gmail|googlemail|hotmail|outlook|yahoo|icloud|live|msn)\.[a-z]+|wa\.me/|\+34[ -]?[6-9][0-9]{2}|\b[67][0-9]{2}([ .-]?[0-9]{3}[ .-]?[0-9]{3}|[ .-]?[0-9]{2}[ .-]?[0-9]{2}[ .-]?[0-9]{2})\b'
ficheros=0
while IFS= read -r -d '' f; do
	ficheros=$((ficheros + 1))
done < <(find "$@" -type f \( -name '*.php' -o -name '*.html' -o -name '*.json' -o -name '*.xml' -o -name '*.css' -o -name '*.js' -o -name '*.mjs' -o -name '*.md' -o -name '*.txt' \) -print0)
if [ "$ficheros" -eq 0 ]; then
	echo "::error::No hay ficheros que revisar en: $*"
	exit 1
fi

if grep -rnEI --include='*.php' --include='*.html' --include='*.json' --include='*.xml' --include='*.css' --include='*.js' --include='*.mjs' --include='*.md' --include='*.txt' "$patron" "$@"; then
	echo "::error::Posibles datos personales (arriba). Quítalos antes de publicar."
	exit 1
fi

# Segunda pasada sobre el texto decodificado: un correo escrito con referencias HTML
# (&#102;, &#x66;, &commat;) o con el señuelo de Complianz (<span class="cmplz-fmail-domain">
# entre la @ y el dominio) no coincide con el patrón en crudo, pero el navegador lo muestra entero.
if ! python3 - "$patron" "$@" <<'PY'
import html, os, re, sys
patron = re.compile(sys.argv[1])
senuelo = re.compile(r'<span class="cmplz-fmail-domain">[^<]*</span>')
etiqueta = re.compile(r'<[^>]*>')
extensiones = ('.php', '.html', '.json', '.xml', '.css', '.js', '.mjs', '.md', '.txt')
def ficheros(ruta):
	if os.path.isfile(ruta):
		yield ruta
	for base, _, nombres in os.walk(ruta):
		for nombre in nombres:
			if nombre.endswith(extensiones):
				yield os.path.join(base, nombre)
hallazgos = 0
for ruta in sys.argv[2:]:
	for f in ficheros(ruta):
		with open(f, encoding='utf-8', errors='replace') as fh:
			crudo = fh.read()
		texto = crudo
		for _ in range(3):  # también &amp;#64; y parecidos
			texto = html.unescape(texto)
		texto = re.sub(r'\\u([0-9a-fA-F]{4})', lambda m: chr(int(m.group(1), 16)), texto)
		texto = senuelo.sub('', texto)
		texto = etiqueta.sub(lambda m: '\n' * m.group().count('\n'), texto)
		if texto == crudo:
			continue  # sin entidades ni etiquetas: la primera pasada ya lo vio
		for m in patron.finditer(texto):
			hallazgos += 1
			print(f'{f}:{texto.count(chr(10), 0, m.start()) + 1}: {m.group()} (decodificado)')
sys.exit(1 if hallazgos else 0)
PY
then
	echo "::error::Posibles datos personales ocultos con entidades HTML (arriba). Quítalos antes de publicar."
	exit 1
fi
echo "OK: $ficheros ficheros sin DNI, NIE, correos personales, wa.me ni móviles."
