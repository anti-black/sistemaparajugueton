<?php
require('../fpdf/fpdf.php');
require('../lib/pagina.php');
class PDF extends FPDF {
    function Header() {
        // $this->SetFont('Times','B',15);
        // $this->Cell(80);
        // $this->Cell(30,10,utf8_decode('Juguetón - Clientes registrados por fecha'),0,0,'C');
        // $this->Ln(20);
    }
    function Footer() {
        // $this->SetY(-15);
        // $this->SetFont('Times','I',8);
        // $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}
//PRIMERO SE LE POENE  LOS ARCHIVOS QUE NECESITA, LOS QUE SON NECESARIO (LIBRERIA DE FPDF y LA CONEXION A LA BASE DE DATOS)

//Despues crear el documento,
    //(orientation, unit, size)
        //orientacion:
            //'P' es portrait (vertical)
            //'L' es landscape (horizontal)
        //inidades
            //'mm' Milimetros
            //'cm' centímetros
        //tamaño: (Hay varios)
            //'Letter' es el papel corriente de carta usaré ese
$pdf = new FPDF('P','mm', 'Letter');
//margenes (opcional)
    //por defecto son de 10, 10, 10 milímetros, peroo si querés más solo se los pones con esta funcion, justo despues de crearlo

// (float left, float top [, float right]); [Por defecto el de la derecha es igual que el de la izquierda]
$pdf->SetMargins(20, 20, 20);
//tipo de fuente (OBLIGATORIO)
$pdf->SetFont(
    'Times', //tipo
    'B', //estilo (negrita, kursiva, subrayada, y una mezcla entre ellas)
    15 //y tamaño de letra
);
//onda misteriosa para sacar números de página (opcinal)
$pdf->AliasNbPages();
//Creas la primera página en blanco y comenzas >:)
$pdf->AddPage();


// -------PARA SAMPAR TEXTO---------
// Si quieres más celdas solo crealas
// solo el primer volado es obligatorio lo demás es opcional
//Cell(ancho, alto, texto, (si lleva borde o no), (como termina la línea) , (Aliniación), (si lleva color de relleno), (cosa misteriosa para enlaces))
$pdf->Cell(
    50, //Ancho, si lo dejás en 0 tomará todo el tamaño
    10, //Alto
    utf8_decode('MINECRAFT'), //Texto
    0, //Borde
    2); //como termina (dice si al terminar la celda esta hace que las demas se pasen hacia abajo o si continúan a la derecha)

$pdf->Cell(
    50, //Ancho, si lo dejás en 0 tomará todo el tamaño
    10, //Alto
    utf8_decode('MINECRAFT'), //Texto
    0, //Borde
    2); //como termina (dice si al terminar la celda esta hace que las demas se pasen hacia abajo o si continúan a la derecha)

$pdf->Cell(
    50, //Ancho, si lo dejás en 0 tomará todo el tamaño
    10, //Alto
    utf8_decode('MINECRAFT'), //Texto
    0, //Borde
    2); //como termina (dice si al terminar la celda esta hace que las demas se pasen hacia abajo o si continúan a la derecha)

$pdf->Cell(
    50, //Ancho, si lo dejás en 0 tomará todo el tamaño
    10, //Alto
    utf8_decode('MINECRAFT'), //Texto
    0, //Borde
    2); //como termina (dice si al terminar la celda esta hace que las demas se pasen hacia abajo o si continúan a la derecha)

$pdf->Cell(
    50, //Ancho, si lo dejás en 0 tomará todo el tamaño
    10, //Alto
    utf8_decode('MINECRAFT'), //Texto
    0, //Borde
    2); //como termina (dice si al terminar la celda esta hace que las demas se pasen hacia abajo o si continúan a la derecha)

//SI TUBIERAS QUE ESTAR UNA AL LADO DE LA OTRA SOLO HAY QUE CAMBIAR DOS COSAS
$pdf->Cell( 30, 10, utf8_decode('MINECRAFT'), 0, 0);
//SE CAMBIA: El ANCHO y la forma de como termina
    //Se pone un ancho mas pequeño, y el numero de como temina se pasa a 0
$pdf->Cell( 30, 10, utf8_decode('MINECRAFT'), 0, 0);
$pdf->Cell( 30, 10, utf8_decode('MINECRAFT'), 0, 0);
$pdf->Cell( 30, 10, utf8_decode('MINECRAFT'), 0, 0);
$pdf->Cell( 30, 10, utf8_decode('MINECRAFT'), 0, 0);
$pdf->Cell( 30, 10, utf8_decode('MINECRAFT'), 0, 0);

$pdf->Ln(); //ésto ahce que se separe una linea
// SE TIENE QUE HACER MÁS ESTRECHA LA FILA


//SE PUEDE SACAR TAMAÑO DEL TEXTO.
$texto = 'MINECRAFT';
$largoDelTexto = $pdf->GetStringWidth($texto);
$pdf->Cell($largoDelTexto + 4, 0, $texto, 0, 0);
$pdf->Cell($largoDelTexto + 4, 0, $texto, 0, 0);
$pdf->Cell($largoDelTexto + 4, 0, $texto, 0, 0);
$pdf->Cell($largoDelTexto + 4, 0, $texto, 0, 0);
$pdf->Cell($largoDelTexto + 4, 0, $texto, 0, 0);
$pdf->Cell($largoDelTexto + 4, 0, $texto, 0, 0);
$pdf->Cell($largoDelTexto + 4, 0, $texto, 0, 0);

$pdf->Output();



// $pdf->SetFont('Times','',12);
// $datos = pagina::obtenerFilas('SELECT * FROM clientes;');
// foreach ($datos as $dato) {
//     $nombre = $dato['correo_cliente'];
//     $pdf->Cell(50, 10, utf8_decode($nombre), 0, 2);
// }
// // for($i=1;$i<=40;$i++)
//     // $pdf->Cell(0,10,'Imprimiendo línea número '.$i,0,1);

?>