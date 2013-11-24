<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/21/13
 * Time: 11:27 AM
 * To change this template use File | Settings | File Templates.
 */
namespace Vendor\Error;

//if (true) {
//    ini_set('display_errors', 0);
//    set_exception_handler(array($this, 'handleException'));
//    set_error_handler(array($this, 'handleError'), error_reporting());
//}
class Handler
{
    private $debug;

    public function __construct($debug){
        $this->debug = $debug;
    }

    public static function renderException(\Exception $e, $file, $line){
        echo '<h1>Handled Mistake</h1>';
        echo '<pre>Message:' . $e->getMessage() . '</pre>';
        echo '<pre>Code:' . $e->getCode() . '</pre>';
        echo '<pre>File:' . $file . '</pre>';
        echo '<pre>Line:' . $line . '</pre>';
        echo '<pre>Trace' . nl2br($e->getTraceAsString()) . '</pre>';
    }
    public static function applicationLogException(\Exception $e){
        if(!syslog(LOG_ERR, 'My handled mistake ' . $e->getMessage()) || !error_log('My handled mistake ' . $e->getMessage())){
            throw new MyException('Log mistake');
        }
    }

    function handleError($code, $message, $file, $line){
//        echo '<br>' .  'hello from custom error handler' . '</br>';
//        echo print_r(func_get_args());
        if (error_reporting() !== 0) {
            $exception = new \Exception($message, $code);

            // in case error appeared in __toString method we can't throw any exception
            $trace = debug_backtrace(FALSE);
            array_shift($trace);
            foreach ($trace as $frame) {
                if ($frame['function'] == '__toString') {
                }
            }

            $this->handleException($exception, $file, $line);

            //throw new \Exception($message, $code);
        }
        die;
    }

//    function handleException($exception){
//        // disable error capturing to avoid recursive errors while handling exceptions
//        restore_error_handler();
//        restore_exception_handler();
//
//        try {
//            $this->logException($exception);
//
//            if (($handler = $this->getErrorHandler()) !== null) {
//                $handler->handle($exception);
//            } else {
//                $this->renderException($exception);
//            }
//
//            $this->end(1);
//
//        } catch (\Exception $e) {
//            // exception could be thrown in end() or ErrorHandler::handle()
//            $msg = (string)$e;
//            $msg .= "\nPrevious exception:\n";
//            $msg .= (string)$exception;
//            if (YII_DEBUG) {
//                echo $msg;
//            }
//            $msg .= "\n\$_SERVER = " . var_export($_SERVER, true);
//            error_log($msg);
//            exit(1);
//        }
//    }


    /**
     * @TODO
     * smth strange with $e, it returns line and file of error handler, not the error itself
     *
     * @param \Exception $e
     * @param            $file
     * @param            $line
     */
    function handleException(\Exception $e, $file, $line){
        //switch off errors handling @todo log into file
        if(!$this->debug){
            return;
        }

        restore_error_handler();
        restore_exception_handler();

        try{
            \Vendor\Error\Handler::applicationLogException($e);
            \Vendor\Error\Handler::renderException($e, $file, $line);
        }
        catch(\Exception $e){
            echo '<br>WTF, one more mistake<br><b>Message</b>:' . $e->getMessage();
        }
    }

    /**
     * Handles fatal PHP errors
     */
    public function handleFatalError()
    {
        $error = error_get_last();
        if (isset($error)){
            if (self::isFatalError($error)) {
                ob_end_clean();
                $exception = new \Exception($error['message']);
                // use error_log because it's too late to use Yii log
                error_log($exception);
                $this->handleException($exception);

                exit(1);
            }else{
                ob_end_flush();
            }
        }else{
            ob_end_flush();
        }
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
}

