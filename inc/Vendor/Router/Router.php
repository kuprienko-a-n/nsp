<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/24/13
 * Time: 11:57 AM
 * To change this template use File | Settings | File Templates.
 */
namespace Vendor\Router;

class Router implements \Vendor\Common\IHandler
{
    /**
     * @the controller path
     */
    private $path;

    private $args = array();

    public $controllerFile;

    public $controller;

    public $id;

    public $action;

    function __construct($path){
        $this->setPath($path);
    }

    public function init()
    {
        $this->loader();
    }

    /**
     *
     * @set controller directory path
     *
     * @param string $path
     *
     * @return void
     *
     */
    function setPath($path)
    {
        /*** check if path i sa directory ***/
        if (is_dir($path) == FALSE) {
            throw new \Vendor\Error\MyException('Invalid controller path: `' . $path . '`');
        }
        /*** set the path ***/
        $this->path = $path;
    }

    /**
     *
     * @load the controller
     *
     * @access public
     *
     * @return void
     *
     */
    public function loader()
    {
        /*** check the route ***/
        $this->getController();

        /*** if the file is not there diaf ***/
//        if (is_readable($this->file) == false)
//        {
//            echo $this->file;
//            throw new \Vendor\Error\MyException('404 Not Found');
//        }

        /*** include the controller ***/
        include_once $this->controllerFile;

        /*** a new controller class instance ***/
        $pathChunks = explode(DIRECTORY_SEPARATOR, $this->controllerFile);
        $class_name = end($pathChunks);
        $class = str_replace('.php', '', $class_name);
        $controller = new $class();

        /*** check if the action is callable ***/
        $action = ucfirst($this->action). 'Action';

        if (!is_callable(array($controller, $action)))
        {
            throw new \Vendor\Error\MyException('Incorrect action');
        }

        /*** run the action ***/
        $controller->init();
        $controller->$action($this->id);
    }

    /**
     *
     * @get the controller
     *
     * @access private
     *
     * @return void
     *
     */
    private function getController() {

        /*** get the route from the url ***/
        //e.g. - host?route=news/show
        $route = '';

        if(!empty($_GET['route'])){
            $route = $this->mapRoutesConfig($_GET['route']);
        }

        if (empty($route))
        {
            $route = 'index/index';
        }
        else
        {
            /*** get the parts of the route ***/
            $parts = explode('/', $route);

            $this->controller = $parts[0];
            if(isset($parts[1]))
            {
                $this->action = $parts[1];
            }

            if(isset($parts[2]))
            {
                $this->id = $parts[2];
            }
        }

        if (empty($this->controller))
        {
            $this->controller = 'index';
        }

        /*** Get action ***/
        if (empty($this->action))
        {
            $this->action = 'index';
        }

        /*** set the file path ***/
        $this->controllerFile = $this->path .'/'. ucfirst(strtolower($this->controller)) . 'Controller.php';
    }

    function  mapRoutesConfig($route){
        $routeConfig = array(
            'api/products' => 'rest/' . strtolower($_SERVER['REQUEST_METHOD']),
            'api/users' => 'rest',
        );

        foreach ($routeConfig as $customRoute => $controller) {
            if(substr_count($route, $customRoute)){
                return str_replace($customRoute, $controller, $route);
            }
        }

        return $route;
    }
}