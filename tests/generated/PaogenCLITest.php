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
     * @source truth/specs/cli.typ:14
     *
     * When paogen CLI is invoked with no arguments
     * Then stdout should contain "USAGE"
     *   And paogen CLI should exit with code 0
     */
    public function testNoArgumentsPrintsUsageAndExits0(): void
    {
        $this->steps->whenPaogenCLIIsInvokedWithNoArguments();
        $this->steps->thenStdoutShouldContainUSAGE();
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: --help prints usage and exits 0
     * @source truth/specs/cli.typ:20
     *
     * When paogen CLI is invoked with argument --help
     * Then stdout should contain "USAGE"
     *   And paogen CLI should exit with code 0
     */
    public function testHelpPrintsUsageAndExits0(): void
    {
        $this->steps->whenPaogenCLIIsInvokedWithArgumentArg('--help');
        $this->steps->thenStdoutShouldContainUSAGE();
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: help subcommand prints usage and exits 0
     * @source truth/specs/cli.typ:26
     *
     * When paogen CLI is invoked with argument help
     * Then stdout should contain "USAGE"
     *   And paogen CLI should exit with code 0
     */
    public function testHelpSubcommandPrintsUsageAndExits0(): void
    {
        $this->steps->whenPaogenCLIIsInvokedWithArgumentArg('help');
        $this->steps->thenStdoutShouldContainUSAGE();
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Rule: Version
     *
     * Scenario: --version prints the paogen version and exits 0
     * @source truth/specs/cli.typ:34
     *
     * When paogen CLI is invoked with argument --version
     * Then stdout should start with paogen
     *   And paogen CLI should exit with code 0
     */
    public function testVersionPrintsThePaogenVersionAndExits0(): void
    {
        $this->steps->whenPaogenCLIIsInvokedWithArgumentArg('--version');
        $this->steps->thenStdoutShouldStartWithPrefix('paogen ');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: version subcommand prints the paogen version and exits 0
     * @source truth/specs/cli.typ:40
     *
     * When paogen CLI is invoked with argument version
     * Then stdout should start with paogen
     *   And paogen CLI should exit with code 0
     */
    public function testVersionSubcommandPrintsThePaogenVersionAndExits0(): void
    {
        $this->steps->whenPaogenCLIIsInvokedWithArgumentArg('version');
        $this->steps->thenStdoutShouldStartWithPrefix('paogen ');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: Version falls back to a non-empty sentinel when Composer metadata is missing
     * @source truth/specs/cli.typ:46
     *
     * Given Composer has no installed-version record for a queried package
     * When the CLI resolves a version for a package does-not-exist/nothing
     * Then the returned version token is non-empty
     */
    public function testVersionFallsBackToANonEmptySentinelWhenComposerMetadataIsMissing(): void
    {
        $this->steps->givenComposerHasNoInstalledVersionRecordForAQueriedPackage();
        $this->steps->whenTheCLIResolvesAVersionForAPackagePackage('does-not-exist/nothing');
        $this->steps->thenTheReturnedVersionTokenIsNonEmpty();
    }


    /**
     * Rule: Unknown command
     *
     * Scenario: Unknown command reports on stderr and exits 2
     * @source truth/specs/cli.typ:57
     *
     * When paogen CLI is invoked with argument does-not-exist
     * Then stderr should contain is not implemented yet
     *   And paogen CLI should exit with code 2
     */
    public function testUnknownCommandReportsOnStderrAndExits2(): void
    {
        $this->steps->whenPaogenCLIIsInvokedWithArgumentArg('does-not-exist');
        $this->steps->thenStderrShouldContainNeedle('is not implemented yet');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(2);
    }


    /**
     * Rule: Validate subcommand
     *
     * Scenario: validate on a syntactically valid OpenAPI document exits 0
     * @source truth/specs/cli.typ:65
     *
     * When paogen CLI is invoked with arguments validate tests/fixtures/schemas/petstore-3.0.yaml
     * Then paogen CLI should exit with code 0
     */
    public function testValidateOnASyntacticallyValidOpenAPIDocumentExits0(): void
    {
        $this->steps->whenPaogenCLIIsInvokedWithArgumentsArgs('validate tests/fixtures/schemas/petstore-3.0.yaml');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: validate on a malformed document reports on stderr and exits 1
     * @source truth/specs/cli.typ:70
     *
     * Given a temporary file that is not valid YAML
     * When paogen CLI is invoked with arguments validate <that-path>
     * Then stderr should contain a parse-error signal
     *   And paogen CLI should exit with code 1
     */
    public function testValidateOnAMalformedDocumentReportsOnStderrAndExits1(): void
    {
        $this->steps->givenATemporaryFileThatIsNotValidYAML();
        $this->steps->whenPaogenCLIIsInvokedWithArgumentsArgs('validate <that-path>');
        $this->steps->thenStderrShouldContainAParseErrorSignal();
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(1);
    }


    /**
     * Scenario: validate with no argument reports on stderr and exits 2
     * @source truth/specs/cli.typ:77
     *
     * When paogen CLI is invoked with argument validate
     * Then stderr should contain missing schema path
     *   And paogen CLI should exit with code 2
     */
    public function testValidateWithNoArgumentReportsOnStderrAndExits2(): void
    {
        $this->steps->whenPaogenCLIIsInvokedWithArgumentArg('validate');
        $this->steps->thenStderrShouldContainNeedle('missing schema path');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(2);
    }


    /**
     * Rule: Generate flags
     *
     * Scenario: --output redirects the generated tree to the supplied directory
     * @source truth/specs/cli.typ:85
     *
     * Given Profile at tests/fixtures/profiles/petstore.php whose declared output is tests/fixtures/generated/petstore
     * When paogen CLI is invoked with arguments generate tests/fixtures/profiles/petstore.php --output=<tmp-dir>
     * Then the generated tree is written under <tmp-dir> instead of the profile's declared output
     *   And paogen CLI should exit with code 0
     */
    public function testOutputRedirectsTheGeneratedTreeToTheSuppliedDirectory(): void
    {
        $this->steps->givenProfileAtPathWhoseDeclaredOutputIsTestsFixturesGeneratedPetstore('tests/fixtures/profiles/petstore.php');
        $this->steps->whenPaogenCLIIsInvokedWithArgumentsArgs('generate tests/fixtures/profiles/petstore.php --output=<tmp-dir>');
        $this->steps->thenTheGeneratedTreeIsWrittenUnderPathInsteadOfTheProfilesDeclaredOutput('<tmp-dir>');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: --dry-run prints a tree summary and writes nothing
     * @source truth/specs/cli.typ:96
     *
     * Given Profile at tests/fixtures/profiles/petstore.php
     *   And a fresh output directory at <tmp-dir>
     * When paogen CLI is invoked with arguments generate tests/fixtures/profiles/petstore.php --output=<tmp-dir> --dry-run
     * Then stdout should contain would write
     *   And the directory <tmp-dir> contains no files
     *   And paogen CLI should exit with code 0
     */
    public function testDryRunPrintsATreeSummaryAndWritesNothing(): void
    {
        $this->steps->givenProfileAtPath('tests/fixtures/profiles/petstore.php');
        $this->steps->givenAFreshOutputDirectoryAtPath('<tmp-dir>');
        $this->steps->whenPaogenCLIIsInvokedWithArgumentsArgs('generate tests/fixtures/profiles/petstore.php --output=<tmp-dir> --dry-run');
        $this->steps->thenStdoutShouldContainNeedle('would write');
        $this->steps->thenTheDirectoryPathContainsNoFiles('<tmp-dir>');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: --diff against a matching golden tree exits 0 with no output
     * @source truth/specs/cli.typ:109
     *
     * Given a temporary copy of tests/fixtures/generated/petstore at <tmp-dir>
     * When paogen CLI is invoked with arguments generate tests/fixtures/profiles/petstore.php --output=<tmp-dir> --diff
     * Then stdout is empty
     *   And paogen CLI should exit with code 0
     */
    public function testDiffAgainstAMatchingGoldenTreeExits0WithNoOutput(): void
    {
        $this->steps->givenATemporaryCopyOfPathAtPath('tests/fixtures/generated/petstore', '<tmp-dir>');
        $this->steps->whenPaogenCLIIsInvokedWithArgumentsArgs('generate tests/fixtures/profiles/petstore.php --output=<tmp-dir> --diff');
        $this->steps->thenStdoutIsEmpty();
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }


    /**
     * Scenario: --diff against a corrupted golden tree prints unified diff and exits 1
     * @source truth/specs/cli.typ:120
     *
     * Given a temporary copy of tests/fixtures/generated/petstore at <tmp-dir> with one file truncated
     * When paogen CLI is invoked with arguments generate tests/fixtures/profiles/petstore.php --output=<tmp-dir> --diff
     * Then stdout should contain @@
     *   And paogen CLI should exit with code 1
     */
    public function testDiffAgainstACorruptedGoldenTreePrintsUnifiedDiffAndExits1(): void
    {
        $this->steps->givenATemporaryCopyOfPathAtPathWithOneFileTruncated('tests/fixtures/generated/petstore', '<tmp-dir>');
        $this->steps->whenPaogenCLIIsInvokedWithArgumentsArgs('generate tests/fixtures/profiles/petstore.php --output=<tmp-dir> --diff');
        $this->steps->thenStdoutShouldContainNeedle('@@');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(1);
    }


    /**
     * Scenario: --dry-run combined with --diff is a usage error
     * @source truth/specs/cli.typ:131
     *
     * When paogen CLI is invoked with arguments generate tests/fixtures/profiles/petstore.php --dry-run --diff
     * Then stderr should contain mutually exclusive
     *   And paogen CLI should exit with code 2
     */
    public function testDryRunCombinedWithDiffIsAUsageError(): void
    {
        $this->steps->whenPaogenCLIIsInvokedWithArgumentsArgs('generate tests/fixtures/profiles/petstore.php --dry-run --diff');
        $this->steps->thenStderrShouldContainNeedle('mutually exclusive');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(2);
    }


    /**
     * Rule: PHP 8.4 deprecation noise
     *
     * Scenario: generate emits no PHP deprecation notices on 8.4
     * @source truth/specs/cli.typ:143
     *
     * Given Profile at tests/fixtures/profiles/petstore.php
     * When paogen CLI is invoked with arguments generate tests/fixtures/profiles/petstore.php
     * Then neither stdout nor stderr contains Deprecated:
     *   And paogen CLI should exit with code 0
     */
    public function testGenerateEmitsNoPHPDeprecationNoticesOn84(): void
    {
        $this->steps->givenProfileAtPath('tests/fixtures/profiles/petstore.php');
        $this->steps->whenPaogenCLIIsInvokedWithArgumentsArgs('generate tests/fixtures/profiles/petstore.php');
        $this->steps->thenNeitherStdoutNorStderrContainsNeedle('Deprecated:');
        $this->steps->thenPaogenCLIShouldExitWithCodeCode(0);
    }
}
