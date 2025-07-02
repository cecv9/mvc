<?php
	
	
	namespace repositorio;
	
	
	use core\Conexion;
	use modelo\Usuario;
	use PDO;
	
	//Incluimos las clases que vamos a usar (no heredar)
	
	
	class UsuarioRepository{
		
		private PDO $pdo; //La propiedad para guardar la conexion.
		
		//Composicion ! en lugar de heredar , recibimos la conexion.
		
		
		public function __construct(){
			//Creamos una instancia del conector y obtenemos el obejeto PDO
			$conector = new Conexion();
			$this->pdo = $conector->Conexion();
		}
		
		
		/**
		 * Obtiene todos los usuarios de la base de datos
		 * @return array Un array de objetos Usuario
		 */
		
		public function consultarTodo():array{
			
			$statement =$this->pdo->prepare("SELECT * FROM usuarios");
			$statement->execute();
			//Le decimos que convierta cada fila en un objeto de la clase Usuario
			return $statement->fetchAll(PDO::FETCH_CLASS,Usuario::class);
		}
		
		/**
		 * Busca un único usuario por su ID.
		 * @param int $id El ID del usuario.
		 * @return Usuario|false Un objeto Usuario si se encuentra, o false si no.
		 */
		
		public function  consultarUno(int $id){
			$statement=$this->pdo->prepare("SELECT * FROM usuarios where id = ?");
			$statement->execute([$id]);
			$statement->setFetchMode(PDO::FETCH_CLASS, Usuario::class);
			return $statement->fetch();
		}
		
		/**
		 * Elimina un usuario por su ID.
		 * @param int $id El ID del usuario a eliminar.
		 */
		
		public function delete(int $id):void{
			$statement=$this->pdo->prepare("DELETE FROM usuarios where id = ?");
			$statement->execute([$id]);
		}
		
		/**
		 * Guarda un usuario (lo inserta si es nuevo, lo actualiza si ya tiene ID).
		 * @param Usuario $usuario El objeto Usuario con los datos a guardar.
		 */
		
		public function save(Usuario $usuario): void {
			if ($usuario->getId() > 0) {
				$sql = "UPDATE usuarios SET id = ? , nombre = ?, apellido = ?, telefono = ?, edad = ? WHERE id = ?";
				$params = [
					$usuario->getId(),
					$usuario->getNombre(),
					$usuario->getApellido(),
					$usuario->getTelefono(),
					$usuario->getEdad(),
					$usuario->getId()
				];
			} else {
				$sql = "INSERT INTO usuarios (id,nombre, apellido, telefono, edad) VALUES (?,?, ?, ?, ?)";
				$params = [
					$usuario->getId(),
					$usuario->getNombre(),
					$usuario->getApellido(),
					$usuario->getTelefono(),
					$usuario->getEdad()
				];
			}
			
			$statement = $this->pdo->prepare($sql);
			$statement->execute($params);
		}
		
	}

		
	