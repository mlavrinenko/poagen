<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Generated;

use PHPUnit\Framework\TestCase;

/**
 * Feature: poagen CLI
 *
 * The top-level poagen command dispatches to subcommands. This feature covers the always-available behaviors: help, version, and the response to an unknown command. Subcommand behavior lives in separate features.
 */
final class PoagenCLITest extends TestCase
{
    private PoagenCLISteps $steps;


    protected function setUp(): void
    {
        $this->steps = new PoagenCLISteps($this);
    }


    /**
     * Rule: Help
     *
     * Scenario: No arguments prints usage and exits 0
     * @source truth/specs/cli.feature-260417.typ:14
     *
     * When poagen CLI is invoked with no arguments
     * Then poagen CLI's stdout should contain "USAGE"
     *   And poagen CLI.exitCode should be 0
     */
    public function testNoArgumentsPrintsUsageAndExits0(): void
    {
        $this->steps->whenPoagenCLIIsInvokedWithNoArguments();
        $this->steps->thenPoagenCLIsStdoutShouldContainUSAGE();
        $this->steps->thenPoagenCLIExitCodeShouldBeCode(0);
    }


    /**
     * Scenario: --help prints usage and exits 0
     * @source truth/specs/cli.feature-260417.typ:20
     *
     * When poagen CLI is invoked with argument --help
     * Then poagen CLI's stdout should contain "USAGE"
     *   And poagen CLI should exit with code 0
     */
    public function testHelpPrintsUsageAndExits0(): void
    {
        $this->steps->whenPoagenCLIIsInvokedWithArgumentArg('--help');
        $this->steps->thenPoagenCLIsStdoutShouldContainUSAGE();
        $this->steps->thenPoagenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: help subcommand prints usage and exits 0
     * @source truth/specs/cli.feature-260417.typ:26
     *
     * When poagen CLI is invoked with argument help
     * Then poagen CLI's stdout should contain "USAGE"
     *   And poagen CLI should exit with code 0
     */
    public function testHelpSubcommandPrintsUsageAndExits0(): void
    {
        $this->steps->whenPoagenCLIIsInvokedWithArgumentArg('help');
        $this->steps->thenPoagenCLIsStdoutShouldContainUSAGE();
        $this->steps->thenPoagenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Rule: Version
     *
     * Scenario: --version prints the poagen version and exits 0
     * @source truth/specs/cli.feature-260417.typ:34
     *
     * When poagen CLI is invoked with argument --version
     * Then poagen CLI's stdout should start with poagen
     *   And poagen CLI should exit with code 0
     */
    public function testVersionPrintsThePoagenVersionAndExits0(): void
    {
        $this->steps->whenPoagenCLIIsInvokedWithArgumentArg('--version');
        $this->steps->thenPoagenCLIsStdoutShouldStartWithPrefix('poagen ');
        $this->steps->thenPoagenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: version subcommand prints the poagen version and exits 0
     * @source truth/specs/cli.feature-260417.typ:40
     *
     * When poagen CLI is invoked with argument version
     * Then poagen CLI's stdout should start with poagen
     *   And poagen CLI should exit with code 0
     */
    public function testVersionSubcommandPrintsThePoagenVersionAndExits0(): void
    {
        $this->steps->whenPoagenCLIIsInvokedWithArgumentArg('version');
        $this->steps->thenPoagenCLIsStdoutShouldStartWithPrefix('poagen ');
        $this->steps->thenPoagenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: Version falls back to a non-empty sentinel when Composer metadata is missing
     * @source truth/specs/cli.feature-260417.typ:46
     *
     * Given poagen CLI's Composer metadata has no installed-version record for a queried package
     * When poagen CLI resolves a version for a package does-not-exist/nothing
     * Then the version token poagen CLI returns is non-empty
     */
    public function testVersionFallsBackToANonEmptySentinelWhenComposerMetadataIsMissing(): void
    {
        $this->steps->givenPoagenCLIsComposerMetadataHasNoInstalledVersionRecordForAQueriedPackage();
        $this->steps->whenPoagenCLIResolvesAVersionForAPackagePackage('does-not-exist/nothing');
        $this->steps->thenVersionTokenPoagenCLIReturnsIsNonEmpty();
    }


    /**
     * Rule: Unknown command
     *
     * Scenario: Unknown command reports on stderr and exits 2
     * @source truth/specs/cli.feature-260417.typ:57
     *
     * When poagen CLI is invoked with argument does-not-exist
     * Then poagen CLI's stderr should contain is not implemented yet
     *   And poagen CLI should exit with code 2
     */
    public function testUnknownCommandReportsOnStderrAndExits2(): void
    {
        $this->steps->whenPoagenCLIIsInvokedWithArgumentArg('does-not-exist');
        $this->steps->thenPoagenCLIsStderrShouldContainNeedle('is not implemented yet');
        $this->steps->thenPoagenCLIShouldExitWithCodeCode(2);
    }


    /**
     * Rule: Validate subcommand
     *
     * Scenario: validate on a syntactically valid OpenAPI document exits 0
     * @source truth/specs/cli.feature-260417.typ:65
     *
     * Given a syntactically valid Schema document at <schema-path>
     * When poagen CLI is invoked with arguments validate <schema-path>
     * Then poagen CLI should exit with code 0
     */
    public function testValidateOnASyntacticallyValidOpenAPIDocumentExits0(): void
    {
        $this->steps->givenSyntacticallyValidSchemaDocumentAtPath('<schema-path>');
        $this->steps->whenPoagenCLIIsInvokedWithArgumentsArgs('validate <schema-path>');
        $this->steps->thenPoagenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: validate on a malformed document reports on stderr and exits 1
     * @source truth/specs/cli.feature-260417.typ:71
     *
     * Given a temporary malformed Schema file that is not valid YAML
     * When poagen CLI is invoked with arguments validate <that-path>
     * Then poagen CLI's stderr should contain a parse-error signal
     *   And poagen CLI should exit with code 1
     */
    public function testValidateOnAMalformedDocumentReportsOnStderrAndExits1(): void
    {
        $this->steps->givenTemporaryMalformedSchemaFileThatIsNotValidYAML();
        $this->steps->whenPoagenCLIIsInvokedWithArgumentsArgs('validate <that-path>');
        $this->steps->thenPoagenCLIsStderrShouldContainAParseErrorSignal();
        $this->steps->thenPoagenCLIShouldExitWithCodeCode(1);
    }


    /**
     * Scenario: validate with no argument reports on stderr and exits 2
     * @source truth/specs/cli.feature-260417.typ:78
     *
     * When poagen CLI is invoked with argument validate
     * Then poagen CLI's stderr should contain missing schema path
     *   And poagen CLI should exit with code 2
     */
    public function testValidateWithNoArgumentReportsOnStderrAndExits2(): void
    {
        $this->steps->whenPoagenCLIIsInvokedWithArgumentArg('validate');
        $this->steps->thenPoagenCLIsStderrShouldContainNeedle('missing schema path');
        $this->steps->thenPoagenCLIShouldExitWithCodeCode(2);
    }


    /**
     * Rule: Generate flags
     *
     * Scenario: --output redirects the generated tree to the supplied directory
     * @source truth/specs/cli.feature-260417.typ:86
     *
     * Given Profile at <profile-path> whose declared output is <declared-output-dir>
     * When poagen CLI is invoked with arguments generate <profile-path> --output=<tmp-dir>
     * Then the generated tree is written under <tmp-dir> instead of Profile's declared output
     *   And poagen CLI should exit with code 0
     */
    public function testOutputRedirectsTheGeneratedTreeToTheSuppliedDirectory(): void
    {
        $this->steps->givenProfileAtPathWhoseDeclaredOutputIsPath('<profile-path>', '<declared-output-dir>');
        $this->steps->whenPoagenCLIIsInvokedWithArgumentsArgs('generate <profile-path> --output=<tmp-dir>');
        $this->steps->thenGeneratedTreeIsWrittenUnderPathInsteadOfProfilesDeclaredOutput('<tmp-dir>');
        $this->steps->thenPoagenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: --dry-run prints a tree summary and writes nothing
     * @source truth/specs/cli.feature-260417.typ:96
     *
     * Given Profile at <profile-path>
     *   And a fresh directory at <tmp-dir> as poagen CLI's output target
     * When poagen CLI is invoked with arguments generate <profile-path> --output=<tmp-dir> --dry-run
     * Then poagen CLI's stdout should contain would write
     *   And poagen CLI's output directory at <tmp-dir> contains no files
     *   And poagen CLI should exit with code 0
     */
    public function testDryRunPrintsATreeSummaryAndWritesNothing(): void
    {
        $this->steps->givenProfileAtPath('<profile-path>');
        $this->steps->givenFreshDirectoryAtPathAsPoagenCLIsOutputTarget('<tmp-dir>');
        $this->steps->whenPoagenCLIIsInvokedWithArgumentsArgs('generate <profile-path> --output=<tmp-dir> --dry-run');
        $this->steps->thenPoagenCLIsStdoutShouldContainNeedle('would write');
        $this->steps->thenPoagenCLIsOutputDirectoryAtPathContainsNoFiles('<tmp-dir>');
        $this->steps->thenPoagenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: --diff against a matching golden tree exits 0 with no output
     * @source truth/specs/cli.feature-260417.typ:108
     *
     * Given a temporary copy of matching Generated File tree at <tmp-dir> for poagen CLI to diff against
     * When poagen CLI is invoked with arguments generate <profile-path> --output=<tmp-dir> --diff
     * Then poagen CLI's stdout is empty
     *   And poagen CLI should exit with code 0
     */
    public function testDiffAgainstAMatchingGoldenTreeExits0WithNoOutput(): void
    {
        $this->steps->givenTemporaryCopyOfMatchingGeneratedFileTreeAtPathForPoagenCLIToDiffAgainst('<tmp-dir>');
        $this->steps->whenPoagenCLIIsInvokedWithArgumentsArgs('generate <profile-path> --output=<tmp-dir> --diff');
        $this->steps->thenPoagenCLIsStdoutIsEmpty();
        $this->steps->thenPoagenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: --diff against a corrupted golden tree prints unified diff and exits 1
     * @source truth/specs/cli.feature-260417.typ:118
     *
     * Given a temporary copy of Generated File tree at <tmp-dir> for poagen CLI to diff against, with one file truncated
     * When poagen CLI is invoked with arguments generate <profile-path> --output=<tmp-dir> --diff
     * Then poagen CLI's stdout should contain @@
     *   And poagen CLI should exit with code 1
     */
    public function testDiffAgainstACorruptedGoldenTreePrintsUnifiedDiffAndExits1(): void
    {
        $this->steps->givenTemporaryCopyOfGeneratedFileTreeAtPathForPoagenCLIToDiffAgainstWithOneFileTruncated('<tmp-dir>');
        $this->steps->whenPoagenCLIIsInvokedWithArgumentsArgs('generate <profile-path> --output=<tmp-dir> --diff');
        $this->steps->thenPoagenCLIsStdoutShouldContainNeedle('@@');
        $this->steps->thenPoagenCLIShouldExitWithCodeCode(1);
    }


    /**
     * Scenario: --dry-run combined with --diff is a usage error
     * @source truth/specs/cli.feature-260417.typ:128
     *
     * When poagen CLI is invoked with arguments generate <profile-path> --dry-run --diff
     * Then poagen CLI's stderr should contain mutually exclusive
     *   And poagen CLI should exit with code 2
     */
    public function testDryRunCombinedWithDiffIsAUsageError(): void
    {
        $this->steps->whenPoagenCLIIsInvokedWithArgumentsArgs('generate <profile-path> --dry-run --diff');
        $this->steps->thenPoagenCLIsStderrShouldContainNeedle('mutually exclusive');
        $this->steps->thenPoagenCLIShouldExitWithCodeCode(2);
    }


    /**
     * Rule: PHP 8.4 deprecation noise
     *
     * Scenario: generate emits no PHP deprecation notices on 8.4
     * @source truth/specs/cli.feature-260417.typ:139
     *
     * Given Profile at <profile-path>
     * When poagen CLI is invoked with arguments generate <profile-path>
     * Then neither poagen CLI's stdout nor stderr contains Deprecated:
     *   And poagen CLI should exit with code 0
     */
    public function testGenerateEmitsNoPHPDeprecationNoticesOn84(): void
    {
        $this->steps->givenProfileAtPath('<profile-path>');
        $this->steps->whenPoagenCLIIsInvokedWithArgumentsArgs('generate <profile-path>');
        $this->steps->thenNeitherPoagenCLIsStdoutNorStderrContainsNeedle('Deprecated:');
        $this->steps->thenPoagenCLIShouldExitWithCodeCode(0);
    }
}
