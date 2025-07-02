<?php

// index.php - Versión Final con Autoloader

// Iniciar sesión, siempre es buena práctica tenerlo al principio.
	session_start();

// --- AUTOLOADER MÁGICO ---
// Esta es la pieza clave que faltaba.
// Le enseña a PHP a encontrar los archivos de las clases automáticamente.
	spl_autoload_register(function ($nombreCompletoClase) {
		// Convierte el namespace en una ruta de archivo.
		// Ejemplo: si PHP necesita 'repositorio\UsuarioRepository'...
		// ...esta línea lo convierte en 'repositorio/UsuarioRepository.php'.
		$rutaArchivo = str_replace('\\', '/', $nombreCompletoClase) . '.php';
		
		// Si el archivo existe en esa ruta, lo carga.
		if (file_exists($rutaArchivo)) {
			require_once $rutaArchivo;
		}
	});
	
	
	try {
		// --- ENRUTADOR (ROUTER) ---
		// Esta parte ya estaba casi bien, la mantenemos.
		$controladorBase = isset($_REQUEST['controlador'])
			? strtolower(strip_tags($_REQUEST['controlador']))
			: 'usuario';
		
		$accion = isset($_REQUEST['accion'])
			? strip_tags($_REQUEST['accion'])
			: 'indexUsuarios';
		
		// Construye el nombre completo de la clase del controlador (con su namespace)
		$nombreClaseControlador = 'controlador\\' . ucfirst($controladorBase) . 'Controlador';
		
		
		// --- VALIDACIÓN Y EJECUCIÓN ---
		
		// Ahora no necesitamos require_once aquí, el autoloader lo hará por nosotros.
		if (!class_exists($nombreClaseControlador)) {
			// Si la clase no existe, el autoloader no pudo encontrarla.
			throw new Exception("La clase controlador '$nombreClaseControlador' no se encontró. Revisa el nombre del archivo, el nombre de la clase y el namespace.");
		}
		
		// Creamos la instancia del controlador
		$instanciaControlador = new $nombreClaseControlador();
		
		// Verificamos si el método existe
		if (!method_exists($instanciaControlador, $accion)) {
			throw new Exception("La acción (método) '$accion' no existe en el controlador '$nombreClaseControlador'.");
		}
		
		// Ejecutamos la acción.
		$instanciaControlador->$accion();
		
	} catch (Exception $e) {
		// Mantenemos el buen manejo de errores.
		http_response_code(404);
		echo "<h1>Error en la Aplicación</h1>";
		echo "<p>Se ha producido un error que impide continuar. Detalles:</p>";
		echo "<pre style='background-color: #ffecec; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px;'>";
		echo "<strong>Mensaje:</strong> " . $e->getMessage();
		echo "</pre>";
	}