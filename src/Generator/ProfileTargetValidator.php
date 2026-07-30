<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\PathItem;
use Mlavrinenko\Paogen\Generator\Emit\InlinePayloadPlanner;
use Mlavrinenko\Paogen\Generator\Emit\TagCatalogue;

use function in_array;
use function sprintf;

/**
 * Cross-checks the profile's operation-keyed guidance against the document —
 * `Profile::$inlineModels` and `Profile::$methodRenames`.
 *
 * Guidance that matches nothing is the failure mode this guards. It looks like
 * working guidance, it costs nothing to write, and it silently stops applying
 * the moment a vendor renames the operation it named — so the consumer's own
 * callers break on a method or class name that moved while their profile still
 * claims to fix it. Same reasoning as the stale-`$skip` check in
 * {@see SkipListValidator}: guidance that outlives its target is worse than no
 * guidance, because nothing surfaces it.
 *
 * Returns failure lines rather than throwing, so the run reports every problem
 * it found in one pass (abort-on-unrepresentable-constructs).
 */
final readonly class ProfileTargetValidator
{
    private const string IDENTIFIER = '/^[A-Za-z_]\w*$/';

    /**
     * @param  array<string,string> $pins          Profile::$inlineModels
     * @param  array<string,string> $methodRenames Profile::$methodRenames
     * @return list<string>         failure lines; empty means the run may proceed
     */
    public function validate(OpenApi $openApi, array $pins, array $methodRenames = [], ?Profile $profile = null): array
    {
        $known = array_fill_keys($this->operationIds($openApi), true);

        return [
            ...$this->validatePins($pins, $known),
            ...$this->validateMethodRenames($methodRenames, $known),
            ...($profile instanceof Profile ? $this->validateTags($openApi, $profile, $known) : []),
        ];
    }

    /**
     * @param  array<string,true> $known
     * @return list<string>
     */
    private function validateTags(OpenApi $openApi, Profile $profile, array $known): array
    {
        $carried = TagCatalogue::tagsCarriedByOperations($openApi, $profile);
        $failures = [];

        foreach (array_keys($profile->tagRenames) as $tag) {
            if (!isset($carried[$tag])) {
                $failures[] = sprintf(
                    "Profile::\$tagRenames['%s'] names a tag no operation carries — remove this entry, or point it "
                        . 'at the tag the vendor now uses.',
                    $tag,
                );
            }
        }

        foreach ($profile->tagChoice as $operationId => $tag) {
            if (!isset($known[$operationId])) {
                $failures[] = sprintf(
                    "Profile::\$tagChoice['%s'] names an operation id absent from the schema — remove this entry.",
                    $operationId,
                );

                continue;
            }

            if (!in_array($tag, TagCatalogue::declaredTagsOf($openApi, $operationId), true)) {
                $failures[] = sprintf(
                    "Profile::\$tagChoice['%s'] picks the tag '%s', which that operation does not carry — a choice "
                        . 'can only narrow the tags the document declared, not add one. Use '
                        . 'Profile::$tagAssignments to place an untagged operation.',
                    $operationId,
                    $tag,
                );
            }
        }

        foreach (array_keys($profile->tagAssignments) as $operationId) {
            if (!isset($known[$operationId])) {
                $failures[] = sprintf(
                    "Profile::\$tagAssignments['%s'] names an operation id absent from the schema — remove this entry.",
                    $operationId,
                );
            }
        }

        return $failures;
    }

    /**
     * @param  array<string,string> $methodRenames
     * @param  array<string,true>   $known
     * @return list<string>
     */
    private function validateMethodRenames(array $methodRenames, array $known): array
    {
        $failures = [];

        foreach (array_keys($methodRenames) as $operationId) {
            if (!isset($known[$operationId])) {
                $failures[] = sprintf(
                    "Profile::\$methodRenames['%s'] names an operation id absent from the schema — remove this "
                        . 'entry, or point it at the operation id the vendor now uses.',
                    $operationId,
                );
            }
        }

        return $failures;
    }

    /**
     * @param  array<string,string> $pins
     * @param  array<string,true>   $known
     * @return list<string>
     */
    private function validatePins(array $pins, array $known): array
    {
        $roles = [InlinePayloadPlanner::ROLE_REQUEST, InlinePayloadPlanner::ROLE_RESPONSE];
        $failures = [];

        foreach ($pins as $key => $className) {
            if (preg_match(self::IDENTIFIER, $className) !== 1) {
                $failures[] = sprintf(
                    "Profile::\$inlineModels['%s'] => '%s' is not a valid PHP class name.",
                    $key,
                    $className,
                );

                continue;
            }

            $split = strrpos($key, '.');
            $operationId = $split === false ? $key : substr($key, 0, $split);
            $role = $split === false ? '' : substr($key, $split + 1);

            if (!in_array($role, $roles, true)) {
                $failures[] = sprintf(
                    "Profile::\$inlineModels['%s'] does not name a payload role — a key is "
                        . "'<operationId>.request' or '<operationId>.response'.",
                    $key,
                );

                continue;
            }

            if (!isset($known[$operationId])) {
                $failures[] = sprintf(
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
