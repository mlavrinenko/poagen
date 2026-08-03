<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use cebe\openapi\spec\Components;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\SecurityScheme as CebeSecurityScheme;
use Mlavrinenko\Paogen\Generator\Emit\SecurityAudit;
use Mlavrinenko\Paogen\Generator\Emit\SecurityUsage;

use function sprintf;

/**
 * Fills a gap the document left: a `security` requirement naming a scheme
 * `components.securitySchemes` never declares.
 *
 * This is not hypothetical. The vendored petstore document requires
 * `api_key` on `getPetById` and `getInventory` and declares only
 * `petstore_auth`, so those two operations name a credential nothing
 * describes. The document is invalid, the fixture may not be edited
 * (`fixtures-are-unmodified-vendor-documents`), and the consumer does know
 * what `api_key` is — so the generator asks for the one fact it is missing
 * instead of guessing a header name or dropping the operations, which is
 * the shape `real-world-schemas` calls for where a document is genuinely
 * ambiguous.
 *
 * The declaration is merged into the parsed document rather than carried
 * beside it, so every reader downstream — the catalog, the emitters, the
 * audit — sees one document with no gap in it and needs to know nothing
 * about where the missing piece came from.
 *
 * Guidance that matches nothing fails the run, the same as
 * {@see ProfileTargetValidator}'s maps: an entry naming a scheme the
 * document does declare, or one no requirement asks for, looks like working
 * guidance while doing nothing.
 */
final readonly class ProfileSecuritySchemes
{
    /**
     * @param  array<string, array<string, mixed>> $declarations Profile::$securitySchemes
     * @return list<string>                        failure lines; empty means the run may proceed
     */
    public static function apply(OpenApi $openApi, array $declarations): array
    {
        if ($declarations === []) {
            return [];
        }

        $usage = SecurityUsage::scan($openApi);
        $components = $openApi->components ?? new Components([]);
        /** @var array<string, CebeSecurityScheme|Reference> $existing */
        $existing = $components->securitySchemes ?? [];
        $failures = [];
        $added = [];

        foreach ($declarations as $name => $declaration) {
            $failure = self::reject($name, $existing, $usage);

            if ($failure === null) {
                $added[$name] = new CebeSecurityScheme($declaration);

                continue;
            }

            $failures[] = $failure;
        }

        if ($added !== []) {
            $components->securitySchemes = [...$existing, ...$added];
            $openApi->components = $components;
        }

        return $failures;
    }

    /**
     * @param array<string, CebeSecurityScheme|Reference> $existing
     */
    private static function reject(string $name, array $existing, SecurityUsage $usage): ?string
    {
        if (isset($existing[$name])) {
            return sprintf(
                "%s['%s'] names a scheme the document already declares under components.securitySchemes — remove "
                    . 'this entry; paogen will not override what the vendor published.',
                SecurityAudit::PROFILE_KEY,
                $name,
            );
        }

        if (!$usage->isRequired($name)) {
            return sprintf(
                "%s['%s'] names a scheme no security requirement asks for — remove this entry, or point it at the "
                    . 'requirement name the document actually uses.',
                SecurityAudit::PROFILE_KEY,
                $name,
            );
        }

        return null;
    }
}
