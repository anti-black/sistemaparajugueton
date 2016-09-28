<?php require("../lib/pagina.php");
echo Pagina::header("Eventos");
?>
<div class='row'>
	<div class='input-field col s12 m8'>
		<i class='material-icons prefix'>search</i>
		<input id='buscar' type='text' name='buscar' onkeyup="cargar($('#buscar').val());" onchange="cargar($('#buscar').val());" class='validate'/>
		<label for='buscar'>Búsqueda</label>
	</div>
	<div class='input-field col s12 m4'>
		<a href='crear.php' class='btn btn-flat indigo lighten-3'><i class='material-icons right'>note_add</i>Nuevo</a>
	</div>
</div>
<br/>
<br/>
<div id='portatabla' class="row">
	<div class="col s12 push-m2 m8 push-l4 l4">
		<div class="progress">
			<div class="indeterminate"></div>
		</div>
	</div>
</div>
<script type="text/javascript" src="comandos.js"></script>
<?php echo Pagina::footer("<script>cargar('');</script>"); ?>