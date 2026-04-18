<?php

/**
 * This file is part of mlavrinenko/paogen
 *
 * @copyright Copyright (c) Maxim Lavrinenko <maxim@lavrinenko.xyz>
 * @license https://opensource.org/license/mit/ MIT License
 */

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\PathItem;
use Mlavrinenko\Paogen\Generator\Bindings;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PsrPrinter;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Emits the `final readonly ApiClient` class.
 *
 * Produces one method per supported OpenAPI operation plus a private static
 * `hydrate()` helper that deserializes JSON into typed Models via
 * reflection. The constructor takes a PSR-18 HTTP client together with
 * PSR-17 request and stream factories, and a base URI.
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

        $clientNamespace = trim($clientNamespace, '\\');

        $file = new PhpFile();
        $file->setStrictTypes();

        $namespace = $file->addNamespace($clientNamespace);
        $namespace->addUse(ClientInterface::class);
        $namespace->addUse(RequestFactoryInterface::class);
        $namespace->addUse(StreamFactoryInterface::class);

        $class = $namespace->addClass($className)->setFinal()->setReadOnly();

        $ctor = $class->addMethod('__construct');
        $ctor->addPromotedParameter('httpClient')->setType(ClientInterface::class)->setPrivate();
        $ctor->addPromotedParameter('requestFactory')->setType(RequestFactoryInterface::class)->setPrivate();
        $ctor->addPromotedParameter('streamFactory')->setType(StreamFactoryInterface::class)->setPrivate();
        $ctor->addPromotedParameter('baseUri')->setType('string')->setPrivate();

        $emitted = 0;

        foreach ($operations as [$httpMethod, $pathUri, $operation]) {
            if ($this->operationEmitter->emit($class, $namespace, $httpMethod, $pathUri, $operation, $bindings)) {
                ++$emitted;
            }
        }

        if ($emitted === 0) {
            return null;
        }

        $this->emitHydrator($class);

        return $this->printer->printFile($file);
    }

    /**
     * @return list<array{0:string,1:string,2:Operation}>
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
            foreach ($items[$pathUri]->getOperations() as $httpMethod => $operation) {
                $out[] = [(string) $httpMethod, $pathUri, $operation];
            }
        }

        return $out;
    }

    private function emitHydrator(\Nette\PhpGenerator\ClassType $class): void
    {
        $method = $class->addMethod('hydrate')
            ->setStatic()
            ->setPrivate()
            ->setReturnType('object');

        $method->addComment('Deserialise a JSON-decoded value into an instance of $class.');
        $method->addComment('');
        $method->addComment('@template T of object');
        $method->addComment('@param class-string<T> $class');
        $method->addComment('@return T');

        $method->addParameter('class')->setType('string');
        $method->addParameter('data')->setType('mixed');

        $method->addBody(<<<'PHP'
            if (!\is_array($data)) {
                throw new \RuntimeException(\sprintf('Cannot hydrate %s from non-array data.', $class));
            }

            $reflection = new \ReflectionClass($class);
            $constructor = $reflection->getConstructor();

            if ($constructor === null) {
                /** @var T */
                return $reflection->newInstance();
            }

            $args = [];

            foreach ($constructor->getParameters() as $parameter) {
                $name = $parameter->getName();

                if (!\array_key_exists($name, $data)) {
                    if ($parameter->isDefaultValueAvailable()) {
                        $args[$name] = $parameter->getDefaultValue();
                    }
                    continue;
                }

                $value = $data[$name];
                $type = $parameter->getType();

                if ($type instanceof \ReflectionNamedType && !$type->isBuiltin() && \is_array($value)) {
                    /** @var class-string $child */
                    $child = $type->getName();
                    $value = self::hydrate($child, $value);
                }

                $args[$name] = $value;
            }

            /** @var T */
            return $reflection->newInstanceArgs($args);
            PHP);
    }
}
