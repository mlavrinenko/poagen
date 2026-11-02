// Helpers for the Markdown sources rendered by docs/generate-md.sh.
//
// These sources are plain Typst. They do not import Tola, so typlite can walk
// them without the site's page show rule.
#import "../../www/utils/site.typ": SITE

// A link to a docs-site page, as an absolute URL.
#let site(route) = SITE.url + route

// The repository root.
#let repo = "https://github.com/mlavrinenko/poagen"
