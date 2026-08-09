<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PsrPrinter;
use Poagen\Runtime\Contract\Envelope;
use Poagen\Runtime\Contract\ResponseType;
use Poagen\Runtime\Contract\StatusResponseMap;

use function array_map;
use function implode;
use function sprintf;
use function trim;

use const DIRECTORY_SEPARATOR;

/**
 * Emits `Generated\ResponseMaps`: one static method per declaration the
 * consumer named in `Profile::$responseMaps`, each returning the one
 * {@see StatusResponseMap} its group's operations share.
 *
 * A class of its own rather than a private helper per client, because the
 * duplication this answers is mostly across clients, not inside one — two
 * operations on two different sub-clients declaring the same responses is the
 * common shape, and a per-class helper cannot reach it. It sits alongside
 * `ApiClient.php` in the same namespace, so a sub-client calls it by its bare
 * name and needs no import.
 *
 * Every method names the operations that share it in its own docblock. That
 * is not decoration: this file is the one place in an emitted tree where two
 * call sites are asserted to mean the same thing, and the assertion came from
 * the consumer, so the file says who it applies to rather than leaving a
 * reader to grep for callers.
 *
 * @internal
 */
final readonly class SharedResponseMapEmitter
{
    public const string CLASS_NAME = 'ResponseMaps';

    private PsrPrinter $printer;

    private EnvelopeTypeEmitter $envelopeTypes;

    public function __construct()
    {
        $this->printer = new PsrPrinter();
        $this->envelopeTypes = new EnvelopeTypeEmitter();
    }

    /**
     * Emit into a write set, or not at all — a profile that declared no group
     * produces no file, which is what keeps an existing tree byte-identical.
     *
     * @param array<string,string> $writes
     */
    public function emitInto(
        SharedResponseMapPlan $plan,
        string $clientNamespace,
        string $rootDir,
        string $modelNamespace,
        array &$writes,
    ): void {
        if ($plan->isEmpty()) {
            return;
        }

        $writes[$rootDir . DIRECTORY_SEPARATOR . self::CLASS_NAME . '.php'] = $this->emit(
            $plan,
            $clientNamespace,
            $modelNamespace,
        );
    }

    public function emit(SharedResponseMapPlan $plan, string $clientNamespace, string $modelNamespace): string
    {
        $file = new PhpFile();
        $file->setStrictTypes();

        $namespace = $file->addNamespace(trim($clientNamespace, '\\'));
        $namespace->addUse(ResponseType::class);
        $namespace->addUse(Envelope::class);

        $class = $namespace->addClass(self::CLASS_NAME)->setFinal();
        $class->addComment('Every response map this profile declared shared.');
        $class->addComment('');
        $class->addComment('Each method is one declaration, called by the operations listed on it.');
        $class->addComment('Nothing here was inferred from two maps looking alike: the profile named');
        $class->addComment('these call sites, which is a claim about meaning only a consumer can make.');

        $returns = sprintf(
            '@return %s<%s<mixed>>',
            $namespace->simplifyName(ResponseType::class),
            $namespace->simplifyName(Envelope::class),
        );

        foreach ($plan->declarations() as $name => $envelope) {
            $method = $class->addMethod($name)->setPublic()->setStatic();
            $method->setReturnType(ResponseType::class);
            $method->addComment('Shared by ' . $this->callers($plan->membersOf($name)) . '.');
            $method->addComment('');
            $method->addComment($returns);
            $method->setBody('return ' . $this->envelopeTypes->expr($namespace, $envelope, $modelNamespace) . ';');
        }

        return $this->printer->printFile($file);
    }

    /**
     * @param list<string> $operationIds
     */
    private function callers(array $operationIds): string
    {
        return implode(', ', array_map(static fn(string $id): string => '`' . $id . '`', $operationIds));
    }
}
