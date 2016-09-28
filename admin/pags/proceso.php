<?php
	include('../../lib/database.php');

	$año = $_POST['año']; //consulta y asignacion de valores
	//ecupera una fila de resultados como un array asociativo, un array numérico o como ambos
	$enero = Database::getRow("SELECT SUM(cantidad_a_pagar_total_final) AS r FROM ventas WHERE MONTH(fecha_venta)=1 AND YEAR(fecha_venta)=?",array($año));
	$febrero = Database::getRow("SELECT SUM(cantidad_a_pagar_total_final) AS r FROM ventas WHERE MONTH(fecha_venta)=2 AND YEAR(fecha_venta)=?",array($año));
	$marzo = Database::getRow("SELECT SUM(cantidad_a_pagar_total_final) AS r FROM ventas WHERE MONTH(fecha_venta)=3 AND YEAR(fecha_venta)=?",array($año));
	$abril = Database::getRow("SELECT SUM(cantidad_a_pagar_total_final) AS r FROM ventas WHERE MONTH(fecha_venta)=4 AND YEAR(fecha_venta)=?",array($año));
	$mayo = Database::getRow("SELECT SUM(cantidad_a_pagar_total_final) AS r FROM ventas WHERE MONTH(fecha_venta)=5 AND YEAR(fecha_venta)=?",array($año));
	$junio = Database::getRow("SELECT SUM(cantidad_a_pagar_total_final) AS r FROM ventas WHERE MONTH(fecha_venta)=6 AND YEAR(fecha_venta)=?",array($año));
	$julio = Database::getRow("SELECT SUM(cantidad_a_pagar_total_final) AS r FROM ventas WHERE MONTH(fecha_venta)=7 AND YEAR(fecha_venta)=?",array($año));
	$agosto = Database::getRow("SELECT SUM(cantidad_a_pagar_total_final) AS r FROM ventas WHERE MONTH(fecha_venta)=8 AND YEAR(fecha_venta)=?",array($año));
	$septiembre = Database::getRow("SELECT SUM(cantidad_a_pagar_total_final) AS r FROM ventas WHERE MONTH(fecha_venta)=9 AND YEAR(fecha_venta)=?",array($año));
	$octubre = Database::getRow("SELECT SUM(cantidad_a_pagar_total_final) AS r FROM ventas WHERE MONTH(fecha_venta)=10 AND YEAR(fecha_venta)=?",array($año));
	$noviembre = Database::getRow("SELECT SUM(cantidad_a_pagar_total_final) AS r FROM ventas WHERE MONTH(fecha_venta)=11 AND YEAR(fecha_venta)=?",array($año));
	$diciembre = Database::getRow("SELECT SUM(cantidad_a_pagar_total_final) AS r FROM ventas WHERE MONTH(fecha_venta)=12 AND YEAR(fecha_venta)=?",array($año));

	$data = array(0 => round($enero['r'],1), //asigno el monto redondeado a un solo decimal a cada mes
				  1 => round($febrero['r'],1),
				  2 => round($marzo['r'],1),
				  3 => round($abril['r'],1),
				  4 => round($mayo['r'],1),
				  5 => round($junio['r'],1),
				  6 => round($julio['r'],1),
				  7 => round($agosto['r'],1),
				  8 => round($septiembre['r'],1),
				  9 => round($octubre['r'],1),
				  10 => round($noviembre['r'],1),
				  11 => round($diciembre['r'],1)
				  );

	echo json_encode($data); //imprimo en json todo el arreglo
?>