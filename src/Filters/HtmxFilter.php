<?php

declare(strict_types=1);

namespace Btw\Core\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Btw\Core\Exceptions\notAuthorized;

/**
 * Session Authentication Filter.
 *
 * Email/Password-based authentication for web applications.
 */
class HtmxFilter implements FilterInterface
{

    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param array|null $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {

        // if ($request->isHtmx()) {
        //     echo 'fdgsdfgsdfg';
        //     exit;
        // }

        if ($request->isHtmx() && response()->getStatusCode() == '302') {

            echo 'Bouh';
            exit;
        }
    }

    /**
     * We don't have anything to do here.
     *
     * @param Response|ResponseInterface $response
     * @param array|null                 $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

        if ($request->isHtmx() && response()->getStatusCode() == '403') {

            $response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => $exception->getMessage() ]);
        }
    }
}
