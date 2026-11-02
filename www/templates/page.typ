// Page wrapper used by every content file.
//
//   #import "/templates/page.typ": page
//   #let meta = (title: "Quickstart", summary: "...")
//   #show: page.with(..meta)
//
// One binding feeds Tola's metadata and the on-page layout. In Markdown mode
// the chrome is dropped and typlite renders the title, summary and body.
#import "/templates/tola.typ": wrap-page
#import "/utils/mode.typ": MARKDOWN
#import "/utils/site.typ": REPO, SITE, u

#let _nav = (
  ("/", "Overview"),
  ("/quickstart/", "Quickstart"),
  ("/installation/", "Installation"),
  ("/profile/", "Profile"),
  ("/generated-code/", "Generated code"),
  ("/formats/", "Formats"),
  ("/cli/", "CLI"),
  ("/examples/", "Examples"),
  ("/status/", "Status"),
)

#let _html-page = wrap-page(
  head: (meta) => [
    #html.elem("meta", attrs: (charset: "utf-8"))
    #html.elem("meta", attrs: (name: "viewport", content: "width=device-width, initial-scale=1"))
    #html.elem("title")[#(
      if meta.title == SITE.title { meta.title } else { meta.title + " | " + SITE.title }
    )]
    #html.elem("meta", attrs: (name: "description", content: meta.summary))
    #html.elem("link", attrs: (rel: "stylesheet", href: "/assets/styles/main.css"))
  ],
  view: (body, meta) => {
    html.header(class: "site-header")[
      #html.a(href: u("/"))[#strong(SITE.title)]
      #html.nav(class: "site-nav")[
        #for (route, label) in _nav [
          #html.a(href: u(route))[#label]
        ]
      ]
    ]
    html.main[
      #html.h1[#meta.title]
      #if "summary" in meta { html.p(class: "lede")[#meta.summary] }
      #body
    ]
    html.footer[
      #html.a(href: REPO)[GitHub] · MIT
    ]
  },
)

#let _md-page(body, ..args) = {
  let meta = args.named()
  html.elem("h1")[#meta.title]
  parbreak()
  if "summary" in meta { par(meta.summary) }
  body
}

#let page = if MARKDOWN { _md-page } else { _html-page }
