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
    bash scripts/build-docs

[doc("Serve the site locally")]
serve:
    cd www && tola serve

[doc("Build, render and validate the docs")]
[group("gate")]
check:
    bash scripts/check-docs
