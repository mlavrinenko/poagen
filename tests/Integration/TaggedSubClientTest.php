<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use Mlavrinenko\Paogen\Tests\Support\PetstoreFixture;
use PHPUnit\Framework\TestCase;

/**
 * emit-tagged-subclients-with-interfaces: the caller surface is grained by tag
 * and every part of it is declared by an interface.
 *
 * Two problems, one fix. There was no declared contract, so a consumer wanting a
 * retry or a paginated iterator had nowhere to put it but inside a generated
 * file. And a flat client is the wrong injection unit: against kilbil a service
 * using two endpoints had to accept an object exposing all 36.
 *
 * The tag-normalisation half is not hypothetical. All eleven kilbil tags are
 * Russian words, and PHP would accept them as class names — which is exactly why
 * the transliteration and the rename path both have to work.
 */
final class TaggedSubClientTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string KILBIL = __DIR__ . '/../../examples/kilbil/schemas/loyalty_v1.yaml';
    private const string PETSTORE = __DIR__ . '/../fixtures/schemas/petstore-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\Tagged';

    /** @var array<string,string> */
    private const array KILBIL_SKIP = [
        'goodsxml' => 'application/xml request body — xml-content-type-policy',
        'goodslistxml' => 'application/xml request body — xml-content-type-policy',
    ];

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testEachTagBecomesAClassAndAnInterfaceDeclaringExactlyItsOwnMethods(): void
    {
        $plan = $this->petstorePlan();
        $names = $this->emittedNames($plan);

        foreach (['PetClient', 'StoreClient', 'UserClient'] as $client) {
            self::assertContains($client, $names);
            self::assertContains($client . 'Interface', $names);
        }

        $interface = $this->sourceOf($plan, 'StoreClientInterface');
        self::assertStringContainsString('public function getOrderById(int $orderId): Order;', $interface);
        // Exactly its own: a `pet` endpoint has no business on the store contract.
        self::assertStringNotContainsString('addPet', $interface);
        // The constructor is not part of the contract a decorator satisfies.
        self::assertStringNotContainsString('__construct', $interface);
    }

    public function testTheRootExposesOneAccessorPerTagAndNoFlatOperationMethods(): void
    {
        $root = $this->sourceOf($this->petstorePlan(), 'ApiClient');

        self::assertStringContainsString('public function pet(): PetClientInterface', $root);
        self::assertStringContainsString('public function store(): StoreClientInterface', $root);
        self::assertStringContainsString('public function user(): UserClientInterface', $root);

        // Exactly one way to reach any endpoint. Two would let a call site bypass
        // whatever decorator a consumer wrapped the sub-client in.
        self::assertStringNotContainsString('public function getOrderById', $root);
        self::assertStringNotContainsString('public function addPet', $root);
    }

    public function testASubClientIsConstructibleWithoutTheRoot(): void
    {
        $sub = $this->sourceOf($this->petstorePlan(), 'StoreClient');

        // Its own transport — nothing that requires the root object to exist,
        // and an interface rather than an implementation, so a consumer can
        // stand one up against a substitute runtime.
        self::assertStringContainsString('private TransportInterface $transport', $sub);
        self::assertStringNotContainsString('ApiClient $', $sub);
        self::assertStringNotContainsString('= new ', $sub);
    }

    public function testANonAsciiTagIsTransliteratedDeterministically(): void
    {
        $names = $this->emittedNames($this->plan(self::KILBIL, skip: self::KILBIL_SKIP));

        // PHP would accept `Клиенты` as a class name and the result would be
        // unusable, so the default is a readable romanisation rather than the
        // raw word or an invented `Tag1`.
        self::assertContains('KlientyClient', $names);
        self::assertContains('PodarochnyeSertifikatyClient', $names);
        // A tag the vendor already wrote in ASCII is untouched.
        self::assertContains('WalletClient', $names);
    }

    public function testAProfileTagRenameNamesTheSubClient(): void
    {
        $plan = $this->plan(self::KILBIL, skip: self::KILBIL_SKIP, tagRenames: ['Клиенты' => 'Customers']);
        $names = $this->emittedNames($plan);

        self::assertContains('CustomersClient', $names);
        self::assertContains('CustomersClientInterface', $names);
        self::assertNotContains('KlientyClient', $names);
        self::assertStringContainsString('public function customers(): CustomersClientInterface', $this->sourceOf($plan, 'ApiClient'));
    }

    public function testARenameNamingATagNoOperationCarriesFailsTheRun(): void
    {
        try {
            $this->plan(self::KILBIL, skip: self::KILBIL_SKIP, tagRenames: ['Клиенти' => 'Customers']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString('tagRenames', $e->getMessage());
            self::assertStringContainsString('no operation carries', $e->getMessage());
        }
    }

    public function testRegeneratingADocumentWhoseTagsDidNotChangeProducesNoDiff(): void
    {
        $first = $this->plan(self::KILBIL, skip: self::KILBIL_SKIP);
        $second = $this->plan(self::KILBIL, skip: self::KILBIL_SKIP);

        self::assertSame($this->byName($first), $this->byName($second));
    }

    /**
     * Petstore's octet-stream upload is unrepresentable and its `api_key`
     * requirement names a scheme the document never declares; both stop the
     * run unless accepted, and neither is what the tag scenarios are about.
     */
    private function petstorePlan(): GenerationPlan
    {
        return $this->plan(
            self::PETSTORE,
            skip: ['uploadFile' => 'octet-stream body'],
            securitySchemes: PetstoreFixture::SECURITY_SCHEMES,
        );
    }

    /**
     * @param array<string,string>              $skip
     * @param array<string,string>              $tagRenames
     * @param array<string,array<string,mixed>> $securitySchemes
     */
    private function plan(string $schema, array $skip = [], array $tagRenames = [], array $securitySchemes = []): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: $schema,
            output: self::makeSandboxDir('paogen-tagged-'),
            namespace: self::NAMESPACE,
            skip: $skip,
            tagRenames: $tagRenames,
            securitySchemes: $securitySchemes,
        ));
    }

    private function sourceOf(GenerationPlan $plan, string $class): string
    {
        return $this->byName($plan)[$class] ?? self::fail("the plan wrote no {$class}.php");
    }

    /**
     * @return array<string,string>
     */
    private function byName(GenerationPlan $plan): array
    {
        $out = [];

        foreach ($plan->writes as $path => $source) {
            $out[basename($path, '.php')] = $source;
        }

        return $out;
    }

    /**
     * @return list<string>
     */
    private function emittedNames(GenerationPlan $plan): array
    {
        return array_keys($this->byName($plan));
    }
}
