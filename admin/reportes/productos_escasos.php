<?php
require('../fpdf/fpdf.php');
require('../lib/pagina.php');
class PDF extends FPDF {
    public $info;
    function Armar($data){
        $this->info = $data;
    }
    function Header() {
        $info = $this->info;
        $this->SetFont('Times','B',15);
        $this->Cell(0,10,utf8_decode('Juguetón - Clientes registrados por fecha.'),0,1,'C');
        $this->SetFont('Times','B',8);
        $this->Cell(0,10,
            utf8_decode('Se muetran los productos que poseen '.
            $info[1].' unidades'.($info[1] == 0 ? '' : ' o menos').
            '. '.($info[0] ? 'Se ignoran los productos ocultos.' : 'Se muestran todos los productos.')),0,0,'C');
        $this->Ln(20);
    }
    function Footer() {
        $this->SetY(-15);
        $this->Cell(0,0,'',1,1,'B');
        $this->SetFont('Times','I',8);
        $this->Cell(0,10,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'R');
    }
}
$_POST = pagina::validarForm($_GET);
$incluyente = $_POST['incluyente'] == '1' ? '1' : '0';
$cantidad = $_POST['cantidad'] <= 0 ? 0 : ($_POST['cantidad'] > 500 ? 500 : $_POST['cantidad']);
$consulta =
"SELECT codigo, nombre_producto, descripcion_producto, existencias_producto, estado FROM productos WHERE (existencias_producto = 0 OR existencias_producto < ?)".($incluyente ? ' AND estado = 1' : '').";";
$data = pagina::obtenerFilas($consulta, array($cantidad));
if (empty($data))
    header('Location: vacio.php');

$pdf = new PDF('P','mm', 'Letter');
$pdf->Armar(array($incluyente, $cantidad));
$pdf->SetMargins(20, 20, 20);
$pdf->SetFont('Times', 'B', 15);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetDrawColor(0);

$pdf->SetFont('Times','',12);
if (!$incluyente) {
    $pdf->Cell(30, 10, utf8_decode('Código'),       1, 0, 'C');
    $pdf->Cell(35, 10, utf8_decode('Nombre'),       1, 0, 'C');
    $pdf->Cell(76, 10, utf8_decode('Descripción'),  1, 0, 'C');
    $pdf->Cell(15, 10, utf8_decode('Total'),        1, 0, 'C');
    $pdf->Cell(20, 10, utf8_decode('Estado'),       1, 1, 'C');
} else {
    $pdf->Cell(30, 10, utf8_decode('Código'),       1, 0, 'C');
    $pdf->Cell(40, 10, utf8_decode('Nombre'),       1, 0, 'C');
    $pdf->Cell(91, 10, utf8_decode('Descripción'),  1, 0, 'C');
    $pdf->Cell(15, 10, utf8_decode('Total'),        1, 1, 'C');
}

$pdf->SetFont('Times','',10);
foreach ($data as $fila) {
    $codigo = $fila['codigo'];
    $nombre_producto = $fila['nombre_producto'];
    $descripcion_producto = $fila['descripcion_producto'];
    $existencias_producto = $fila['existencias_producto'];
    $estado = $fila['estado'] ? 'Visible' : 'Oculto';

    if (!$incluyente) {
        $pdf->Cell(30, 10, acomodar(30, utf8_decode($codigo)),                1, 0);
        $pdf->Cell(35, 10, acomodar(35, utf8_decode($nombre_producto)),       1, 0);
        $pdf->Cell(76, 10, acomodar(76, utf8_decode($descripcion_producto)),  1, 0);
        $pdf->Cell(15, 10, acomodar(15, utf8_decode($existencias_producto)),  1, 0);
        $pdf->Cell(20, 10, acomodar(20, utf8_decode($estado)),                1, 1, 'C');
    } else {
        $pdf->Cell(30, 10, acomodar(30, utf8_decode($codigo)),                1, 0);
        $pdf->Cell(40, 10, acomodar(40, utf8_decode($nombre_producto)),       1, 0);
        $pdf->Cell(91, 10, acomodar(91, utf8_decode($descripcion_producto)),  1, 0);
        $pdf->Cell(15, 10, acomodar(15, utf8_decode($existencias_producto)),  1, 1, 'C');
    }
}

function acomodar($tamaño, $texto){
    global $pdf;
    while ($pdf->GetStringWidth($texto) >= $tamaño - 1)
        $texto = mb_substr($texto, 0, -1);
    return $texto;
}

$pdf->Output();
?>