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

class CometController extends Controller {

    public function init(){
        Comet\NspRealPlexer::$listenedAddr = 'http://rpl.nsp.dev/';
    }

    /**
     *
     */
    public function indexAction() {
        $file = NSP_ROOT . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'comet';
        $rowNumb = count(file($file));
        NSP::$app->view->initCursor = $rowNumb;
        NSP::$app->view->rplxJsUri = Comet\NspRealPlexer::getRealPlexorJsLibUri(TRUE);
        NSP::$app->registry->get('view')->show('index');
    }

    public function subscribeAction() {
        $poll = $realPlpoll = new Comet\NspRealPlexer(
            '192.168.137.11',
            '10010',
            'nsp'
        );
    }

    public function saveAction() {
        $userName = $_POST['user_name'];
        $userMsg = $_POST['user_msg'];
        $file = NSP_ROOT . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'comet';
        $rowNumb = count(file($file));
        $bytes = file_put_contents($file, ++$rowNumb . '. ' . $userName . ':' . $userMsg . PHP_EOL, FILE_APPEND);
        if($bytes){
            $poll = $realPlpoll = new Comet\NspRealPlexer(
                '192.168.137.11',
                '10010',
                'nsp'
            );
            $realPlpoll->getRealPlexor()->send(array("Alpha" => $rowNumb),
                array(
                     'user_name' => $userName,
                     'user_msg'  => $userMsg,
                     'row'       => $rowNumb,
                )
            );
            //$id1, $id2 - optional users ids
        }
    }
}

