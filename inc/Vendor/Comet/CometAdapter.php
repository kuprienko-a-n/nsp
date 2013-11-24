<?php
/**
 * Created by PhpStorm.
 * User: KAN
 * Date: 22.11.13
 * Time: 3:11
 */

namespace Vendor\Comet;

use \Vendor\Comet\CometInterface;

/**
 * CometAdapter is an adapter to fit different comet implementation
 */
class CometAdapter implements CometInterface
{
    /**
     * @var CometInterface
     */
    protected $comet;

    /**
     * Wrap comet object
     *
     * @param CometInterface $comet
     */
    public function __construct(CometInterface $comet){
        $this->comet = $comet;
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
        $this->comet->push($event, $data);
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
        $this->comet->listen($lastQueryTime);
    }

    /**
     * Registration of events and handlers assignment
     *
     * @param string   $event
     * @param callback $callback
     */
    public function registerEvent($event, $callback)
    {
        $this->comet->registerEvent($event, $callback);
    }
}