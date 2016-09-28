<?php
//Obtenemos la fecha y hora del sistema
ini_set("date.timezone","America/El_Salvador");
//Declaramos el enlace para obtener el formato de la pagina
require("../page1.php");
//Ingresamos el encabezado de nuestra pagina
Page::header("Editar perfil");
$nombre = "";



if(!empty($_POST))
{
    //Declaramos variables con Metodo POST
    $_POST = Validator::validateForm($_POST);
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $contracliente = $_POST['contra_cliente'];
    $contracliente2 = $_POST['contra_cliente2'];
    //Declaramos que si las variables estan vacias o no, sustituyan su valor por el nuevo que va a ingresar el cliente
    try
    {
        if(!empty($nombre) && !empty($apellido))
        {
            if(!empty($contracliente) && !empty($contracliente2))
            {
                if(strlen($contracliente)>=8)
                {
                if($contracliente == $contracliente2)
                {
                    if(preg_match('/([a-z]+[0-9]+)|([0-9]+[a-z]+)/i', $contracliente))
                    {
                        if($correo != $contracliente)
                        {
                            $contra = password_hash($contracliente, PASSWORD_DEFAULT);
                            //En esta consulta actualizamos los datos, con los nuevos que va a ingresar el cliente al modificar su informacion
                            $sql = "UPDATE clientes SET nombre_cliente = ?, apellido_cliente = ?, direccion_primaria = ?, telefono_movil = ?, contra_cliente = ? WHERE id_cliente = ?";
                            $params = array($nombre, $apellido, $direccion, $telefono, $contra, $_SESSION['id_cliente']);
                            echo "<script>alert('$contracliente');</script>";
                            Page::actualizar_Sesion($nombre, $apellido);
                            echo "<script>$('#nombS').text('".$_SESSION["nombre_cliente"]."');</script>";
                            Database::executeRow($sql, $params);
                        }
                        else
                            throw new Exception("La contraseña no puede ser tu correo.");
                    }
                    else
                        throw new Exception("La clave debe ser alfanumerica");
                }
                else
                    throw new Exception("Las claves ingresadas no coinciden.");

                }
                else
                throw new Exception("Los campos deben contener minimo 8 caracteres.");
            }
            else
            {
                $sql = "UPDATE clientes SET nombre_cliente = ?, apellido_cliente = ?, direccion_primaria = ?, telefono_movil = ? WHERE id_cliente = ?";
                $params = array($nombre, $apellido, $direccion, $telefono, $_SESSION['id_cliente']);
                Page::actualizar_Sesion($nombre, $apellido);
                echo "<script>$('#nombS').text('".$_SESSION["nombre_cliente"]."');</script>";
                Database::executeRow($sql, $params);
            }
        }
        else
            throw new Exception("Debe de rellenar los nombres.");
    }
    catch (Exception $error)
    {
        print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}
else
{
    $sql = "SELECT * FROM clientes WHERE id_cliente = ?";
    $params = array($_SESSION['id_cliente']);
    $data = Database::getRow($sql, $params);
    $nombre = $data['nombre_cliente'];
    $apellido = $data['apellido_cliente'];
    $direccion = $data['correo_cliente'];
    $telefono= $data['telefono_movil'];

}
?>

<!--Formulario para que el cliente se registre-->
<form method='post' class='row' id='profile' action="" novalidate="novalidate" enctype='multipart/form-data' autocomplete="off">
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
    <!--Campo para introducir correo electronico valido-->
    <div class='row'>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>email</i>
            <input id='direccion' type='text' name='direccion' class='validate' length='50' maxlenght='50' value='<?php print($direccion); ?>' required/>
            <label for='direccion'>Direccion</label>
        </div>
        <!--Campo para agregar la fecha de nacimiento, es necesario que el usuario sea mayor de 18 años-->
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>perm_identity</i>
            <input id='telefono' type='number' name='telefono' class='validate' length='50' maxlenght='50' value='<?php print($telefono); ?>' required/>
            <label for='telefono' class="active">Telefono</label>
        </div>
    </div>
    <div class='row'>
        <label>CAMBIAR CLAVE</label>
    </div>
    <!--Campos para introducir contraseña-->
    <div class='row'>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>lock</i>
            <input id='contracliente' type='password' name='contracliente' class='validate' length='25' maxlenght='25'/>
            <label for='contracliente'>Clave nueva</label>
        </div>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>lock</i>
            <input id='contracliente2' type='password' name='contracliente2' class='validate' length='25' maxlenght='25'/>
            <label for='contracliente2'>Confirmar clave</label>
        </div>
    </div>

    <a href='sesiones.php' class='btn green'><i class='material-icons right'>security</i>Sesiones</a>
    <button type='submit' class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
    <a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>Cancelar</a>
</form>
<?php
Page::footer();
?>