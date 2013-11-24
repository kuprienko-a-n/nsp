<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/24/13
 * Time: 12:23 PM
 * To change this template use File | Settings | File Templates.
 */
use \Vendor\NSP\NSP;

class PostController extends \Vendor\Common\Controller {

    public function indexAction() {
        /*/*** set a template variable ***/

//        NSP::$app->registry->view->welcome = 'Welcome to NSP MVC';
//
//        /*** load the index template ***/
        NSP::$app->view->viewVar = 'Post controller';
        NSP::$app->registry->get('view')->show('index');
    }

    public function formAction(){
        NSP::$app->view->caption = 'Form to upload files';

        if(isset($_POST['mysubmit'])){
            if($_FILES){
                var_dump($_FILES);
                $path = NSP_ROOT . DIRECTORY_SEPARATOR . 'files/';
                $filename = 'new_' . $_FILES['myfile']['name'];
                $dest = $path . $filename;
                if(move_uploaded_file($_FILES['myfile']['tmp_name'], $dest)){
                    NSP::$app->view->result = 'File ' . $filename . ' has been uploaded successfully';
                }
            }
        }

        NSP::$app->registry->get('view')->show('form');

    }

    public function jsonrpcserverAction(){
        $jsonrpcNspServer = new \Vendor\Service\NspJsonRpcServer(new \Vendor\Service\NspService());
        
        echo $jsonrpcNspServer->execute();
    }

    public function jsonrpcclientAction(){
        $jsonrpcNspClient = new \Vendor\Service\NspJsonRpcClient('http://192.168.137.11:8082/nsp/index.php?route=post/jsonrpcserver');

        var_dump($jsonrpcNspClient->getUserAgentInfo());
    }
}