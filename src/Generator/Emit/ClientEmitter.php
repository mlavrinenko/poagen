<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\Profile;
use Nette\PhpGenerator\PsrPrinter;

use const DIRECTORY_SEPARATOR;

/**
 * Emits the whole caller surface: one sub-client and interface per tag, plus the
 * root `ApiClient` that hands them out.
 *
 * The root carries no operation methods beyond the ones the document left
 * untagged, so exactly one way exists to reach any given endpoint. Two ways would
 * let a call site bypass whatever decorator a consumer wrapped the sub-client in,
 * which would make the interface advisory rather than load-bearing.
 *
 * Sub-clients are the primary surface. The root is a composition root — useful
 * for wiring a container, and not what a service should depend on.
 *
 * @internal
 */
final class ClientEmitter
{
    private readonly PsrPrinter $printer;
    private readonly SubClientEmitter $subClients;

    /** @var list<SkippedOperation> */
    private array $skipped = [];

    public function __construct(OperationEmitter $operationEmitter)
    {
        $this->printer = new PsrPrinter();
        $this->subClients = new SubClientEmitter($operationEmitter);
    }

    /**
     * @param  array<string,string> $writes keyed by absolute path
     * @return int                  how many files this wrote
     */
    public function emit(
        string $clientNamespace,
        string $rootDir,
        OpenApi $openApi,
        Bindings $bindings,
        Profile $profile,
        NameRegistry $tagRegistry,
        array &$writes,
    ): int {
        $groups = SubClientPlanner::plan($openApi, $profile, $tagRegistry);

        if ($groups === []) {
            return 0;
        }

        $securityCatalog = new SecuritySchemeCatalog($openApi);
        $clientNamespace = trim($clientNamespace, '\\');
        $written = 0;
        $rootGroup = null;

        /** @var list<TagGroup> $live groups that emitted at least one method */
        $live = [];

        foreach ($groups as $group) {
            if ($group->isRoot()) {
                $rootGroup = $group;
                continue;
            }

            $result = $this->subClients->emit($clientNamespace, $group, $bindings, $securityCatalog);
            $this->skipped = [...$this->skipped, ...$result['skipped']];

            if ($result['source'] === '') {
                continue;
            }

            $writes[$rootDir . DIRECTORY_SEPARATOR . $group->phpName . '.php'] = $result['source'];
            $writes[$rootDir . DIRECTORY_SEPARATOR . $group->interfaceName() . '.php'] = $result['interface'];
            $written += 2;
            $live[] = $group;
        }

        $servers = ServerCatalog::resolve($openApi);

        return $written + $this->emitRoot($clientNamespace, $rootDir, $rootGroup, $live, $bindings, $securityCatalog, $servers, $writes);
    }

    /**
     * @return list<SkippedOperation> the skipped operations from the most recent
     *                                {@see emit()} call, in pipeline order. Resets
     *                                the internal log so the next run does not
     *                                double-count entries.
     */
    public function drainSkipped(): array
    {
        $out = $this->skipped;
        $this->skipped = [];

        return $out;
    }

    /**
     * @param list<TagGroup>       $live
     * @param list<ResolvedServer> $servers
     * @param array<string,string> $writes
     */
    private function emitRoot(
        string $clientNamespace,
        string $rootDir,
        ?TagGroup $rootGroup,
        array $live,
        Bindings $bindings,
        SecuritySchemeCatalog $securityCatalog,
        array $servers,
        array &$writes,
    ): int {
        // With no tags and nothing untagged there is no client to emit at all.
        if ($live === [] && !$rootGroup instanceof TagGroup) {
            return 0;
        }

        $group = $rootGroup ?? new TagGroup('', 'ApiClient', []);
        [$file, $namespace, $class] = $this->subClients->openClass(
            $clientNamespace,
            'ApiClient',
            'ApiClientInterface',
            $securityCatalog,
        );
        ServerConstantEmitter::addTo($class, $servers);

        $outcome = $this->subClients->addOperations($class, $namespace, $group, $bindings, $securityCatalog);
        $this->skipped = [...$this->skipped, ...$outcome['skipped']];

        if ($outcome['emitted'] === 0 && $live === []) {
            return 0;
        }

        $args = implode(', ', ClientConstructor::forwardedArgs($securityCatalog->constructorSchemes()));

        foreach ($live as $sub) {
            $namespace->addUse($clientNamespace . '\\' . $sub->phpName);
            $namespace->addUse($clientNamespace . '\\' . $sub->interfaceName());

            $accessor = $class->addMethod($sub->accessor())->setPublic();
            $accessor->setReturnType($clientNamespace . '\\' . $sub->interfaceName());
            $accessor->addComment('The `' . $sub->rawTag . '` endpoints.');
            $accessor->setBody('return new ' . $sub->phpName . '(' . $args . ');');
        }

        $writes[$rootDir . DIRECTORY_SEPARATOR . 'ApiClient.php'] = $this->printer->printFile($file);
        $writes[$rootDir . DIRECTORY_SEPARATOR . 'ApiClientInterface.php'] = $this->subClients->printInterface(
            $clientNamespace,
            'ApiClientInterface',
            "The composition root's contract: one accessor per tag, plus whatever the document left untagged.\n\n"
                . 'A service should depend on the sub-client interface it actually needs rather than on this — that '
                . 'grain is the point of the split.',
            $class,
            $namespace,
        );

        return 2;
    }
}
