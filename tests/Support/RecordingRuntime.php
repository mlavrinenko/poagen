<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Support;

use Mlavrinenko\Paogen\Runtime\Contract\DescriptorParserInterface;
use Mlavrinenko\Paogen\Runtime\Contract\HydratorInterface;
use Mlavrinenko\Paogen\Runtime\Contract\MarshallerInterface;
use Mlavrinenko\Paogen\Runtime\Contract\PropertyDescriptor;
use Mlavrinenko\Paogen\Runtime\Contract\XmlWriterInterface;
use Mlavrinenko\Paogen\Runtime\Marshal\DescriptorParser;
use Mlavrinenko\Paogen\Runtime\Marshal\Hydrator;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Mlavrinenko\Paogen\Runtime\Marshal\XmlWriter;

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
final class RecordingRuntime implements DescriptorParserInterface, HydratorInterface, MarshallerInterface, XmlWriterInterface
{
    /** @var list<string> */
    public array $calls = [];

    private readonly Hydrator $hydrator;

    private readonly Marshaller $marshaller;

    private readonly XmlWriter $xmlWriter;

    private readonly DescriptorParser $descriptors;

    public function __construct()
    {
        $this->descriptors = new DescriptorParser();
        // The delegates read metadata through this object, so a descriptor
        // lookup made on the client's behalf is recorded too.
        $this->hydrator = new Hydrator($this);
        $this->marshaller = new Marshaller($this);
        $this->xmlWriter = new XmlWriter();
    }

    /**
     * @param class-string $class
     *
     * @return list<PropertyDescriptor>
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
     */
    public function renderList(array $items, string $rootElement, string $itemElement): string
    {
        $this->calls[] = 'renderList';

        return $this->xmlWriter->renderList($items, $rootElement, $itemElement);
    }
}
