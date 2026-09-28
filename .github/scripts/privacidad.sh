#!/usr/bin/env bash
# Busca datos personales en el código y en la muestra: DNI o NIE, correos de
# proveedores personales, enlaces wa.me y móviles españoles. El repositorio es
# público: nada de eso puede entrar. Uso: privacidad.sh [rutas…]
set -euo pipefail
raiz="$(cd "$(dirname "$0")/../.." && pwd)"
if [ "$#" -eq 0 ]; then
	set -- "$raiz/theme" "$raiz/plugin" "$raiz/playground"
fi

patron='\b[0-9]{8}-?[A-HJ-NP-TV-Z]\b|\b[XYZ][0-9]{7}[A-Z]\b|[A-Za-z0-9._%+-]+@(gmail|googlemail|hotmail|outlook|yahoo|icloud|live|msn)\.[a-z]+|wa\.me/|\+34[ -]?[6-9][0-9]{2}|\b[67][0-9]{8}\b'
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
echo "OK: $ficheros ficheros sin DNI, NIE, correos personales, wa.me ni móviles."
