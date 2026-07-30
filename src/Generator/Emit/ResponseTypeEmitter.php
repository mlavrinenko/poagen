<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Mlavrinenko\Paogen\Runtime\Contract\ResponseType;
use Nette\PhpGenerator\PhpNamespace;

use function sprintf;

/**
 * Names the shape an operation was promised back.
 *
 * The five {@see ReturnSpec} kinds map one-to-one onto {@see ResponseType},
 * which is the whole of what used to be the emitted status branch, decode
 * and hydrate sequence. The emitted method still declares its own return
 * type; this is what makes the transport give back a value that matches it.
 *
 * @internal
 */
final readonly class ResponseTypeEmitter
{
    public function expr(PhpNamespace $namespace, ReturnSpec $return, string $modelNamespace): string
    {
        $namespace->addUse(ResponseType::class);
        $type = $namespace->simplifyName(ResponseType::class);

        return match ($return->kind) {
            ReturnSpec::KIND_MODEL => sprintf('%s::object(%s::class)', $type, $this->model($namespace, $return, $modelNamespace)),
            ReturnSpec::KIND_LIST => sprintf('%s::listOf(%s::class)', $type, $this->model($namespace, $return, $modelNamespace)),
            ReturnSpec::KIND_SCALAR => sprintf('%s::%s()', $type, $return->scalarPhpType ?? 'string'),
            ReturnSpec::KIND_MAP => sprintf('%s::mapOf(%s::%s())', $type, $type, $return->mapValuePhpType ?? 'mixed'),
            default => sprintf('%s::nothing()', $type),
        };
    }

    private function model(PhpNamespace $namespace, ReturnSpec $return, string $modelNamespace): string
    {
        $fqcn = '\\' . trim($modelNamespace, '\\') . '\\' . $return->model;
        $namespace->addUse(ltrim($fqcn, '\\'));

        return $namespace->simplifyName($fqcn);
    }
}
