<?php

namespace Btw\Core\Adapters;

use CodeIgniter\HTTP\Response;

/**
 * Response class for BTW
 */
final class RawJsonResponse extends Response
{
    /**
     * @var array|object
     */
    private $rawData;

    public function __construct()
    {
        $config = config('App');

        parent::__construct($config);
    }

    /**
     * @param array|object $data
     *
     * @return $this
     */
    public function setData($data = []): self
    {
        $this->rawData = $data;
        $this->setBody(json_encode($data));

        return $this;
    }

    /**
     * @return array|object
     */
    public function getRawData()
    {
        return $this->rawData;
    }

    /**
     * @return $this
     */
    public function withJsonHeader()
    {
        $this->setHeader('Content-Type', 'application/json');
        // $this->setHeader('HX-Trigger', json_encode(['showMessage' => 'bonjour']));
        $this->setHeader("X-Requested-With", "XMLHttpRequest");
        return $this;
    }
}