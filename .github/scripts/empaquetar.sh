#!/usr/bin/env bash
# Construye museopostal.zip y museopostal-coleccion.zip con su carpeta raíz fija
# (nunca el «Source code (zip)» de GitHub, cuya raíz museopostal-v1.0.0/ rompe
# la sustitución al actualizar). Uso: empaquetar.sh [carpeta de salida]
set -euo pipefail
raiz="$(cd "$(dirname "$0")/../.." && pwd)"
salida="${1:-$raiz/dist}"
mkdir -p "$salida"
salida="$(cd "$salida" && pwd)"
rm -f "$salida/museopostal.zip" "$salida/museopostal-coleccion.zip"

tmp="$(mktemp -d)"
trap 'rm -rf "$tmp"' EXIT
cp -R "$raiz/theme/museopostal" "$tmp/museopostal"
cp -R "$raiz/plugin/museopostal-coleccion" "$tmp/museopostal-coleccion"
find "$tmp" \( -name '.DS_Store' -o -name '*.orig' -o -name '*.rej' \) -delete

(cd "$tmp" && zip -qrX "$salida/museopostal.zip" museopostal)
(cd "$tmp" && zip -qrX "$salida/museopostal-coleccion.zip" museopostal-coleccion)
ls -l "$salida"/*.zip
