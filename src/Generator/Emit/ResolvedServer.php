<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

/**
 * One document-declared server, resolved to the PHP identifier
 * {@see ServerCatalog} emits it under.
 *
 * `$constantName` is derived from the server's own `description` when the
 * document gives one, or from its declaration position otherwise — never
 * from `$url`, which can carry a `{variable}` template or characters no PHP
 * identifier allows.
 *
 * @internal
 */
final readonly class ResolvedServer
{
    public function __construct(
        public string $constantName,
        public string $url,
        public ?string $description,
    ) {}
}
