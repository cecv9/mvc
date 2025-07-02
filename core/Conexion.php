<?php
	namespace  core;
	
	class Conexion{
	
		public string  $driver;
		public string  $host;
		public string  $user;
		public string  $password;
		public string  $database;
		//public string  $port;
		public string  $charset;

	
		public function __construct(string $driver="mysql",string $host="localhost",
									string $user="root",string $password="",string $database="sunny_side",
			                        string $charset="utf8")
		{
			$this->driver = $driver;
			$this->host = $host;
			$this->user = $user;
			$this->password = $password;
			$this->database = $database;
			$this->charset = $charset;
			
		
		}
		
		
		public function conexion(){
			
			try {
				$dns="$this->driver:host=$this->host;dbname=$this->database;charset=$this->charset";
				
				$pdo=new PDO($dns,$this->user,$this->password);
				
			}catch (pdoException $mensaje){
				throw new Exception("Errror de conexion".$mensaje->getMessage());
			
			}
			
		}
		
		
	}