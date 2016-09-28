<?php
require('../fpdf/fpdf.php');
require('../lib/pagina.php');
class PDF extends FPDF {
    public $fechas;
    function Armar($data){
        $this->fechas = $data;
    }
    function Header() {
        $fecha = $this->fechas;
        $this->SetFont('Times','B',15);
        $this->Cell(0,10,utf8_decode('Juguetón - Clientes registrados por fecha.'),0,1,'C');
        $this->SetFont('Times','B',8);
        $this->Cell(0,10,utf8_decode('Seleccionados desde '.(date('d/m/Y', strtotime($fecha[0]))).' hasta '.(date('d/m/Y', strtotime($fecha[1])))),0,0,'C');
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
$modo = $_POST['modo'] != '0' ? '1' : '0';
$valores = array(
    date('Y-m-d', mktime(0, 0, 0, 1, 1, date('Y'))),
    date('Y-m-d', mktime(0, 0, 0, 1, 0, date('Y') + 1))
);
if (strtotime(str_replace('/', '-', $_POST['inter0'])) != false)
    $valores[0] = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['inter0'])));
if (strtotime(str_replace('/', '-', $_POST['inter1'])) != false)
    $valores[1] = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['inter1'])));

if (strtotime($valores[0]) >= strtotime($valores[1])) {
    $inicio =  $valores[1];
    $fin = $valores[0];
} else {
    $inicio =  $valores[0];
    $fin = $valores[1];
}
$valores = array($inicio, $fin);

$consulta = "SELECT * FROM clientes WHERE creacion_cliente BETWEEN ? AND ? ORDER BY creacion_cliente ASC;";
$data = pagina::obtenerFilas($consulta, $valores);
if (empty($data))
    header('Location: vacio.php');

$pdf = new PDF('P','mm', 'Letter');
$pdf->Armar($valores);
$pdf->SetMargins(20, 20, 20);
$pdf->SetFont('Times', 'B', 15);
$pdf->AliasNbPages();
$pdf->AddPage();

$prefecha = $data[0]['creacion_cliente'];
$escrito = false;
$recuento = 0;
foreach ($data as $fila) {
    if ($prefecha != $fila['creacion_cliente']) {
        $prefecha = $fila['creacion_cliente'];
        $escrito = false;
        continue;
    }

    foreach ($data as $subfila) {
        if ($subfila['creacion_cliente'] == $prefecha) {
            if (!$escrito) {
                $texto = textero('Total: '.$recuento);
                if ($recuento != 0){
                    $pdf->Cell($texto[1]+10,10,$texto[0],0,1,'R');
                    $pdf->SetDrawColor(0);
                    $pdf->Cell(0,0,'','B',1);
                }
                $recuento = 0;
                $pdf->SetFont('Times','',12);
                $texto = textero(date('d/m/Y', strtotime($prefecha)));
                $pdf->Cell($texto[1],10,$texto[0],0,$modo);
                $pdf->SetFont('Times','',10);
                $escrito = true;
            } if ($modo) {
                $pdf->Cell(20,10,'',0,0);
                $pdf->SetFont('Times','B',12);
                $texto = textero('Nombres:');
                $pdf->Cell($texto[1],10,$texto[0],0,0);
                $pdf->SetFont('Times','',10);
                $texto = textero($subfila['nombre_cliente']);
                $pdf->Cell($texto[1],10,$texto[0],0,0);
                $pdf->SetFont('Times','B',12);
                $texto = textero('Apellidos:');
                $pdf->Cell($texto[1],10,$texto[0],0,0);
                $pdf->SetFont('Times','',10);
                $texto = textero($subfila['apellido_cliente']);
                $pdf->Cell($texto[1],10,$texto[0],0,0);
                $pdf->SetFont('Times','B',12);
                $texto = textero('Correo:');
                $pdf->Cell($texto[1],10,$texto[0],0,0);
                $pdf->SetFont('Times','',10);
                $texto = textero($subfila['correo_cliente']);
                $pdf->Cell($texto[1],10,$texto[0],0,1);
                $pdf->Cell(20,10,'',0,0);
                $pdf->SetFont('Times','B',12);
                $texto = textero('Fecha de nacimiento:');
                $pdf->Cell($texto[1],10,$texto[0],0,0);
                $pdf->SetFont('Times','',10);
                $texto = textero($subfila['fecha_nacimiento']);
                $pdf->Cell($texto[1],10,$texto[0],0,1);

                $pdf->SetDrawColor(175,175,175);
                $pdf->Cell(20,10,'',0,0);
                $pdf->Cell(0,0,'',1,1,'B');
            }
            $recuento++;
        }
    }

}
$f = textero('Total: '.$recuento);
$pdf->Cell($f[1]+10,10,$f[0],0,1,'R');
$recuento = 0;

$pdf->Output();

function textero($texto){
    global $pdf;
    return array(utf8_decode($texto), ($pdf->GetStringWidth($texto) + 4));
}
function ordenarF(){

}
?>