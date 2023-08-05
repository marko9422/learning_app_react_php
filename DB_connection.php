<?php
	/**
	* Database Connection
	*/
	class DbConnect {
		// private $server = 'a045um.forpsi.com';
		// private $dbname = 'f155447';
		// private $user = 'f155447';
		// private $pass = 'Cc5HNQTJ';

        private $server = 'localhost';
		private $dbname = 'learning_app_react';
		private $user = 'root';
		private $pass = '';

		public function connect() {
			try {
				$conn = new PDO('mysql:host=' .$this->server .';dbname=' . $this->dbname, $this->user, $this->pass);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $conn;
			} catch (\Exception $e) {
				echo "Database Error: " . $e->getMessage();
			}
		}
        
	}
?>