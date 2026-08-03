<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpNamespace;

use function implode;
use function ltrim;
use function trim;

/**
 * Sets the native PHP return type for a {@see ReturnSpec::KIND_UNION} —
 * the whole point of `a-union-response-selects-its-branch`'s acceptance
 * criterion that it narrow under `instanceof` with no suppression. Split
 * out of {@see OperationEmitter} to keep both under the linecop limit
 * (`quality-gates-at-maximum-strictness`).
 *
 * A full FQCN per branch, joined by `|`, mirrors
 * {@see RequestBodyParameterEmitter::addJsonUnionBodyParam()} exactly
 * rather than routing through the phpdoc-oriented {@see DocTypeSimplifier}:
 * `Method::setReturnType()` treats an already-short name as an unqualified
 * type in the *current* namespace and prefixes it wrongly, so what it needs
 * is the real FQCN plus a registered `use`, not an already-simplified string.
 *
 * @internal
 */
final readonly class UnionReturnTypeApplier
{
    public static function apply(Method $method, PhpNamespace $namespace, ReturnSpec $return, string $modelNamespace): void
    {
        $fqcns = [];

        foreach ($return->models ?? [] as $model) {
            $fqcn = '\\' . trim($modelNamespace, '\\') . '\\' . $model;
            $namespace->addUse(ltrim($fqcn, '\\'));
            $fqcns[] = $fqcn;
        }

        $method->setReturnType(implode('|', $fqcns));
    }
}
