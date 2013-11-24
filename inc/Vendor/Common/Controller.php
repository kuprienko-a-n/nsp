<?php

namespace Vendor\Common;

abstract class Controller {

    /**
     * @all controllers must contain an index method
     */
    abstract function indexAction();

    /**
     * general init func-n, for mvc needs
     */
    public function init(){
        //implementation of init func-ty
    }
}

?>
