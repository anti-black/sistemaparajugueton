<?php
	include('../../lib/database.php');

	$año = $_POST['año']; //consulta y asignacion de valores
	//ecupera una fila de resultados como un array asociativo, un array numérico o como ambos
	$enero = Database::getRow("SELECT COUNT(id_cliente) AS r FROM clientes WHERE MONTH(creacion_cliente)=1 AND YEAR(creacion_cliente)=?",array($año));
	$febrero = Database::getRow("SELECT COUNT(id_cliente) AS r FROM clientes WHERE MONTH(creacion_cliente)=2 AND YEAR(creacion_cliente)=?",array($año));
	$marzo = Database::getRow("SELECT COUNT(id_cliente) AS r FROM clientes WHERE MONTH(creacion_cliente)=3 AND YEAR(creacion_cliente)=?",array($año));
	$abril = Database::getRow("SELECT COUNT(id_cliente) AS r FROM clientes WHERE MONTH(creacion_cliente)=4 AND YEAR(creacion_cliente)=?",array($año));
	$mayo = Database::getRow("SELECT COUNT(id_cliente) AS r FROM clientes WHERE MONTH(creacion_cliente)=5 AND YEAR(creacion_cliente)=?",array($año));
	$junio = Database::getRow("SELECT COUNT(id_cliente) AS r FROM clientes WHERE MONTH(creacion_cliente)=6 AND YEAR(creacion_cliente)=?",array($año));
	$julio = Database::getRow("SELECT COUNT(id_cliente) AS r FROM clientes WHERE MONTH(creacion_cliente)=7 AND YEAR(creacion_cliente)=?",array($año));
	$agosto = Database::getRow("SELECT COUNT(id_cliente) AS r FROM clientes WHERE MONTH(creacion_cliente)=8 AND YEAR(creacion_cliente)=?",array($año));
	$septiembre = Database::getRow("SELECT COUNT(id_cliente) AS r FROM clientes WHERE MONTH(creacion_cliente)=9 AND YEAR(creacion_cliente)=?",array($año));
	$octubre = Database::getRow("SELECT COUNT(id_cliente) AS r FROM clientes WHERE MONTH(creacion_cliente)=10 AND YEAR(creacion_cliente)=?",array($año));
	$noviembre = Database::getRow("SELECT COUNT(id_cliente) AS r FROM clientes WHERE MONTH(creacion_cliente)=11 AND YEAR(creacion_cliente)=?",array($año));
	$diciembre = Database::getRow("SELECT COUNT(id_cliente) AS r FROM clientes WHERE MONTH(creacion_cliente)=12 AND YEAR(creacion_cliente)=?",array($año));

	$data = array(0 => round($enero['r'],0), //asigno el monto redondeado a un solo decimal a cada mes
				  1 => round($febrero['r'],0),
				  2 => round($marzo['r'],0),
				  3 => round($abril['r'],0),
				  4 => round($mayo['r'],0),
				  5 => round($junio['r'],0),
				  6 => round($julio['r'],0),
				  7 => round($agosto['r'],0),
				  8 => round($septiembre['r'],0),
				  9 => round($octubre['r'],0),
				  10 => round($noviembre['r'],0),
				  11 => round($diciembre['r'],0)
				  );

	echo json_encode($data); //imprimo en json todo el arreglo
?>