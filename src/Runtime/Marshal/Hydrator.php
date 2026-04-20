<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Runtime\Marshal;

use Mlavrinenko\Paogen\Runtime\Attribute\Discriminator;
use Mlavrinenko\Paogen\Runtime\ScalarBinding;

/**
 * Inverse of {@see Marshaller}: turns a JSON-decoded array into a typed
 * Model instance. Recurses into nested models, lists, maps, and
 * discriminated / structural unions. See ADR-010.
 */
final class Hydrator
{
    /**
     * @template T of object
     *
     * @param class-string<T> $class
     * @param array<mixed>    $data
     *
     * @return T
     */
    public function hydrate(string $class, array $data): object
    {
        $args = [];

        foreach (DescriptorParser::descriptorsFor($class) as $descriptor) {
            if (!\array_key_exists($descriptor->wireName, $data)) {
                continue;
            }

            $args[$descriptor->phpName] = $this->decode($data[$descriptor->wireName], $descriptor->type, $descriptor->discriminator);
        }

        return new $class(...$args);
    }

    private function decode(mixed $value, PropertyType $type, ?Discriminator $discriminator = null): mixed
    {
        if ($value === null) {
            return null;
        }

        return match ($type->kind) {
            PropertyType::KIND_PASSTHROUGH => $value,
            PropertyType::KIND_DATETIME => $this->decodeDateTime($value),
            PropertyType::KIND_ENUM => $this->decodeEnum($value, $type),
            PropertyType::KIND_MODEL => $this->decodeModel($value, $type),
            PropertyType::KIND_SCALAR_BINDING => $this->decodeScalarBinding($value, $type),
            PropertyType::KIND_UNION => $this->decodeUnion($value, $type, $discriminator),
            PropertyType::KIND_LIST => $this->decodeList($value, $type),
            PropertyType::KIND_MAP => $this->decodeMap($value, $type),
            default => $value,
        };
    }

    private function decodeDateTime(mixed $value): \DateTimeImmutable
    {
        if ($value instanceof \DateTimeImmutable) {
            return $value;
        }
        \assert(\is_string($value));

        return new \DateTimeImmutable($value);
    }

    private function decodeEnum(mixed $value, PropertyType $type): \BackedEnum
    {
        /** @var class-string<\BackedEnum> $class */
        $class = $type->class;

        if ($value instanceof $class) {
            return $value;
        }

        \assert(\is_string($value) || \is_int($value));

        return $class::from($value);
    }

    private function decodeModel(mixed $value, PropertyType $type): object
    {
        $class = $type->class;
        \assert(\is_string($class));

        if ($value instanceof $class) {
            return $value;
        }

        \assert(\is_array($value));

        return $this->hydrate($class, $value);
    }

    private function decodeScalarBinding(mixed $value, PropertyType $type): ScalarBinding
    {
        /** @var class-string<ScalarBinding> $class */
        $class = $type->class;

        if ($value instanceof $class) {
            return $value;
        }

        return $class::fromScalar($value);
    }

    private function decodeUnion(mixed $value, PropertyType $type, ?Discriminator $discriminator): mixed
    {
        if (!\is_array($value)) {
            return $value;
        }

        if ($discriminator instanceof Discriminator) {
            $branch = $this->branchFromDiscriminator($value, $discriminator);

            if ($branch !== null) {
                return $this->hydrate($branch, $value);
            }
        }

        $branch = $this->branchFromStructure($value, $type->branches);

        return $this->hydrate($branch, $value);
    }

    /**
     * @param array<mixed> $value
     *
     * @return class-string|null
     */
    private function branchFromDiscriminator(array $value, Discriminator $discriminator): ?string
    {
        if (!\array_key_exists($discriminator->field, $value)) {
            return null;
        }

        $tag = $value[$discriminator->field];

        if (!\is_string($tag)) {
            return null;
        }

        return $discriminator->map[$tag] ?? null;
    }

    /**
     * @param array<mixed>       $value
     * @param list<class-string> $branches
     *
     * @return class-string
     */
    private function branchFromStructure(array $value, array $branches): string
    {
        \assert($branches !== []);
        $payloadKeys = array_map(strval(...), array_keys($value));

        foreach ($branches as $branch) {
            $wireKeys = [];

            foreach (DescriptorParser::descriptorsFor($branch) as $descriptor) {
                $wireKeys[] = $descriptor->wireName;
            }

            if (array_diff($payloadKeys, $wireKeys) === []) {
                return $branch;
            }
        }

        return $branches[0];
    }

    /**
     * @return list<mixed>
     */
    private function decodeList(mixed $value, PropertyType $type): array
    {
        \assert(\is_array($value));
        $itemType = $type->itemType ?? PropertyType::passthrough();
        $out = [];

        foreach ($value as $item) {
            $out[] = $this->decode($item, $itemType);
        }

        return $out;
    }

    /**
     * @return array<string, mixed>
     */
    private function decodeMap(mixed $value, PropertyType $type): array
    {
        \assert(\is_array($value));
        $valueType = $type->itemType ?? PropertyType::passthrough();
        $out = [];

        foreach ($value as $key => $item) {
            $out[(string) $key] = $this->decode($item, $valueType);
        }

        return $out;
    }
}
