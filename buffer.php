<?php
ob_start();
//ob_implicit_flush(TRUE);
echo 'before ob_start<br>';

//ob_start();
echo 'in obstar1t<br>';
echo 'in obstar2t<br>';
echo 'in obstar3t<br>';
//$tmp = ob_get_contents();
//ob_end_flush();
//$tmp = ob_get_clean();
//ob_end_clean();
echo 'after ob_end_flush<br>';

//var_dump($tmp);
//ob_get_clean();
