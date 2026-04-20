<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use Mlavrinenko\Paogen\Generator\Naming\NameNormaliser;

/**
 * User-supplied generation guidance. See ADR-001 / ADR-003.
 *
 * Pure value object: parsed by the generator, never executed.
 */
final readonly class Profile
{
    /**
     * @param string                $schema         Path to the OpenAPI YAML/JSON file.
     * @param string                $output         Output directory for generated PHP.
     * @param string                $namespace      Root namespace for generated classes (no trailing backslash).
     * @param list<string>          $discoverIn     Namespace prefixes to scan for #[Binds*] attributes.
     * @param array<string,string>  $renames        Map of schema-component name → desired PHP class name.
     *                                              Always honoured before the auto-sanitiser.
     * @param NameNormaliser|null   $nameNormaliser Custom normalisation pipeline. When null, paogen
     *                                              composes RenamesNormaliser($renames) + PascalCaseSanitiser.
     *                                              When set, paogen uses it verbatim — `$renames` is *not*
     *                                              merged in automatically. See ADR-003 (T-023).
     * @param array<string,string>  $discriminators Override map for undiscriminated property-level
     *                                              `oneOf`/`anyOf`. Keys are raw `'<ComponentName>.<propertyName>'`
     *                                              (pre-normalisation); values are the wire field name that
     *                                              selects the branch. ADR-010 + T-030.
     */
    public function __construct(
        public string $schema,
        public string $output,
        public string $namespace,
        public array $discoverIn = [],
        public array $renames = [],
        public ?NameNormaliser $nameNormaliser = null,
        public array $discriminators = [],
    ) {}
}
