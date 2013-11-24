<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/24/13
 * Time: 12:23 PM
 * To change this template use File | Settings | File Templates.
 */
use \Vendor\NSP\NSP;

class RestController extends \Vendor\Common\Controller {

    public function indexAction() {
        /*/*** set a template variable ***/

//        NSP::$app->registry->view->welcome = 'Welcome to NSP MVC';
//
//        /*** load the index template ***/
        NSP::$app->view->viewVar = 'Rest controller';
        NSP::$app->registry->get('view')->show('index');
    }

    public function getAction($id){
        $server = new \Vendor\Service\NspRestServer('products');

        $productService = new \Vendor\Service\NspService();
        $result = null;
        if(!empty($id)){
            $result = $productService->getProductById($id);
        }else{
            $result = $productService->getProducts();
        }
        if($result){
            $result = array('product' => $result);
        }

        $code = $result ? 200 : 204;

        $server->npsSendResponse($result, $code, \Vendor\Service\RestUtils::XML);
    }

    public function postAction(){
        //implement
    }

    public function putAction(){
        //implement
    }

    public function deleteAction($id){
        //implement
    }

}