<?php
	#Esta es la clase conexión al servidor de DB que extiende a MySQLi.
	class GNet extends mysqli {
		public function __construct($host, $user, $pass, $db){
			@parent::__construct($host, $user, $pass, $db);
		}
	}

	$Path = $_SERVER['DOCUMENT_ROOT']."/".explode("/", $_SERVER['REQUEST_URI'])[1];
	if (explode("/", $_SERVER['REQUEST_URI'])[1] != "GNet"){
		$Path = $_SERVER['DOCUMENT_ROOT'];
	}

	#Creamos una ruta absoluta y accedemos al fichero de Configuración.
	$t = $Path."/app/config/Config.tcb";
	// $t = $_SERVER['DOCUMENT_ROOT']."/".explode("/", $_SERVER['REQUEST_URI'])[1]."/app/config/Config.tcb";

	#Verificando la inexistencia del fichero de configuración.
	if (!file_exists($t)){
		#En caso de no existir este podría estar en otra ubicación, 
		#de tal forma que se escribe una nueva ruta.
		// $t = $_SERVER['DOCUMENT_ROOT']."/app/config/Config.tcb";
		$H = null;
		$U = null;
		$P = null;
		$D = null;
		$X = null;
	}

	#Se captura el estado de la variable error.
	$error = false;

	#Se verifica nuevamente si el fichero de Configuración existe, con la nueva ruta.
	if (file_exists($t)){
		#Se abre el fichero y se obtiene un objeto en forma de array con el contenido del fichero.
		$ArrayFileConfig = file($t);
		
		@$H = rtrim($ArrayFileConfig[0]);	#Host
		@$U = rtrim($ArrayFileConfig[1]);	#Username
		@$P = rtrim($ArrayFileConfig[2]);	#Password
		@$D = rtrim($ArrayFileConfig[3]);	#Database
		
		#Si no está establecido el Prefijo, entonces queda vacío, sino obtiene el dato.
		if (!isset($ArrayFileConfig[4]))
			$X = "";
		else
			$X = rtrim($ArrayFileConfig[4]);

		#Se verifica el tamaño de la dirección Local, IP.
		//echo "<br/><br/><br/>Host original: ", $H, "<br/><br/><br/>";
		if (strlen($H) == 12 && (substr($H, 3) == "localhost" || substr($H, 3) == "127.0.0.1")){
			@$H = substr($H, 3); #Se aplica una subcadena en caso de tener 12 caracteres.
		}

		#Se hace una instancia del objeto y se establece la conexión a la base de datos.
		@$IC = new GNet($H, $U, $P, $D);

		#Se verifica la conexión, en caso de error, se escribe true en la variable de error.
		if (@$IC->connect_error){
			$error = true;
		} else {
			$error = false; #false en caso contrario.
			
			#Se verifica el prefijo, si no está vacío entonces se le agrega un _ .
			if ($X != "")
				$X .= "_";

			#Se aplica una query donde se escribe el método de entrada en caracteres.
			if (!@$IC->query("SET NAMES 'utf8'"))
				$error = true;
			else
				$error = false;
		}
		#La variable de error, también juega en otros fichero donde este haya sido incluido.
	} else {
		$error = true;
	}

?>