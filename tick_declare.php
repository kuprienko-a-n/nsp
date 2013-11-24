<?php
//function my_callback_function() {
//  echo "I was called from a tick!<br ?-->";
//}
//
//declare(ticks = 1);
//register_tick_function("my_callback_function");
//
//$x = 10;

function my_callback_function() {
    echo "I was called from a tick!<br ?-->";
}

declare(ticks = 1);
register_tick_function("my_callback_function");
//function my_callback_function() {
//    echo "I was called from a tick!<br ?-->";
//}
//
//declare(ticks = 1);
//register_tick_function("my_callback_function");

?>