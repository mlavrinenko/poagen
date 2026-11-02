// Site-wide constants. The product name and URL are declared here once.
#import "mode.typ": MARKDOWN

#let SITE = (
  title: "poagen",
  tagline: "OpenAPI-driven PHP client generator producing typed, extensible clients.",
  url: "https://mlavrinenko.github.io/poagen",
)

#let REPO = "https://github.com/mlavrinenko/poagen"
#let PREFIX = "/poagen"

// The Markdown copy of a route: `/quickstart/` becomes `/quickstart/index.md`.
#let md-path(path) = {
  let (base, ..frag) = path.split("#")
  let file = if base == "/" or base.ends-with("/") { base + "index.md" } else { base }
  if frag == () { file } else { file + "#" + frag.join("#") }
}

// A site-relative link. In the Markdown copy it points at the copy, by full URL.
#let u(path) = if MARKDOWN { SITE.url + md-path(path) } else { PREFIX + path }
