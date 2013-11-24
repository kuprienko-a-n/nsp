<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/24/13
 * Time: 12:23 PM
 * To change this template use File | Settings | File Templates.
 */
use \Vendor\NSP\NSP;

class IndexController extends \Vendor\Common\Controller {

    public function indexAction() {
        /*/*** set a template variable ***/

//        NSP::$app->registry->view->welcome = 'Welcome to NSP MVC';
//
//        /*** load the index template ***/
        NSP::$app->view->viewVar = 'variable value example';
        NSP::$app->registry->get('view')->show('index');
    }
}