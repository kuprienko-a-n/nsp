<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/22/13
 * Time: 5:56 AM
 * To change this template use File | Settings | File Templates.
 */
namespace Vendor\Error;

class Service{
    const SERVICE_ERROR_MY = 'my';
    const SERVICE_ERROR_CORE = 'core';
    const SERVICE_ERROR_MY_OTHER = 'my_other';

    public static function checkErrorWork($trigger = self::SERVICE_ERROR_MY){
        switch($trigger){
            case self::SERVICE_ERROR_MY:
                throw new MyException('trigger:' . $trigger);
                break;
            case self::SERVICE_ERROR_MY_OTHER:
                throw new MyExceptionOther('trigger:' . $trigger);
                break;
            case self::SERVICE_ERROR_CORE:
                throw new \Exception('trigger:' . $trigger);
                break;
            default:
                throw new \Exception('trigger:' . $trigger);
        }
    }
}