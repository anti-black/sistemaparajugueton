<?php
session_start();
class Database
{
    private static $connection;

    private static function connect()
    {
        $server = 'localhost';
        $database = 'jugueton';
        $username = 'root';
        $password = '';
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8");
        self::$connection = null;
        try
        {
            self::$connection = new PDO("mysql:host=".$server."; dbname=".$database, $username, $password, $options);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $exception)
        {
            die($exception->getMessage());
        }
    }

    private static function desconnect()
    {
        self::$connection = null;
    }

    public static function executeRow($query, $values = null)
    {
        $res = false;
        self::connect();
        $statement = self::$connection->prepare($query);
        $res = $statement->execute($values);
        self::desconnect();
        return $res;
    }

    public static function getRow($query, $values = null) {
        self::connect();
        $statement = null;
        $statement = self::$connection->prepare($query);
        $statement->execute($values);
        self::desconnect();
        return $statement->fetch(PDO::FETCH_BOTH);
    }

    public static function getRows($query, $values = null) {
        self::connect();
        $statement = self::$connection->prepare($query);
        $statement->execute($values);
        self::desconnect();
        return $statement->fetchAll(PDO::FETCH_BOTH);
    }

    public static function getValue($query, $values = null, $indice) {
        $fila = self::getRow($query, $values);
        return $fila[$indice];
    }
}
class Validator
{
	public static function validateForm($fields)
	{
		foreach ($fields as $index => $value) {
			$value = trim($value);
			$value = strip_tags($value);
			$fields[$index] = $value;
		}
		return $fields;
	}

