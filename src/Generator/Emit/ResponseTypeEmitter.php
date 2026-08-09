<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use Nette\PhpGenerator\Dumper;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\PhpNamespace;
use Poagen\Generator\Generator\ScalarFormat;
use Poagen\Runtime\Attribute\BranchSelector;
use Poagen\Runtime\Attribute\Discriminator;
use Poagen\Runtime\Codec;
use Poagen\Runtime\Contract\ResponseType;
use Poagen\Runtime\Http\ResponseDecoder;
use Poagen\Runtime\Marshal\UnionBranchPicker;
use Psr\Http\Message\StreamInterface;

use function array_map;
use function assert;
use function implode;
use function sprintf;
use function var_export;

/**
 * Names the shape an operation was promised back.
 *
 * The {@see ReturnSpec} kinds map one-to-one onto {@see ResponseType}, which
 * is the whole of what used to be the emitted status branch, decode and
 * hydrate sequence. The emitted method still declares its own return type;
 * this is what makes the transport give back a value that matches it.
 *
 * A map's value is a spec of its own, so this recurses — `ResponseType` nests
 * the same way and {@see ResponseDecoder}
 * already reads it that way.
 *
 * @internal
 */
final readonly class ResponseTypeEmitter
{
    public function expr(PhpNamespace $namespace, ReturnSpec $return, string $modelNamespace): string
    {
        $namespace->addUse(ResponseType::class);

        return $this->value($namespace, $return, $modelNamespace, $namespace->simplifyName(ResponseType::class));
    }

    /**
     * The PHPDoc type an emitted `@return` (or a nested map value) spells.
     * FQCNs are left long here; {@see DocTypeSimplifier} shortens the finished
     * string and registers the `use` statements it needs.
     */
    public function docType(ReturnSpec $return, string $modelNamespace): string
    {
        return match ($return->kind) {
            ReturnSpec::KIND_MODEL => $this->fqcn($return, $modelNamespace),
            ReturnSpec::KIND_LIST => 'list<' . $this->fqcn($return, $modelNamespace) . '>',
            ReturnSpec::KIND_SCALAR => $return->scalarPhpType ?? 'string',
            ReturnSpec::KIND_SCALAR_LIST => 'list<' . $this->docType($return->listItem ?? ReturnSpec::mixed(), $modelNamespace) . '>',
            ReturnSpec::KIND_MAP => 'array<string, ' . $this->docType($return->mapValue ?? ReturnSpec::mixed(), $modelNamespace) . '>',
            ReturnSpec::KIND_UNION => $this->unionDocType($return, $modelNamespace),
            ReturnSpec::KIND_STREAM => '\\' . StreamInterface::class,
            default => 'mixed',
        };
    }

    /**
     * The native PHP union spelling across every branch — `A|B` — which is
     * also the whole native return type for a top-level union response; a
     * union nested inside a `KIND_SCALAR_LIST` item spells the same string
     * one level down, inside `list<...>`.
     */
    private function unionDocType(ReturnSpec $return, string $modelNamespace): string
    {
        return implode('|', array_map(
            fn(string $model): string => '\\' . trim($modelNamespace, '\\') . '\\' . $model,
            $return->models ?? [],
        ));
    }

    private function value(PhpNamespace $namespace, ReturnSpec $return, string $modelNamespace, string $type): string
    {
        return match ($return->kind) {
            ReturnSpec::KIND_MODEL => sprintf('%s::object(%s::class)', $type, $this->model($namespace, $return, $modelNamespace)),
            ReturnSpec::KIND_LIST => sprintf('%s::listOf(%s::class)', $type, $this->model($namespace, $return, $modelNamespace)),
            ReturnSpec::KIND_SCALAR => $this->scalar($namespace, $return, $type),
            ReturnSpec::KIND_SCALAR_LIST => sprintf(
                '%s::scalarListOf(%s)',
                $type,
                $this->value($namespace, $return->listItem ?? ReturnSpec::mixed(), $modelNamespace, $type),
            ),
            ReturnSpec::KIND_MAP => sprintf(
                '%s::mapOf(%s)',
                $type,
                $this->value($namespace, $return->mapValue ?? ReturnSpec::mixed(), $modelNamespace, $type),
            ),
            ReturnSpec::KIND_MIXED => sprintf('%s::mixed()', $type),
            ReturnSpec::KIND_UNION => $this->union($namespace, $return, $modelNamespace, $type),
            ReturnSpec::KIND_STREAM => sprintf('%s::stream()', $type),
            default => sprintf('%s::nothing()', $type),
        };
    }

    /**
     * A scalar, named by its `format` binding where the document gave it one.
     *
     * An unbound scalar keeps the four-method shorthand
     * (`ResponseType::string()`); a bound one names the binding instead, so
     * `{type: string, format: date}` decodes to the same
     * `\DateTimeImmutable` a model property with that format hydrates to, and
     * a consumer's own `#[BindsFormat]` value object — or registered
     * {@see Codec} — wins over the built-in exactly as it
     * does on a property.
     */
    private function scalar(PhpNamespace $namespace, ReturnSpec $return, string $type): string
    {
        $format = $return->scalarFormat;

        if (!$format instanceof ScalarFormat) {
            return sprintf('%s::%s()', $type, $return->scalarPhpType ?? 'string');
        }

        if ($format->kind === ScalarFormat::KIND_SCALAR) {
            $namespace->addUse(ltrim($format->phpType, '\\'));

            return sprintf('%s::binding(%s::class)', $type, $namespace->simplifyName($format->phpType));
        }

        if ($format->kind === ScalarFormat::KIND_CODEC) {
            $codec = $format->codecClass;
            assert($codec !== null);
            $namespace->addUse(ltrim($codec, '\\'));

            return sprintf('%s::codec(%s::class)', $type, $namespace->simplifyName($codec));
        }

        return sprintf('%s::dateTime()', $type);
    }

    private function fqcn(ReturnSpec $return, string $modelNamespace): string
    {
        return '\\' . trim($modelNamespace, '\\') . '\\' . $return->model;
    }

    private function model(PhpNamespace $namespace, ReturnSpec $return, string $modelNamespace): string
    {
        $fqcn = $this->fqcn($return, $modelNamespace);
        $namespace->addUse(ltrim($fqcn, '\\'));

        return $namespace->simplifyName($fqcn);
    }

    /**
     * `ResponseType::union()`, carrying exactly the piece
     * {@see UnionBranchPicker} needs —
     * a `Discriminator` for a tag-in-value resolution, a `BranchSelector`
     * for a structural one, never both. A pin never reaches here: {@see
     * \Poagen\Generator\Generator\Emit\ResponseUnionPlanner} types a
     * pinned response as its single branch directly, `KIND_MODEL`, the same
     * way a pinned property carries no union at all.
     */
    private function union(PhpNamespace $namespace, ReturnSpec $return, string $modelNamespace, string $type): string
    {
        $resolution = $return->unionResolution;
        assert($resolution instanceof UnionResolution);

        $discriminator = $resolution->kind === UnionResolution::KIND_TAG_IN_VALUE
            ? $this->discriminatorExpr($namespace, $resolution, $modelNamespace)
            : 'null';
        $selector = $resolution->kind === UnionResolution::KIND_STRUCTURAL
            ? $this->selectorExpr($namespace, $resolution, $modelNamespace)
            : 'null';

        return sprintf('%s::union(%s, %s, %s)', $type, $discriminator, $selector, var_export($resolution->position, true));
    }

    private function discriminatorExpr(PhpNamespace $namespace, UnionResolution $resolution, string $modelNamespace): string
    {
        $namespace->addUse(Discriminator::class);
        $map = [];

        foreach ($resolution->map as $tag => $model) {
            $map[$tag] = $this->classLiteral($namespace, $model, $modelNamespace);
        }

        return sprintf(
            'new %s(field: %s, map: %s, onParent: false)',
            $namespace->simplifyName(Discriminator::class),
            var_export($resolution->field, true),
            new Dumper()->dump($map),
        );
    }

    private function selectorExpr(PhpNamespace $namespace, UnionResolution $resolution, string $modelNamespace): string
    {
        $selectors = $resolution->selectors;
        assert($selectors instanceof BranchSelectors);
        $namespace->addUse(BranchSelector::class);

        $fields = [];

        foreach ($selectors->fields as $model => $field) {
            $fields[$field] = $this->classLiteral($namespace, (string) $model, $modelNamespace);
        }

        $emptyArg = $selectors->empty === null ? '' : sprintf(', empty: %s', $this->classLiteral($namespace, $selectors->empty, $modelNamespace));

        return sprintf(
            'new %s(fields: %s%s)',
            $namespace->simplifyName(BranchSelector::class),
            new Dumper()->dump($fields),
            $emptyArg,
        );
    }

    private function classLiteral(PhpNamespace $namespace, string $model, string $modelNamespace): Literal
    {
        $fqcn = '\\' . trim($modelNamespace, '\\') . '\\' . $model;
        $namespace->addUse(ltrim($fqcn, '\\'));

        return new Literal($namespace->simplifyName($fqcn) . '::class');
    }
}
