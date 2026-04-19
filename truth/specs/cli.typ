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

    #scenario(
      "Version falls back to a non-empty sentinel when Composer metadata is missing",
      stage: unstable,
    )[
      #given[Composer has no installed-version record for a queried package]
      #when[the CLI resolves a version for a package #p((package: "does-not-exist/nothing"))]
      #then[the returned version token is non-empty]
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
    #scenario("validate on a syntactically valid OpenAPI document exits 0", stage: unstable)[
      #when[#the(PaogenCli) is invoked with arguments #p((args: "validate tests/fixtures/schemas/petstore-3.0.yaml"))]
      #then[#the(PaogenCli) should exit with code #p((code: "0"))]
    ]

    #scenario("validate on a malformed document reports on stderr and exits 1", stage: unstable)[
      #given[a temporary file that is not valid YAML]
      #when[#the(PaogenCli) is invoked with arguments #p((args: "validate <that-path>"))]
      #then[stderr should contain a parse-error signal]
      #and_[#the(PaogenCli) should exit with code #p((code: "1"))]
    ]

    #scenario("validate with no argument reports on stderr and exits 2", stage: unstable)[
      #when[#the(PaogenCli) is invoked with argument #p((arg: "validate"))]
      #then[stderr should contain #p((needle: "missing schema path"))]
      #and_[#the(PaogenCli) should exit with code #p((code: "2"))]
    ]
  ]

  #rule("Generate flags")[
    #scenario(
      "--output redirects the generated tree to the supplied directory",
      stage: unstable,
      traces: ("src/GenerateCommand.php",),
    )[
      #given[#a(Profile) at #p((path: "tests/fixtures/profiles/petstore.php")) whose declared `output` is `tests/fixtures/generated/petstore`]
      #when[#the(PaogenCli) is invoked with arguments #p((args: "generate tests/fixtures/profiles/petstore.php --output=<tmp-dir>"))]
      #then[the generated tree is written under #p((path: "<tmp-dir>")) instead of the profile's declared `output`]
      #and_[#the(PaogenCli) should exit with code #p((code: "0"))]
    ]

    #scenario(
      "--dry-run prints a tree summary and writes nothing",
      stage: unstable,
      traces: ("src/GenerateCommand.php", "src/Generator/PlanReporter.php"),
    )[
      #given[#a(Profile) at #p((path: "tests/fixtures/profiles/petstore.php"))]
      #and_[a fresh output directory at #p((path: "<tmp-dir>"))]
      #when[#the(PaogenCli) is invoked with arguments #p((args: "generate tests/fixtures/profiles/petstore.php --output=<tmp-dir> --dry-run"))]
      #then[stdout should contain #p((needle: "would write"))]
      #and_[the directory #p((path: "<tmp-dir>")) contains no files]
      #and_[#the(PaogenCli) should exit with code #p((code: "0"))]
    ]

    #scenario(
      "--diff against a matching golden tree exits 0 with no output",
      stage: unstable,
      traces: ("src/GenerateCommand.php", "src/Generator/PlanReporter.php"),
    )[
      #given[a temporary copy of #p((path: "tests/fixtures/generated/petstore")) at #p((path: "<tmp-dir>"))]
      #when[#the(PaogenCli) is invoked with arguments #p((args: "generate tests/fixtures/profiles/petstore.php --output=<tmp-dir> --diff"))]
      #then[stdout is empty]
      #and_[#the(PaogenCli) should exit with code #p((code: "0"))]
    ]

    #scenario(
      "--diff against a corrupted golden tree prints unified diff and exits 1",
      stage: unstable,
      traces: ("src/GenerateCommand.php", "src/Generator/PlanReporter.php"),
    )[
      #given[a temporary copy of #p((path: "tests/fixtures/generated/petstore")) at #p((path: "<tmp-dir>")) with one file truncated]
      #when[#the(PaogenCli) is invoked with arguments #p((args: "generate tests/fixtures/profiles/petstore.php --output=<tmp-dir> --diff"))]
      #then[stdout should contain #p((needle: "@@"))]
      #and_[#the(PaogenCli) should exit with code #p((code: "1"))]
    ]

    #scenario(
      "--dry-run combined with --diff is a usage error",
      stage: unstable,
      traces: ("src/GenerateCommand.php",),
    )[
      #when[#the(PaogenCli) is invoked with arguments #p((args: "generate tests/fixtures/profiles/petstore.php --dry-run --diff"))]
      #then[stderr should contain #p((needle: "mutually exclusive"))]
      #and_[#the(PaogenCli) should exit with code #p((code: "2"))]
    ]
  ]

  #rule("PHP 8.4 deprecation noise")[
    #scenario(
      "generate emits no PHP deprecation notices on 8.4",
      stage: unstable,
      traces: ("patches/cebe-php-openapi-php84-nullable.patch", "composer.json"),
    )[
      #given[#a(Profile) at #p((path: "tests/fixtures/profiles/petstore.php"))]
      #when[#the(PaogenCli) is invoked with arguments #p((args: "generate tests/fixtures/profiles/petstore.php"))]
      #then[neither stdout nor stderr contains #p((needle: "Deprecated:"))]
      #and_[#the(PaogenCli) should exit with code #p((code: "0"))]
    ]
  ]
]
