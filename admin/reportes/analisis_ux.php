<?php
require('../fpdf/fpdf.php');
require('../lib/pagina.php');

function validarArregloRecursivo($arrelo){
    if (!is_array($arrelo))
        return trim($arrelo);
    return array_map('validarArregloRecursivo', $arrelo);
}
function nombreSis($indice){
    switch ($indice) {
        case 1: return 'Windows 10';
        case 2: return 'Windows 8.1';
        case 3: return 'Windows 8';
        case 4: return 'Windows 7';
        case 5: return 'Windows Vista';
        case 6: return 'Windows Server';
        case 7: return 'Windows XP';
        case 8: return 'Mac OS';
        case 9: return 'Linux';
        case 10: return 'Ubuntu';
        case 11: return 'iPhone';
        case 12: return 'iPod';
        case 13: return 'iPad';
        case 14: return 'Android';
        case 15: return 'BlackBerry';
        case 16: return 'Mobile';
        default: return 'Desconocido';
    }
}
function nombreNav($indice){
    switch ($indice) {
        case 1: return 'InternetExplorer';
        case 2: return 'Firefox';
        case 3: return 'Safari';
        case 4: return 'Chrome';
        case 5: return 'Edge';
        case 6: return 'Opera';
        case 7: return 'Netscape';
        case 8: return 'Maxthon';
        case 9: return 'Konqueror';
        case 10: return 'Navegador Movil';
        case 11: return 'Desconocido';
    }
}
class PDF extends FPDF {
    public $fechas;
    function Armar($data){
        $this->fechas = $data;
    }
    function Header() {
        $fecha = $this->fechas;
        $this->SetFont('Times','B',15);
        $this->Cell(0,10,utf8_decode('Juguetón - Datos de UX.'),0,1,'C');
        $this->SetFont('Times','B',8);
        $this->Cell(0,10,utf8_decode('Basado en los inicios de sesión de todos los tiempos por parte de los clientes.'),0,0,'C');
        $this->Ln();
    }
    function Footer() {
        $this->SetY(-15);
        $this->Cell(0,0,'',1,1,'B');
        $this->SetFont('Times','I',8);
        $this->Cell(0,10,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'R');
    }
}
$_POST = validarArregloRecursivo($_POST);
$SO = $_POST['so']; $BW = $_POST['na'];

$consulta = "SELECT * FROM sesiones;";
$data = pagina::obtenerFilas($consulta);

$sistemas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$navegadores = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

$pdf = new PDF('P','mm', 'Letter');
$pdf->Armar(array($incluyente, $cantidad));
$pdf->SetMargins(20, 20, 20);
$pdf->SetFont('Times', 'B', 15);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetDrawColor(0);

