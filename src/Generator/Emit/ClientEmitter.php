<?php

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

        foreach ($operations as [$httpMethod, $pathUri, $operation, $pathItem]) {
            if ($this->operationEmitter->emit($class, $namespace, $httpMethod, $pathUri, $operation, $bindings, $pathItem)) {
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

    private function emitHydrator(\Nette\PhpGenerator\ClassType $class): void
    {
        $method = $class->addMethod('hydrate')
            ->setStatic()
            ->setPrivate()
            ->setReturnType('object');

        $method->addComment('Deserialise a JSON-decoded value into an instance of $class.');
        $method->addComment('');
        $method->addComment('Uses the Model\'s `PROPERTY_MAP` const (ADR-007) to translate');
        $method->addComment('wire keys into PHP property names and to recurse into nested');
        $method->addComment('models / list-of-model items.');
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

            /** @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}}> $map */
            $map = $class::PROPERTY_MAP;

            $args = [];

            foreach ($map as $phpName => [$wireKey, $shape]) {
                if (!\array_key_exists($wireKey, $data)) {
                    continue;
                }

                $value = $data[$wireKey];

                if ($shape === null) {
                    $args[$phpName] = $value;
                    continue;
                }

                if (\is_string($shape)) {
                    $args[$phpName] = \is_array($value) ? self::hydrate($shape, $value) : $value;
                    continue;
                }

                [$kind, $itemType] = $shape;

                if ($kind === 'scalar' && $itemType !== null) {
                    if ($value === null || $value instanceof $itemType) {
                        $args[$phpName] = $value;
                        continue;
                    }
                    $args[$phpName] = $itemType::fromScalar($value);
                    continue;
                }

                if ($kind === 'datetime' || $kind === 'date') {
                    if ($value === null || $value instanceof \DateTimeImmutable) {
                        $args[$phpName] = $value;
                        continue;
                    }
                    if (!\is_string($value)) {
                        throw new \RuntimeException(\sprintf(
                            'Expected string for %s::$%s, got %s.',
                            $class,
                            $phpName,
                            \get_debug_type($value),
                        ));
                    }
                    $args[$phpName] = new \DateTimeImmutable($value);
                    continue;
                }

                if ($kind === 'enum' && $itemType !== null) {
                    if ($value === null || $value instanceof $itemType) {
                        $args[$phpName] = $value;
                        continue;
                    }
                    $args[$phpName] = $itemType::from($value);
                    continue;
                }

                // ['list', null] or ['list', class-string].
                if (!\is_array($value)) {
                    $args[$phpName] = $value;
                    continue;
                }

                if ($itemType === null) {
                    $args[$phpName] = $value;
                    continue;
                }

                $args[$phpName] = \array_values(\array_map(
                    static fn(mixed $item): mixed => \is_array($item) ? self::hydrate($itemType, $item) : $item,
                    $value,
                ));
            }

            return new $class(...$args);
            PHP);
    }
}
