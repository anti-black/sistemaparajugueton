<?php
//enlace al formato de la pagina
require("../lib/pagina.php");
//enlace a la base de datos
require("../../lib/database.php");
//encabezado de la pagina
echo Pagina::header("Clientes");
?>
<?php
$id = 0;
if(isset($_POST['id']))
    $id = $_POST['id'];
//echo $id;
//verificamos si los campos estan vacios o no si no estan vacios se hace la consulta necesaria para actualizar datos
if(empty($_GET['id']) && $id == 0)
{//encabezado de la pagina
  echo Pagina::header("Ver clientes");
  //declaramos variables
  $id = null;
  $nombre = null;
  $apellido = null;
  $correo = null;
  $fecha = null;
  $telefono = null;
  $direccion = null;


}
else
{//encabezado de la pagina
  //Pagina::header("Ver cliente");
  $id = $_GET['id'];
  if(isset($_POST['id']))
    $id = $_POST['id'];
  //echo $id;
  $sql = "SELECT * FROM clientes WHERE id_cliente = ?";
  $params = array($id);
  $data = pagina::obtenerFila($sql, array($id));
  //declaramos variables
  $nombre = $data['nombre_cliente'];
  $apellido = $data['apellido_cliente'];
  $correo = $data['correo_cliente'];

  $telefono = $data['telefono_movil'];
  $direccion = $data['direccion_primaria'];


}

?>
<!--Formulario para que el cliente se registre-->
<form method='post' class='row' id="login"   enctype='multipart/form-data' novalidate="novalidate" autocomplete="off" onpaste="return false" oncut="return false" oncopy="return false">
    <div class='row'>
        <!--Campo para agregar el nombre del cliente-->
        <div class='input-field col s12 m6'>
        <i class='material-icons prefix'>assignment_ind</i>
        <input id='nombre' type='text' readonly name='nombre' class='validate' length='50' maxlenght='50' value='<?php print($nombre); ?>' required/>
        <label for='nombre'>Nombres</label>
    </div>
     <!--Campo para agregar los apellidos del cliente-->
    <div class='input-field col s12 m6'>
        <i class='material-icons prefix'>assignment_ind</i>
        <input id='apellido' type='text' readonly name='apellido' class='validate' length='50' maxlenght='50' value='<?php print($apellido); ?>' required/>
        <label for='apellido'>Apellidos</label>
    </div>

</div>
<div class='input-field col s12 m6'>
        <i class='material-icons prefix'>email</i>
        <input id='correo' type='email' name='correo' readonly class='validate' length='100' maxlenght='100' value='<?php print($correo); ?>'/>
        <label for='correo'>Correo</label>
    </div>
<div class='row'>
    <!--Campo para introducir correo electronico valido-->
    <div class='input-field col s12 m6'>
        <i class='material-icons prefix'>call</i>
        <input id='telefono' type='number' name='telefono'  readonly class='validate' length='8' maxlenght='8' value='<?php print($telefono); ?>' required/>
        <label for='telefono'>Telefono</label>
    </div>
    <div class='input-field col s12 m6'>
        <i class='material-icons prefix'>place</i>
        <input id='direccion' type='text' name='direccion' readonly class='validate' length='50' maxlenght='50' value='<?php print($direccion); ?>' required/>
        <label for='direccion'>Direccion</label>
    </div>
</div>
<br>
<br>
<center><a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>Regresar</a></center>
</form>

<?php
echo Pagina::footer();
?>