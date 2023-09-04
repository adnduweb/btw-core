<?php

namespace Btw\Core\Exceptions;

use CodeIgniter\Debug\BaseExceptionHandler;
use CodeIgniter\Debug\ExceptionHandlerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

class notFoundExceptionHandler extends BaseExceptionHandler implements ExceptionHandlerInterface
{
    // You can override the view path.
    protected ?string $viewPath = BTPATH . 'Views/Errors/html/';

    protected $code = 404;

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
        $allSegments = $request->getUri()->getSegments();
        if ($allSegments[0] == ADMIN_AREA){
            $this->render($exception, $statusCode, $this->viewPath . "error_admin_{$statusCode}.php");
        }else{
            $this->render($exception, $statusCode, $this->viewPath . "error_front_{$statusCode}.php");
        }

        
        exit($exitCode);
    }

}