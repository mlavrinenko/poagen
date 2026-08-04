<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Support;

/**
 * A consumer's own runtime: one object satisfying every marshalling contract
 * the transport depends on, recording each call before delegating.
 *
 * Written as a single class on purpose. It is the shape of the claim being
 * tested — that the contracts are separable from the implementations, so a
 * consumer can supply their own for all of them and hand the result to a
 * generated client without editing a generated file.
 *
 * Delegation keeps the doubles honest: the values that come back are the ones
 * the real implementations produce, so a test asserting on the wire is still
 * asserting on real behaviour.
 */
final class RecordingRuntime implements \Poagen\Runtime\Contract\DescriptorParserInterface, \Poagen\Runtime\Contract\HydratorInterface, \Poagen\Runtime\Contract\MarshallerInterface, \Poagen\Runtime\Contract\XmlWriterInterface
{
    /** @var list<string> */
    public array $calls = [];

    private readonly \Poagen\Runtime\Marshal\Hydrator $hydrator;

    private readonly \Poagen\Runtime\Marshal\Marshaller $marshaller;

    private readonly \Poagen\Runtime\Marshal\XmlWriter $xmlWriter;

    private readonly \Poagen\Runtime\Marshal\DescriptorParser $descriptors;

    public function __construct()
    {
        $this->descriptors = new \Poagen\Runtime\Marshal\DescriptorParser();
        // The delegates read metadata through this object, so a descriptor
        // lookup made on the client's behalf is recorded too.
        $this->hydrator = new \Poagen\Runtime\Marshal\Hydrator($this);
        $this->marshaller = new \Poagen\Runtime\Marshal\Marshaller($this);
        $this->xmlWriter = new \Poagen\Runtime\Marshal\XmlWriter();
    }

    /**
     * @param class-string $class
     *
     * @return list<\Poagen\Runtime\Contract\PropertyDescriptor>
     */
    public function descriptorsFor(string $class): array
    {
        $this->calls[] = 'descriptorsFor';

        return $this->descriptors->descriptorsFor($class);
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $class
     * @param array<mixed>    $data
     *
     * @return T
     */
    public function hydrate(string $class, array $data): object
    {
        $this->calls[] = 'hydrate';

        return $this->hydrator->hydrate($class, $data);
    }

    /**
     * @return array<string, mixed>
     */
    public function marshal(object $model): array
    {
        $this->calls[] = 'marshal';

        return $this->marshaller->marshal($model);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function renderObject(array $data, string $rootElement): string
    {
        $this->calls[] = 'renderObject';

        return $this->xmlWriter->renderObject($data, $rootElement);
    }

    /**
     * @param list<array<string, mixed>> $items
     * @param array<string,string>       $nestedContainers
     */
    public function renderList(array $items, string $rootElement, string $itemElement, array $nestedContainers = []): string
    {
        $this->calls[] = 'renderList';

        return $this->xmlWriter->renderList($items, $rootElement, $itemElement, $nestedContainers);
    }
}
