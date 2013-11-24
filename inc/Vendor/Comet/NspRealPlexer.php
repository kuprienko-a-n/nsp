<?php

namespace Vendor\Comet;

use \Vendor\Comet\CometInterface;

/**
 * include Dklab_Realplexor class
 */
include(dirname(__FILE__) . '/RealPlexor/api/php/Dklab/Realplexor.php');



/**
 * Dklab_Realplexor PHP API.
 *
 * @version 1.31
 */
class NspRealPlexer implements CometInterface
{
    /**
     * @var \Dklab_Realplexor object
     */
    private $realPlexor;

    /**
     * Listened address
     *
     * @deprecated
     * @var string
     */
    public static $listenedAddr;


    /**
     * @return \Dklab_Realplexor
     */
    public function getRealPlexor()
    {
        return $this->realPlexor;
    }

    /**
     * Get RealPlexor library path
     *
     * @return string
     */
    public static function getRealPlexorLibPath()
    {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'RealPlexor';
    }

    /**
     * Get RealPlexor js lib path
     *
     * @return string
     */
    public static function getRealPlexorJsLibPath()
    {
        return self::getRealPlexorLibPath() . DIRECTORY_SEPARATOR . 'dklab_realplexor.js';
    }

    /**
     * Get RealPlexor js lib uri
     *
     * @return string
     */
    public static function getRealPlexorJsLibUri($dynamic = TRUE, $absolute = FALSE)
    {
        $src = NULL;
        if ($dynamic){
            if(empty(self::$listenedAddr)){
                throw new \Exception('Set listened address');
            }
            $src =  self::$listenedAddr . '?identifier=SCRIPT';
        }else {
            $src =  $absolute ? $_SERVER['HTTP_HOST'] . '/' . self::getRealPlexorJsLibPath() : '/' . self::getRealPlexorJsLibPath();
        }

        return $src;
    }

    /**
     * Create new realplexor API instance.
     *
     * @param string $host        Host of IN line.
     * @param string $port        Port of IN line (if 443, SSL is used).
     * @param string $namespace   Namespace to use.
     * @param string $identifier  Use this "identifier" marker instead of the default one.
     */
    public function __construct($host, $port, $namespace = null, $identifier = "identifier")
    {
        $this->realPlexor = new \Dklab_Realplexor($host, $port, $namespace, $identifier);
    }

    /**
     * Trigger events
     *
     * @param string $event
     *  event name
     * @param array  $data
     *  event arguments
     */
    public function push($event, $data = null)
    {
        // TODO: Implement push() method.
    }

    /**
     * Listen events
     *
     * @param int $lastQueryTime
     *  for slow connection
     *
     * @return array
     *  array of handlers results
     */
    public function listen($lastQueryTime = null)
    {
        // TODO: Implement listen() method.
    }

    /**
     * Registration of events and handlers assignment
     *
     * @param string   $event    Имя события
     * @param callback $callback Функция-обработчик
     */
    public function registerEvent($event, $callback)
    {
        // TODO: Implement registerEvent() method.
    }
}
