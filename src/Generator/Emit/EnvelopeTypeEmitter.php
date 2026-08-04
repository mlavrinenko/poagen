<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Mlavrinenko\Paogen\Runtime\Contract\Envelope;
use Mlavrinenko\Paogen\Runtime\Contract\ResponseType;
use Mlavrinenko\Paogen\Runtime\Contract\StatusResponseMap;
use Nette\PhpGenerator\PhpNamespace;

use function array_unique;
use function array_values;
use function implode;
use function sprintf;
use function var_export;

/**
 * Names the whole per-status resolution `typed-error-responses` builds: the
 * `ResponseType::envelope(...)` expression a generated method's `send()`
 * call carries now, and the `Envelope<...>` PHPDoc that narrows its
 * otherwise-bare native return type — the same intermediate-variable pattern
 * {@see ResponseTypeEmitter::varType()} already used for a top-level union,
 * generalised to every operation.
 *
 * Reuses {@see ResponseTypeEmitter}'s per-status expression and doc-type
 * building unchanged: an envelope is a map of the same {@see ReturnSpec}
 * every status has always resolved to, not a new shape of its own.
 *
 * @internal
 */
final readonly class EnvelopeTypeEmitter
{
    public function __construct(private ResponseTypeEmitter $responseTypes = new ResponseTypeEmitter()) {}

    public function expr(PhpNamespace $namespace, EnvelopeSpec $envelope, string $modelNamespace): string
    {
        $namespace->addUse(ResponseType::class);
        $namespace->addUse(StatusResponseMap::class);
        $type = $namespace->simplifyName(ResponseType::class);

        $default = $envelope->default instanceof ReturnSpec
            ? $this->responseTypes->expr($namespace, $envelope->default, $modelNamespace)
            : 'null';

        return sprintf(
            '%s::envelope(new %s(exact: %s, ranges: %s, default: %s))',
            $type,
            $namespace->simplifyName(StatusResponseMap::class),
            $this->pairs($namespace, $envelope->exact, $modelNamespace),
            $this->pairs($namespace, $envelope->ranges, $modelNamespace),
            $default,
        );
    }

    /**
     * `Envelope<A|B>` — every distinct body doc-type across every declared
     * status, deduplicated before the union is joined. An operation whose
     * every status shares the identical shape collapses to that one shape
     * rather than a union of one, which is what lets a profile merge (two
     * statuses pinned to the same class) shrink a real union down to none.
     */
    public function docType(EnvelopeSpec $envelope, string $modelNamespace): string
    {
        $parts = [];

        foreach ($envelope->entries() as [, $spec]) {
            $parts[] = $spec->kind === ReturnSpec::KIND_VOID ? 'null' : $this->responseTypes->docType($spec, $modelNamespace);
        }

        return '\\' . Envelope::class . '<' . implode('|', array_values(array_unique($parts))) . '>';
    }

    /**
     * @param list<array{0: string, 1: ReturnSpec}> $specs
     */
    private function pairs(PhpNamespace $namespace, array $specs, string $modelNamespace): string
    {
        if ($specs === []) {
            return '[]';
        }

        $rows = [];

        foreach ($specs as [$status, $spec]) {
            $rows[] = sprintf('[%s, %s]', var_export($status, true), $this->responseTypes->expr($namespace, $spec, $modelNamespace));
        }

        return '[' . implode(', ', $rows) . ']';
    }
}
