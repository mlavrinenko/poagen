<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Schema;
use Poagen\Generator\Generator\Emit\InlineModelMergeValidator;
use Poagen\Generator\Generator\Emit\XmlNestedContainerValidator;

use function in_array;
use function sprintf;

/**
 * Cross-checks the profile's operation-keyed guidance against the document —
 * `Profile::$inlineModels` and `Profile::$methodRenames`. The
 * `'<operationId>.item.<property>'` form of `Profile::$xmlElements` gets the
 * same treatment, delegated to {@see XmlNestedContainerValidator} to keep
 * this file under the linecop limit (`quality-gates-at-maximum-strictness`).
 *
 * Guidance that matches nothing is the failure mode this guards. It looks like
 * working guidance, it costs nothing to write, and it silently stops applying
 * the moment a vendor renames the operation it named — so the consumer's own
 * callers break on a method or class name that moved while their profile still
 * claims to fix it. Same reasoning as the stale-`$skip` check in
 * {@see SkipListValidator}: guidance that outlives its target is worse than no
 * guidance, because nothing surfaces it.
 *
 * `$inlineModels` reads as one class name to many sites
 * (name-inline-schemas-by-operation-and-status): a site absent from the
 * document fails the same way any other stale entry here does, and a merge
 * whose sites do not all emit the identical shape fails naming the two that
 * differ and the property they differ on — {@see InlineModelMergeValidator}.
 *
 * Returns failure lines rather than throwing, so the run reports every problem
 * it found in one pass (abort-on-unrepresentable-constructs).
 */
final readonly class ProfileTargetValidator
{
    private const string IDENTIFIER = '/^[A-Za-z_]\w*$/';

    /**
     * @param  array<string, string|list<string>> $inlineModels  Profile::$inlineModels
     * @param  array<string,string>                $methodRenames Profile::$methodRenames
     * @return list<string>                        failure lines; empty means the run may proceed
     */
    public function validate(OpenApi $openApi, array $inlineModels, array $methodRenames = [], ?Profile $profile = null): array
    {
        $known = array_fill_keys($this->operationIds($openApi), true);

        return [
            ...$this->validateInlineModels($openApi, $inlineModels),
            ...$this->validateMethodRenames($methodRenames, $known),
            ...($profile instanceof Profile ? $this->validateTags($openApi, $profile, $known) : []),
            ...($profile instanceof Profile
                ? XmlNestedContainerValidator::validate($openApi, $profile->xmlElements, $known)
                : []),
        ];
    }

    /**
     * @param  array<string,true> $known
     * @return list<string>
     */
    private function validateTags(OpenApi $openApi, Profile $profile, array $known): array
    {
        $carried = Emit\TagCatalogue::tagsCarriedByOperations($openApi, $profile);
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

            if (!in_array($tag, Emit\TagCatalogue::declaredTagsOf($openApi, $operationId), true)) {
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
     * @param  array<string, string|list<string>> $inlineModels
     * @return list<string>
     */
    private function validateInlineModels(OpenApi $openApi, array $inlineModels): array
    {
        $failures = [];

        foreach (Emit\InlineModelGroups::normalise($inlineModels) as $className => $sites) {
            if (preg_match(self::IDENTIFIER, $className) !== 1) {
                $failures[] = sprintf("Profile::\$inlineModels['%s'] is not a valid PHP class name.", $className);

                continue;
            }

            $failures = [...$failures, ...$this->validateSites($openApi, $className, $sites)];
        }

        return $failures;
    }

    /**
     * @param  list<string> $sites
     * @return list<string>
     */
    private function validateSites(OpenApi $openApi, string $className, array $sites): array
    {
        $failures = [];
        $schemas = [];

        foreach ($sites as $site) {
            $schema = Emit\InlineModelSiteResolver::schema($openApi, Emit\InlineModelSite::parse($site));

            if (!$schema instanceof Schema) {
                $failures[] = sprintf(
                    "Profile::\$inlineModels['%s'] names the site '%s', which is absent from the schema — remove "
                        . 'this entry, or point it at the site the vendor now uses.',
                    $className,
                    $site,
                );

                continue;
            }

            $schemas[$site] = $schema;
        }

        if ($failures !== [] || count($schemas) < 2) {
            return $failures;
        }

        return InlineModelMergeValidator::mismatches($className, $schemas);
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
