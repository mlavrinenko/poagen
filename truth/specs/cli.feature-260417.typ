#import "@local/speconaut:0.1.0": *
#import "../domain/cli.context.typ": cli-context, PoagenCli
#import "../domain/guidance.context.typ": guidance-context, Profile
#import "../domain/schema.context.typ": schema-context, Schema
#import "../domain/generation.context.typ": generation-context, GeneratedFile

#feature("poagen CLI", description: [
  The top-level `poagen` command dispatches to subcommands. This feature covers
  the always-available behaviors: `help`, `version`, and the response to an
  unknown command. Subcommand behavior lives in separate features.
])[

  #rule("Help")[
    #scenario("No arguments prints usage and exits 0", stage: "unstable")[
      #when[#the(PoagenCli) is invoked with no arguments]
      #then[#the(PoagenCli)'s stdout should contain "USAGE"]
      #and_[#the(PoagenCli.exitCode) should be #p((code: "0"))]
    ]

    #scenario("--help prints usage and exits 0", stage: "unstable")[
      #when[#the(PoagenCli) is invoked with argument #p((arg: "--help"))]
      #then[#the(PoagenCli)'s stdout should contain "USAGE"]
      #and_[#the(PoagenCli) should exit with code #p((code: "0"))]
    ]

    #scenario("help subcommand prints usage and exits 0", stage: "unstable")[
      #when[#the(PoagenCli) is invoked with argument #p((arg: "help"))]
      #then[#the(PoagenCli)'s stdout should contain "USAGE"]
      #and_[#the(PoagenCli) should exit with code #p((code: "0"))]
    ]
  ]

  #rule("Version")[
    #scenario("--version prints the poagen version and exits 0", stage: "unstable")[
      #when[#the(PoagenCli) is invoked with argument #p((arg: "--version"))]
      #then[#the(PoagenCli)'s stdout should start with #p((prefix: "poagen "))]
      #and_[#the(PoagenCli) should exit with code #p((code: "0"))]
    ]

    #scenario("version subcommand prints the poagen version and exits 0", stage: "unstable")[
      #when[#the(PoagenCli) is invoked with argument #p((arg: "version"))]
      #then[#the(PoagenCli)'s stdout should start with #p((prefix: "poagen "))]
      #and_[#the(PoagenCli) should exit with code #p((code: "0"))]
    ]

    #scenario(
      "Version falls back to a non-empty sentinel when Composer metadata is missing",
      stage: "unstable",
    )[
      #given[#the(PoagenCli)'s Composer metadata has no installed-version record for a queried package]
      #when[#the(PoagenCli) resolves a version for a package #p((package: "does-not-exist/nothing"))]
      #then[the version token #the(PoagenCli) returns is non-empty]
    ]
  ]

  #rule("Unknown command")[
    #scenario("Unknown command reports on stderr and exits 2", stage: "unstable")[
      #when[#the(PoagenCli) is invoked with argument #p((arg: "does-not-exist"))]
      #then[#the(PoagenCli)'s stderr should contain #p((needle: "is not implemented yet"))]
      #and_[#the(PoagenCli) should exit with code #p((code: "2"))]
    ]
  ]

  #rule("Validate subcommand")[
    #scenario("validate on a syntactically valid OpenAPI document exits 0", stage: "unstable")[
      #given[a syntactically valid #a(Schema) document at #p((path: "<schema-path>"))]
      #when[#the(PoagenCli) is invoked with arguments #p((args: "validate <schema-path>"))]
      #then[#the(PoagenCli) should exit with code #p((code: "0"))]
    ]

    #scenario("validate on a malformed document reports on stderr and exits 1", stage: "unstable")[
      #given[a temporary #a([malformed], Schema) file that is not valid YAML]
      #when[#the(PoagenCli) is invoked with arguments #p((args: "validate <that-path>"))]
      #then[#the(PoagenCli)'s stderr should contain a parse-error signal]
      #and_[#the(PoagenCli) should exit with code #p((code: "1"))]
    ]

    #scenario("validate with no argument reports on stderr and exits 2", stage: "unstable")[
      #when[#the(PoagenCli) is invoked with argument #p((arg: "validate"))]
      #then[#the(PoagenCli)'s stderr should contain #p((needle: "missing schema path"))]
      #and_[#the(PoagenCli) should exit with code #p((code: "2"))]
    ]
  ]

  #rule("Generate flags")[
    #scenario(
      "--output redirects the generated tree to the supplied directory",
      stage: "unstable",
    )[
      #given[#a(Profile) at #p((path: "<profile-path>")) whose declared `output` is #p((path: "<declared-output-dir>"))]
      #when[#the(PoagenCli) is invoked with arguments #p((args: "generate <profile-path> --output=<tmp-dir>"))]
      #then[the generated tree is written under #p((path: "<tmp-dir>")) instead of #the(Profile)'s declared `output`]
      #and_[#the(PoagenCli) should exit with code #p((code: "0"))]
    ]

    #scenario(
      "--dry-run prints a tree summary and writes nothing",
      stage: "unstable",
    )[
      #given[#a(Profile) at #p((path: "<profile-path>"))]
      #and_[a fresh directory at #p((path: "<tmp-dir>")) as #the(PoagenCli)'s output target]
      #when[#the(PoagenCli) is invoked with arguments #p((args: "generate <profile-path> --output=<tmp-dir> --dry-run"))]
      #then[#the(PoagenCli)'s stdout should contain #p((needle: "would write"))]
      #and_[#the(PoagenCli)'s output directory at #p((path: "<tmp-dir>")) contains no files]
      #and_[#the(PoagenCli) should exit with code #p((code: "0"))]
    ]

    #scenario(
      "--diff against a matching golden tree exits 0 with no output",
      stage: "unstable",
    )[
      #given[a temporary copy of #a([matching], GeneratedFile) tree at #p((path: "<tmp-dir>")) for #the(PoagenCli) to diff against]
      #when[#the(PoagenCli) is invoked with arguments #p((args: "generate <profile-path> --output=<tmp-dir> --diff"))]
      #then[#the(PoagenCli)'s stdout is empty]
      #and_[#the(PoagenCli) should exit with code #p((code: "0"))]
    ]

    #scenario(
      "--diff against a corrupted golden tree prints unified diff and exits 1",
      stage: "unstable",
    )[
      #given[a temporary copy of #a(GeneratedFile) tree at #p((path: "<tmp-dir>")) for #the(PoagenCli) to diff against, with one file truncated]
      #when[#the(PoagenCli) is invoked with arguments #p((args: "generate <profile-path> --output=<tmp-dir> --diff"))]
      #then[#the(PoagenCli)'s stdout should contain #p((needle: "@@"))]
      #and_[#the(PoagenCli) should exit with code #p((code: "1"))]
    ]

    #scenario(
      "--dry-run combined with --diff is a usage error",
      stage: "unstable",
    )[
      #when[#the(PoagenCli) is invoked with arguments #p((args: "generate <profile-path> --dry-run --diff"))]
      #then[#the(PoagenCli)'s stderr should contain #p((needle: "mutually exclusive"))]
      #and_[#the(PoagenCli) should exit with code #p((code: "2"))]
    ]
  ]

  #rule("PHP 8.4 deprecation noise")[
    #scenario(
      "generate emits no PHP deprecation notices on 8.4",
      stage: "unstable",
    )[
      #given[#a(Profile) at #p((path: "<profile-path>"))]
      #when[#the(PoagenCli) is invoked with arguments #p((args: "generate <profile-path>"))]
      #then[neither #the(PoagenCli)'s stdout nor stderr contains #p((needle: "Deprecated:"))]
      #and_[#the(PoagenCli) should exit with code #p((code: "0"))]
    ]
  ]
]
