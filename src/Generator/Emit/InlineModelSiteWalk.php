<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\RequestBody;
use cebe\openapi\spec\Response;
use cebe\openapi\spec\Schema;

/**
 * Every `'<operationId>.<position>'` site in the document that would earn its
 * own inline model class — exactly what {@see InlinePayloadPlanner} and
 * {@see ExtraResponsePlanner} would themselves name one from, read without
 * their side effects (no ledger claim, no root queued). Feeds
 * {@see InlineModelMergeAdvisor}, which groups the result by shape rather
 * than by site.
 *
 * @internal
 */
final readonly class InlineModelSiteWalk
{
    /**
     * @param array<string,string> $preScannedSkips raw operationId → reason — an operation refused
     *                                               before payload naming runs claims no site here either
     * @return list<InlineModelSiteSchema>
     */
    public static function sites(OpenApi $openApi, array $preScannedSkips = []): array
    {
        $out = [];

        foreach (OperationOrder::inEmissionOrder($openApi) as [, , $operation]) {
            $rawId = (string) ($operation->operationId ?? '');

            if ($rawId === '') {
                continue;
            }

            if (isset($preScannedSkips[$rawId])) {
                continue;
            }

            self::addRequestSite($operation, $rawId, $out);
            self::addResponseSites($operation, $rawId, $out);
        }

        return $out;
    }

    /**
     * @param list<InlineModelSiteSchema> $out
     */
    private static function addRequestSite(Operation $operation, string $rawId, array &$out): void
    {
        $body = RequestBodyAnalyzer::resolveBody($operation->requestBody);

        if (!$body instanceof RequestBody) {
            return;
        }

        self::addOne($rawId, InlinePayloadPlanner::ROLE_REQUEST, InlinePayloadPlanner::jsonSchemaOf($body->content), $out);
    }

    /**
     * @param list<InlineModelSiteSchema> $out
     */
    private static function addResponseSites(Operation $operation, string $rawId, array &$out): void
    {
        $responses = $operation->responses;

        if ($responses === null) {
            return;
        }

        foreach ($responses->getResponses() as $status => $response) {
            if (!$response instanceof Response) {
                continue;
            }

            self::addOne($rawId, (string) $status, InlinePayloadPlanner::jsonSchemaOf($response->content), $out);
        }
    }

    /**
     * @param list<InlineModelSiteSchema> $out
     */
    private static function addOne(string $rawId, string $position, ?Schema $schema, array &$out): void
    {
        if (!$schema instanceof Schema) {
            return;
        }

        if (InlinePayloadPlanner::isSynthesisableObject($schema)) {
            $out[] = new InlineModelSiteSchema(new InlineModelSite($rawId, $position), $schema, item: false);

            return;
        }

        $items = InlinePayloadPlanner::inlineObjectItemsOf($schema);

        if ($items instanceof Schema) {
            $out[] = new InlineModelSiteSchema(new InlineModelSite($rawId, $position), $items, item: true);
        }
    }
}
