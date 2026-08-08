<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\GenerationPlan;
use Poagen\Generator\Generator\Generator;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;

/**
 * keep-the-standalone-runtime-check-from-rotting-outside-the-gate.
 *
 * `scripts/verify-runtime-standalone` hand-writes a consumer (`run.php`)
 * against the petstore example's generated API, and that hand-written code
 * drifted out of step with the generated API twice without anyone noticing
 * — `security-wiring` gave `ApiClient` a credential per declared scheme
 * while `run.php` still constructed it with a transport alone, and
 * `typed-error-responses` replaced `getPetById`'s `Pet` return with an
 * `Envelope` while `run.php` still read the model directly. The check that
 * would have caught either sits outside `just check` on purpose — it
 * resolves a real composer project — so nothing ran it on either change.
 * See `truth/decisions/standalone-harness-drift-is-caught-offline.decision-
 * 260808.typ`.
 *
 * This test regenerates the petstore example from the same profile
 * (`examples/petstore/poagen.php`) `just check-examples` already treats as
 * the source of truth, through {@see Generator::plan()}
 * — entirely offline, no network, no disk write — and pins the exact two
 * shapes `run.php`'s hand-written call site depends on: how many positional
 * constructor arguments `ApiClient` takes, in what order, and what
 * `getPetById`'s `200` response hydrates into. A future change to either
 * shape now fails inside `just check`, on every push, offline — rather than
 * waiting on someone remembering `just verify-runtime-standalone` exists.
 *
 * Reproduced locally (uncommitted, reverted) by adding a third security
 * scheme to `examples/petstore/schemas/petstore-3.0.yaml`'s `getPetById`
 * operation without touching `scripts/verify-runtime-standalone`: this test
 * went red on the constructor-arity assertion below while
 * `just verify-runtime-standalone` itself kept passing, unaware, exactly
 * the silent-drift failure mode this test exists to close.
 */
final class StandaloneHarnessTracksGeneratedApiTest extends TestCase
{
    use GeneratedTreeSandbox;

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testApiClientTakesExactlyTheThreePositionalArgumentsTheHarnessPasses(): void
    {
        $apiClient = self::plannedSource($this->plan()->writes, 'ApiClient');

        // scripts/verify-runtime-standalone's run.php constructs the client
        // positionally: `new ApiClient($transport, 'scratch-api-key',
        // 'scratch-oauth-token')`. PHP does not typecheck a positional call
        // against parameter names, so a constructor that gains, loses, or
        // reorders a parameter breaks that call silently at runtime, not at
        // any check — this pins the exact three-parameter, three-line shape
        // run.php relies on.
        self::assertStringContainsString(
            "public function __construct(\n"
                . "        private TransportInterface \$transport,\n"
                . "        private string \$apiKey,\n"
                . "        private string \$petstoreAuth,\n"
                . '    ) {',
            $apiClient,
        );
    }

    public function testGetPetByIdReturnsAnEnvelopeWhoseTwoHundredBodyIsAPet(): void
    {
        $petClient = self::plannedSource($this->plan()->writes, 'PetClient');

        // run.php reads the result as `$envelope->status` and
        // `$envelope->body instanceof Pet` — an Envelope wrapping a Pet, not
        // a bare Pet. That is what typed-error-responses changed
        // getPetById into, and what run.php silently stopped matching until
        // 85d9da67 caught up with it by hand.
        self::assertStringContainsString('function getPetById(int $petId): Envelope', $petClient);

        self::assertStringContainsString(
            "ResponseType::envelope(new StatusResponseMap(exact: [['200', ResponseType::object(Pet::class)]",
            self::methodSlice($petClient, 'getPetById'),
        );
    }

    private function plan(): GenerationPlan
    {
        /** @var Profile $profile */
        $profile = require __DIR__ . '/../../examples/petstore/poagen.php';

        return self::generator()->plan($profile->with(output: self::makeSandboxDir('poagen-standalone-harness-drift-')));
    }
}
