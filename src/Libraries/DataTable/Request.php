<?php
namespace Btw\Core\Libraries\DataTable;

use \Config\Services;

class Request
{

	 /**
     * Get DataTable Request
     *  
     * @param  String $requestName
     * @return String|Array
     */


    public static function get($requestName = NULL)
    {
    	$request = Services::request();
        if($requestName !== NULL)
    	   return $request->getGetPost($requestName);
        
        return (Object) (($request->is('get')) ? $request->getGet() : $request->getPost());

    }


}