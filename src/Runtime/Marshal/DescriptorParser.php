<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Runtime\Marshal;

use Mlavrinenko\Paogen\Runtime\Attribute\Discriminator;
use Mlavrinenko\Paogen\Runtime\Attribute\Format;
use Mlavrinenko\Paogen\Runtime\Attribute\WireName;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\ConstExprParser;
use PHPStan\PhpDocParser\Parser\PhpDocParser;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use PHPStan\PhpDocParser\Parser\TypeParser;
use PHPStan\PhpDocParser\ParserConfig;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;

use function assert;

/**
 * Reflects a Model class once and produces a list of {@see PropertyDescriptor}s.
 * Reads the constructor's `@param` phpdoc through `phpstan/phpdoc-parser` and
 * the `#[WireName] / #[Format] / #[Discriminator]` attributes per parameter.
 *
 * Deciding which {@see PropertyType} a parameter carries is
 * {@see PropertyTypeResolver}'s job, not this one's.
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

        $reflection = new ReflectionClass($class);
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
    private static function parseConstructorPhpdoc(ReflectionMethod $constructor): array
    {
        $doc = $constructor->getDocComment();

        if ($doc === false) {
            $doc = MethodDocScanner::docFor($constructor);
        }

        if ($doc === false) {
            return [];
        }

        if (!self::$docParser instanceof PhpDocParser) {
            $config = new ParserConfig([]);
            $constExpr = new ConstExprParser($config);
            $typeParser = new TypeParser($config, $constExpr);
            self::$docParser = new PhpDocParser($config, $typeParser, $constExpr);
            self::$lexer = new Lexer($config);
        }

        assert(self::$lexer instanceof Lexer);
        $tokens = new TokenIterator(self::$lexer->tokenize($doc));
        $node = self::$docParser->parse($tokens);

        $out = [];

        foreach ($node->getParamTagValues() as $tag) {
            $out[ltrim($tag->parameterName, '$')] = $tag->type;
        }

        return $out;
    }

    private static function buildDescriptor(
        ReflectionParameter $parameter,
        ?TypeNode $phpdocType,
        string $namespace,
    ): PropertyDescriptor {
        $phpName = $parameter->getName();
        $wireAttr = self::attributeValue($parameter, WireName::class);
        $wireName = $wireAttr === null ? $phpName : $wireAttr->name;
        $formatAttr = self::attributeValue($parameter, Format::class);
        $discriminator = self::attributeValue($parameter, Discriminator::class);

        $type = PropertyTypeResolver::resolve(
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
    private static function attributeValue(ReflectionParameter $parameter, string $name): ?object
    {
        $attrs = $parameter->getAttributes($name);

        return $attrs === [] ? null : $attrs[0]->newInstance();
    }
}
