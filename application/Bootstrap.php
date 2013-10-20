<?php
/*
* declare protected methods inside this class, and they will be called (in the order they are listed) before the controller logic is fired.
* The methods you declare may not have arguments.
* all methods that you create have access to $this->controller ... which is a reference to the controller object.
*/
use Libraries\TinyPHP\BootstrapBase;
class Bootstrap extends BootstrapBase
{
	protected function globalJavascripts()
    {
        $this->controller->addJavascript('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');
        $this->controller->addJavascript('https://www.google.com/jsapi');
        $this->controller->addJavascript('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js');
        $this->controller->addJavascript('/js/jquery.qtip.min.js');
        $this->controller->addJavascript('/js/global.min.js');
    }
    
    protected function globalStylesheets()
    {
        $this->controller->addStylesheet('http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,600,700,300');
        $this->controller->addStylesheet('/css/global.css');
        $this->controller->addStylesheet('/css/custom-theme/jquery-ui-1.10.3.custom.min.css');
        $this->controller->addStylesheet('/css/jquery.qtip.min.css');
    }
}