<?php require("../page1.php");
//se añaden herramientas de seguridad
require("../../lib/herramientas.php");
//Enlace para el formato de la pagina
//Encabezado de la pagina
$error = '';
if(!empty($_POST))
{
    $_POST = validator::validateForm($_POST);
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];
    try
    {
        if($correo != "" && $clave != "")
        {
            $sql = "SELECT * FROM clientes WHERE correo_cliente = ?";
            $params = array($correo);
            $data = Database::getRow($sql, $params);
            if($data != null)
            {
                $hash = $data['contra_cliente'];
                if(password_verify($clave, $hash))
                {
                    if($data['estado'] == 0)
                    {
                        //Database::executeRow("UPDATE clientes SET ", array($data['id_cliente']));
                        herramientas::iniciarSesion($data['id_cliente']);
                        // $param = array (1,$data['id_cliente']);
                        // Database::executeRow($query,$param);
                        $_SESSION['id_cliente'] = $data['id_cliente'];
                        Page::actualizar_Sesion($data['nombre_cliente'], $data['apellido_cliente']);
                        header("location: index.php");
                    }
                    else
                        throw new Exception("Su cuenta ha sido desactivada.");
                }
                else //Mensaje que se muestra cuando la contraseña es incorrecta
                    throw new Exception("La contraseña ingresada es incorrecta.");

            }
            else //Mensaje que se muestra cuando el usuario no existe
                throw new Exception("El correo ingresado no existe.");

        }
        else //Mensaje que se muestra cuando no se han ingresado datos en los inputs y se le da clic al boton entrar
            throw new Exception("Debe ingresar un correo y una contraseña.");
    }
    catch (Exception $error)
    {
        $error = "<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>";
    }
}
Page::header("Iniciar sesión");
echo $error;
?>

<h2>Bienvenido Cliente</h2>
<form class='row' method='post' action="" id="login" novalidate="novalidate" autocomplete="off" >
	<div class='row'>
  <!--Ingresamos el correo del cliente-->
		<div class='input-field col m6 offset-m3 s12'>
			<i class='material-icons prefix'>person_pin</i>
			<input id='correo' type='email' name='correo' class='validate' required/>
      <label for='correo' class="active">Correo</label>
    </div>
    <!--Se ingresa la contraseña del cliente-->
    <div class='input-field col m6 offset-m3 s12'>
     <i class='material-icons prefix'>vpn_key</i>
     <input id='clave' type='password' name='clave' class="validate" required onpaste="return false" oncut="return false" oncopy="return false"/>
     <label for='clave' class="active">Contraseña</label>
   </div>
 </div>
 <!--Ingresamos al index de la pagina-->
 <button type='submit' class='btn blue'><i class='material-icons right'>verified_user</i>Aceptar</button>
 <!--Nos dirige al registro-->
 <a href='registro.php'class='btn  lime darken-3'><i class='material-icons right'>add</i>Registro</a>
</form>
<a href="../cuenta/recuperarclave.php"><P>¿Olvidaste tu contraseña?</P></a>
<?php Page::footer(); ?>