<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\GenerateCommand;
use Poagen\Generator\Generator\Profile;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

use function count;

/**
 * `poagen generate --output=<dir>` must change the output directory and nothing
 * else.
 *
 * This guard exists because the hand-enumerated copy behind
 * `GenerateCommand::withOutput()` rotted twice: `$inlineModels` was added to
 * `Profile` and not carried, then the three tag maps and `$xmlElements` were too.
 * Each time the symptom was silent — a `--output` run emitted a different tree
 * than a plain run, discarding the consumer's guidance, and reported success. The
 * `--diff` and `--dry-run` flags route through the same call, so a stale copy also
 * makes the preview lie about what a real run would write.
 *
 * Reflecting over the constructor is what makes this hold for the *next* field
 * rather than only for the ones already forgotten. Every field below is set to a
 * non-default value on purpose: a field left at its default would compare equal
 * to a copy that dropped it, and the guard would pass on the bug it exists for.
 */
final class OutputOverrideCarriesEveryProfileFieldTest extends TestCase
{
    public function testEveryProfileFieldSurvivesAnOutputOverride(): void
    {
        $original = new Profile(
            schema: '/schema.yaml',
            output: '/original',
            namespace: 'Acme\\Thing',
            discoverIn: ['Acme\\Thing\\ValueObject'],
            renames: ['raw-component' => 'RawComponent'],
            discriminators: ['Pet.kind' => 'petType'],
            skip: ['someOp' => 'a reason'],
            methodRenames: ['someop' => 'someOp'],
            tagRenames: ['Клиенты' => 'Customers'],
            tagAssignments: ['someOp' => 'Customers'],
            tagChoice: ['someOp' => 'Customers'],
            xmlElements: ['someOp' => 'root'],
            inlineModels: ['someOp.request' => 'SomeRequest'],
            source: 'config/acme-poagen.php',
        );

        $overridden = $this->withOutput($original, '/elsewhere');

        self::assertSame('/elsewhere', $overridden->output);

        foreach ($this->profileFieldNames() as $field) {
            if ($field === 'output') {
                continue;
            }

            // Read through reflection rather than a variable property: the
            // strict rule set forbids the latter, and this is the one place a
            // by-name read is the whole point.
            $property = new ReflectionProperty(Profile::class, $field);

            self::assertSame(
                $property->getValue($original),
                $property->getValue($overridden),
                "--output dropped Profile::\${$field}; carry it in Profile::with()",
            );
        }
    }

    /**
     * @return list<string>
     */
    private function profileFieldNames(): array
    {
        $constructor = new ReflectionClass(Profile::class)->getConstructor();
        self::assertNotNull($constructor);

        $names = [];

        foreach ($constructor->getParameters() as $parameter) {
            $names[] = $parameter->getName();
        }

        // A guard that reflected over nothing would pass silently.
        self::assertGreaterThan(10, count($names));

        return $names;
    }

    private function withOutput(Profile $profile, string $output): Profile
    {
        $method = new ReflectionMethod(GenerateCommand::class, 'withOutput');
        $result = $method->invoke(null, $profile, $output);
        self::assertInstanceOf(Profile::class, $result);

        return $result;
    }
}
