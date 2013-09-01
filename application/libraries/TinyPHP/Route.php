<?php
namespace Libraries\TinyPHP;
class Route
{
	public $url;
	public $controller;
	public $func;
	
	public function __construct($url,$controller,$func = "index")
	{
		$this->url = $url;
		$this->controller = $controller;
		$this->func = $func;
	}
}