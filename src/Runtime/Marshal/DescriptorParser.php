<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Runtime\Marshal;

use Mlavrinenko\Paogen\Runtime\Attribute\Discriminator;
use Mlavrinenko\Paogen\Runtime\Attribute\Format;
use Mlavrinenko\Paogen\Runtime\Attribute\WireName;
use Mlavrinenko\Paogen\Runtime\ScalarBinding;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\NullableTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\ConstExprParser;
use PHPStan\PhpDocParser\Parser\PhpDocParser;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use PHPStan\PhpDocParser\Parser\TypeParser;
use PHPStan\PhpDocParser\ParserConfig;

/**
 * Reflects a Model class once and produces a list of {@see PropertyDescriptor}s.
 * Reads the constructor's `@param` phpdoc through `phpstan/phpdoc-parser` and
 * the `#[WireName] / #[Format] / #[Discriminator]` attributes per parameter.
 *
 * @internal
 */
final class DescriptorParser
{
    /** @var array<class-string, list<PropertyDescriptor>> */
    private static array $cache = [];

    private static ?PhpDocParser $docParser = null;
    private static ?Lexer $lexer = null;

    /**
     * @param class-string $class
     *
     * @return list<PropertyDescriptor>
     */
    public static function descriptorsFor(string $class): array
    {
        if (isset(self::$cache[$class])) {
            return self::$cache[$class];
        }

        $reflection = new \ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            return self::$cache[$class] = [];
        }

        $phpdocTypes = self::parseConstructorPhpdoc($constructor);
        $descriptors = [];

        foreach ($constructor->getParameters() as $parameter) {
            $descriptors[] = self::buildDescriptor($parameter, $phpdocTypes[$parameter->getName()] ?? null, $reflection->getNamespaceName());
        }

