<?php

namespace Btw\Core\Exceptions;

use Btw\Core\Debug\BaseExceptionHandler;
use Btw\Core\Debug\ExceptionHandlerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

class notAuthorizedExceptionHandler extends BaseExceptionHandler implements ExceptionHandlerInterface
{
    // You can override the view path.
    protected ?string $viewPath = BTPATH . 'Views/Errors/html/';

    protected $code = 403;

    public function handle(
        Throwable $exception,
        RequestInterface $request,
        ResponseInterface $response,
        int $statusCode,
        int $exitCode
    ): void {

        $response->setStatusCode($statusCode, $exception->getMessage());
        if (! headers_sent()) {
            header(
                sprintf(
                    'HTTP/%s %s %s',
                    $request->getProtocolVersion(),
                    $response->getStatusCode(),
                    $exception->getMessage()
                ),
                true,
                $statusCode
            );
        }

        $this->render($exception, $statusCode, $this->viewPath . "error_{$statusCode}.php");
        exit($exitCode);
    }

}