<?php
session_start();
class pcliente
{
	public static function header($title)
	{
		$header = "<!DOCTYPE html>
		<html lang='es'>
		<head>
			<meta charset='utf-8'>
			<title>$title</title>
			<link type='text/css' rel='stylesheet' href='/css/materialize.min.css'/>
			<link type='text/css' rel='stylesheet' href='/css/icons.css'/>
			<link type='text/css' rel='stylesheet' href='/css/estilo.css'/>
			<meta name='viewport' content='width=device-width, initial-scale=1.0'/>
		</head>
		<body>

	<div class='navbar-fixed'>
				<nav class='teal lighten-1'>
					<div class='nav-wrapper'>
					 <a id='logo-container' href='index.php' class='brand-logo'><img class='todo-shrink-navlogo' src='img/logo.png'/>
					 </a>
					<a href='#' data-activates='mobile' class='button-collapse'><i class='material-icons'>menu</i></a>
	        					<ul class='right hide-on-med-and-down'>
	        					<li><a href='productos.php'><i class='material-icons left'>dashboard</i>Catalogo</a></li>

		          					<li><a class='dropdown-button' href='#' data-activates='dropdown1'><i class='material-icons left'>list</i>Categorias</a></li>
		          						<li><a href='eventos.php'><i class='material-icons left'>content_paste</i></a></li>
		          					<li><a href='noticias.php'><i class='material-icons left'>today</i></a></li>


                                    <li><a href='carrito.php'><i class='material-icons left'>shopping_cart</a></i></li>
		          					<li><a class='dropdown-button' href='#' data-activates='dropdown'><i class='material-icons left'>perm_identity</i>$_SESSION[nombre_cliente]</a></li>
		        				</ul>
		        				<ul id='dropdown' class='dropdown-content'>
									<li><a href='profile.php'>Perfil</a></li>
										<li><a href='logout.php'>Cerrar sesión</a></li>
								</ul>

										<ul id='dropdown1' class='dropdown-content'>
									<li><a href='niños.php'>Niños</a></li>
									<li><a href='niñas.php'>Niñas</a></li>
								</ul>

			        			<ul class='side-nav' id='mobile'>
	        								<li><a href='ubicacion.php'><i class='material-icons left'>my_location</a></i></li>
			          				<li><a class='dropdown-button' href='#' data-activates='dropdown-mobile'><i class='material-icons left'>perm_identity</i>$_SESSION[nombre_cliente]</a></li>
	      						</ul>
	      						<ul id='dropdown-mobile' class='dropdown-content'>
									<li><a href='profile.php'>Perfil</a></li>
										<li><a href='logout.php'>Cerrar sesión</a></li>
								</ul>
				</div>
			</nav>
		</div>";

print($header);
}
		public static function footer()
		{
			$footer = "
	<footer class='page-footer blue-grey lighten-5'>
    <div class='container'>
      <div class='row'>

        <div class='col l4 s3'>
          <h5 class='black-text'>Nosotros</h5>
          <ul>
            <li><a class='grey-text' href='#!'>Acerca de</a></li>
            <li><a class='grey-text' href='#!'>Términos y condicions</a></li>
            <li><a class='grey-text' href='#!'>FAQ</a></li>
            <li><a class='grey-text' href='#!'>Contactanos</a></li>
          </ul>
        </div>

        <div class='col s4'>
          <h5 class='black-text'>Información</h5>
          <ul>
            <li><a class='grey-text' href='#!'>Apartados</a></li>
            <li><a class='grey-text' href='#!'>Financiamiento</a></li>
            <li><a class='grey-text' href='#!'>Garantia y devoluciones</a></li>
            <li><a class='grey-text' href='#!'>Ventas coorporativas</a></li>
          </ul>
        </div>
        <div class='col s3'>
          <h5 class='black-text'>Encuentranos</h5>
          <ul>
            <li><a class='grey-text'>Masferrer</li>
            <li><a class='grey-text'>Los próceres</li>
            <li><a class='grey-text'>Multiplaza</li>
            <li><a class='grey-text'>Metrocentro San Salvador</li>
            <li><a href='ubicacion.php'>Ir a sucursales</a></li>
          </ul>
        </div>



      </div>
    </div>
    <div class='footer-copyright teal lighten-2'>
      <div class='container'>
      <center>© 2016 Jugueton El Salvador</center>
      </div>
    </div>
  </footer>
	<script src='/js/jquery-2.2.3.min.js'></script>
	<script src='/js/materialize.min.js'></script>
	<script src='/js/materialize.js'></script>

	<script>
		$(document).ready(function(){
		$('.slider').slider({full_width: true});
		});
	</script>

";
print($footer);
	}
	public static function calculaedad($fecha) {
		$fechacon=date("Y-m-d",strtotime($fecha));
		$fecha = time() - strtotime($fechacon);
		$edad = floor($fecha / 31556926);
		$valido = ($edad >= 18) ? true : false;
		return $valido;
	}
}

?>

