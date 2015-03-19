<?php

	Class Database {

		private    $db_host     = "localhost";
		private    $db_username = "root";
		private    $db_password = "";
		protected  $db_name     = "system";
		protected  $connection;

		//Conecta com o banco ao instanciar o objeto
		public function __construct(){
			$setting_charset  = $this->connect();
			$setting_charset->exec("SET NAMES utf8");
			$this->connection = $setting_charset;
		}

		//Conecta com o banco
		public function connect(){
			try {
				return new PDO('mysql:host='.$this->db_host.';dbname='.$this->db_name, $this->db_username, $this->db_password);
			} catch (PDOException $e) {
				echo "<span style='color: red; font-weight: bold;'>Erro: ".$e->getMessage()."<br/>Entre em contato com os desenvolvedores.</span>";
				exit();
			}
		}
	
	}