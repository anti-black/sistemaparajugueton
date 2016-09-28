<?php require "../lib/pagina.php"; echo pagina::header('Actualizacion de precios', true); ?>
<div class="container">
    <div class="card-panel blue-grey darken-4 s12">
		<h6 class="white-text">1. Seleccionar un archivo de valores separador por tabulación</h6>
	</div>
	<div class="row">
		<div class="col s12">
			<form>
				<div class="file-field input-field col s12 m6 l4">
					<div class="btn">
						<span>Archivo</span>
						<input type="file" name="Archivo" id="Archivo">
					</div>
					<div class="file-path-wrapper">
						<input class="file-path" readonly type="text">
					</div>
				</div>
				<div class="input-field col s12 m6 l4">
					<select id="tipoCarga">
						<option value="0" selected>Automático</option>
						<option value="1">Separado por punto y coma (;) usar coma (,) para decimales</option>
						<option value="2">Separado por coma (,) usar punto (.) para decimales</option>
					</select>
					<label>Materialize Select</label>
				</div>
			</form>
		</div>
	</div>
	<div class="card-panel blue-grey darken-4 s12">
		<h6 class="white-text">2. Subir el archivo</h6>
		<div class="btn waves-effect waves-dark" onclick="MostrarTXT();" >Subir</div>
	</div>
	<div class="card-panel blue-grey darken-4 s12">
		<h6 class="white-text">3. Comprobar resultados</h6>
		<p class="white-text">Los resultados de abajo es lo que se encontró dentro del documento</p>
	</div>
	<div class="container">
		<form action="actualizar_p.php" method="post" id="prevalidado">

		</form>
	</div>
<script>
    function MostrarTXT(){
    	try {
	        var arch = document.getElementById('Archivo').files[0];
	        var reader = new FileReader();
	        reader.readAsText(arch, 'UTF-8');
	        reader.onloadstart = MostrarPrecarga;
	        reader.onerror = MostrarError;
	        reader.onload = MostrarRes;
    	} catch (e) { Materialize.toast('Seleccione un archivo', 4000); }
    }
    function MostrarRes(event){
    	try {
	        var info = event.target.result;
	        var tipo = $('#tipoCarga').val();
	        $.ajax({
	            type:'POST',
	            url:'prevalidar.php', //archivo del calculo
	            data: { dat : info , tip : tipo },
	            success:function(data) {
	            	switch (data) {
	            		case '0':
	            			Materialize.toast('No se ha encontrado nada en el archivo', 4000);
	            			$('#prevalidado').html('');
	            			break;
	            		case '-1':
	            			Materialize.toast('Mal formato del archivo', 4000);
	            			$('#prevalidado').html('');
	            			break;
	            		default:
	            			$('#prevalidado').html(data);
	            			$('.modal-trigger').leanModal();
	            			break;
	            	}
	            }
	        });
    	} catch (e) {}
    }
	function MostrarPrecarga(event) { $("#prevalidado").html('<div class="div col s8 offset-s2"><div class="progress"><div class="indeterminate"></div></div></div>'); }
	function MostrarError(event) { $("#prevalidado").html(''); Materialize.toast('Error al cargar', 8000); }
</script>
<?php echo Pagina::footer(isset($_GET['ex']) ? "<script type='text/javascript'>Materialize.toast('Precios anteriores actualizados con éxito', 8000);</script>" : ''); ?>