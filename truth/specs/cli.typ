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
    #scenario("No arguments prints usage and exits 0")[
      #when[#the(PaogenCli) is invoked with no arguments]
      #then[stdout should contain "USAGE"]
      #and_[#the(PaogenCli) should exit with code #p((code: "0"))]
    ]

    #scenario("--help prints usage and exits 0")[
      #when[#the(PaogenCli) is invoked with argument #p((arg: "--help"))]
      #then[stdout should contain "USAGE"]
      #and_[#the(PaogenCli) should exit with code #p((code: "0"))]
    ]

    #scenario("help subcommand prints usage and exits 0")[
      #when[#the(PaogenCli) is invoked with argument #p((arg: "help"))]
      #then[stdout should contain "USAGE"]
      #and_[#the(PaogenCli) should exit with code #p((code: "0"))]
    ]
  ]

  #rule("Version")[
    #scenario("--version prints the paogen version and exits 0")[
      #when[#the(PaogenCli) is invoked with argument #p((arg: "--version"))]
      #then[stdout should start with #p((prefix: "paogen "))]
      #and_[#the(PaogenCli) should exit with code #p((code: "0"))]
    ]

    #scenario("version subcommand prints the paogen version and exits 0")[
      #when[#the(PaogenCli) is invoked with argument #p((arg: "version"))]
      #then[stdout should start with #p((prefix: "paogen "))]
      #and_[#the(PaogenCli) should exit with code #p((code: "0"))]
    ]
  ]

  #rule("Unknown command")[
    #scenario("Unknown command reports on stderr and exits 2")[
      #when[#the(PaogenCli) is invoked with argument #p((arg: "does-not-exist"))]
      #then[stderr should contain #p((needle: "is not implemented yet"))]
      #and_[#the(PaogenCli) should exit with code #p((code: "2"))]
    ]
  ]
]
