<?php 
header('Access-Control-Allow-Origin: *');
	// Dividimos la URL.
	$requestURI = explode( '/', $_SERVER['REQUEST_URI'] );
	// Eliminamos los espacios del principio y final
	// y recalculamos los índices del vector.
	$requestURI = array_values( array_filter( $requestURI ) );


	function studlyCase( $value )
	{
		$value = ucwords( str_replace( array( '-', '_' ), ' ', $value ) );
		return str_replace( ' ', '', $value );
	}

	// Configuración.
	define( 'CONTROLLER_PATH', 'controllers/' );
	define( 'EXT', '.php' );


	if (sizeof($requestURI) == 1 ) {
		// Página principal.
		echo 'Prueba a escribir <a href="/controller/method/param1/param2"><code>controller/method/param1/param2</code></a> en la URL.';
	}else{
		
		try{
			// Guardamos el nombre del controlador y la
			// ruta de su archivo para utilizarlas más tarde.
			$controllerName = studlyCase( $requestURI[1] );
			$controllerPath = CONTROLLER_PATH . $controllerName . EXT;
			// Guardamos el nombre del método a llamar.

			if (strtolower( $_SERVER['REQUEST_METHOD'] ) == "put") {
				$method = $controllerName . '::'. "edit";
			}else if (strtolower( $_SERVER['REQUEST_METHOD'] ) == "delete") {
				$method = $controllerName . '::'. "delete";
			}else{
				$method = $controllerName . '::'. strtolower( $_SERVER['REQUEST_METHOD'] )  . studlyCase( $requestURI[2]);
			}


			// Eliminamos el controlador y el método de
			// $requestURI para quedarnos sólo con los parámetros.
			$arguments = array_slice( $requestURI, 3 );

			// Comprobamos que el archivo del controlador existe.
			if ( ! file_exists( $controllerPath ) ) {
				throw new DomainException( 'El archivo <code>' . $controllerPath . '</code> no existe.', 404 );
			}

			// Cargamos el archivo.
			require_once $controllerPath;	

			// Comprobamos que el archivo contenga el controlador.
			if ( ! class_exists( $controllerName ) ) {
				throw new RuntimeException( 'El archivo <code>' . $controllerPath . '</code> debe contener un objeto <code>' . $controllerName . '</code>.' );
			}

			// Comprobamos que el método definido en la URL esté disponible.
			if ( ! is_callable( $method ) ) {
				throw new DomainException( 'El archivo <code>' . $controllerPath . '</code> no contiene un método <code>' . $method  . '</code>.', 404 );
			}

			// Creamos un nuevo método reflejo de $method.
			$reflection = new ReflectionMethod( $method );

			// Comprobamos que la URL tiene todos los
			// parámetros requeridos por el método.
			if ( $reflection->getNumberOfRequiredParameters() > count( $arguments ) ) {
				throw new DomainException( 'No hay suficientes parámetros como para ejecutar el método <code>' . $method . '</code>', 404 );
			}

			// Llamamos a la función.
			call_user_func_array( $method, $arguments );



		}
		catch ( RuntimeException $e ) {
			echo $e->getMessage();
		}
		catch ( DomainException $e ) {
			echo '<strong>Error ' . $e->getCode() . '</strong>: ' . $e->getMessage();
			// O bien escribimos un mensaje de página no encontrada.
		}
	}







 ?>