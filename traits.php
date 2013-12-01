<?php
/**
 * Created by PhpStorm.
 * User: KAN
 * Date: 02.12.13
 * Time: 2:19
 */

trait A {
    public function smallTalk() {
        echo 'a';
    }
    public function bigTalk() {
        echo 'A';
    }
}

trait B {
    public function smallTalk() {
        echo 'b';
    }
    public function bigTalk() {
        echo 'B';
    }

    public function someModif() {
        echo 'someModif';
    }
}

class Talker {
    use A, B {
        B::smallTalk insteadof A;
        A::bigTalk insteadof B;
        someModif as protected newSomeModif;
    }
}

class Aliased_Talker {
    use A, B {
        B::smallTalk insteadof A;
        A::bigTalk insteadof B;
        B::bigTalk as talk;
    }
}

trait testTrait
{
    function tA(){
        echo 'From Trait : hello from ' . __METHOD__ . '<br>';
    }

    function tB(){
        echo 'From Trait : hello from ' . __METHOD__ . '<br>';
    }

    function traitRewrite(){
        echo 'From Trait : hello from ' . __METHOD__ . '<br>';
    }
}

class Base
{
    public function baseFunc(){
        echo 'From Class : hello from ' . __METHOD__ . '<br>';
    }

    public function traitRewrite(){
        echo 'From Class : hello from ' . __METHOD__ . '<br>';
    }
}



class Child extends Base
{
    use testTrait;
}

$child = new Child();
$child->tA();
$child->tB();
$child->traitRewrite();