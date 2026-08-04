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
 * otherwise-bare native return type — the intermediate-variable pattern a
 * top-level union always needed, generalised to every operation, so every
 * emitted method carries it now rather than only the ones that used to need
 * it.
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

    /**
     * `exact`, `ranges` and `default` are all optional named arguments on
     * `StatusResponseMap::__construct`, defaulting to `[]`, `[]` and `null`
     * respectively — an operation that declares no range key and no
     * `default` (most of them) writes neither argument rather than writing
     * out the default it would have supplied anyway. Named arguments make
     * the omission order-independent, so dropping the middle one never
     * shifts what the surviving ones mean.
     */
    public function expr(PhpNamespace $namespace, EnvelopeSpec $envelope, string $modelNamespace): string
    {
        $namespace->addUse(ResponseType::class);
        $namespace->addUse(StatusResponseMap::class);
        $type = $namespace->simplifyName(ResponseType::class);

        $args = [];

        if ($envelope->exact !== []) {
            $args[] = sprintf('exact: %s', $this->pairs($namespace, $envelope->exact, $modelNamespace));
        }

        if ($envelope->ranges !== []) {
            $args[] = sprintf('ranges: %s', $this->pairs($namespace, $envelope->ranges, $modelNamespace));
        }

        if ($envelope->default instanceof ReturnSpec) {
            $args[] = sprintf('default: %s', $this->responseTypes->expr($namespace, $envelope->default, $modelNamespace));
        }

        return sprintf(
            '%s::envelope(new %s(%s))',
            $type,
            $namespace->simplifyName(StatusResponseMap::class),
            implode(', ', $args),
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
     * A status paired with `null` rather than the spelled-out
     * `ResponseType::nothing()` when its body is `KIND_VOID` — shorter, and
     * unambiguous only because the pair's presence in the list already says
     * the status is declared. `StatusResponseMap::__construct` normalises
     * that `null` back to `ResponseType::nothing()` immediately, so
     * `StatusResponseMap::match()` never has to know the shorthand exists:
     * a status this list names always resolves to a real
     * {@see ResponseType}, and `null`
     * keeps meaning exactly one thing on that path — the status is not in
     * the list at all.
     *
     * @param list<array{0: string, 1: ReturnSpec}> $specs
     */
    private function pairs(PhpNamespace $namespace, array $specs, string $modelNamespace): string
    {
        if ($specs === []) {
            return '[]';
        }

        $rows = [];

        foreach ($specs as [$status, $spec]) {
            $expr = $spec->kind === ReturnSpec::KIND_VOID
                ? 'null'
                : $this->responseTypes->expr($namespace, $spec, $modelNamespace);
            $rows[] = sprintf('[%s, %s]', var_export($status, true), $expr);
        }

        return '[' . implode(', ', $rows) . ']';
    }
}
