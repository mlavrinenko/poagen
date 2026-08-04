<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PsrPrinter;

use function assert;

/**
 * Emits the empty marker interface that represents a top-level `oneOf` /
 * `anyOf` component (T-026).
 *
 * `$ref`-branch Models pick the interface up via {@see ComponentCatalog::interfacesFor};
 * inline-object branches are synthesised as `<Component><TitleOrIndex>`
 * classes and declared `implements <Interface>` at synthesis time.
 */
final readonly class UnionInterfaceEmitter
{
    private PsrPrinter $printer;

    public function __construct()
    {
        $this->printer = new PsrPrinter();
    }

    public function emit(string $modelNamespace, ComponentShape $shape): string
    {
        assert($shape->kind === ComponentShape::KIND_UNION);

        $file = new PhpFile();
        $file->setStrictTypes();
        $namespace = $file->addNamespace(trim($modelNamespace, '\\'));
        $namespace->addInterface($shape->phpName);

        return $this->printer->printFile($file);
    }
}
