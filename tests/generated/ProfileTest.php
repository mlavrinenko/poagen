<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Generated;

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
     * @source truth/specs/profile.feature-260418.typ:12
     *
     * Given a PHP file at <profile-path> returns Profile for Schema at <schema-path>
     * When Profile is loaded from that path
     * Then the result is Profile
     *   And Profile's schema resolves to the fixture path
     */
    public function testAPHPFileThatReturnsAProfileIsLoadedAsThatProfile(): void
    {
        $this->steps->givenPhpFileAtPathReturnsProfileForSchemaAtSchema('<profile-path>', '<schema-path>');
        $this->steps->whenProfileIsLoadedFromThatPath();
        $this->steps->thenResultIsProfile();
        $this->steps->thenProfilesSchemaResolvesToTheFixturePath();
    }


    /**
     * Scenario: A PHP file that does not return a Profile is rejected
     * @source truth/specs/profile.feature-260418.typ:22
     *
     * Given a PHP file that returns the integer 42 instead of Profile
     * When loading Profile from that path is attempted
     * Then loading Profile throws InvalidProfileException
     */
    public function testAPHPFileThatDoesNotReturnAProfileIsRejected(): void
    {
        $this->steps->givenPhpFileThatReturnsTheIntegerValueInsteadOfProfile(42);
        $this->steps->whenLoadingProfileFromThatPathIsAttempted();
        $this->steps->thenLoadingProfileThrowsError('InvalidProfileException');
    }


    /**
     * Rule: Discovering user value-object bindings
     *
     * Scenario: A user class with BindsFormat in a discovered namespace registers a format binding
     * @source truth/specs/profile.feature-260418.typ:33
     *
     * Given Value Object class is annotated with #[BindsFormat('email')]
     *   And its namespace is listed in Profile's discoverIn
     * When Attribute Scan runs over Profile
     * Then the resulting binding map contains email → that Value Object
     */
    public function testAUserClassWithBindsFormatInADiscoveredNamespaceRegistersAFormatBinding(): void
    {
        $this->steps->givenValueObjectClassIsAnnotatedWithAttr('#[BindsFormat(\'email\')]');
        $this->steps->givenItsNamespaceIsListedInProfilesDiscoverIn();
        $this->steps->whenAttributeScanRunsOverProfile();
        $this->steps->thenResultingBindingMapContainsFormatThatValueObject('email');
    }


    /**
     * Scenario: A class outside discoverIn is ignored even if annotated
     * @source truth/specs/profile.feature-260418.typ:43
     *
     * Given Value Object class is annotated with #[BindsFormat('uuid')]
     *   And its namespace is not listed in Profile's discoverIn
     * When Attribute Scan runs over Profile
     * Then the resulting binding map does not contain uuid for that Value Object
     */
    public function testAClassOutsideDiscoverInIsIgnoredEvenIfAnnotated(): void
    {
        $this->steps->givenValueObjectClassIsAnnotatedWithAttr('#[BindsFormat(\'uuid\')]');
        $this->steps->givenItsNamespaceIsNotListedInProfilesDiscoverIn();
        $this->steps->whenAttributeScanRunsOverProfile();
        $this->steps->thenResultingBindingMapDoesNotContainFormatForThatValueObject('uuid');
    }
}
