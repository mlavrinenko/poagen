set quiet := true
set unstable := true
set working-directory := '..'
set script-interpreter := ["bash", "-eo", "pipefail"]

[default]
[private]
list:
    @just --list docs

[doc("Render README.md from docs/src")]
md:
    bash docs/generate-md.sh

[doc("Fail if README.md drifted from docs/src")]
[group("gate")]
md-check:
    bash scripts/check-docs-md

[doc("Build the site, render Markdown copies and llms.txt")]
build:
    cd www && tola build --clean
    bash www/generate-md.sh

[doc("Serve the site locally")]
serve:
    cd www && tola serve

[doc("Build, render and validate the docs")]
[group("gate")]
check: md-check
    cd www && tola build --clean
    bash www/generate-md.sh
    cd www && tola validate
