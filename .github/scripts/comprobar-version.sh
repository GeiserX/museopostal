#!/usr/bin/env bash
# Comprueba que la etiqueta (v1.2.3) coincide con la versión del tema
# (style.css), la del plugin (cabecera) y su constante. Uso: comprobar-version.sh v1.2.3
set -euo pipefail
raiz="$(cd "$(dirname "$0")/../.." && pwd)"
etiqueta="${1:?Uso: comprobar-version.sh vX.Y.Z}"
version="${etiqueta#v}"

if ! [[ "$etiqueta" =~ ^v[0-9]+\.[0-9]+\.[0-9]+$ ]]; then
	echo "::error::La etiqueta «$etiqueta» no tiene la forma vX.Y.Z"
	exit 1
fi

tema="$(sed -n 's/^Version:[[:space:]]*//p' "$raiz/theme/museopostal/style.css" | tr -d '\r' | head -n1)"
plugin="$(sed -n 's/^[[:space:]*]*Version:[[:space:]]*//p' "$raiz/plugin/museopostal-coleccion/museopostal-coleccion.php" | tr -d '\r' | head -n1)"
constante="$(sed -n "s/^const MUSEOPOSTAL_COLECCION_VERSION = '\([^']*\)';/\1/p" "$raiz/plugin/museopostal-coleccion/museopostal-coleccion.php" | head -n1)"

fallos=0
for par in "tema (style.css):$tema" "plugin (cabecera):$plugin" "plugin (constante):$constante"; do
	nombre="${par%%:*}"
	valor="${par#*:}"
	if [ "$valor" != "$version" ]; then
		echo "::error::La versión del $nombre es «$valor» y la etiqueta pide «$version»"
		fallos=1
	else
		echo "OK $nombre = $valor"
	fi
done
exit "$fallos"
