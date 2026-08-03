<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;

use function sprintf;

/**
 * The whole-document verdict on security: what aborts the run, and what is
 * merely worth saying.
 *
 * A dropped scheme used to be invisible. The emitted client took no
 * credential, sent no credential, and the run reported success, so the
 * consumer learned about it from the vendor's 401 rather than from the
 * tool — which is neither what `silence-means-success` promises nor what
 * `fail-loud-never-silent` requires. Every reaction here is one of the two
 * the project already recognises: an abort naming what to fix, or a notice
 * that never touches the exit status because nothing was left out.
 *
 * Only a scheme some requirement actually names is judged. An unused
 * declaration costs the consumer nothing — see {@see SecurityUsage}.
 *
 * @internal
 */
final readonly class SecurityAudit
{
    public const string PROFILE_KEY = 'Profile::$securitySchemes';

    /**
     * @param list<string> $failures lines that abort the run, one per scheme
     * @param list<string> $notices  lines that never move the exit status
     */
    private function __construct(
        public array $failures,
        public array $notices,
    ) {}

    public static function of(OpenApi $openApi): self
    {
        $catalog = new SecuritySchemeCatalog($openApi);
        $usage = $catalog->usage();
        $failures = [];
        $notices = [];

        foreach ($usage->requiredNames() as $name) {
            $scheme = $catalog->scheme($name);

            if (!$scheme instanceof SecurityScheme) {
                $failures[] = self::undeclared($name, $usage);

                continue;
            }

            if ($scheme->isRefused()) {
                $failures[] = self::refused($scheme, $usage);

                continue;
            }

            if ($scheme->isReported()) {
                $notices[] = self::mutualTls($scheme);
            }
        }

        return new self($failures, $notices);
    }

    /**
     * The one scheme with no request-level credential at all: the material
     * lives in the TLS handshake, on the consumer's PSR-18 client. Nothing
     * shrank, so the run generates normally and exits zero — this is the
     * notice channel `report-unrecognised-formats` established, not a
     * second one. The same line lands on the emitted client's docblock, so
     * a reader of the client learns it without having kept the run's output.
     */
    public static function mutualTls(SecurityScheme $scheme): string
    {
        return sprintf(
            "security scheme '%s' is mutualTLS — there is no request-level credential to emit, so the generated "
                . 'client takes none. Configure the client certificate and key on the PSR-18 client you hand to the '
                . 'transport.',
            $scheme->name,
        );
    }

    private static function refused(SecurityScheme $scheme, SecurityUsage $usage): string
    {
        return sprintf(
            "security scheme '%s' (%s) cannot be wired: %s. %s Skipping those operations is the only opt-out — add "
                . 'their operation ids to Profile::$skip.',
            $scheme->name,
            $scheme->typeLabel,
            $scheme->refusalReason,
            self::whereRequired($scheme->name, $usage),
        );
    }

    private static function undeclared(string $name, SecurityUsage $usage): string
    {
        return sprintf(
            "security requirement '%s' names a scheme components.securitySchemes does not declare, so paogen cannot "
                . "tell what to send or where. %s Declare it under %s keyed '%s' — e.g. ['type' => 'apiKey', "
                . "'in' => 'header', 'name' => '%s'] — or skip those operations via Profile::\$skip.",
            $name,
            self::whereRequired($name, $usage),
            self::PROFILE_KEY,
            $name,
            $name,
        );
    }

    /**
     * A globally-applied scheme is named as such rather than by listing
     * every operation that inherits it — that list is the whole document,
     * and reading it teaches the consumer nothing the one sentence does not.
     */
    private static function whereRequired(string $name, SecurityUsage $usage): string
    {
        $operations = $usage->operationsFor($name);
        $global = $usage->isGlobal($name)
            ? "Applied globally by the document's top-level `security`, so every operation that does not override it "
                . 'requires it.'
            : '';

        if ($operations === []) {
            return $global;
        }

        $listed = sprintf('Required by %s.', implode(', ', $operations));

        return $global === '' ? $listed : $global . ' ' . $listed;
    }
}
