<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Generated;

use PHPUnit\Framework\TestCase;

/**
 * Feature: Profile
 *
 * The generator is a pure function of Schema and Profile. This feature covers loading and validating Profile, and discovering user-side bindings declared via attributes on user value objects.
 */
final class ProfileTest extends TestCase
{
    private ProfileSteps $steps;


    protected function setUp(): void
    {
        $this->steps = new ProfileSteps($this);
    }


    /**
     * Rule: Loading a Profile
     *
     * Scenario: A PHP file that returns a Profile is loaded as that Profile
     * @source truth/specs/profile.typ:15
     *
     * Given a PHP file at tests/fixtures/profiles/petstore.php returns Profile for Schema at tests/fixtures/schemas/petstore-3.0.yaml
     * When the loader is invoked with that path
     * Then the result is Profile
     *   And its schema resolves to the fixture path
     */
    public function testAPHPFileThatReturnsAProfileIsLoadedAsThatProfile(): void
    {
        $this->steps->givenAPHPFileAtPathReturnsProfileForSchemaAtSchema('tests/fixtures/profiles/petstore.php', 'tests/fixtures/schemas/petstore-3.0.yaml');
        $this->steps->whenTheLoaderIsInvokedWithThatPath();
        $this->steps->thenTheResultIsProfile();
        $this->steps->thenItsSchemaResolvesToTheFixturePath();
    }


    /**
     * Scenario: A PHP file that does not return a Profile is rejected
     * @source truth/specs/profile.typ:26
     *
     * Given a PHP file that returns the integer 42
     * When the loader is invoked with that path
     * Then the loader throws InvalidProfileException
     */
    public function testAPHPFileThatDoesNotReturnAProfileIsRejected(): void
    {
        $this->steps->givenAPHPFileThatReturnsTheIntegerValue(42);
        $this->steps->whenTheLoaderIsInvokedWithThatPath();
        $this->steps->thenTheLoaderThrowsError('InvalidProfileException');
    }


    /**
     * Rule: Discovering user value-object bindings
     *
     * Scenario: A user class with BindsFormat in a discovered namespace registers a format binding
     * @source truth/specs/profile.typ:41
     *
     * Given Value Object class is annotated with #[BindsFormat('email')]
     *   And its namespace is listed in Profile's discoverIn
     * When Attribute Scan runs over Profile
     * Then the resulting binding map contains email → that class
     */
    public function testAUserClassWithBindsFormatInADiscoveredNamespaceRegistersAFormatBinding(): void
    {
        $this->steps->givenValueObjectClassIsAnnotatedWithAttr('#[BindsFormat(\'email\')]');
        $this->steps->givenItsNamespaceIsListedInProfilesDiscoverIn();
        $this->steps->whenAttributeScanRunsOverProfile();
        $this->steps->thenTheResultingBindingMapContainsFormatThatClass('email');
    }


    /**
     * Scenario: A class outside discoverIn is ignored even if annotated
     * @source truth/specs/profile.typ:56
     *
     * Given Value Object class is annotated with #[BindsFormat('uuid')]
     *   And its namespace is not listed in Profile's discoverIn
     * When Attribute Scan runs over Profile
     * Then the resulting binding map does not contain uuid
     */
    public function testAClassOutsideDiscoverInIsIgnoredEvenIfAnnotated(): void
    {
        $this->steps->givenValueObjectClassIsAnnotatedWithAttr('#[BindsFormat(\'uuid\')]');
        $this->steps->givenItsNamespaceIsNotListedInProfilesDiscoverIn();
        $this->steps->whenAttributeScanRunsOverProfile();
        $this->steps->thenTheResultingBindingMapDoesNotContainFormat('uuid');
    }
}
