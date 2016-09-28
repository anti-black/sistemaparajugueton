<script src="js/4capcha.js"></script>
<?php

//Obtenemos la fecha y hora del sistema
ini_set("date.timezone","America/El_Salvador");
//Declaramos el enlace para la base de datos
require("../page1.php");
//Ingresamos el encabezado de nuestra pagina
if(!empty($_POST))
{
    $_POST = Validator::validateForm($_POST);
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['dirección'];
    $telefono = $_POST['telefono'];
   // $telefono2=$telefono2.(string)7;
    $correo = $_POST['correo'];
    $fecha = $_POST['fecha'];
    try
    {
        if($nombre != "" && $apellido != "")
        {
            $contracliente = $_POST['contracliente'];
            $contracliente2 = $_POST['contracliente2'];
            if(Page::calculaedad($fecha))
            {
                if($correo != "" && $contracliente != "" && $contracliente2 != "")
                {
                    if($correo != $contracliente)
                    {
                        $secret = "6LdiQSgTAAAAAC7Bg3LpcEqElcQGs8yK1ODPLQsy";
                        $ip = $_SERVER["REMOTE_ADDR"];
                        $captcha = $_POST["g-recaptcha-response"];

                        $result = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
                        //var_dump($result);
                        $array = json_decode($result , TRUE);
                        if ($array["success"])
                        {
                            if(strlen($contracliente)>=8)
                            {
                            if($contracliente == $contracliente2)
                            {
                                if(preg_match('/([a-z]+[0-9]+)|([0-9]+[a-z]+)/i', $contracliente))
                                {
                                    $sql = "INSERT INTO clientes(contra_cliente, nombre_cliente, apellido_cliente, correo_cliente, fecha_nacimiento, telefono_movil, direccion_primaria, creacion_cliente) VALUES(?,?,?,?,?,?,?,CURRENT_TIMESTAMP);";
                                    $clave = password_hash($contracliente, PASSWORD_DEFAULT);
                                    $params = array($clave, $nombre, $apellido, $correo, $fecha, $telefono2, $direccion);
                                    Database::executeRow($sql, $params);
                                    header("location: login.php");
                                } else
                                    throw new Exception("La clave debe ser alfanumerica");
                            }
                            else
                                throw new Exception("Las contraseñas ingresadas no coinciden.");

                        }
                         else
                                throw new Exception("La contraseña debe tener 8 caracteres minimo :3.");
                        }
                        else
                            throw new Exception("Debe marcar la casilla de Captcha");
                    } else
                        throw new Exception("La contraseña no puede ser tu correo.");
                } else
                    throw new Exception("Debe ingresar una cuenta de correo y la contraseña.");
            } else
                throw new Exception("Tiene que ser mayor de edad.");
        } else
            throw new Exception("Debe ingresar al menos un nombre y un apellido.");
    }
    catch (Exception $error)
    {
        print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}


Page::header("Registro Cliente");
?>
<style>
    div.error
    {
        color: red;
        float: right;
        font-size:  14px;
    }
</style>

<!--Formulario para que el cliente se registre-->
<form method='post' class='row' id="login" enctype='multipart/form-data' novalidate="novalidate" autocomplete="off" onpaste="return false" oncut="return false" oncopy="return false">
    <div class='row'>
        <!--Campo para agregar el nombre del cliente-->
        <div class='input-field col s12 m6'>
         <i class='material-icons prefix'>assignment_ind</i>
         <input id='nombre' type='text' name='nombre' class='validate' length='50' maxlenght='50' value='<?php print($nombre); ?>' required/>
         <label for='nombre'>Nombres</label>
     </div>
     <!--Campo para agregar los apellidos del cliente-->
     <div class='input-field col s12 m6'>
        <i class='material-icons prefix'>assignment_ind</i>
        <input id='apellido' type='text' name='apellido' class='validate' length='50' maxlenght='50' value='<?php print($apellido); ?>' required/>
        <label for='apellido'>Apellidos</label>
    </div>

</div>
<div class='input-field col s12 m6'>
    <!--Campo para agregar la fecha de nacimiento, es necesario que el usuario sea mayor de 18 años-->
    <i class='material-icons prefix'>perm_identity</i>
    <input id='fecha' type='date' name='fecha' class='validate' value='<?php print($fecha); ?>'/>
    <label for='fecha' class="active">Fecha</label>
</div>
<div class='input-field col s12 m6'>
        <i class='material-icons prefix'>email</i>
        <input id='correo' type='email' name='correo' class='validate' length='100' maxlenght='100' value='<?php print($correo); ?>'/>
        <label for='correo'>Correo</label>
    </div>
<div class='row'>
    <!--Campo para introducir correo electronico valido-->
    <div class='input-field col s12 m6'>
        <i class='material-icons prefix'>call</i>
        <input id='telefono' type='number' name='telefono' class='validate' length='8' maxlenght='8' value='<?php print($telefono); ?>' required/>
        <label for='telefono'>Telefono</label>
    </div>
    <div class='input-field col s12 m6'>
        <i class='material-icons prefix'>place</i>
        <input id='direccion' type='text' name='direccion' class='validate' length='50' maxlenght='50' value='<?php print($direccion); ?>' required/>
        <label for='direccion'>Direccion</label>
    </div>
</div>

<div class='row'>
    <!--Campos para introducir contraseña-->
    <div class='input-field col s12 m6'>
        <i class='material-icons prefix'>lock</i>
        <input id='contracliente' type='password' name='contracliente' class='validate' length='25' maxlenght='25' required/>
        <label for='contracliente'>Contraseña</label>
    </div>
    <div class='input-field col s12 m6'>
        <i class='material-icons prefix'>lock</i>
        <input id='contracliente2' type='password' name='contracliente2' class='validate' length='25' maxlenght='25' required/>
        <label for='contracliente2'>Confirmar contraseña</label>
    </div>
</div>
<div class="g-recaptcha" data-sitekey="6LdiQSgTAAAAAAN_moBCHZsBnYC7saze_9B_ocs0"></div>

<button type='submit' class='btn light-green darken-3'><i class='material-icons right'>save</i>Guardar</button>
<a href='login.php'class='btn red darken-1'><i class='material-icons right'>highlight_off</i>Cancelar</a>

</form>

<?php
Page::footer();
?>