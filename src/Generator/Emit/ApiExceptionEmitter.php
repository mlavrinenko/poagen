<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Mlavrinenko\Paogen\Runtime\Contract\ApiErrorInterface;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PsrPrinter;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

/**
 * Emits the per-profile `Generated\ApiException` class.
 *
 * One class per generation run, sat alongside `ApiClient.php`. Thrown by every
 * emitted operation when the response status is outside the 2xx range. Carries
 * status, request, response, and a best-effort JSON-decoded body. Per ADR-009,
 * decode failures are swallowed (no `JSON_THROW_ON_ERROR`) and surface as
 * `null` from `getDecodedBody()`.
 */
final readonly class ApiExceptionEmitter
{
    private PsrPrinter $printer;

    public function __construct()
    {
        $this->printer = new PsrPrinter();
    }

    public function emit(string $clientNamespace): string
    {
        $clientNamespace = trim($clientNamespace, '\\');

        $file = new PhpFile();
        $file->setStrictTypes();

        $namespace = $file->addNamespace($clientNamespace);
        $namespace->addUse(ApiErrorInterface::class);
        $namespace->addUse(RequestInterface::class);
        $namespace->addUse(ResponseInterface::class);
        $namespace->addUse(RuntimeException::class);
        $namespace->addUseFunction('json_decode');
        $namespace->addUseFunction('json_last_error');
        $namespace->addUseConstant('JSON_ERROR_NONE');

        $class = $namespace->addClass('ApiException')
            ->setFinal()
            ->setExtends(RuntimeException::class)
            ->addImplement(ApiErrorInterface::class);

        $class->addComment('Thrown when the response status is outside the 2xx range.');
        $class->addComment('');
        $class->addComment('Carries the original PSR-7 request and response together with a');
        $class->addComment('best-effort JSON decode of the body. Decode failures are swallowed:');
        $class->addComment('`getDecodedBody()` returns `null` when the body is empty or not JSON.');
        $class->addComment('');
        $class->addComment('Named once where the transport is wired — `new HttpTransport($baseUri,');
        $class->addComment('ApiException::class)` — and thrown from there, so this stays the type');
        $class->addComment('a caller catches for this API while the sequence that raises it lives');
        $class->addComment('in the runtime.');

        $class->addProperty('decodedBody')
            ->setPrivate()
            ->setType('mixed')
            ->setValue(null);

        $class->addProperty('decoded')
            ->setPrivate()
            ->setType('bool')
            ->setValue(false);

        $ctor = $class->addMethod('__construct');
        $ctor->addPromotedParameter('statusCode')->setType('int')->setPrivate()->setReadOnly();
        $ctor->addPromotedParameter('request')->setType(RequestInterface::class)->setPrivate()->setReadOnly();
        $ctor->addPromotedParameter('response')->setType(ResponseInterface::class)->setPrivate()->setReadOnly();
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

        $decode = $class->addMethod('getDecodedBody')
            ->setPublic()
            ->setReturnType('mixed');
        $decode->addComment('Best-effort JSON decode of the response body.');
        $decode->addComment('');
        $decode->addComment('Returns `null` for an empty body or any decode failure (per ADR-009).');
        $decode->addComment('Cached on first call.');
        $decode->addBody(<<<'PHP'
            if ($this->decoded) {
                return $this->decodedBody;
            }

            $this->decoded = true;

            $body = (string) $this->response->getBody();

            if ($body === '') {
                return $this->decodedBody;
            }

            /** @var mixed $decoded */
            $decoded = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->decodedBody;
            }

            $this->decodedBody = $decoded;

            return $this->decodedBody;
            PHP);

        return $this->printer->printFile($file);
    }
}
