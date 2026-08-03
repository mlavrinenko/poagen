<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\PathItem;

use function is_string;
use function sprintf;

/**
 * Which scheme names the document actually requires, and where.
 *
 * This is what keeps an unused declaration silent. A scheme sitting under
 * `components.securitySchemes` that no operation and no global requirement
 * ever names costs the consumer nothing — it is vocabulary the vendor
 * published and did not use — so refusing the run over an unused
 * `http digest` block, or printing a notice about an unused `mutualTLS`
 * one, would be noise about a fact with no consequence. Every diagnostic
 * paogen raises about a scheme is raised because some operation needs that
 * scheme and will not get it.
 *
 * It is also where an abort gets the list it names. A refused scheme
 * reports every operation that requires it, so the consumer can see the
 * cost of skipping them before deciding to.
 *
 * @internal
 */
final readonly class SecurityUsage
{
    /**
     * @param array<string, list<string>> $operations scheme name → operation labels that name it
     * @param array<string, true>         $global     scheme names the document's top-level `security` applies
     */
    private function __construct(
        private array $operations,
        private array $global,
    ) {}

    public static function scan(OpenApi $openApi): self
    {
        $global = SecurityRequirements::read($openApi->security);
        $operations = [];

        foreach ($openApi->paths ?? [] as $pathUri => $pathItem) {
            if (!is_string($pathUri)) {
                continue;
            }
            if (!$pathItem instanceof PathItem) {
                continue;
            }
            foreach ($pathItem->getOperations() as $httpMethod => $operation) {
                // An operation that inherits the global requirement is
                // covered by the global flag, so only an explicit override
                // adds an operation label — otherwise a globally-secured
                // document would list every one of its operations twice
                // over in one diagnostic.
                if (!isset($operation->security)) {
                    continue;
                }

                $label = sprintf(
                    '%s %s (%s)',
                    strtoupper((string) $httpMethod),
                    $pathUri,
                    (string) ($operation->operationId ?? '?'),
                );

                foreach (array_keys(SecurityRequirements::read($operation->security)) as $name) {
                    $operations[$name][] = $label;
                }
            }
        }

        return new self($operations, array_fill_keys(array_keys($global), true));
    }

    public function isRequired(string $name): bool
    {
        return isset($this->global[$name]) || ($this->operations[$name] ?? []) !== [];
    }

    public function isGlobal(string $name): bool
    {
        return isset($this->global[$name]);
    }

    /**
     * @return list<string>
     */
    public function operationsFor(string $name): array
    {
        return $this->operations[$name] ?? [];
    }

    /**
     * Every scheme name some requirement asks for, global names first and
     * then in the order the paths declare them, so a diagnostic reads in
     * document order rather than hash order.
     *
     * @return list<string>
     */
    public function requiredNames(): array
    {
        $seen = $this->global;
        $out = array_keys($this->global);

        foreach (array_keys($this->operations) as $name) {
            if (!isset($seen[$name])) {
                $seen[$name] = true;
                $out[] = $name;
            }
        }

        return $out;
    }
}
