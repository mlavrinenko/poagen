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
     * Rule: Unknown command
     *
     * Scenario: Unknown command reports on stderr and exits 2
     * @source truth/specs/cli.typ:48
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
     * @source truth/specs/cli.typ:56
     *
     * When paogen CLI is invoked with arguments validate tests/fixtures/schemas/petstore-3.0.yaml
     * Then paogen CLI should exit with code 0
     */
    #[\PHPUnit\Framework\Attributes\DoesNotPerformAssertions]
    public function testValidateOnASyntacticallyValidOpenAPIDocumentExits0(): void
    {
        $this->markTestIncomplete('Scenario is draft');
    }


    /**
     * Scenario: validate on a malformed document reports on stderr and exits 1
     * @source truth/specs/cli.typ:61
     *
     * Given a file at /tmp/broken.yaml that is not valid YAML
     * When paogen CLI is invoked with arguments validate /tmp/broken.yaml
     * Then stderr should contain the underlying parse error
     *   And paogen CLI should exit with code 1
     */
    #[\PHPUnit\Framework\Attributes\DoesNotPerformAssertions]
    public function testValidateOnAMalformedDocumentReportsOnStderrAndExits1(): void
    {
        $this->markTestIncomplete('Scenario is draft');
    }


    /**
     * Rule: Generate flags
     *
     * Scenario: --output redirects the generated tree to the supplied directory
     * @source truth/specs/cli.typ:70
     *
     * Given Profile at tests/fixtures/profiles/petstore.php whose declared output is tests/fixtures/generated/petstore
     * When paogen CLI is invoked with arguments generate tests/fixtures/profiles/petstore.php --output=/tmp/paogen-out
     * Then the generated tree is written under /tmp/paogen-out instead of the profile's declared output
     *   And paogen CLI should exit with code 0
     */
    #[\PHPUnit\Framework\Attributes\DoesNotPerformAssertions]
    public function testOutputRedirectsTheGeneratedTreeToTheSuppliedDirectory(): void
    {
        $this->markTestIncomplete('Scenario is draft');
    }
}
