<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/24/13
 * Time: 12:23 PM
 * To change this template use File | Settings | File Templates.
 */
use \Vendor\NSP\NSP;
use \Vendor\Common\Controller;
use \Vendor\Comet;

class CometController extends Controller
{

    /**
     *
     */
    public function indexAction()
    {
        NSP::$app->registry->get('view')->show('index');
    }

    public function subscribeAction()
    {
        set_time_limit(0);
        $poll = new Comet\NativePolling();

        $cometAdapter = new Comet\CometAdapter($poll);

        $cometAdapter->registerEvent(
            'file_read',
            function ($data) {
                header('Content-type: application/json');
                list($userName, $userMsg, $rowNumb) = $data;
                $file = NSP_ROOT . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'comet';
                $rowNumb = count(file($file));
                $bytes = file_put_contents($file, ++$rowNumb . '. ' . $userName . ':' . $userMsg . PHP_EOL, FILE_APPEND);
                $response = $data + array('row' => $rowNumb);
                echo json_encode($response);
            }
        );

//        echo json_encode(ob_end_flush());
        $poll->listen();
    }

    public function saveAction()
    {
        $userName = $_POST['user_name'];
        $userMsg = $_POST['user_msg'];
        $poll = new Comet\NativePolling();
        $cometAdapter = new Comet\CometAdapter($poll);
        $cometAdapter->push(
            'file_read',
            array(
                 'user_name' => $userName,
                 'user_msg'  => $userMsg,
            )
        );
    }
}

