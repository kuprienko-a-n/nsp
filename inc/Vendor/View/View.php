<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/24/13
 * Time: 12:30 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Vendor\View;

class View  implements \Vendor\Common\IHandler
{

    public function init()
    {
        // TODO: Implement init() method.
    }

    /*
     * @the registry
     * @access private
     */
    private $registry;

    /*
     * @Variables array
     * @access private
     */
    private $vars = array();

    /**
     *
     * @constructor
     *
     * @access public
     *
     * @return void
     *
     */
    function __construct() {

    }


    /**
     *
     * @set undefined vars
     *
     * @param string $index
     *
     * @param mixed $value
     *
     * @return void
     *
     */
    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }


    function show($name) {
        $path = NSP_ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . $name . '.phtml';

        if (file_exists($path) == FALSE)
        {
//            throw new \Exception('Template not found in '. $path);
            throw new \Vendor\Error\MyException('Template not found in '. $path);
        }

        // Load variables
        foreach ($this->vars as $key => $value)
        {
            $$key = $value;
        }
        include_once ($path);
    }


}
