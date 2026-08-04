<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\PathItem;

use function count;
use function sprintf;
use function strlen;

use const SORT_STRING;

/**
 * Names the operation ids the document gave poagen no way to make readable, and
 * says what would fix them.
 *
 * An identifier with no word boundary — `searchclient`, `getclientfullbalance`,
 * `goodslistxml` — has no algorithmic path to a camelCase method name. Deriving
 * one would need a dictionary, and a dictionary produces a *different wrong
 * answer per schema*: `getclientfullbalance` could plausibly split a dozen ways,
 * the choice would depend on whatever corpus was consulted, and it would move
 * when unrelated parts of the schema changed. That breaks the "no incidental
 * renames" half of `cheap-regeneration` while pretending to help.
 *
 * So poagen keeps the vendor's spelling, which is at least stable and
 * predictable, and says so — `real-world-schemas` asks the generator to request
 * guidance and state exactly what it needs where a document is ambiguous rather
 * than merely awkward. This is that request.
 *
 * It is a notice and not a failure. Nothing was omitted; the client works, it is
 * only less pleasant to call, and `user-code-guides-generation` is explicit that
 * the absence of guidance is never an error.
 *
 * @internal
 */
final readonly class OperationIdAdvisor
{
    /**
     * Anything with a separator, an uppercase letter, or a digit boundary has
     * word boundaries poagen can already act on.
     */
    private const string UNSEPARATED = '/^[a-z]+$/';

    /**
     * @param  array<string,string> $methodRenames Profile::$methodRenames — an id the consumer already
     *                                             answered is not worth mentioning again
     * @return list<string>         zero or one notice; the whole set is reported as one line so a
     *                              36-operation document does not bury the rest of the output
     */
    public static function notices(OpenApi $openApi, array $methodRenames): array
    {
        $unseparated = [];

        foreach (self::operationIds($openApi) as $id) {
            if (isset($methodRenames[$id])) {
                continue;
            }
            if (preg_match(self::UNSEPARATED, $id) === 1 && strlen($id) > 3) {
                $unseparated[] = $id;
            }
        }

        if ($unseparated === []) {
            return [];
        }

        sort($unseparated, SORT_STRING);

        return [sprintf(
            "%d operation id(s) carry no word boundary, so the emitted method keeps the vendor's spelling: %s. "
                . 'poagen does not guess a split — a dictionary would give a different answer per schema and move '
                . "names between runs. Where the vendor's spelling reads badly, name the method you want in "
                . "Profile::\$methodRenames, keyed on the operation id (e.g. 'getclientfullbalance' => "
                . "'getClientFullBalance'). A single word needs no answer.",
            count($unseparated),
            implode(', ', $unseparated),
        )];
    }

    /**
     * @return list<string>
     */
    private static function operationIds(OpenApi $openApi): array
    {
        $paths = $openApi->paths;

        if ($paths === null) {
            return [];
        }

        $ids = [];

        foreach ($paths as $pathItem) {
            if (!$pathItem instanceof PathItem) {
                continue;
            }

            foreach ($pathItem->getOperations() as $operation) {
                $id = (string) ($operation->operationId ?? '');

                if ($id !== '') {
                    $ids[] = $id;
                }
            }
        }

        return $ids;
    }
}
