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
class BlockIpFilter implements FilterInterface
{


    public $blockIps = ['whitelist-ip-1', 'whitelist-ip-2', '127.0.0.1', '::1'];

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
      
        if (!in_array($request->getIPAddress(), $this->blockIps)) {
            //throw new HttpException(403, "You are restricted to access the site.", null);
            // abort(403, "You are restricted to access the site.");
            // echo $request->getIPAddress(); exit;
            //return response()->setStatusCode(403, 'You are restricted to access the site.');
            //throw new \Exception('cool', 403);
            //throw new \Exception('Some message goes here');
            //throw new \Exception('You are restricted to access the site', 403); 
           // throw new class ('You are restricted to access the site', 403) extends \Exception implements \CodeIgniter\Exceptions\HTTPExceptionInterface {}; 
            throw notAuthorized::forSite();
            //return response()->setStatusCode(403, 'Nope. Not here.');
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
    }
}