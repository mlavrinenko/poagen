<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Generated;

use PHPUnit\Framework\TestCase;

/**
 * Feature: paogen CLI
 *
 * The top-level paogen command dispatches to subcommands. This feature covers the always-available behaviors: help, version, and the response to an unknown command. Subcommand behavior lives in separate features.
 */
final class PaogenCLITest extends TestCase
{
    private PaogenCLISteps $steps;


    protected function setUp(): void
    {
        $this->steps = new PaogenCLISteps($this);
    }


    /**
     * Rule: Help
     *
     * Scenario: No arguments prints usage and exits 0
     * @source truth/specs/cli.feature-260417.typ:14
     *
     * When paogen CLI is invoked with no arguments
     * Then paogen CLI's stdout should contain "USAGE"
     *   And paogen CLI should exit with code 0
     */
    public function testNoArgumentsPrintsUsageAndExits0(): void
    {
        $this->steps->whenPaogenCLIIsInvokedWithNoArguments();
        $this->steps->thenPaogenCLIsStdoutShouldContainUSAGE();
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: --help prints usage and exits 0
     * @source truth/specs/cli.feature-260417.typ:20
     *
     * When paogen CLI is invoked with argument --help
     * Then paogen CLI's stdout should contain "USAGE"
     *   And paogen CLI should exit with code 0
     */
    public function testHelpPrintsUsageAndExits0(): void
    {
        $this->steps->whenPaogenCLIIsInvokedWithArgumentArg('--help');
        $this->steps->thenPaogenCLIsStdoutShouldContainUSAGE();
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: help subcommand prints usage and exits 0
     * @source truth/specs/cli.feature-260417.typ:26
     *
     * When paogen CLI is invoked with argument help
     * Then paogen CLI's stdout should contain "USAGE"
     *   And paogen CLI should exit with code 0
     */
    public function testHelpSubcommandPrintsUsageAndExits0(): void
    {
        $this->steps->whenPaogenCLIIsInvokedWithArgumentArg('help');
        $this->steps->thenPaogenCLIsStdoutShouldContainUSAGE();
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Rule: Version
     *
     * Scenario: --version prints the paogen version and exits 0
     * @source truth/specs/cli.feature-260417.typ:34
     *
     * When paogen CLI is invoked with argument --version
     * Then paogen CLI's stdout should start with paogen
     *   And paogen CLI should exit with code 0
     */
    public function testVersionPrintsThePaogenVersionAndExits0(): void
    {
        $this->steps->whenPaogenCLIIsInvokedWithArgumentArg('--version');
        $this->steps->thenPaogenCLIsStdoutShouldStartWithPrefix('paogen ');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: version subcommand prints the paogen version and exits 0
     * @source truth/specs/cli.feature-260417.typ:40
     *
     * When paogen CLI is invoked with argument version
     * Then paogen CLI's stdout should start with paogen
     *   And paogen CLI should exit with code 0
     */
    public function testVersionSubcommandPrintsThePaogenVersionAndExits0(): void
    {
        $this->steps->whenPaogenCLIIsInvokedWithArgumentArg('version');
        $this->steps->thenPaogenCLIsStdoutShouldStartWithPrefix('paogen ');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: Version falls back to a non-empty sentinel when Composer metadata is missing
     * @source truth/specs/cli.feature-260417.typ:46
     *
     * Given paogen CLI's Composer metadata has no installed-version record for a queried package
     * When paogen CLI resolves a version for a package does-not-exist/nothing
     * Then the version token paogen CLI returns is non-empty
     */
    public function testVersionFallsBackToANonEmptySentinelWhenComposerMetadataIsMissing(): void
    {
        $this->steps->givenPaogenCLIsComposerMetadataHasNoInstalledVersionRecordForAQueriedPackage();
        $this->steps->whenPaogenCLIResolvesAVersionForAPackagePackage('does-not-exist/nothing');
        $this->steps->thenVersionTokenPaogenCLIReturnsIsNonEmpty();
    }


    /**
     * Rule: Unknown command
     *
     * Scenario: Unknown command reports on stderr and exits 2
     * @source truth/specs/cli.feature-260417.typ:57
     *
     * When paogen CLI is invoked with argument does-not-exist
     * Then paogen CLI's stderr should contain is not implemented yet
     *   And paogen CLI should exit with code 2
     */
    public function testUnknownCommandReportsOnStderrAndExits2(): void
    {
        $this->steps->whenPaogenCLIIsInvokedWithArgumentArg('does-not-exist');
        $this->steps->thenPaogenCLIsStderrShouldContainNeedle('is not implemented yet');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(2);
    }


    /**
     * Rule: Validate subcommand
     *
     * Scenario: validate on a syntactically valid OpenAPI document exits 0
     * @source truth/specs/cli.feature-260417.typ:65
     *
     * Given a syntactically valid Schema document at <schema-path>
     * When paogen CLI is invoked with arguments validate <schema-path>
     * Then paogen CLI should exit with code 0
     */
    public function testValidateOnASyntacticallyValidOpenAPIDocumentExits0(): void
    {
        $this->steps->givenSyntacticallyValidSchemaDocumentAtPath('<schema-path>');
        $this->steps->whenPaogenCLIIsInvokedWithArgumentsArgs('validate <schema-path>');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: validate on a malformed document reports on stderr and exits 1
     * @source truth/specs/cli.feature-260417.typ:71
     *
     * Given a temporary malformed Schema file that is not valid YAML
     * When paogen CLI is invoked with arguments validate <that-path>
     * Then paogen CLI's stderr should contain a parse-error signal
     *   And paogen CLI should exit with code 1
     */
    public function testValidateOnAMalformedDocumentReportsOnStderrAndExits1(): void
    {
        $this->steps->givenTemporaryMalformedSchemaFileThatIsNotValidYAML();
        $this->steps->whenPaogenCLIIsInvokedWithArgumentsArgs('validate <that-path>');
        $this->steps->thenPaogenCLIsStderrShouldContainAParseErrorSignal();
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(1);
    }


    /**
     * Scenario: validate with no argument reports on stderr and exits 2
     * @source truth/specs/cli.feature-260417.typ:78
     *
     * When paogen CLI is invoked with argument validate
     * Then paogen CLI's stderr should contain missing schema path
     *   And paogen CLI should exit with code 2
     */
    public function testValidateWithNoArgumentReportsOnStderrAndExits2(): void
    {
        $this->steps->whenPaogenCLIIsInvokedWithArgumentArg('validate');
        $this->steps->thenPaogenCLIsStderrShouldContainNeedle('missing schema path');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(2);
    }


    /**
     * Rule: Generate flags
     *
     * Scenario: --output redirects the generated tree to the supplied directory
     * @source truth/specs/cli.feature-260417.typ:86
     *
     * Given Profile at <profile-path> whose declared output is <declared-output-dir>
     * When paogen CLI is invoked with arguments generate <profile-path> --output=<tmp-dir>
     * Then the generated tree is written under <tmp-dir> instead of Profile's declared output
     *   And paogen CLI should exit with code 0
     */
    public function testOutputRedirectsTheGeneratedTreeToTheSuppliedDirectory(): void
    {
        $this->steps->givenProfileAtPathWhoseDeclaredOutputIsPath('<profile-path>', '<declared-output-dir>');
        $this->steps->whenPaogenCLIIsInvokedWithArgumentsArgs('generate <profile-path> --output=<tmp-dir>');
        $this->steps->thenGeneratedTreeIsWrittenUnderPathInsteadOfProfilesDeclaredOutput('<tmp-dir>');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: --dry-run prints a tree summary and writes nothing
     * @source truth/specs/cli.feature-260417.typ:96
     *
     * Given Profile at <profile-path>
     *   And a fresh directory at <tmp-dir> as paogen CLI's output target
     * When paogen CLI is invoked with arguments generate <profile-path> --output=<tmp-dir> --dry-run
     * Then paogen CLI's stdout should contain would write
     *   And paogen CLI's output directory at <tmp-dir> contains no files
     *   And paogen CLI should exit with code 0
     */
    public function testDryRunPrintsATreeSummaryAndWritesNothing(): void
    {
        $this->steps->givenProfileAtPath('<profile-path>');
        $this->steps->givenFreshDirectoryAtPathAsPaogenCLIsOutputTarget('<tmp-dir>');
        $this->steps->whenPaogenCLIIsInvokedWithArgumentsArgs('generate <profile-path> --output=<tmp-dir> --dry-run');
        $this->steps->thenPaogenCLIsStdoutShouldContainNeedle('would write');
        $this->steps->thenPaogenCLIsOutputDirectoryAtPathContainsNoFiles('<tmp-dir>');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: --diff against a matching golden tree exits 0 with no output
     * @source truth/specs/cli.feature-260417.typ:108
     *
     * Given a temporary copy of matching Generated File tree at <tmp-dir> for paogen CLI to diff against
     * When paogen CLI is invoked with arguments generate <profile-path> --output=<tmp-dir> --diff
     * Then paogen CLI's stdout is empty
     *   And paogen CLI should exit with code 0
     */
    public function testDiffAgainstAMatchingGoldenTreeExits0WithNoOutput(): void
    {
        $this->steps->givenTemporaryCopyOfMatchingGeneratedFileTreeAtPathForPaogenCLIToDiffAgainst('<tmp-dir>');
        $this->steps->whenPaogenCLIIsInvokedWithArgumentsArgs('generate <profile-path> --output=<tmp-dir> --diff');
        $this->steps->thenPaogenCLIsStdoutIsEmpty();
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: --diff against a corrupted golden tree prints unified diff and exits 1
     * @source truth/specs/cli.feature-260417.typ:118
     *
     * Given a temporary copy of Generated File tree at <tmp-dir> for paogen CLI to diff against, with one file truncated
     * When paogen CLI is invoked with arguments generate <profile-path> --output=<tmp-dir> --diff
     * Then paogen CLI's stdout should contain @@
     *   And paogen CLI should exit with code 1
     */
    public function testDiffAgainstACorruptedGoldenTreePrintsUnifiedDiffAndExits1(): void
    {
        $this->steps->givenTemporaryCopyOfGeneratedFileTreeAtPathForPaogenCLIToDiffAgainstWithOneFileTruncated('<tmp-dir>');
        $this->steps->whenPaogenCLIIsInvokedWithArgumentsArgs('generate <profile-path> --output=<tmp-dir> --diff');
        $this->steps->thenPaogenCLIsStdoutShouldContainNeedle('@@');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(1);
    }


    /**
     * Scenario: --dry-run combined with --diff is a usage error
     * @source truth/specs/cli.feature-260417.typ:128
     *
     * When paogen CLI is invoked with arguments generate <profile-path> --dry-run --diff
     * Then paogen CLI's stderr should contain mutually exclusive
     *   And paogen CLI should exit with code 2
     */
    public function testDryRunCombinedWithDiffIsAUsageError(): void
    {
        $this->steps->whenPaogenCLIIsInvokedWithArgumentsArgs('generate <profile-path> --dry-run --diff');
        $this->steps->thenPaogenCLIsStderrShouldContainNeedle('mutually exclusive');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(2);
    }


    /**
     * Rule: PHP 8.4 deprecation noise
     *
     * Scenario: generate emits no PHP deprecation notices on 8.4
     * @source truth/specs/cli.feature-260417.typ:139
     *
     * Given Profile at <profile-path>
     * When paogen CLI is invoked with arguments generate <profile-path>
     * Then neither paogen CLI's stdout nor stderr contains Deprecated:
     *   And paogen CLI should exit with code 0
     */
    public function testGenerateEmitsNoPHPDeprecationNoticesOn84(): void
    {
        $this->steps->givenProfileAtPath('<profile-path>');
        $this->steps->whenPaogenCLIIsInvokedWithArgumentsArgs('generate <profile-path>');
        $this->steps->thenNeitherPaogenCLIsStdoutNorStderrContainsNeedle('Deprecated:');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }
}
