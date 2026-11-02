#!/usr/bin/env bash
# Render every site page a second time as Markdown, beside its HTML, and write
# llms.txt. Tola builds first; this script only reads the result.
set -euo pipefail

cd "$(dirname "$0")"
site_url="https://mlavrinenko.github.io/poagen"
root="public/poagen"

[[ -d "$root" ]] || {
  echo "www/generate-md.sh: $root does not exist; run \`tola build\` first" >&2
  exit 1
}

shopt -s globstar nullglob
for src in content/**/*.typ; do
  rel="${src#content/}"
  rel="${rel%.typ}"
  if [[ "$rel" == "index" ]]; then
    dest="$root/index.md"
  else
    dest="$root/$rel/index.md"
  fi
  mkdir -p "$(dirname "$dest")"
  typlite --root . --input markdown=1 "$src" "$dest"
done

{
  echo "# poagen"
  echo
  echo "> OpenAPI-driven PHP client generator producing typed, extensible clients."
  echo
  while IFS= read -r html; do
    route="${html#"$root"}"
    route="${route%/index.html}"
    [[ -z "$route" ]] && route="/"
    title="$(grep -o '<title>[^<]*' "$html" | sed 's/<title>//')"
    desc="$(grep -o '<meta name="description" content="[^"]*' "$html" | sed 's/.*content="//')"
    echo "- [$title]($site_url$route): $desc"
  done < <(find "$root" -name index.html | sort)
} > "$root/llms.txt"

echo "www/generate-md.sh: wrote Markdown copies and llms.txt under $root"
