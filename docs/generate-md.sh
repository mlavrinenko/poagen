#!/usr/bin/env bash
# Render docs/src/*.typ to the repository's Markdown files with typlite.
set -euo pipefail

cd "$(dirname "$0")/.."

render() {
  local src="$1" dest="$2" banner="$3"
  local tmp
  tmp="$(mktemp)"
  typlite --root . "$src" "$tmp"
  {
    printf '%s\n\n' "$banner"
    cat "$tmp"
  } > "$dest"
  rm -f "$tmp"
  echo "docs/generate-md.sh: wrote $dest"
}

render docs/src/readme.typ README.md \
  '<!-- Generated from docs/src/readme.typ by `just docs md`. Do not edit; edit the source. -->'
