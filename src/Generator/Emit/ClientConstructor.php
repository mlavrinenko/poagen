<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Mlavrinenko\Paogen\Runtime\Marshal\Hydrator;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\PhpNamespace;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * The constructor every emitted client shares — root and sub-client alike.
 *
 * Shared because `caller-surface-is-injectable` requires each sub-client to be
 * constructible on its own, from the transport, the factories, the base address,
 * the declared credentials and the hydration collaborators. A sub-client that
 * needed the root object to exist would not be separately injectable, and the
 * grain would buy nothing.
 *
 * @internal
 */
final readonly class ClientConstructor
{
    /**
     * @param list<SecurityScheme> $schemes
     */
    public static function addTo(ClassType $class, PhpNamespace $namespace, array $schemes): void
    {
        $namespace->addUse(ClientInterface::class);
        $namespace->addUse(RequestFactoryInterface::class);
        $namespace->addUse(StreamFactoryInterface::class);
        $namespace->addUse(Hydrator::class);
        $namespace->addUse(Marshaller::class);

        $ctor = $class->addMethod('__construct');
        $ctor->addPromotedParameter('httpClient')->setType(ClientInterface::class)->setPrivate();
        $ctor->addPromotedParameter('requestFactory')->setType(RequestFactoryInterface::class)->setPrivate();
        $ctor->addPromotedParameter('streamFactory')->setType(StreamFactoryInterface::class)->setPrivate();
        $ctor->addPromotedParameter('baseUri')->setType('string')->setPrivate();

        // Security-scheme args sit AFTER the transport args so a schema that
        // gains a scheme does not reorder the existing signature.
        foreach ($schemes as $scheme) {
            $ctor->addPromotedParameter($scheme->ctorArg)->setType('string')->setPrivate();
        }

        // Hydrator + Marshaller default to fresh instances; consumers can pass
        // their own to swap caches or override codecs (ADR-010).
        $ctor->addPromotedParameter('hydrator', new Literal('new Hydrator()'))
            ->setType(Hydrator::class)
            ->setPrivate();
        $ctor->addPromotedParameter('marshaller', new Literal('new Marshaller()'))
            ->setType(Marshaller::class)
            ->setPrivate();
    }

    /**
     * The argument list one client passes to another when the root hands out a
     * sub-client, in the same order {@see addTo} declares.
     *
     * @param  list<SecurityScheme> $schemes
     * @return list<string>
     */
    public static function forwardedArgs(array $schemes): array
    {
        $args = ['$this->httpClient', '$this->requestFactory', '$this->streamFactory', '$this->baseUri'];

        foreach ($schemes as $scheme) {
            $args[] = '$this->' . $scheme->ctorArg;
        }

        $args[] = '$this->hydrator';
        $args[] = '$this->marshaller';

        return $args;
    }
}
