<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/22/13
 * Time: 10:42 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Vendor\Application;

use \Vendor\Error as Error;
use \Vendor\NSP\NSP;
use \Vendor\Session;

class Application
{
    /**
     *
     */
    const DEBUG_MODE_ON = TRUE;

    /**
     *
     */
    const DEBUG_MODE_OFF = FALSE;

    /**
     *
     */
    const ERROR_CONTROL_MODE = TRUE;

    /**
     * @var
     */
    private $_session;

    /**
     * @var
     */
    private $_view;

    /**
     * @var \Vendor\View\View
     */
    public $view;


    //private static $_registry = new \Exception(); it's a pity :"(

    /**
     * @var \Vendor\Registry\Registry
     */
    public $registry;

    function __construct()
    {
//        echo '<br>' . __class__ . ' is initialized</br>';
        //load core components according to config

    }

    //should be done the other way
    function loadCoreRegistry()
    {
        $this->registry = \Vendor\Registry\Registry::getInstance();
        $config = include_once NSP_ROOT . '/inc/Vendor/config.php';

        foreach ($config as $rkey => $val) {
            switch ($rkey) {
                case 'db':
                    $dbclass = '\Vendor\Database\\' . ucfirst($val['type']);
                    $this->registry->set('db', new $dbclass($val['config']));
                    break;
                case 'session':
                    if ($val['type'] === 'user') {
                        $handlerclass = '\Vendor\Session\\' . ucfirst($val['handler']) . 'SessionHandler';
                        $handler = new $handlerclass();
                        //register session db adapter
                        $sessiondbclass = '\Vendor\Database\\' . ucfirst($val['handler']);
                        if(isset($dbclass) && ($dbclass == $sessiondbclass)){
                            $sessionDbAdapter = $this->registry->get('db');
                        }else{
                            $sessionDbAdapter = new $sessiondbclass($val);
                        }
                        $this->registry->set('db_session', $sessionDbAdapter);
                        //than init handler
                        $handler->init();
                        $this->registry->set('session', $handler);
                    }
                    break;
            }
        }
    }

    function run($debug)
    {
        NSP::$app = $this;

        $this->initErrorsControl($debug);
        $this->loadCoreRegistry();
//        $this->initSession();
        $this->initView();
        $this->initRouter();
    }

//    protected function initSession($handlerType = 'user')
//    {
//        $this->_session = new \Vendor\Session\SqliteSessionHandler();
//        $this->_session->init();
//    }

    protected function initRouter()
    {
        $this->_router = new \Vendor\Router\Router(
            NSP_ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'controller');
        $this->_router->init();
    }

    protected function initView()
    {
        $this->view = new \Vendor\View\View();
        $this->view->init();
        $this->registry->set('view', $this->view);
    }

    /**
     * @return \Vendor\Common\ISession
     */
    public function getSession()
    {
        return $this->_session;
    }

    protected function initErrorsControl($debug)
    {
        if(self::ERROR_CONTROL_MODE){
            $errorHandler = new \Vendor\Error\Handler($debug);
            set_error_handler(array($errorHandler, 'handleError'), error_reporting());
            set_exception_handler(array($errorHandler, 'handleException'));
            register_shutdown_function(array($errorHandler, 'handleFatalError'), 0, false);
        }
    }
}