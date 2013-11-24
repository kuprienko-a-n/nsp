<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/21/13
 * Time: 10:56 AM
 * To change this template use File | Settings | File Templates.
 */
namespace Vendor\Session;

class SqliteSessionHandler extends \Vendor\Common\SessionHandler implements \Vendor\Common\ISession
{
    private $savePath = '/protected/sessions';
    private $lifeTime = 3600;
    protected $type = 'sqlite_sess';

    public function init(){
        parent::init();
    }

    public function getSavePath(){
        return $this->savePath;
    }

    public function setSavePath($path){
        return $this->savePath = $path;
    }

    function open($sessionName)
    {
        return TRUE;
    }

    function close()
    {
        return TRUE;
    }

    function read($sessionName)
    {
        return ServiceSqliteSessionData::getBySessionId($sessionName);
    }

    function write($sessionName, $data)
    {
        ServiceSqliteSessionData::saveSession(array(
                              'name' => $sessionName,
//                              'data' => serialize($data),
                              'data' => $data,
                              'time' => time() + $this->lifeTime,
                         ));

//        $fname = "$this->savePath/sess_{$sessionName}__{$time}";
//        return file_put_contents($fname, $data) === false ? false : true;
    }

    function destroy($sessionName)
    {
//        $file = "$this->savePath/sess_$sessionName";
//        if (file_exists($file)) {
//            unlink($file);
//        }
//        NSP::$app->registry->get('db')->
        return ServiceSqliteSessionData::removeBySessionId($sessionName);
    }

    function gc($maxlifetime)
    {
//        foreach (glob("$this->savePath/sess_*") as $file) {
//            if (filemtime($file) + $maxlifetime < time() && file_exists($file)) {
//                unlink($file);
//            }
//        }
        return ServiceSqliteSessionData::removeExpiredSession();
    }

    function setHandlers(){
        //var_dump(ini_get('session.save_handler')); - session.save_handler automatically set to "user" fater custom session handle initializing
        //here session.save_handler == 'files'
        session_set_save_handler(
            array($this, 'open'),
            array($this, 'close'),
            array($this, 'read'),
            array($this, 'write'),
            array($this, 'destroy'),
            array($this, 'gc')
        );
        //here session.save_handler == 'user'
    }
}

