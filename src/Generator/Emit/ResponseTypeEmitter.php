<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Mlavrinenko\Paogen\Generator\ScalarFormat;
use Mlavrinenko\Paogen\Runtime\Contract\ResponseType;
use Mlavrinenko\Paogen\Runtime\Http\ResponseDecoder;
use Nette\PhpGenerator\PhpNamespace;

use function sprintf;

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
            default => 'mixed',
        };
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
     * a consumer's own `#[BindsFormat]` value object wins over the built-in
     * exactly as it does on a property.
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
}
