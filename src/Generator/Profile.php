<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

/**
 * User-supplied generation guidance. See ADR-001 / ADR-003.
 *
 * Pure value object: parsed by the generator, never executed.
 */
final readonly class Profile
{
    /**
     * @param string             $schema     Path to the OpenAPI YAML/JSON file.
     * @param string             $output     Output directory for generated PHP.
     * @param string             $namespace  Root namespace for generated classes (no trailing backslash).
     * @param list<string>       $discoverIn Namespace prefixes to scan for #[Binds*] attributes.
     * @param array<string,string> $renames  Map of schema-component name → desired PHP class name.
     */
    public function __construct(
        public string $schema,
        public string $output,
        public string $namespace,
        public array $discoverIn = [],
        public array $renames = [],
    ) {}
}
