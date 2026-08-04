<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PsrPrinter;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

/**
 * Emits the per-profile `Generated\ApiException` class.
 *
 * One class per generation run, sat alongside `ApiClient.php`. Per the owner
 * ruling behind `typed-error-responses`, a declared response is a return
 * value now — an envelope, never an exception — so this is thrown only for
 * the one case an envelope cannot honestly represent: a status the document
 * did not describe at all, or a declared body that failed to hydrate.
 * Carries status, request, response and the reason, in place of
 * `error-response-policy`'s best-effort decoded body — nothing here ever
 * hydrated, so there was never a typed body to hand back.
 */
final readonly class ApiExceptionEmitter
{
    private PsrPrinter $printer;

    public function __construct()
    {
        $this->printer = new PsrPrinter();
    }

    /**
     * Emit into a write set, or not at all.
     *
     * Only emits when `ApiClient` was emitted: the exception has no referent
     * without at least one operation that throws it. The rule lives here
     * rather than in the generator so it travels with the class it governs.
     *
     * @param array<string,string> $writes
     */
    public function emitInto(string $clientNamespace, string $rootDir, array &$writes): void
    {
        if (!isset($writes[$rootDir . DIRECTORY_SEPARATOR . 'ApiClient.php'])) {
            return;
        }

        $writes[$rootDir . DIRECTORY_SEPARATOR . 'ApiException.php'] = $this->emit($clientNamespace);
    }

    public function emit(string $clientNamespace): string
    {
        $clientNamespace = trim($clientNamespace, '\\');

        $file = new PhpFile();
        $file->setStrictTypes();

        $namespace = $file->addNamespace($clientNamespace);
        $namespace->addUse(\Poagen\Runtime\Contract\ApiErrorInterface::class);
        $namespace->addUse(RequestInterface::class);
        $namespace->addUse(ResponseInterface::class);
        $namespace->addUse(RuntimeException::class);

        $class = $namespace->addClass('ApiException')
            ->setFinal()
            ->setExtends(RuntimeException::class)
            ->addImplement(\Poagen\Runtime\Contract\ApiErrorInterface::class);

        $class->addComment('Thrown for the one case an envelope cannot honestly represent: a');
        $class->addComment('status the document declared no exact, range or `default` response for,');
        $class->addComment('or a declared body that failed to hydrate. Every other response —');
        $class->addComment('including one outside the 2xx range — is a return value now, not this.');
        $class->addComment('');
        $class->addComment('Named once where the transport is wired — `new HttpTransport($baseUri,');
        $class->addComment('ApiException::class)` — and thrown from there, so this stays the type');
        $class->addComment('a caller catches for this API while the sequence that raises it lives');
        $class->addComment('in the runtime.');

        $ctor = $class->addMethod('__construct');
        $ctor->addPromotedParameter('statusCode')->setType('int')->setPrivate()->setReadOnly();
        $ctor->addPromotedParameter('request')->setType(RequestInterface::class)->setPrivate()->setReadOnly();
        $ctor->addPromotedParameter('response')->setType(ResponseInterface::class)->setPrivate()->setReadOnly();
        $ctor->addPromotedParameter('reason')->setType('string')->setPrivate()->setReadOnly();
        $ctor->addParameter('message')->setType('string')->setDefaultValue('');
        $ctor->addBody('parent::__construct($message);');

        $class->addMethod('getStatusCode')
            ->setPublic()
            ->setReturnType('int')
            ->addBody('return $this->statusCode;');

        $class->addMethod('getRequest')
            ->setPublic()
            ->setReturnType(RequestInterface::class)
            ->addBody('return $this->request;');

        $class->addMethod('getResponse')
            ->setPublic()
            ->setReturnType(ResponseInterface::class)
            ->addBody('return $this->response;');

        $reason = $class->addMethod('getReason')
            ->setPublic()
            ->setReturnType('string');
        $reason->addComment('Why the transport raised: the status this exception carries either');
        $reason->addComment('matched nothing the document declared, or matched a declared response');
        $reason->addComment('whose body failed to hydrate.');
        $reason->addBody('return $this->reason;');

        return $this->printer->printFile($file);
    }
}
