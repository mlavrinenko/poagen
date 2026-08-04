<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Poagen\Runtime\Contract\TransportInterface;

/**
 * The constructor every emitted client shares — root and sub-client alike.
 *
 * Two kinds of argument and no more: one transport, and whatever credentials
 * the document declares. Everything the client used to restate — the message
 * factories, the base address, the hydration machinery — belongs to the
 * transport now, which is the point of
 * `operations-delegate-to-an-injected-transport`: twelve clients taking the
 * same seven parameters was the second clone family, and this is what
 * collapses it.
 *
 * The type-hint is the interface, never an implementation. Injecting a final
 * class is not substitution — the type would be the implementation — and the
 * transport is where most of the runtime's behaviour now lives, so that is
 * exactly the seam `caller-surface-is-injectable` has to hold at.
 *
 * Shared between the root and its sub-clients because that standard also
 * requires each sub-client to be constructible on its own. A sub-client that
 * needed the root object to exist would not be separately injectable, and the
 * grain would buy nothing.
 *
 * @internal
 */
final readonly class ClientConstructor
{
    /**
     * Add the constructor and put it back at the head of the class.
     *
     * Which credentials a client takes is only known once its operations have
     * been emitted — a scheme required solely by an operation that turned out
     * to be unrepresentable is not one this client needs — so the constructor
     * is built last and moved first, rather than guessed at before the class
     * has any methods. The emitted member order is unchanged: constructor,
     * then operations, then whatever the root adds after them.
     *
     * @param list<SecurityScheme> $schemes
     */
    public static function addFirst(ClassType $class, PhpNamespace $namespace, array $schemes): void
    {
        self::addTo($class, $namespace, $schemes);

        $methods = $class->getMethods();
        $constructor = $methods['__construct'];
        unset($methods['__construct']);

        $class->setMethods([$constructor, ...array_values($methods)]);
    }

    /**
     * @param list<SecurityScheme> $schemes
     */
    private static function addTo(ClassType $class, PhpNamespace $namespace, array $schemes): void
    {
        $namespace->addUse(TransportInterface::class);

        $ctor = $class->addMethod('__construct');
        $ctor->addPromotedParameter('transport')->setType(TransportInterface::class)->setPrivate();

        // Security-scheme args sit AFTER the transport so a schema that gains
        // a scheme does not reorder the existing signature. A scheme claims
        // one argument, except `http basic`, whose credential is genuinely
        // two values — a user and a password that meet as base64(user:pass)
        // and nowhere else.
        foreach ($schemes as $scheme) {
            foreach ($scheme->ctorArgs() as $arg) {
                $ctor->addPromotedParameter($arg)->setType('string')->setPrivate();
            }
        }
    }

    /**
     * The argument list one client passes to another when the root hands out a
     * sub-client, in the same order {@see addTo} declares.
     *
     * @param list<SecurityScheme> $schemes
     * @return list<string>
     */
    public static function forwardedArgs(array $schemes): array
    {
        $args = ['$this->transport'];

        foreach ($schemes as $scheme) {
            foreach ($scheme->ctorArgs() as $arg) {
                $args[] = '$this->' . $arg;
            }
        }

        return $args;
    }
}
