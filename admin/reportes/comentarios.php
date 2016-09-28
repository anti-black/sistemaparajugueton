<?php
require('../fpdf/fpdf.php');
require('../lib/pagina.php');
class PDF extends FPDF {
    public $info;
    function Armar($data){
        $this->info = $data;
    }
    function Header() {
        $nfo = $this->info;
        $this->SetFont('Times','B',15);
        $this->Cell(0,10,utf8_decode('Juguetón - Comentarios por producto.'),0,1,'C');
        $this->SetFont('Times','B',8);
        $this->Cell(0,10,utf8_decode('Total de comentarios del producto: '.$nfo),0,0,'C');
        $this->Ln(10);
    }
    function Footer() {
        $this->SetY(-15);
        $this->Cell(0,0,'',1,1,'B');
        $this->SetFont('Times','I',8);
        $this->Cell(0,10,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'R');
    }
}
$_POST = pagina::validarForm($_POST); $IDP = pagina::URLD64($_POST['prod']);

$predata = pagina::obtenerFila("SELECT * FROM productos WHERE md5(id_producto) = ?;", array($IDP));
$data = pagina::obtenerFilas(
    "SELECT nombre_cliente, apellido_cliente, correo_cliente, fecha_comentado, comentario FROM comentarios INNER JOIN clientes ON comentarios.id_cliente = clientes.id_cliente WHERE md5(id_producto) = ? ORDER BY fecha_comentado DESC;",
    array($IDP));
// if (empty($data))
//     header('Location: vacio.php');

$pdf = new PDF('P','mm', 'Letter');
$pdf->Armar($predata['nombre_producto']);
$pdf->SetMargins(20, 20, 20);
$pdf->SetFont('Times', 'B', 15);
$pdf->AliasNbPages();
$pdf->AddPage();



$prefecha = $data[0]['creacion_cliente'];
$escrito = false;
foreach ($data as $fila) {
    $pdf->SetFont('Times','B',12);
    $texto = textero('Nombres:');
    $pdf->Cell($texto[1],10,$texto[0],0,0);

    $pdf->SetFont('Times','',10);
    $texto = textero($fila['nombre_cliente']);
    $pdf->Cell($texto[1],10,$texto[0],0,0);

    $pdf->SetFont('Times','B',12);
    $texto = textero('Apellidos:');
    $pdf->Cell($texto[1],10,$texto[0],0,0);

    $pdf->SetFont('Times','',10);
    $texto = textero($fila['apellido_cliente']);
    $pdf->Cell($texto[1],10,$texto[0],0,0);

    $pdf->SetFont('Times','B',12);
    $texto = textero('Correo:');
    $pdf->Cell($texto[1],10,$texto[0],0,0);

    $pdf->SetFont('Times','',10);
    $texto = textero($fila['correo_cliente']);
    $pdf->Cell($texto[1],10,$texto[0],0,1);

    $pdf->Cell(20,10,'',0,0);
    $pdf->SetFont('Times','B',12);
    $texto = textero('Fecha:');
    $pdf->Cell($texto[1],10,$texto[0],0,0);

	$fe = date('j', strtotime($fila['fecha_comentado'])).' de '.mes(date('F', strtotime($fila['fecha_comentado']))).', '.date('Y', strtotime($fila['fecha_comentado']));
	$ho = date(' h:i A', strtotime($fila['fecha_comentado']));
    $pdf->SetFont('Times','',10);
    $texto = textero($fe.'.'.$ho);
    $pdf->Cell($texto[1],10,$texto[0],0,1);
    $pdf->Cell(20,10,'',0,0);

    $pdf->SetFont('Times','B',12);
    $texto = textero('Comentario:');
    $pdf->Cell($texto[1],10,$texto[0],0,0);

    $pdf->SetFont('Times','',10);
    $texto = textero($fila['comentario']);
    $pdf->Cell($texto[1],10,$texto[0],0,1);

    $pdf->SetDrawColor(175,175,175);
    $pdf->Cell(20,10,'',0,0);

    $pdf->Cell(0,0,'',1,1,'B');
}

$pdf->Output();

function textero($texto){
    global $pdf;
    return array(utf8_decode($texto), ($pdf->GetStringWidth($texto) + 4));
}
function mes($mes){
	switch ($mes) {
		case 'January': return 'Ene';
		case 'February': return 'Feb';
		case 'March': return 'Mar';
		case 'April': return 'Abr';
		case 'May': return 'May';
		case 'June': return 'Jun';
		case 'July': return 'Jul';
		case 'August': return 'Ago';
		case 'September': return 'Sep';
		case 'October': return 'Oct';
		case 'November': return 'Nov';
		case 'December': return 'Dic';
		default: return $mes;
	}
}
?>