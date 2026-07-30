<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Mlavrinenko\Paogen\Runtime\ScalarBinding;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PsrPrinter;

use function assert;

/**
 * Emits a thin `ScalarBinding` value object for a top-level scalar component
 * (T-026). DigitalOcean-style `urn`, `ssh_key_id` etc. are declared as
 * `type: string` / `type: integer` but referenced as classes; this emitter
 * materialises them so `$ref`s resolve to real files that round-trip through
 * `Marshaller` / `Hydrator` via the existing `ScalarBinding` path.
 */
final readonly class ScalarVoEmitter
{
    private const array PHP_TYPE_BY_JSON = [
        'string' => 'string',
        'integer' => 'int',
        'number' => 'float',
        'boolean' => 'bool',
    ];

    private PsrPrinter $printer;

    public function __construct()
    {
        $this->printer = new PsrPrinter();
    }

    public function emit(string $modelNamespace, ComponentShape $shape): string
    {
        assert($shape->kind === ComponentShape::KIND_SCALAR);
        assert($shape->scalarType !== null);

        $phpType = self::PHP_TYPE_BY_JSON[$shape->scalarType];
        $namespaceName = trim($modelNamespace, '\\');

        $file = new PhpFile();
        $file->setStrictTypes();
        $namespace = $file->addNamespace($namespaceName);
        $namespace->addUse(ScalarBinding::class);

        $class = $namespace->addClass($shape->phpName)->setFinal()->setReadOnly();
        $class->addImplement(ScalarBinding::class);

        $class->addMethod('__construct')
            ->addPromotedParameter('value')
            ->setPublic()
            ->setType($phpType);

        $namespace->addUseFunction('assert');
        $namespace->addUseFunction('is_' . $phpType);

        $class->addMethod('fromScalar')
            ->setStatic()
            ->setPublic()
            ->setReturnType('self')
            ->addBody('assert(is_' . $phpType . '($raw));')
            ->addBody('return new self($raw);')
            ->addParameter('raw')
            ->setType('mixed');

        $class->addMethod('toScalar')
            ->setPublic()
            ->setReturnType($phpType)
            ->addBody('return $this->value;');

        return $this->printer->printFile($file);
    }
}