        return self::$cache[$class] = $descriptors;
    }

    /**
     * @return array<string, TypeNode>
     */
    private static function parseConstructorPhpdoc(\ReflectionMethod $constructor): array
    {
        $doc = $constructor->getDocComment();

        if ($doc === false) {
            return [];
        }

        if (!self::$docParser instanceof \PHPStan\PhpDocParser\Parser\PhpDocParser) {
            $config = new ParserConfig([]);
            $constExpr = new ConstExprParser($config);
            $typeParser = new TypeParser($config, $constExpr);
            self::$docParser = new PhpDocParser($config, $typeParser, $constExpr);
            self::$lexer = new Lexer($config);
        }

        \assert(self::$lexer instanceof \PHPStan\PhpDocParser\Lexer\Lexer);
        $tokens = new TokenIterator(self::$lexer->tokenize($doc));
        $node = self::$docParser->parse($tokens);

        $out = [];

        foreach ($node->getParamTagValues() as $tag) {
            $out[ltrim($tag->parameterName, '$')] = $tag->type;
        }

        return $out;
    }

    private static function buildDescriptor(
        \ReflectionParameter $parameter,
        ?TypeNode $phpdocType,
        string $namespace,
    ): PropertyDescriptor {
        $phpName = $parameter->getName();
        $wireAttr = self::attributeValue($parameter, WireName::class);
        $wireName = $wireAttr === null ? $phpName : $wireAttr->name;
        $formatAttr = self::attributeValue($parameter, Format::class);
        $discriminator = self::attributeValue($parameter, Discriminator::class);

        $type = self::resolveType(
            $parameter->getType(),
            $phpdocType,
            $formatAttr?->format,
            $namespace,
        );

        return new PropertyDescriptor($phpName, $wireName, $type, $discriminator);
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $name
     *
     * @return T|null
     */
    private static function attributeValue(\ReflectionParameter $parameter, string $name): ?object
    {
        $attrs = $parameter->getAttributes($name);

        return $attrs === [] ? null : $attrs[0]->newInstance();
    }

    private static function resolveType(
        ?\ReflectionType $native,
        ?TypeNode $phpdoc,
        ?string $format,
        string $namespace,
    ): PropertyType {
        if ($native instanceof \ReflectionUnionType) {
            return self::resolveUnion($native);
        }

        if (!$native instanceof \ReflectionNamedType) {
            return PropertyType::passthrough();
        }

        $name = $native->getName();

        if ($name === 'array') {
            return self::resolveArrayLike($phpdoc, $namespace);
        }

        if ($native->isBuiltin()) {
            return PropertyType::passthrough();
        }

        return self::resolveClassType($name, $format);
    }

    private static function resolveUnion(\ReflectionUnionType $native): PropertyType
    {
        $branches = [];

        foreach ($native->getTypes() as $branch) {
            if (!$branch instanceof \ReflectionNamedType) {
                continue;
            }
            if ($branch->isBuiltin()) {
                continue;
            }
            /** @var class-string $branchName */
            $branchName = $branch->getName();
            $branches[] = $branchName;
        }

        return PropertyType::union($branches);
    }

    private static function resolveClassType(string $name, ?string $format): PropertyType
    {
        /** @var class-string $name */
        if (is_subclass_of($name, \BackedEnum::class)) {
            return PropertyType::enum($name);
        }

        if (is_a($name, \DateTimeInterface::class, true)) {
            return PropertyType::dateTime($format ?? 'date-time');
        }

        if (is_a($name, ScalarBinding::class, true)) {
            return PropertyType::scalarBinding($name);
        }

        return PropertyType::model($name);
    }

    private static function resolveArrayLike(?TypeNode $phpdoc, string $namespace): PropertyType
    {
        if (!$phpdoc instanceof TypeNode) {
            return PropertyType::passthrough();
        }

        $stripped = self::stripNullable($phpdoc);

        if ($stripped instanceof GenericTypeNode) {
            $head = $stripped->type->name;
            $count = \count($stripped->genericTypes);

            if ($head === 'list' && $count > 0) {
                return PropertyType::listOf(self::resolvePhpdocType($stripped->genericTypes[0], $namespace));
            }

            if ($head === 'array' && $count === 1) {
                return PropertyType::listOf(self::resolvePhpdocType($stripped->genericTypes[0], $namespace));
            }

            if ($head === 'array' && $count === 2) {
                return PropertyType::mapOf(self::resolvePhpdocType($stripped->genericTypes[1], $namespace));
            }
        }

        return PropertyType::passthrough();
    }

    private static function stripNullable(TypeNode $node): TypeNode
    {
        if ($node instanceof NullableTypeNode) {
            return $node->type;
        }

        if ($node instanceof UnionTypeNode) {
            $non = array_values(array_filter(
                $node->types,
                static fn(TypeNode $t): bool => !($t instanceof IdentifierTypeNode && $t->name === 'null'),
            ));

            if (\count($non) === 1) {
                return $non[0];
            }
        }

        return $node;
    }

    private static function resolvePhpdocType(TypeNode $node, string $namespace): PropertyType
    {
        if ($node instanceof UnionTypeNode) {
            // `Foo|null` collapses to Foo; `Foo|Bar` is treated as a model union.
            $models = [];

            foreach ($node->types as $branch) {
                if ($branch instanceof IdentifierTypeNode && $branch->name === 'null') {
                    continue;
                }
                if ($branch instanceof IdentifierTypeNode) {
                    $resolved = self::resolveIdentifier($branch->name, $namespace);

                    if ($resolved !== null) {
                        $models[] = $resolved;
                    }
                }
            }

            return $models === [] ? PropertyType::passthrough() : PropertyType::union($models);
        }

        if ($node instanceof IdentifierTypeNode) {
            $class = self::resolveIdentifier($node->name, $namespace);

            return $class === null ? PropertyType::passthrough() : self::resolveClassType($class, null);
        }

        return PropertyType::passthrough();
    }

    /**
     * @return class-string|null
     */
    private static function resolveIdentifier(string $name, string $namespace): ?string
    {
        if ($name === '' || \in_array($name, ['string', 'int', 'integer', 'bool', 'boolean', 'float', 'mixed', 'array', 'null'], true)) {
            return null;
        }

        $candidate = ltrim($name, '\\');

        if (class_exists($candidate, false) || interface_exists($candidate, false) || enum_exists($candidate, false)) {
            /** @var class-string $candidate */
            return $candidate;
        }

        $namespaced = ltrim($namespace . '\\' . $candidate, '\\');

        if (class_exists($namespaced) || interface_exists($namespaced) || enum_exists($namespaced)) {
            /** @var class-string $namespaced */
            return $namespaced;
        }

        return class_exists($candidate) ? $candidate : null;
    }
}
