<?php
	
	class Security{
		
	
		public function generateCSRFToken(){
			if (empty($_SESSION['csrf_token'])) {
				// Generamos un token único usando una combinación de md5 y uniqid con microtime para mayor entropía
				$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
				$_SESSION['csrf_token_expiry'] = time() + 3600; // Token válido por 1 hora
			}
			return $_SESSION['csrf_token'];
		}
		
		public function verifyCSRFToken($token) {
			if (!empty($_SESSION['csrf_token'])
				&& hash_equals($_SESSION['csrf_token'], $token)
				&& $_SESSION['csrf_token_expiry'] >= time()) {
				// Si el token es válido y no ha expirado, lo regeneramos
				$this->generateCSRFToken();
				return true;
			}
			return false;
		}
		
	}