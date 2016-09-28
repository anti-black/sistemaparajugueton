<?php //include "../lib/database.php";
/*
* Herramientas para obtener variables o hacer funciones especiales de poco uso
*/
class herramientas
{
	//Copiar un archivo de un lugar a otro, no borra el original.
		//Parámetros:
			//NuevoNombre = nombre que tendrá el archivo al final de la copia.
			//Origen = ruta absoluta y nombre del archivo original.
			//Destino = ruta absoluta de la ubicación final, no lleva el nombre del archivo.
	public static function copiarArchivo($nuevoNombre, $origen, $destino){
        $myfile = fopen($destino.$nuevoNombre, "w") or die("Error al abrir el archivo!");//se unen las direcciones
        //el método fopen abre archivos 'FileOPEN'.
        //pide la ruta del archivo(si el archivo no existe lo crea) y el modo ('write' en este caso)

        $txt = file_get_contents($origen); //se obtienen los datos del archivo original y se guardan en una varibale

        fwrite($myfile, $txt); //el método fwrite escribe sobre archivos
        //al archivo final se le colocan los datos

        fclose($myfile); //se cierra el archivo
	}

    public static function obtenerPlataforma() {
        $user_agent = $_SERVER['HTTP_USER_AGENT']; //se obtiene el agente del cliente (la persona que accede al servicio del servidor)
        $plataforma = "Plataforma desconocida"; //se inicia la variable
        $plataformas = array( //lista de patrones y sistemas
                '/windows nt 10/i'      =>  'Windows 10',       '/windows nt 6.3/i'     =>  'Windows 8.1',
                '/windows nt 6.2/i'     =>  'Windows 8',        '/windows nt 6.1/i'     =>  'Windows 7',
                '/windows nt 6.0/i'     =>  'Windows Vista',    '/windows nt 5.2/i'     =>  'Windows Server 2003/XPx64',
                '/windows nt 5.1/i'     =>  'Windows XP',       '/windows xp/i'         =>  'Windows XP',
                '/windows nt 5.0/i'     =>  'Windows 2000',     '/windows me/i'         =>  'Windows ME',
                '/win98/i'              =>  'Windows 98',       '/win95/i'              =>  'Windows 95',
                '/win16/i'              =>  'Windows 3.11',     '/macintosh|mac os x/i' =>  'Mac OS X',
                '/mac_powerpc/i'        =>  'Mac OS 9',         '/linux/i'              =>  'Linux',
                '/ubuntu/i'             =>  'Ubuntu',           '/iphone/i'             =>  'iPhone',
                '/ipod/i'               =>  'iPod',             '/ipad/i'               =>  'iPad',
                '/android/i'            =>  'Android',          '/blackberry/i'         =>  'BlackBerry',
                '/webos/i'              =>  'Mobile');
        foreach ($plataformas as $patron => $valor) //por cada valor en el arreglo se comprueba el patron
            if (preg_match($patron, $user_agent)) //se comprueba cada patron
                $plataforma = $valor; //si el patrón coincide se le guarda en variable
        return $plataforma; //se devuelve la variable
    }

    public static function obtenerNavegador() {
        $user_agent = $_SERVER['HTTP_USER_AGENT']; //se obtiene el agente del cliente (la persona que accede al servicio del servidor)
        $navegador = "Desconocido"; //se inicia la variable
        $navegadores = array( //lista de patrones y navegadores
                '/msie/i'       =>  'InternetExplorer', '/firefox/i'    =>  'Firefox',
                '/safari/i'     =>  'Safari',           '/chrome/i'     =>  'Chrome',
                '/edge/i'       =>  'Edge',             '/opera/i'      =>  'Opera',
                '/netscape/i'   =>  'Netscape',         '/maxthon/i'    =>  'Maxthon',
                '/konqueror/i'  =>  'Konqueror',        '/mobile/i'     =>  'HandheldBrowser' );
        foreach ($navegadores as $patron => $valor) //por cada valor en el arreglo se comprueba el patron
            if (preg_match($patron, $user_agent)) //se comprueba cada patron
                $navegador = $valor; //si el patrón coincide se le guarda en variable
        return $navegador; //se devuelve la variable
    }

    public static function iniciarSesion($id){
        $sql = "INSERT INTO sesiones(id_cliente, codigo, navegador, sistema) VALUES (?, ?, ?, ?);";
        $clave = $_SESSION['clave'] = md5(uniqid());
        $valores = array($id, $clave, self::obtenerNavegador(), self::obtenerPlataforma());
        return Database::executeRow($sql, $valores);
    }
}
?>