	public static function validateImage($file)
	{
		if (!empty($file['error']))
			return false;
		$img_size = $file["size"];
     	if($img_size <= 2097152) {
     		$img_type = $file["type"];
	     	if($img_type == "image/jpeg" || $img_type == "image/png" || $img_type == "image/gif") {
	    		$img_temporal = $file["tmp_name"];
	    		$img_info = getimagesize($img_temporal);
		    	$img_width = $img_info[0];
				$img_height = $img_info[1];
				if ($img_height == $img_height && $img_width <= 1200)
					return base64_encode(file_get_contents($img_temporal));
				else
					return false;
	    	}
	    	else
	    		return false;
     	}
     	else
     		return false;
	}
}
class Page
{
	public static function header($title)
	{
		ini_set("date.timezone","America/El_Salvador");
		$sesion = false;//por defecto no hay sesion
		$filename = basename($_SERVER['PHP_SELF']);
		$filas = self::categorias();
		$sesion = self::validarAcceso();
		if (!$sesion)
			session_destroy();
		$nombre = !empty($_SESSION['nombre_cliente']) ? $_SESSION['nombre_cliente'] : 'Anónimo';
		$header = "
	<!DOCTYPE html>
	<html lang='es'>
	<head>
		<meta charset='utf-8'>
		<title> $title</title>
		<link type='text/css' rel='stylesheet' href='/css/materialize.min.css'/>
		<link type='text/css' rel='stylesheet' href='/css/estilo.css'/>
		<link type='text/css' rel='stylesheet' href='/css/owl.carousel.css'/>
		<link type='text/css' rel='stylesheet' href='/css/icons.css'/>
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<script src='/js/jquery-2.2.3.min.js'></script>
		<script src='//ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js'></script>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'/>
	</head>
	<body>

	<div class='navbar-fixed'>
		<nav class='light-blue accent-3'>
			<div class='nav-wrapper'>
			<a id='logo-container' href='../principal/index.php' class='brand-logo'><img class='todo-shrink-navlogo' src='../img/logo.png'/></a>
				<a href='#' data-activates='mobile' class='button-collapse'><i class='material-icons'>menu</i></a>
				<ul class='right hide-on-med-and-down'>
					<li><a href='../productos/productos.php'><i class='material-icons left'>import_contacts</i>Catalogo</a></li>
					<li><a class='dropdown-button' href='#' data-activates='dropdown1'><i class='material-icons left'>list</i>Categorias</a></li>
					<li><a href='../eventos/eventos.php'><i class='material-icons left'<i class='material-icons left'>today</i></a></li>
					<li><a href='../noticias/noticias.php'><i class='material-icons left'<i class='material-icons left'>content_paste</i></a></li>". (($sesion) ? "
					<li><a href='../productos/carrito.php'><i class='material-icons left'<i class='material-icons left'>shopping_cart</i></a></li>" : '')."
					<li><a class='dropdown-button' href='#' data-activates='dropdown'><i class='material-icons left'>perm_identity</i>$nombre</a></li>
				</ul>
				<ul id='dropdown' class='dropdown-content'>". (($sesion) ? "
					<li><a href='../cuenta/profile.php'>Editar perfil</a></li>
					<li><a href='../principal/logout.php'>Cerrar sesion</a></li>" : "
					<li><a href='../principal/registro.php'>Registrarse</a></li>
					<li><a href='../principal/login.php'>Iniciar</a></li>")."
				</ul>

				<ul id='dropdown1' class='dropdown-content'>$filas
				</ul>

				<ul class='side-nav' id='mobile'>
					<li><a class='dropdown-button' href='#' data-activates='dropdown-mobile'><i class='material-icons left'>perm_identity</i>$nombre</a></li>
					<li><a href='../productos/productos.php'><i class='material-icons left'>import_contacts</i>Catalogo</a></li>
					<li><a class='dropdown-button' href='#' data-activates='dropdown1-mobile'><i class='material-icons left'>list</i>Categorias</a></li>
					<li><a href='noticias.php'><i class='material-icons left'<i class='material-icons left'>content_paste</i>Noticias</a></li>
					<li><a href='eventos.php'><i class='material-icons left'<i class='material-icons left'>today</i>Eventos</a></li>
				</ul>
				<ul id='dropdown-mobile' class='dropdown-content'>". (($sesion) ? "
					<li><a href='../cuenta/profile.php'>Editar perfil</a></li>
					<li><a href='../principal/logout.php'>Cerrar sesion</a></li>" : "
					<li><a href='../principal/registro.php'>Registrarse</a></li>
					<li><a href='../principal/login.php'>Iniciar</a></li>")."
				</ul>
				<ul id='dropdown1-mobile' class='dropdown-content'>$filas
				</ul>
			</div>
		</nav>
	</div>";
		if($filename != "index.php")
			$header .= "<div class='container center-align'>";
		if($sesion)//verificamos si existe una sesion activa, ¿como?, si solo pone la variable la condicion valida si es verdadera, así como esa variable solo de tipo booleano pueden ir asi, solas
			if($filename != "login.php")
				$header .= "<h3>$title</h3>";
			else
				header("location: index.php"); // vaya entonces
		else//si no econtro sesion
			if ($filename != "login.php"	&& $filename != "registro.php"	&& $filename != "index.php"		&&
				$filename != "niñas.php"	&& $filename != "niños.php"		&& $filename != "productos.php"	&&
				$filename != "ubicacion.php"&& $filename != "detallenot.php"&& $filename != "contacto.php"	&&
				$filename != "noticias.php"	&& $filename != "eventos.php"	&& $filename != "detallepro.php" )//esta condicion verifica si no estamos en el login o en el registrarse, y como antes verificamos si hay alguna sesion
					header("location: ../principal/login.php");
		//print("<div class='card-panel red'><a href='login.php'><h5>Debe iniciar sesión.</h5></a></div>");
		//self::footer();
		//exit();
			else
				$header .= "<h3>$title</h3>";
		print($header);
	}

