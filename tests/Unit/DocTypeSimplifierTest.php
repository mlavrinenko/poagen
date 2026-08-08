<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit;

use Nette\PhpGenerator\PhpNamespace;
use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\Emit\DocTypeSimplifier;

/**
 * `DocTypeSimplifier::shorten()` in isolation, the layer speconaut does not
 * cover. `PhpNamespace::simplifyType()` treats any bareword it does not
 * recognise as a PHP builtin as an unqualified class name and makes it
 * absolute — correct for a real FQN missing its leading backslash, wrong for
 * a PHPStan pseudo-type, which is not a class and never carried one. Every
 * case that used to depend on pseudo-types never reaching `shorten()` at all
 * is pinned here now that `refine-list-item-types-from-the-item-schema-constraints`
 * puts one inside a structural type for the first time.
 */
final class DocTypeSimplifierTest extends TestCase
{
    public function testAClassReferenceIsShortenedAndImported(): void
    {
        $namespace = new PhpNamespace('Poagen\\Generated\\Model');

        self::assertSame('Tag', DocTypeSimplifier::shorten($namespace, '\\Poagen\\Generated\\Model\\Nested\\Tag'));
        self::assertContains('Poagen\\Generated\\Model\\Nested\\Tag', $namespace->getUses());
    }

    public function testAListOfAKnownPseudoTypeIsLeftAloneRatherThanPrefixedWithABackslash(): void
    {
        $namespace = new PhpNamespace('Poagen\\Generated\\Model');

        self::assertSame('list<non-empty-string>', DocTypeSimplifier::shorten($namespace, 'list<non-empty-string>'));
    }

    public function testABarePseudoTypeIsLeftAlone(): void
    {
        $namespace = new PhpNamespace('Poagen\\Generated\\Model');

        self::assertSame('positive-int', DocTypeSimplifier::shorten($namespace, 'positive-int'));
    }

    /**
     * The acceptance case this task exists to prove: a structural type
     * carrying both a pseudo-type and a class reference — the pseudo-type
     * stays bare, the class reference still shortens and still gets an
     * import registered for it.
     */
    public function testAPseudoTypeBesideAClassReferenceInOneStructuralTypeBothResolveCorrectly(): void
    {
        $namespace = new PhpNamespace('Poagen\\Generated\\Model');

        $shortened = DocTypeSimplifier::shorten(
            $namespace,
            'list<non-empty-string>|\\Poagen\\Generated\\Model\\Nested\\Tag',
        );

        self::assertSame('list<non-empty-string>|Tag', $shortened);
        self::assertContains('Poagen\\Generated\\Model\\Nested\\Tag', $namespace->getUses());
    }

    /**
     * Same proof the other way around: the class comes first, the
     * pseudo-type second, inside a generic's arguments rather than a
     * top-level union.
     */
    public function testAClassReferenceBesideAPseudoTypeInsideAGenericBothResolveCorrectly(): void
    {
        $namespace = new PhpNamespace('Poagen\\Generated\\Model');

        $shortened = DocTypeSimplifier::shorten(
            $namespace,
            'array<string, \\Poagen\\Generated\\Model\\Nested\\Tag|positive-int>',
        );

        self::assertSame('array<string, Tag|positive-int>', $shortened);
    }
}
