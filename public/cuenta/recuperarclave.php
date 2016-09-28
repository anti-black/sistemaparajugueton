<?php
require("../page1.php");
//page::header("Recuperar contraseña");
?>
<h2>Recuperar Clave</h2>
<form class='row' method='POST' action="../principal/clave.php" autocomplete="off"  oncut="return false" oncopy="return false">
	<div class='row'>

			<input  type='email' name='correo' class='validate' required/>
      <label for='correo' class="active">Correo</label>

 </div>
 <button type='submit' class='btn blue'><i class='material-icons right'>verified_user</i>Aceptar</button>
 </form>

