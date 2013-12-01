<?php
/**
 * Created by PhpStorm.
 * User: KAN
 * Date: 22.11.13
 * Time: 2:26
 */

namespace Vendor\Comet;

/**
 * Describes Polling-server functionality
 */
interface CometInterface
{
    /**
     * Trigger events
     *
     * @param string $event
     *  event name
     * @param array $data
     *  event arguments
     */
    public function push($event, $data = null);

    /**
     * Listen events
     *
     * @param int $lastQueryTime
     *  for slow connection
     * @return array
     *  array of handlers results
     */
    public function listen($lastQueryTime = null);

    /**
     * Registration of events and handlers assignment
     *
     * @param string $event
     *  Event name
     * @param callback $callback
     *  event handler
     */
    public function registerEvent($event, $callback);
}