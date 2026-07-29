<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\PathItem;
use Mlavrinenko\Paogen\Generator\Emit\InlinePayloadPlanner;

/**
 * Cross-checks `Profile::$inlineModels` against the document.
 *
 * A pin that matches nothing is the failure mode this guards. It looks like
 * working guidance, it costs nothing to write, and it silently stops applying
 * the moment a vendor renames the operation it named — so the consumer's own
 * callers break on a class name that moved while their profile still claims to
 * pin it. Same reasoning as the stale-`$skip` check in
 * {@see SkipListValidator}: guidance that outlives its target is worse than no
 * guidance, because nothing surfaces it.
 *
 * Returns failure lines rather than throwing, so the run reports every problem
 * it found in one pass (abort-on-unrepresentable-constructs).
 */
final readonly class InlineModelPinValidator
{
    private const string IDENTIFIER = '/^[A-Za-z_]\w*$/';

    /**
     * @param  array<string,string> $pins Profile::$inlineModels
     * @return list<string>         failure lines; empty means the run may proceed
     */
    public function validate(OpenApi $openApi, array $pins): array
    {
        $roles = [InlinePayloadPlanner::ROLE_REQUEST, InlinePayloadPlanner::ROLE_RESPONSE];
        $known = array_fill_keys($this->operationIds($openApi), true);
        $failures = [];

        foreach ($pins as $key => $className) {
            if (preg_match(self::IDENTIFIER, $className) !== 1) {
                $failures[] = \sprintf(
                    "Profile::\$inlineModels['%s'] => '%s' is not a valid PHP class name.",
                    $key,
                    $className,
                );

                continue;
            }

            $split = strrpos($key, '.');
            $operationId = $split === false ? $key : substr($key, 0, $split);
            $role = $split === false ? '' : substr($key, $split + 1);

            if (!\in_array($role, $roles, true)) {
                $failures[] = \sprintf(
                    "Profile::\$inlineModels['%s'] does not name a payload role — a key is "
                        . "'<operationId>.request' or '<operationId>.response'.",
                    $key,
                );

                continue;
            }

            if (!isset($known[$operationId])) {
                $failures[] = \sprintf(
                    "Profile::\$inlineModels['%s'] names an operation id absent from the schema — remove this "
                        . 'entry, or point it at the operation id the vendor now uses.',
                    $key,
                );
            }
        }

        return $failures;
    }

    /**
     * @return list<string>
     */
    private function operationIds(OpenApi $openApi): array
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
