<?php 
namespace Btw\Core\Libraries\DataTable;

class Column{

	public $key;
	public $alias;
	public $type = 'column';
	public $callback;
	public $searchable = TRUE;
	public $orderable = TRUE;

}

