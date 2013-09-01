<?php
namespace Libraries\TinyPHP;
use Controllers\ErrorController;
class Router
{

	private $aRoutes = array();

	public function __construct(array $aRoutes)
	{
		if(!empty($aRoutes))
		{
			$this->aRoutes = $aRoutes;
		}
	}

	public function dispatch($requestURI)
	{
		$aURIParts = parse_url($requestURI);
		$requestURI = $aURIParts['path'];
		if(substr($requestURI,-1) == '/')
		{
			$requestURI = substr($requestURI,0,-1);
		}
		if(substr($requestURI,0,1) == '/')
		{
			$requestURI = substr($requestURI,1);
		}
		if(!trim($requestURI))
		{
			$requestURI = 'index';
		}
		$routeFound = false;
		if(!empty($this->aRoutes))
		{
			foreach($this->aRoutes as $route)
			{
				if($route->url == $requestURI)
				{
					if(class_exists('controllers\\' . $route->controller))
					{
						try
						{
							$instance = 'controllers\\' . $route->controller;
							new $instance($route->func);
							$routeFound = true;
						}catch(\Exception $e){
							throw new \Exception($e->getMessage());
						}
					}else{
						throw new \Exception("Could not find Controller: " . $route->controller . ". Create a file called " . $route->controller . ".php in the application/controllers directory.");
					}
					break;
				}
			}
		}
		if(!$routeFound)
		{
			new ErrorController('errorPage');
		}
	}

}

?>