<?php
$correo = $_POST['correo'];

require("../page1.1.php");
require_once '../mailer/PHPMailerAutoload.php';

function randomPassword()
{
	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++)
    {
    	$n = rand(0, $alphaLength);
    	$pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string

}
    $pass = randomPassword();
    $passHash = password_hash($pass, PASSWORD_DEFAULT);

    $sql="SELECT COUNT(id_cliente) FROM clientes WHERE correo_cliente=?";
    $params=array($correo);
    $dato=Database::getRow($sql,$params);
    $je=$dato[0];
    if($je>0)
    {
        $sql='update clientes set contra_cliente=? where correo_cliente=?';
        Database::executeRow($sql,array($passHash, $correo));
        $mail = new PHPMailer;
        $mail->CharSet = 'UTF-8';

        $mail->SMTPDebug = 0;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'jugueton1sv@gmail.com';                 // SMTP username
        $mail->Password = 'expojugueton2016';                           // SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    	);                         // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
        $mail->setFrom('jugueton@example.com', 'Jugueton El Salvador');
        $mail->addAddress($correo,'');     // Add a recipient
        $mail->Subject = 'Recuperar Clave';
        $mail->Body    = 'Tu nueva contraseña es '.$pass;
        $mail->AltBody = 'prueba';

        if($mail->send())
        {
            header("location:login.php");
        }
        else
        {
            echo"<script>alert('No se envio el correo vuelva a intentarlo');</script>";
        }
    }
    else
    {
        echo"<script>alert('No existe el correo en la base de datos');</script>";
    }
    ?>
