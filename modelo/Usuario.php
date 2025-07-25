<?php
	
	namespace modelo;
	//YA NO NECESITAMOS HEREDAR NADA
	class Usuario{
		
		private int $id=0;
		private string $nombre="";
		private string $apellido="";
		private string $telefono="";
		private int $edad=0;
		
		// El constructor ahora puede estar vacío o no existir,
		// ya que PDO::FETCH_CLASS lo puede manejar.
		public function __construct() {}
		
		public function __set($name, $value) {
			// Verifica si la propiedad existe en esta clase antes de asignarla.
			if (property_exists($this, $name)) {
				$this->$name = $value;
			}
		}
		
		
		// Todos tus Getters y Setters se quedan aquí. Son perfectos para esta clase.
		// ... (getId, setId, getNombre, setNombre, etc.)
		public function getId(): int { return $this->id; }
		public function setId(int $id): void { $this->id = $id; }
		public function getNombre(): string { return $this->nombre; }
		public function setNombre(string $nombre): void { $this->nombre = $nombre; }
		public function getApellido(): string { return $this->apellido; }
		public function setApellido(string $apellido): void { $this->apellido = $apellido; }
		public function getTelefono(): string { return $this->telefono; }
		public function setTelefono(string $telefono): void { $this->telefono = $telefono; }
		public function getEdad(): int { return $this->edad; }
		public function setEdad(int $edad): void { $this->edad = $edad; }
	}
		
		
	