	public static function footer()
	{
		$footer = "
	</div>
	<footer class='page-footer blue-grey lighten-5'>
		<div class='container'>
			<div class='row'>
				<div class='col s12 m6 l4'>
					<h5 class='black-text'>Nosotros</h5>
					<ul>
						<li><a class='grey-text' href='#!'>Acerca de</a></li>
						<li><a class='grey-text' href='#!'>Términos y condicions</a></li>
						<li><a class='grey-text' href='#!'>FAQ</a></li>
						<li><a class='grey-text' href='contacto.php'>Contactanos</a></li>
					</ul>
				</div>
				<div class=' col s12 m6 l4'>
					<h5 class='black-text'>Información</h5>
					<ul>
						<li><a class='grey-text' href='#!'>Apartados</a></li>
						<li><a class='grey-text' href='#!'>Financiamiento</a></li>
						<li><a class='grey-text' href='#!'>Garantia y devoluciones</a></li>
						<li><a class='grey-text' href='#!'>Ventas coorporativas</a></li>
					</ul>
				</div>
				<div class='col s12 m6 l4'>
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
		<div class='footer-copyright light-blue accent-2'>
			<div class='container'>
				<center>© 2016 Jugueton El Salvador</center>
			</div>
		</div>
	</footer>
	<script src='/js/materialize.min.js'></script>
	<script src='/js/materialize.js'></script>
	<script src='/js/owl.carousel.js'></script>
	<script src='/js/owl.carousel.min.js'></script>

	<script>
		$(document).ready(function() {
			$('.button-collapse').sideNav();
			$('.materialboxed').materialbox();
			$('select').material_select();
			$('.dropdown-button').dropdown({ belowOrigin: true });
			$('.slider').slider();
			$('ul.tabs').tabs();
			$('.collapsible').collapsible({ accordion : false });
		});
		$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
});
	</script>
	</body>
	</html>";
		print($footer);
	}

	function categorias(){
		$lista = '';
		$sql = 'SELECT  md5(id_categoria),  categoria FROM  categorias WHERE (estado = 1) ORDER BY  id_categoria ASC;';
		$data = Database::getRows($sql, null);
		foreach ($data as $fila) {
			$id = self::base64url_encode($fila[0]);
			$lista .= "
					<li><a href='../productos/productos.php?cat=$id'>$fila[1]</a></li>";
		}
		return $lista;
	}

	public static function setCombo($name, $value, $query)
	{
		$data = Database::getRows($query, null);
		$combo = "<select name='$name' required>";
		if($value == null)
			$combo .= "<option value='' disabled selected>Seleccione una opción</option>";
		foreach($data as $row)
		{
			$combo .= "<option value='$row[0]'";
			if(isset($_POST[$name]) == $row[0] || $value == $row[0])
				$combo .= " selected";
			$combo .= ">$row[1]</option>";
		}
		$combo .= "</select>
		<label style='text-transform: capitalize;'>$name</label>";
		print($combo);
	}

	public static function calculaedad($fecha) {
		$fechacon=date("Y-m-d",strtotime($fecha));
		$fecha = time() - strtotime($fechacon);
		$edad = floor($fecha / 31556926);
		$valido = ($edad >= 18) ? true : false;
		return $valido;
	}

	public static function actualizar_Sesion($nombre, $apellido) {
		$arr = explode(" ", $nombre);
		$arr2 = explode(" ", $apellido);
		$_SESSION['nombre_cliente'] = $arr[0]." ".$arr2[0];
	}

	public static function validarAcceso() {
		if (empty(array($_SESSION['clave'], $_SESSION['id_cliente'])))
			return false;
		$valores = array($_SESSION['clave'], $_SESSION['id_cliente']);
		Database::executeRow("UPDATE sesiones SET ultimo = CURRENT_TIMESTAMP WHERE codigo = ? AND id_cliente = ?;", $valores);
		return !empty(Database::getRows("SELECT * FROM sesiones WHERE codigo = ? AND id_cliente = ?;", $valores));
	}

	public static function iniciado(){
		return (!empty($_SESSION) && self::validarAcceso());
	}
	public static function base64url_encode($data) {
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}

	public static function base64url_decode($data) {
		return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
	}
}
?>