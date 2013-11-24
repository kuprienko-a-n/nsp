<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/22/13
 * Time: 5:54 AM
 * To change this template use File | Settings | File Templates.
 */
namespace Vendor\Error;

class MyException extends \Exception
{
    protected $severity;

    /**
     * Constructs the exception
     * @link http://php.net/manual/en/errorexception.construct.php
     * @param $message [optional]
     * @param $code [optional]
     * @param $severity [optional]
     * @param $filename [optional]
     * @param $lineno [optional]
     * @param $previous [optional]
     */
    public function __construct($message = '', $code = 0, $severity = 1, $filename = __FILE__, $lineno = __LINE__, \Exception $previous = null)
    {
        $message = __CLASS__  . ' : ' . $message;
        parent::__construct($message, $code, $previous);
        $this->severity = $severity;
        $this->file = $filename;
        $this->line = $lineno;
    }

    /**
     * Gets the exception severity
     * @link http://php.net/manual/en/errorexception.getseverity.php
     * @return int the severity level of the exception.
     */
    final public function getSeverity()
    {
        return $this->severity;
    }

    /**
     * Returns if error is one of fatal type
     *
     * @param array $error error got from error_get_last()
     * @return bool if error is one of fatal type
     */
    public static function isFatalError($error)
    {
        return isset($error['type']) && in_array($error['type'], array(E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING));
    }

    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        $names = array(
            E_ERROR => Yii::t('yii', 'Fatal Error'),
            E_PARSE => Yii::t('yii', 'Parse Error'),
            E_CORE_ERROR => Yii::t('yii', 'Core Error'),
            E_COMPILE_ERROR => Yii::t('yii', 'Compile Error'),
            E_USER_ERROR => Yii::t('yii', 'User Error'),
            E_WARNING => Yii::t('yii', 'Warning'),
            E_CORE_WARNING => Yii::t('yii', 'Core Warning'),
            E_COMPILE_WARNING => Yii::t('yii', 'Compile Warning'),
            E_USER_WARNING => Yii::t('yii', 'User Warning'),
            E_STRICT => Yii::t('yii', 'Strict'),
            E_NOTICE => Yii::t('yii', 'Notice'),
            E_RECOVERABLE_ERROR => Yii::t('yii', 'Recoverable Error'),
            E_DEPRECATED => Yii::t('yii', 'Deprecated'),
        );
        return isset($names[$this->getCode()]) ? $names[$this->getCode()] : Yii::t('yii', 'Error');
    }
}