<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/21/13
 * Time: 10:56 AM
 * To change this template use File | Settings | File Templates.
 */
namespace Vendor\Session;

class ApcSessionHandler extends \Vendor\Common\SessionHandler implements \Vendor\Common\ISession
{
    private $lifeTime = 3600;
    protected $type = 'apc_sess';

    public function init(){
        parent::init();
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
        return ServiceApcSessionData::getBySessionId($sessionName);
    }

    function write($sessionName, $data)
    {
        ServiceApcSessionData::saveSession(array(
                              'name' => $sessionName,
                              'data' => $data,
                         ));
    }

    function destroy($sessionName)
    {
        return ServiceApcSessionData::removeBySessionId($sessionName);
    }

    function gc($maxlifetime)
    {
        return ServiceApcSessionData::removeExpiredSession();
    }
}

