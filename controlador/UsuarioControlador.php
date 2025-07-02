<?php
	
	
	namespace controlador;
	
	use repositorio\UsuarioRepository;
	use modelo\Usuario;
	use core\Security; // <--- ¡CAMBIO AQUÍ! De 'seguridad' a 'core
	
	class UsuarioControlador{
		
		private UsuarioRepository $repository; //Composicion
		private Security $seguridad; // Temporal para CSRF
		
		public function __construct(){
			$this->repository = new UsuarioRepository();
			$this->seguridad = new Security('dummy'); // 'dummy' porque el constructor lo pide
			
		}
		
		public function indexUsuarios(){
			//Le pedimos al repositorio que dos de los datos
			$usuarios = $this->repository->consultarTodo();
			//Pasamos los datos a la vista
			$security= new Security();
			$csrf_token = $security->generateCSRFToken();
			require_once("vista/usuarios.php");
		}
		
		public function mostrarUsuario(){
			
			$id=filter_input(INPUT_GET,"id",FILTER_VALIDATE_INT) ?:0;
			
			if ($id > 0) {
				//Le pedimos al usuario al repositorio
				$usuario=$this->repository->consultarUno($id);
				if(!$usuario){
					$_SESSION['flash'] = ['error' => 'Usuario no encontrado'];
					header("Location: index.php");
					exit();
				}
			}else{
				//Creamos un objeto Usuario vacio para el  formulario de nuevo registro
				$usuario = new Usuario();
			
			}
			
			$csrf_token = $this->seguridad->generateCSRFToken();
			require_once("vista/usuario_formulario.php");
		}
		
		public function guardar(){
			//if (!$this->seguridad->verifyCSRFToken($_POST['csrf_token'])) {
			//	die('Error de seguridad CSRF.');
			//}
			
			$usuario= new Usuario();
			$usuario->setId(filter_input(INPUT_POST,"id",FILTER_VALIDATE_INT));
			$usuario->setNombre(filter_input(INPUT_POST,"nombre"));
			$usuario->setApellido(filter_input(INPUT_POST,"apellido"));
			$usuario->setTelefono(filter_input(INPUT_POST,"telefono"));
			$usuario->setEdad(filter_input(INPUT_POST,"edad",FILTER_VALIDATE_INT));
			
			//Le pasamos el objeto completo al repositorio para que el decida si insertar o actualizar
			$this->repository->save($usuario);
			
			header("Location: index.php");
			exit();
		}
		
		
		public function eliminar(){
			$id=filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT); // Es mejor usar POST para acciones destructivas
			if($id){
				$this->repository->delete($id);
			}
			header("Location: index.php");
			exit();
		}
		
	}