foreach ($data as $fila) {
    $sis = $fila['sistema'];
    if (strpos($sis, 'Windows 10') != false || $sis == 'Windows 10') $sistemas[1] ++;
    elseif (strpos($sis, 'Windows 8.1') != false || $sis == 'Windows 8.1') $sistemas[2] ++;
    elseif (strpos($sis, 'Windows 8') != false || $sis == 'Windows 8') $sistemas[3] ++;
    elseif (strpos($sis, 'Windows 7') != false || $sis == 'Windows 7') $sistemas[4] ++;
    elseif (strpos($sis, 'Windows Vista') != false || $sis == 'Windows Vista') $sistemas[5] ++;
    elseif (strpos($sis, 'Windows Server') != false || $sis == 'Windows Server') $sistemas[6] ++;
    elseif (strpos($sis, 'Windows XP') != false || $sis == 'Windows XP') $sistemas[7] ++;
    elseif (strpos($sis, 'Mac OS') != false || $sis == 'Mac OS') $sistemas[8] ++;
    elseif (strpos($sis, 'Linux') != false || $sis == 'Linux') $sistemas[9] ++;
    elseif (strpos($sis, 'Ubuntu') != false || $sis == 'Ubuntu') $sistemas[10] ++;
    elseif (strpos($sis, 'iPhone') != false || $sis == 'iPhone') $sistemas[11] ++;
    elseif (strpos($sis, 'iPod') != false || $sis == 'iPod') $sistemas[12] ++;
    elseif (strpos($sis, 'iPad') != false || $sis == 'iPad') $sistemas[13] ++;
    elseif (strpos($sis, 'Android') != false || $sis == 'Android') $sistemas[14] ++;
    elseif (strpos($sis, 'BlackBerry') != false || $sis == 'BlackBerry') $sistemas[15] ++;
    elseif (strpos($sis, 'Mobile') != false || $sis == 'Mobile') $sistemas[16] ++;
    else $sistemas[17] ++;

    $na = $fila['navegador'];
    if (strpos($na, 'InternetExplorer') != false || $na == 'InternetExplorer') $navegadores[1] ++;
    elseif (strpos($na, 'Firefox') != false || $na == 'Firefox') $navegadores[2] ++;
    elseif (strpos($na, 'Safari') != false || $na == 'Safari') $navegadores[3] ++;
    elseif (strpos($na, 'Chrome') != false || $na == 'Chrome') $navegadores[4] ++;
    elseif (strpos($na, 'Edge') != false || $na == 'Edge') $navegadores[5] ++;
    elseif (strpos($na, 'Opera') != false || $na == 'Opera') $navegadores[6] ++;
    elseif (strpos($na, 'Netscape') != false || $na == 'Netscape') $navegadores[7] ++;
    elseif (strpos($na, 'Maxthon') != false || $na == 'Maxthon') $navegadores[8] ++;
    elseif (strpos($na, 'Konqueror') != false || $na == 'Konqueror') $navegadores[9] ++;
    elseif (strpos($na, 'HandheldBrowser') != false || $na == 'HandheldBrowser') $navegadores[10] ++;
    else $navegadores[11] ++;
}

$pdf->Cell(0, 10, utf8_decode('Totales de inicios de sesión por sistema operativo'), 0, 1, 'C');
$pdf->Cell(88, 10, 'Sistema Operativo', 1, 0, 'C');
$pdf->Cell(88, 10, 'Cantidad', 1, 1, 'C');
$pdf->SetFont('Times', '', 13);
if(empty($SO))
    foreach ($sistemas as $indice => $repeticiones) {
        if ($indice == 0) continue;
        $pdf->Cell(88, 10, nombreSis($indice), 1, 0, 'C');
        $pdf->Cell(88, 10, $repeticiones, 1, 1, 'C');
    }
else
    foreach ($SO as $interno)
        foreach ($sistemas as $indice => $repeticiones)
            if ($interno == $indice) {
                $pdf->Cell(88, 10, nombreSis($indice), 1, 0, 'C');
                $pdf->Cell(88, 10, $repeticiones, 1, 1, 'C');
                break;
            }
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 15);
$pdf->Cell(0, 10, utf8_decode('Totales de inicios de sesión por navegador'), 0, 1, 'C');
$pdf->Cell(88, 10, 'Navegador', 1, 0, 'C');
$pdf->Cell(88, 10, 'Cantidad', 1, 1, 'C');
$pdf->SetFont('Times', '', 13);
if(empty($BW))
    foreach ($navegadores as $indice => $repeticiones) {
        if ($indice == 0) continue;
        $pdf->Cell(88, 10, nombreNav($indice), 1, 0, 'C');
        $pdf->Cell(88, 10, $repeticiones, 1, 1, 'C');
    }
else
    foreach ($BW as $interno)
        foreach ($navegadores as $indice => $repeticiones)
            if ($interno == $indice) {
                $pdf->Cell(88, 10, nombreNav($indice), 1, 0, 'C');
                $pdf->Cell(88, 10, $repeticiones, 1, 1, 'C');
                break;
            }
$pdf->Output();

?>