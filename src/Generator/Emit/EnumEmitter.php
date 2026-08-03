<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;
use Mlavrinenko\Paogen\Generator\Enum\EnumSpec;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PsrPrinter;

/**
 * Emits one PHP 8.1 backed enum file from an {@see EnumSpec}.
 *
 * No I/O — produces the printed PHP source string.
 */
final readonly class EnumEmitter
{
    private PsrPrinter $printer;

    public function __construct()
    {
        $this->printer = new PsrPrinter();
    }

    /**
     * Emit every enum a catalogue holds into a write set, keyed by path.
     *
     * @param array<string,string> $writes
     */
    public function emitAllInto(EnumCatalog $enums, string $enumDir, array &$writes): void
    {
        foreach ($enums->all() as $spec) {
            $writes[$enumDir . DIRECTORY_SEPARATOR . $spec->name . '.php'] = $this->emit($enums->enumNamespace, $spec);
        }
    }

    public function emit(string $enumNamespace, EnumSpec $spec): string
    {
        $enumNamespace = trim($enumNamespace, '\\');

        $file = new PhpFile();
        $file->setStrictTypes();

        $namespace = $file->addNamespace($enumNamespace);
        $enum = $namespace->addEnum($spec->name)->setType($spec->backingType);

        foreach ($spec->cases as $case) {
            $enum->addCase($case['name'], $case['value']);
        }

        return $this->printer->printFile($file);
    }
}
