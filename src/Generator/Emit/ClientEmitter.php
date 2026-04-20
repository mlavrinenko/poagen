<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\PathItem;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Runtime\Marshal\Hydrator;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PsrPrinter;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Emits the `final readonly ApiClient` class.
 *
 * Produces one method per supported OpenAPI operation. ADR-010: response
 * hydration and request marshalling are delegated to the runtime
 * {@see Hydrator} / {@see Marshaller}, which the generated constructor
 * injects with sensible defaults.
 */
final readonly class ClientEmitter
{
    private PsrPrinter $printer;

    public function __construct(
        private OperationEmitter $operationEmitter,
    ) {
        $this->printer = new PsrPrinter();
    }

    public function emit(
        string $clientNamespace,
        string $className,
        OpenApi $openApi,
        Bindings $bindings,
    ): ?string {
        $operations = $this->collectOperations($openApi);

        if ($operations === []) {
            return null;
        }

        $securityCatalog = new SecuritySchemeCatalog($openApi);

        $clientNamespace = trim($clientNamespace, '\\');

        $file = new PhpFile();
        $file->setStrictTypes();

        $namespace = $file->addNamespace($clientNamespace);
        $namespace->addUse(ClientInterface::class);
        $namespace->addUse(RequestFactoryInterface::class);
        $namespace->addUse(StreamFactoryInterface::class);
        $namespace->addUse(Hydrator::class);
        $namespace->addUse(Marshaller::class);
        // Same-namespace use so the per-profile ApiException prints short.
        $namespace->addUse($clientNamespace . '\\ApiException');

        $class = $namespace->addClass($className)->setFinal()->setReadOnly();

        $ctor = $class->addMethod('__construct');
        $ctor->addPromotedParameter('httpClient')->setType(ClientInterface::class)->setPrivate();
        $ctor->addPromotedParameter('requestFactory')->setType(RequestFactoryInterface::class)->setPrivate();
        $ctor->addPromotedParameter('streamFactory')->setType(StreamFactoryInterface::class)->setPrivate();
        $ctor->addPromotedParameter('baseUri')->setType('string')->setPrivate();

        // Security scheme args sit AFTER the transport args so unchanged
        // schemas keep their existing constructor signature.
        foreach ($securityCatalog->constructorSchemes() as $scheme) {
            $ctor->addPromotedParameter($scheme->ctorArg)->setType('string')->setPrivate();
        }

        // Hydrator + Marshaller default to fresh instances; consumers can
        // pass their own to swap caches or override codecs (ADR-010).
        $ctor->addPromotedParameter('hydrator', new Literal('new Hydrator()'))
            ->setType(Hydrator::class)
            ->setPrivate();
        $ctor->addPromotedParameter('marshaller', new Literal('new Marshaller()'))
            ->setType(Marshaller::class)
            ->setPrivate();

        $emitted = 0;

        foreach ($operations as [$httpMethod, $pathUri, $operation, $pathItem]) {
            if ($this->operationEmitter->emit($class, $namespace, $httpMethod, $pathUri, $operation, $bindings, $pathItem, $securityCatalog)) {
                ++$emitted;
            }
        }

        return $emitted === 0 ? null : $this->printer->printFile($file);
    }

    /**
     * @return list<array{0:string,1:string,2:Operation,3:PathItem}>
     */
    private function collectOperations(OpenApi $openApi): array
    {
        $paths = $openApi->paths;

        if ($paths === null) {
            return [];
        }

        $items = [];

        foreach ($paths as $pathUri => $pathItem) {
            if (!\is_string($pathUri)) {
                continue;
            }
            if (!$pathItem instanceof PathItem) {
                continue;
            }
            $items[$pathUri] = $pathItem;
        }

        $uris = array_keys($items);
        sort($uris, \SORT_STRING);

        $out = [];

        foreach ($uris as $pathUri) {
            $pathItem = $items[$pathUri];

            foreach ($pathItem->getOperations() as $httpMethod => $operation) {
                $out[] = [(string) $httpMethod, $pathUri, $operation, $pathItem];
            }
        }

        return $out;
    }
}
