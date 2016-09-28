<?php  require "lib/pagina.php";
$var = '0123456789abcdef';
$var = pagina::URLA64($var);
echo $var.PHP_EOL;
$var = pagina::URLD64($var);
echo $var;
 ?>