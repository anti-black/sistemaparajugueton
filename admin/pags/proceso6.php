<?php
	include('../../lib/database.php');

	$año = $_POST['año']; //consulta y asignacion de valores
	//ecupera una fila de resultados como un array asociativo, un array numérico o como ambos
	$enero = Database::getRow("SELECT COUNT(id_venta) AS r FROM ventas WHERE MONTH(fecha_venta)=1 AND YEAR(fecha_venta)=2016");
	$febrero = Database::getRow("SELECT COUNT(id_venta) AS r FROM ventas WHERE MONTH(fecha_venta)=2 AND YEAR(fecha_venta)=2016");
	$marzo = Database::getRow("SELECT COUNT(id_venta) AS r FROM ventas WHERE MONTH(fecha_venta)=3 AND YEAR(fecha_venta)=2016");
	$abril = Database::getRow("SELECT COUNT(id_venta) AS r FROM ventas WHERE MONTH(fecha_venta)=4 AND YEAR(fecha_venta)=?",array($año));
	$mayo = Database::getRow("SELECT COUNT(id_venta) AS r FROM ventas WHERE MONTH(fecha_venta)=5 AND YEAR(fecha_venta)=?",array($año));
	$junio = Database::getRow("SELECT COUNT(id_venta) AS r FROM ventas WHERE MONTH(fecha_venta)=6 AND YEAR(fecha_venta)=?",array($año));
	$julio = Database::getRow("SELECT COUNT(id_venta) AS r FROM ventas WHERE MONTH(fecha_venta)=7 AND YEAR(fecha_venta)=?",array($año));
	$agosto = Database::getRow("SELECT COUNT(id_venta) AS r FROM ventas WHERE MONTH(fecha_venta)=8 AND YEAR(fecha_venta)=?",array($año));
	$septiembre = Database::getRow("SELECT COUNT(id_venta) AS r FROM ventas WHERE MONTH(fecha_venta)=9 AND YEAR(fecha_venta)=?",array($año));
	$octubre = Database::getRow("SELECT COUNT(id_venta) AS r FROM ventas WHERE MONTH(fecha_venta)=10 AND YEAR(fecha_venta)=?",array($año));
	$noviembre = Database::getRow("SELECT COUNT(id_venta) AS r FROM ventas WHERE MONTH(fecha_venta)=11 AND YEAR(fecha_venta)=?",array($año));
	$diciembre = Database::getRow("SELECT COUNT(id_venta) AS r FROM ventas WHERE MONTH(fecha_venta)=12 AND YEAR(fecha_venta)=?",array($año));

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