<?php
/**
 * Created by PhpStorm.
 * User: KAN
 * Date: 22.11.13
 * Time: 2:26
 */

namespace Vendor\Comet;

use \Vendor\Comet\CometInterface;
use Vendor\Error\MyException;

/**
 * Polling-server
 */
class NativePolling implements CometInterface
{
    /**
     * Default semaphore key
     */
    const SEM_KEY = 1;

    /**
     * Default max acquire argument for sem_get
     */
    const SEM_MAX_ACQUIRE_DEFAULT = 1;

    /**
     * Default semaphore permission
     */
    const SEM_PERM_DEFAULT = 0666;

    /**
     * Default semaphore auto release
     */
    const SEM_AUTO_RELEASE_DEFAULT = -1;

    /**
     * Execution period of event listening
     */
    const LISTEN_PERIOD_DEFAULT = 3600;

    /**
     * Event handlers
     *
     * @var array
     */
    protected $_handlers = array();

    /**
     * Events generation
     * @param string $event
     * @param array $data
     *  event arguments
     */
    public function push($event, $data = null)
    {
        //event semaphore
        $eventSemKey = sem_get(self::convertHashIntoNumber($event), self::SEM_MAX_ACQUIRE_DEFAULT, self::SEM_PERM_DEFAULT, self::SEM_AUTO_RELEASE_DEFAULT);
        if($eventSemKey === FALSE){
            throw new \Exception('Cant create semaphore');
            exit;
        }
        //set blocking
        sem_acquire($eventSemKey);

        /**
         * In the memory first 8 bytes contain data length, the data itself is kept as the serialized array
         * array('evant_name1' => event_time, ..., '_updated' => event_time)
         * where event_time - time of the latest event triggering
         * _updated - a special field, where the time of the latest event is keeping
         */
        $tmp = tempnam('/tmp', 'PHP');
        $shmid = shmop_open(ftok($tmp, 'e'), 'c', self::SEM_PERM_DEFAULT, 1024);
        if ($shmid) {
            $storageLength = (int) shmop_read($shmid, 0, 8);
            $storage = array();
            if ($storageLength) {
                $storage = unserialize(strval(shmop_read($shmid, 8, (int) $storageLength)));
            }
            $storage[$event] = array('time' => time(), 'data' => $data);
            $storage['_updated'] = time();
            $storageLength =  strlen(serialize($storage));
            shmop_write($shmid,  (int) $storageLength, 0);
            shmop_write($shmid, serialize($storage), 8);
            shmop_close($shmid);
        }
    }

    /**
     * @param int $lastQueryTime
     *  for slow connection
     * @return array
     *  array of handlers results
     */
    public function listen($lastQueryTime = null)
    {
        $lastQueryTime = ($lastQueryTime) ?: time();
        //$endTime = time() + (int) ini_get('max_execution_time') -1;
        $endTime = time() + self::LISTEN_PERIOD_DEFAULT;
        $tmp = tempnam('/tmp', 'PHP');
        $shmid = shmop_open(ftok($tmp, 'e'), "a", 0, 0);// @see http://cct.me.ntut.edu.tw/ccteducation/chchting/aiahtm/computer/phphelp/function.shmop-open.php.htm
        $result = array();
        if ($shmid) {
            while (time() < $endTime) {
                sleep(1);
                $storageLength = (int) shmop_read($shmid, 0, 8);
                $storage= unserialize(strval(shmop_read($shmid, 8, (int) $storageLength)));
                if ($storage['_updated'] > $lastQueryTime) {
                    unset($storage['_updated']);
                    asort($storage);
                    /**
                     * loop through memory storage
                     */
                    foreach ($storage as $event => $data) {
                        //если внести в поток вывода что-то то запрос будет каждый раз со стооны js, так как он думает что ответ пришел от lomg poll
                        if (substr($event, 0, 1) != '_' && $data['time'] > $lastQueryTime) {//проверка на то, что последнее вновь появившееся событие (запись в мемори) позже времени начала выполнения скрипта, то есть оно новое и его нужно исоплнять
                            $ret = $this->_runHandler($event, $data['data']);
                            if ($ret) {
                                $result[$event] = $ret;
                            }
                        }
                    }
                    // При возникновении события завершаем запрос и отправляем данные клиенту
                    break;
                }
            }
            shmop_close($shmid);
        }

        return $result;
    }

    /**
     * Event registration and handler assignment. Supports one handler per event.
     *
     * @param string $event Имя события
     * @param callback $callback Функция-обработчик
     */
    public function registerEvent($event, $callback)
    {
        $this->_handlers[$event] = $callback;
    }

    /**
     * Get numeric presentation of hashed string
     *
     * @param $string
     *
     * @return number
     */
    public static function convertHashIntoNumber($string){
        static $cache;

        if(!isset($cache[$string])){
            $cache[$string] = hexdec(md5($string));
        }

        return $cache[$string];
    }

    /**
     * Execute event handler of triggered event
     *
     * @param string $keyИмя
     * @param array $data
     * @return mixed
     */
    protected function _runHandler($key, $data = array())
    {
        if (!empty($this->_handlers[$key])) {
            $result = call_user_func_array($this->_handlers[$key], array($data));
            //release event semaphore
            $eventSemKey = sem_get(self::convertHashIntoNumber($key));
            sem_remove($eventSemKey);

            return $result;
        }
    }
}