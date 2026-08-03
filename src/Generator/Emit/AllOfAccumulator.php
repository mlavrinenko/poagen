<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use stdClass;

use function array_key_exists;
use function get_object_vars;
use function in_array;
use function json_encode;
use function sprintf;

/**
 * Mutable scratch state for one {@see AllOfMerger::merge()} call — never
 * exposed outside that class.
 *
 * Properties and `required` names accumulate across the node itself and
 * every member, recursing into a member whose own target carries `allOf`
 * again. A property name declared twice with two structurally different
 * schemas throws {@see AllOfRefusal} by name, naming both sites — the same
 * name declared twice identically is not a conflict, since nothing about the
 * merge is ambiguous.
 *
 * "Different" is judged on {@see SHAPE_KEYS} only — the keywords that decide
 * the emitted PHP type — not on the full node. Two members declaring `type:
 * string` for the same property with two different `description`/`example`
 * strings are documentation, not disagreement: DigitalOcean's `volumeAction`
 * (`allOf: [inline, $ref action]`) declares `type` twice this way, and
 * `PropertySynthesiser`/`TypeResolver` already read past `description`,
 * `example`, `minLength`, `pattern` and the rest for every other property —
 * treating them as significant here would refuse a component the vendor
 * document, and every other reader of it, considers unambiguous.
 *
 * @internal
 */
final class AllOfAccumulator
{
    /** @var list<string> the JSON Schema keywords that decide an emitted PHP type */
    private const array SHAPE_KEYS = [
        'type', 'format', 'nullable', 'enum', 'items', 'properties', 'required',
        'additionalProperties', 'allOf', 'oneOf', 'anyOf', 'not', 'discriminator',
    ];

    /** @var array<string,Schema|Reference> */
    public array $properties = [];

    /** @var array<string,string> property name → the site that declared it, for a collision message */
    public array $propertySites = [];

    /** @var list<string> */
    public array $required = [];

    /** @var list<string> every member site visited, for a "members searched" message */
    public array $memberSites = [];

    public ?Schema $unionMember = null;

    public string $unionSite = '';

    public function addProperty(string $name, Schema|Reference $schema, string $site): void
    {
        if (array_key_exists($name, $this->properties)) {
            if (!$this->sameSchema($this->properties[$name], $schema)) {
                throw new AllOfRefusal(sprintf(
                    "allOf declares property '%s' twice with two different schemas — at %s and at %s",
                    $name,
                    $this->propertySites[$name],
                    $site,
                ));
            }

            return;
        }

        $this->properties[$name] = $schema;
        $this->propertySites[$name] = $site;
    }

    public function addRequired(string $name): void
    {
        if (!in_array($name, $this->required, true)) {
            $this->required[] = $name;
        }
    }

    private function sameSchema(Schema|Reference $a, Schema|Reference $b): bool
    {
        return json_encode($this->shapeOf($a)) === json_encode($this->shapeOf($b));
    }

    /**
     * @return array<string,mixed>
     */
    private function shapeOf(Schema|Reference $node): array
    {
        if ($node instanceof Reference) {
            return ['$ref' => $node->getReference()];
        }

        $raw = $node->getSerializableData();
        $vars = $raw instanceof stdClass ? get_object_vars($raw) : [];
        $shape = [];

        foreach (self::SHAPE_KEYS as $key) {
            if (array_key_exists($key, $vars)) {
                $shape[$key] = $vars[$key];
            }
        }

        return $shape;
    }
}
