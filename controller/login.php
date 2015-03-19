<?php

	require_once 'Database.php';

	class login extends Database{
	
		private $login;
		private $senha;
	
		public function getLogin(){
			return $this->login;
		}
	
		public function setLogin($login){
			$this->login = $login;
		}
	
		public function getSenha(){
			return $this->senha;
		}
	
		public function setSenha($senha){
			$this->senha = $senha;
		}
	
		public function logar(){
			$db = $this->connection;
			$sql= "SELECT * FROM usuarios WHERE login = ? AND senha = ?";
			$logar= $db->prepare($sql);

			$logar->bindValue(1, $this->getLogin());
			$logar->bindValue(2, $this->getSenha());
			$logar->execute();
			
			if($logar->rowCount() == 1):
				$stmt = $logar->fetch(PDO::FETCH_OBJ);
				if ($stmt->nivel == 1):
					$_SESSION['id']   	  = $stmt->id;
					$_SESSION['nome'] 	  = $stmt->nome;
					$_SESSION['login'] 	  = $stmt->login;
					$_SESSION['senha'] 	  = $stmt->senha;
					$_SESSION['nivel'] 	  = $stmt->nivel;
					$_SESSION['administrador']  = true;
					header("Location: view/adm.php");
					return true;
				elseif ($stmt->nivel == 2):
					$_SESSION['id']   	  = $stmt->id;
					$_SESSION['nome'] 	  = $stmt->nome;
					$_SESSION['login'] 	  = $stmt->login;
					$_SESSION['senha'] 	  = $stmt->senha;
					$_SESSION['nivel'] 	  = $stmt->nivel;
					$_SESSION['usuario']  = true;
					header("Location: view/usuario.php");
					return true;
				else:
					echo "<script>alert('Login e/ou senha incorretos.'); document.location: '../index.php';</script>";
					return false;
				endif;
			endif;

		}
	
		/*função para deslogar da sessao administrador*/
		public static function deslogar_adm(){
			if(isset($_SESSION['administrador'])):
				unset($_SESSION['administrador']);
				session_destroy();
				header("Location: ../index.php");
			endif;	
		}
	
		//função para deslogar da sessao usuario
		public static function deslogar_usuario(){
			if(isset($_SESSION['usuario'])):
				unset($_SESSION['usuario']);
				session_destroy();
				header("Location: ../index.php");
			endif;
		}
	
	}