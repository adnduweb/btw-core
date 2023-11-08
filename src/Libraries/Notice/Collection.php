<?php

/**
 * This file is part of Doudou.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Libraries\Notice;

abstract class Collection
{
    /**
     * The id of the quote or invoice.
     *
     * @var int
     */
    protected $id;

    /**
    * The reference of the quote or invoice.
    *
    * @var int
    */
    protected $companyId;

    /**
     * The title of the quote or invoice.
     *
     * @var int
     */
    protected $userId;


    /**
     * The title of the quote or invoice.
     *
     * @var int
     */
    protected $typeId;

        /**
     * The title of the quote or invoice.
     *
     * @var int
     */
    protected $from;


        /**
     * The title of the quote or invoice.
     *
     * @var int
     */
    protected $to;

        /**
     * The title of the quote or invoice.
     *
     * @var int
     */
    protected $name;

        /**
     * The title of the quote or invoice.
     *
     * @var int
     */
    protected $description;


    /**
     * An array to store items.
     *
     * @var array
     */
    protected $items = [];



    /**
     * Initialize the calculated amount array.
     */
    public function __construct()
    {
       
    }

    /**
     * Sets the id.
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;
    }

    public function setFrom($from)
    {
        $this->from = $from;
    }

    public function setTo($to)
    {
        $this->to = $to;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getCompanyId()
    {
        return $this->companyId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getTypeId()
    {
        return $this->typeId;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

     /**
     * Call the calculation methods.
     */
    public function run()
    {
        
    }
}
