<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Operation;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\InterfaceType;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;
use Poagen\Generator\Generator\Bindings;

use function sprintf;

/**
 * Emits one client class and the interface it implements.
 *
 * Used for both a tag's sub-client and the root, because the two differ only in
 * what else they carry: the root adds an accessor per tag. Sharing the machinery
 * is what keeps `caller-surface-is-injectable` true of every emitted surface
 * rather than only of the one that happened to be written first.
 *
 * The interface is not decoration. It is the seam a consumer's own convenience —
 * a retry, a paginated iterator, a method taking their domain object — meets the
 * generated code at, and the compiler is what checks the seam still holds after
 * a regeneration. Without it the only place to put any of that is inside a
 * generated file, which `never-edit-generated` forbids, so the feature would have
 * nowhere to live.
 *
 * @internal
 */
final readonly class SubClientEmitter
{
    private PsrPrinter $printer;

    public function __construct(
        private OperationEmitter $operationEmitter,
    ) {
        $this->printer = new PsrPrinter();
    }

    /**
     * A tag's sub-client, or null when nothing in the group could be emitted.
     *
     * @return array{source: string, interface: string, skipped: list<SkippedOperation>, operations: list<Operation>}
     */
    public function emit(
        string $clientNamespace,
        TagGroup $group,
        Bindings $bindings,
        SecuritySchemeCatalog $securityCatalog,
    ): array {
        [$file, $namespace, $class] = $this->openSubClass($clientNamespace, $group->phpName, $group->interfaceName());
        $outcome = $this->addOperations($class, $namespace, $group, $bindings, $securityCatalog);

        if ($outcome['emitted'] === 0) {
            return ['source' => '', 'interface' => '', 'skipped' => $outcome['skipped'], 'operations' => []];
        }

        ClientConstructor::addFirst($class, $namespace, $securityCatalog->constructorSchemesFor($outcome['operations']));

        return [
            'operations' => $outcome['operations'],
            'source' => $this->printer->printFile($file),
            'interface' => $this->printInterface(
                $clientNamespace,
                $group->interfaceName(),
                sprintf(
                    "The contract for the `%s` endpoints.\n\n"
                        . "Type-hint this rather than the class: hand-written convenience implements the same\n"
                        . "contract and delegates to the generated implementation, so a regeneration that changes\n"
                        . 'the surface fails to compile instead of silently breaking the seam.',
                    $group->rawTag,
                ),
                $class,
                $namespace,
            ),
            'skipped' => $outcome['skipped'],
        ];
    }

    /**
     * Start the ROOT client's file — everything {@see openSubClass} does,
     * plus the document-level security metadata {@see SecurityDocs} carries
     * across: the oauth2 / openIdConnect flow constants and the docblock
     * that reads them, and the `mutualTLS` line saying where the client
     * certificate is configured.
     *
     * The root is the only client that carries them, which is why this is a
     * separate entry point rather than a flag: the metadata is a fact about
     * the document rather than about a tag, and the root is the composition
     * root — where a consumer wires their transport, which is exactly when a
     * token endpoint is what they need. `ClientEmitter::emitRoot()` is the
     * one caller.
     *
     * @return array{0:PhpFile, 1:PhpNamespace, 2:ClassType}
     */
    public function openClass(
        string $clientNamespace,
        string $className,
        string $interfaceName,
        SecuritySchemeCatalog $securityCatalog,
    ): array {
        $opened = $this->openSubClass($clientNamespace, $className, $interfaceName);
        $comment = SecurityDocs::clientComment($securityCatalog);

        if ($comment !== '') {
            $opened[2]->addComment($comment);
        }

        SecurityDocs::addConstants($opened[2], $securityCatalog);

        return $opened;
    }

    /**
     * Start a client file: the class and its interface declaration. The
     * constructor comes later, from {@see ClientConstructor::addFirst}, once
     * the emitted operations say which credentials this client actually needs.
     *
     * @return array{0:PhpFile, 1:PhpNamespace, 2:ClassType}
     */
    private function openSubClass(string $clientNamespace, string $className, string $interfaceName): array
    {
        $clientNamespace = trim($clientNamespace, '\\');

        $file = new PhpFile();
        $file->setStrictTypes();
        $namespace = $file->addNamespace($clientNamespace);

        $class = $namespace->addClass($className)->setFinal()->setReadOnly();
        $class->addImplement($clientNamespace . '\\' . $interfaceName);

        return [$file, $namespace, $class];
    }

    /**
     * @return array{emitted: int, skipped: list<SkippedOperation>, operations: list<Operation>}
     */
    public function addOperations(
        ClassType $class,
        PhpNamespace $namespace,
        TagGroup $group,
        Bindings $bindings,
        SecuritySchemeCatalog $securityCatalog,
    ): array {
        $skipped = [];
        $emitted = 0;
        $operations = [];

        foreach ($group->operations as [$httpMethod, $pathUri, $operation, $pathItem]) {
            $outcome = $this->operationEmitter->emit(
                $class,
                $namespace,
                $httpMethod,
                $pathUri,
                $operation,
                $bindings,
                $pathItem,
                $securityCatalog,
            );

            if ($outcome->wasEmitted) {
                ++$emitted;
                // Only an operation that reached the class counts towards the
                // credentials the class asks for. One that turned out to be
                // unrepresentable sends nothing, so its scheme is not this
                // client's to demand.
                $operations[] = $operation;
                continue;
            }

            if ($outcome->skip instanceof SkippedOperation) {
                $skipped[] = $outcome->skip;
            }
        }

        return ['emitted' => $emitted, 'skipped' => $skipped, 'operations' => $operations];
    }

    /**
     * Mirror the class's public methods — signature, phpdoc and return type —
     * onto an interface. The constructor is left out: how an implementation
     * acquires its collaborators is its own business, not part of the contract a
     * decorator has to satisfy.
     */
    public function printInterface(
        string $clientNamespace,
        string $interfaceName,
        string $comment,
        ClassType $class,
        PhpNamespace $sourceNamespace,
    ): string {
        $clientNamespace = trim($clientNamespace, '\\');

        $file = new PhpFile();
        $file->setStrictTypes();
        $namespace = $file->addNamespace($clientNamespace);

        $interface = $namespace->addInterface($interfaceName);
        $interface->addComment($comment);
        $referenced = $this->mirrorMethods($class, $interface);

        // Carry only the imports the mirrored signatures actually use. Copying
        // the class file's whole list would drag in the constructor's transport
        // and hydration types, which the interface does not mention — and an
        // unused import is a style finding in the consumer's own project, which
        // is the tier `analysis-runs-at-maximum-strictness` admits nothing on.
        foreach ($sourceNamespace->getUses() as $alias => $fqn) {
            if (isset($referenced[$alias])) {
                $namespace->addUse($fqn, $alias);
            }
        }

        return $this->printer->printFile($file);
    }

    /**
     * @return array<string,true> the short type names the mirrored signatures mention
     */
    private function mirrorMethods(ClassType $class, InterfaceType $interface): array
    {
        $haystack = '';

        foreach ($class->getMethods() as $method) {
            if ($method->getName() === '__construct') {
                continue;
            }

            $signature = clone $method;
            $signature->setBody('');
            $interface->addMember($signature);

            $haystack .= ' ' . $signature->getReturnType() . ' ' . $signature->getComment();

            foreach ($signature->getParameters() as $parameter) {
                $haystack .= ' ' . $parameter->getType();
            }
        }

        $words = preg_split('/[^A-Za-z0-9_]+/', $haystack);
        $referenced = [];

        foreach ($words === false ? [] : $words as $word) {
            if ($word !== '') {
                $referenced[$word] = true;
            }
        }

        return $referenced;
    }
}
