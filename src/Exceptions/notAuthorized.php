<?php

namespace Btw\Core\Exceptions;

use Config\Services;
use CodeIgniter\Exceptions\ExceptionInterface;
use CodeIgniter\Exceptions\HTTPExceptionInterface;
use OutOfBoundsException;

class notAuthorized extends OutOfBoundsException implements ExceptionInterface, HTTPExceptionInterface
{
    protected $code = 403;

    public static function forSite()
    {
        return new self('You are restricted to access the site');
    }
}

