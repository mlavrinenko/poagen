// Feature: paogen CLI
// The thin command-line entry point: help, version, and unknown-command handling.

#import "@local/speconaut:0.1.0": *
#import "../domain.typ": *

#feature("paogen CLI", traces: ("src/Cli.php", "bin/paogen"), description: [
  The top-level `paogen` command dispatches to subcommands. This feature covers
  the always-available behaviors: `help`, `version`, and the response to an
  unknown command. Subcommand behavior lives in separate features.
])[

  #rule("Help")[
    #scenario("No arguments prints usage and exits 0", stage: unstable)[
      #when[#the(PaogenCli) is invoked with no arguments]
      #then[stdout should contain "USAGE"]
      #and_[#the(PaogenCli) should exit with code #p((code: "0"))]
    ]

    #scenario("--help prints usage and exits 0", stage: unstable)[
      #when[#the(PaogenCli) is invoked with argument #p((arg: "--help"))]
      #then[stdout should contain "USAGE"]
      #and_[#the(PaogenCli) should exit with code #p((code: "0"))]
    ]

    #scenario("help subcommand prints usage and exits 0", stage: unstable)[
      #when[#the(PaogenCli) is invoked with argument #p((arg: "help"))]
      #then[stdout should contain "USAGE"]
      #and_[#the(PaogenCli) should exit with code #p((code: "0"))]
    ]
  ]

  #rule("Version")[
    #scenario("--version prints the paogen version and exits 0", stage: unstable)[
      #when[#the(PaogenCli) is invoked with argument #p((arg: "--version"))]
      #then[stdout should start with #p((prefix: "paogen "))]
      #and_[#the(PaogenCli) should exit with code #p((code: "0"))]
    ]

    #scenario("version subcommand prints the paogen version and exits 0", stage: unstable)[
      #when[#the(PaogenCli) is invoked with argument #p((arg: "version"))]
      #then[stdout should start with #p((prefix: "paogen "))]
      #and_[#the(PaogenCli) should exit with code #p((code: "0"))]
    ]
  ]

  #rule("Unknown command")[
    #scenario("Unknown command reports on stderr and exits 2", stage: unstable)[
      #when[#the(PaogenCli) is invoked with argument #p((arg: "does-not-exist"))]
      #then[stderr should contain #p((needle: "is not implemented yet"))]
      #and_[#the(PaogenCli) should exit with code #p((code: "2"))]
    ]
  ]

  #rule("Validate subcommand")[
    #scenario("validate on a syntactically valid OpenAPI document exits 0", stage: draft)[
      #when[#the(PaogenCli) is invoked with arguments #p((args: "validate tests/fixtures/schemas/petstore-3.0.yaml"))]
      #then[#the(PaogenCli) should exit with code #p((code: "0"))]
    ]

    #scenario("validate on a malformed document reports on stderr and exits 1", stage: draft)[
      #given[a file at #p((path: "/tmp/broken.yaml")) that is not valid YAML]
      #when[#the(PaogenCli) is invoked with arguments #p((args: "validate /tmp/broken.yaml"))]
      #then[stderr should contain the underlying parse error]
      #and_[#the(PaogenCli) should exit with code #p((code: "1"))]
    ]
  ]

  #rule("Generate flags")[
    #scenario("--output redirects the generated tree to the supplied directory", stage: draft)[
      #given[#a(Profile) at #p((path: "tests/fixtures/profiles/petstore.php")) whose declared `output` is `tests/fixtures/generated/petstore`]
      #when[#the(PaogenCli) is invoked with arguments #p((args: "generate tests/fixtures/profiles/petstore.php --output=/tmp/paogen-out"))]
      #then[the generated tree is written under #p((path: "/tmp/paogen-out")) instead of the profile's declared `output`]
      #and_[#the(PaogenCli) should exit with code #p((code: "0"))]
    ]
  ]
]
