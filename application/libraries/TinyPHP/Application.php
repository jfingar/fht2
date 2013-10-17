<?php
namespace Libraries\TinyPHP;
class Application
{
    public static $APP_ROOT_DIR = '../';
    public static $APPLICATION_DIR = '../application/';
    public static $WEB_ROOT_DIR = '../webroot/';
    public static $MODELS_DIR = '../application/models/';
    public static $CONTROLLER_DIR = '../application/controllers/';
    public static $VIEW_DIR = '../application/views/';
    public static $LIB_DIR = '../application/libraries/';
    public static $TINYPHP_DIR = '../application/libraries/TinyPHP/';
    public static $CONFIG_DIR = '../application/config/';
    public static $LOG_DIR = '../application/logs/';
    public static $HELPER_DIR = '../application/helpers/';

    public static $env;
    public static $config = array();

    public static function run($defaultEnvironment = 'production',$isCLI = false)
    {
        self::$env = getenv("ENV") ? getenv("ENV") : $defaultEnvironment;
        if(!$isCLI){
            self::initSession();
        }
        self::initPHPMailer();
        self::initAutoload();
        self::initConfig();
        if(!$isCLI){
            self::startRouting();
        }
    }
    
    private static function initSession()
    {
        if(session_id() == ''){
            session_start();
        }
    }
    
    private static function initPHPMailer()
    {
        $swiftMailerIncludeFilePath = self::$APP_ROOT_DIR . '../libraries/PHPMailer/class.phpmailer.php';
        if(file_exists($swiftMailerIncludeFilePath)){
            require_once $swiftMailerIncludeFilePath;
        }
    }
	
    public static function initAutoload()
    {
        spl_autoload_register(function($class){
            $class = str_replace("\\",DIRECTORY_SEPARATOR,$class);
            $pathToClassFile = Application::$APPLICATION_DIR . $class . '.php';
            if(strpos($pathToClassFile,'Libraries')){
                $pathToClassFile = str_replace('Libraries','libraries',$pathToClassFile);
            }
            if(strpos($pathToClassFile,'Models')){
                $pathToClassFile = str_replace('Models','models',$pathToClassFile);
            }
            if(strpos($pathToClassFile,'Helpers')){
                $pathToClassFile = str_replace('Helpers','helpers',$pathToClassFile);
            }
            if(strpos($pathToClassFile,'Mappers')){
                $pathToClassFile = str_replace('Mappers','mappers',$pathToClassFile);
            }
            if(strpos($pathToClassFile,'Controllers')){
                $pathToClassFile = str_replace('Controllers','controllers',$pathToClassFile);
            }
            if(file_exists($pathToClassFile)){
                include_once $pathToClassFile;
            }
        });
    }
	
    public static function initConfig()
    {
        self::buildConfig(self::$env);
        // timezone
        $tz = isset(self::$config['timezone']) ? self::$config['timezone'] : 'America/Phoenix';
        date_default_timezone_set($tz);

        // errors display
        $displayErrors = isset(self::$config['display_errors']) ? self::$config['display_errors'] : 0;
        ini_set('display_errors',$displayErrors);
    }
	
    private static function startRouting()
    {
        include self::$APPLICATION_DIR . 'Routes.php';
        $router = new Router($aRoutes);
        try{
            $router->dispatch($_SERVER['REQUEST_URI']);
        }catch(\Exception $e){
            echo $e->getMessage();
        }
    }
    
    private static function buildConfig($env)
    {
        $fullConf = parse_ini_file(self::$CONFIG_DIR . 'config.ini',true);
        $sections = array_keys($fullConf);
        foreach($sections as $section){
            if(strpos($section,':') !== false){
                $parentSection = substr(strstr($section,':'),1);
                $childSection = strstr($section,':',true);
                if($env == $childSection){
                    $key = $childSection . ':' . $parentSection;
                    array_push(self::$config,$fullConf[$key]);
                    self::buildConfig($parentSection);
                }
            }else{
                if($env == $section){
                    array_push(self::$config,$fullConf[$env]);
                    foreach(self::$config as $k => $confSection){
                        foreach($confSection as $param => $value){
                            if(!isset(self::$config[$param])){
                                self::$config[$param] = $value;
                            }
                        }
                        unset(self::$config[$k]);
                    }
                }
            }
        }
    }
}