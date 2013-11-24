<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/24/13
 * Time: 12:23 PM
 * To change this template use File | Settings | File Templates.
 */
use \Vendor\NSP\NSP;

class ServiceController extends \Vendor\Common\Controller {

    public function indexAction() {
        /*/*** set a template variable ***/

//        NSP::$app->registry->view->welcome = 'Welcome to NSP MVC';
//
//        /*** load the index template ***/
        NSP::$app->view->viewVar = 'Post controller';
        NSP::$app->registry->get('view')->show('index');
    }

    public function jsonrpcserverAction(){
        $jsonrpcNspServer = new \Vendor\Service\NspJsonRpcServer(new \Vendor\Service\NspService());
        
        echo $jsonrpcNspServer->execute();
    }

    public function jsonrpcclientAction(){
        $jsonrpcNspClient = new \Vendor\Service\NspJsonRpcClient('http://192.168.137.11:8082/nsp/index.php?route=post/jsonrpcserver');

        var_dump($jsonrpcNspClient->test());
    }



    public function restserveerAction(){
        $server = new \Vendor\Service\NspJsonRpcClient('http://192.168.137.11:8082/nsp/index.php?route=post/jsonrpcserver');

        var_dump($jsonrpcNspClient->test());
    }

    public function restclientAction(){
        $jsonrpcNspClient = new \Vendor\Service\NspJsonRpcClient('http://192.168.137.11:8082/nsp/index.php?route=post/jsonrpcserver');

        var_dump($jsonrpcNspClient->test());
    }
}