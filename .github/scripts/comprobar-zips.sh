#!/usr/bin/env bash
# Comprueba que cada zip tiene una sola carpeta raíz fija y su fichero principal.
# Uso: comprobar-zips.sh <carpeta con los zips>
set -euo pipefail
carpeta="${1:?Uso: comprobar-zips.sh <carpeta>}"
fallos=0

comprobar() {
	local zip="$1" raiz="$2" principal="$3" entradas
	if [ ! -f "$zip" ]; then
		echo "::error::No existe $zip"
		return 1
	fi
	entradas="$(unzip -Z1 "$zip")"
	if ! grep -qx "$raiz/$principal" <<<"$entradas"; then
		echo "::error::$zip no tiene $raiz/$principal"
		return 1
	fi
	if grep -v "^$raiz/" <<<"$entradas" | grep -q .; then
		echo "::error::$zip tiene entradas fuera de $raiz/:"
		grep -v "^$raiz/" <<<"$entradas" | head -5
		return 1
	fi
	echo "OK $zip: $(wc -l <<<"$entradas" | tr -d ' ') entradas, todas bajo $raiz/, con $raiz/$principal"
}

comprobar "$carpeta/museopostal.zip" museopostal style.css || fallos=1
comprobar "$carpeta/museopostal-coleccion.zip" museopostal-coleccion museopostal-coleccion.php || fallos=1
exit "$fallos"
