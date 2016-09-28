<?php
require("../page1.1.php");
	session_start();
	$query = "UPDATE clientes SET estado = ? Where id_cliente = ?";
    $param = array (0,$_SESSION['id_cliente']);
    Database::executeRow($query,$param);
	session_destroy();
	header("location: login.php");
?>