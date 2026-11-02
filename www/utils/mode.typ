// The render mode, read from `sys.inputs` and nothing else.
//
// www/generate-md.sh renders each page a second time with typlite and
// `--input markdown=1`, into `index.md` beside the page's HTML. In that mode
// the page wrapper drops Tola's chrome and links point at the Markdown copies.
#let MARKDOWN = sys.inputs.at("markdown", default: "") == "1"
