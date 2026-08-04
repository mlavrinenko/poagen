<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

/**
 * One `'<operationId>.<position>'` key of `Profile::$inlineModels` —
 * `addclient.403`, `addclient.request` — split into the raw operation id and
 * the position, which is either the literal word `request` or a response
 * status exactly as the document spells it.
 *
 * The split is on the *last* dot, matching every other dotted profile key
 * (`$propertyRenames`, `$xmlElements`) — an operation id never contains one
 * in either vendored corpus, but a status never does either, so there is no
 * ambiguity to break the tie on.
 *
 * @internal
 */
final readonly class InlineModelSite
{
    public function __construct(
        public string $operationId,
        public string $position,
    ) {}

    public static function parse(string $key): self
    {
        $split = strrpos($key, '.');

        return $split === false
            ? new self($key, '')
            : new self(substr($key, 0, $split), substr($key, $split + 1));
    }

    public function key(): string
    {
        return $this->operationId . '.' . $this->position;
    }

    public function isRequest(): bool
    {
        return $this->position === InlinePayloadPlanner::ROLE_REQUEST;
    }
}
