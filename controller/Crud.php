<?php

	require_once 'Database.php';

	class Crud extends Database{

		//CAMPOS DO USUARIO
		private $nome;
		private $area;
		private $ramal;
		private $login;
		private $senha;
		private $nivel;
		/*private $status;*/
	
		//GETTERS E SETTERS
		public function getNome(){
			return $this->nome;
		}
		
		public function setNome($nome){
			$this->nome = $nome;
		}
		
		public function getArea(){
			return $this->area;
		}
		
		public function setArea($area){
			$this->area = $area;
		}
		
		public function getRamal(){
			return $this->ramal;
		}
		
		public function setRamal($ramal){
			$this->ramal = $ramal;
		}
		
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
		
		public function getNivel(){
			return $this->nivel;
		}
	
		public function setNivel($nivel){
			$this->nivel = $nivel;
		}
	
		//protect para que todas as classes utilizem
		//$table contém o nome do banco
		protected $table = 'usuarios';

		//procura um usuario pelo id
		public function find($nid){
			$db = $this->connection;
			//fazendo select de campos
			$sql= "SELECT * FROM usuarios WHERE id = :id";
			$stmt = $db->prepare($sql);
			//envia os parametros
			$stmt->bindParam(':id', $nid, PDO::PARAM_INT);
			//se tudo estiver correto ele executa
			$stmt->execute();
			//e retorna os valores
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}
		
		public function mostraData(){
			$data = date('d/m/Y');
			return $data;
		}
		
		public function mostraHora(){
			$hora = strftime('%H:%M');
			return $hora;
		}
		
		public function findOcorrencia($id){
			$db = $this->connection;
			//fazendo select de campos
			$sql= "SELECT * FROM ocorrencia WHERE ocorrencia_id = :id";
			$stmt = $db->prepare($sql);
			//envia os parametros
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			//se tudo estiver correto ele executa
			$stmt->execute();
			//e retorna os valores
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}
		
		public function busca(){
			$db = $this->connection;
			//fazendo select de campos
			$sql= "SELECT * FROM usuarios";
			$stmt = $db->prepare($sql);
			//se tudo estiver correto ele executa
			$stmt->execute();
			//e retorna os valores
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}
		
		public function buscaCategoria(){
			$db = $this->connection;
			//fazendo select de campos
			$sql= "SELECT * FROM categoria ORDER BY cat_nome ASC";
			$stmt = $db->prepare($sql);
			//se tudo estiver correto ele executa
			$stmt->execute();
			//e retorna os valores
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}
		
		public function buscaEmpresa(){
			$db = $this->connection;
			//fazendo select de campos
			$sql= "SELECT * FROM cliente ORDER BY cli_nome ASC";
			$stmt = $db->prepare($sql);
			//se tudo estiver correto ele executa
			$stmt->execute();
			//e retorna os valores
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}
		
		public function deleteCliente($nid){
			$db = $this->connection;
			$sql  = "DELETE FROM cliente WHERE id = :id";
			$stmt = $db->prepare($sql);
			//passa os parametros
			$stmt->bindParam(':id', $nid, PDO::PARAM_INT);
			//retorna os valores
			return $stmt->execute(); 
		}
		
		public function buscaCliente($nid){
			$db = $this->connection;
			//fazendo select de campos
			$sql= "SELECT * FROM cliente WHERE cli_id = :cli_id";
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':cli_id', $nid, PDO::PARAM_INT);
			$stmt->execute();
			//e retorna os valores
			return $stmt->fetch(PDO::FETCH_OBJ);
		}

		public function buscaOcorrencia(){
			$db = $this->connection;
			//fazendo select de campos
			$sql= "SELECT * FROM ocorrencia ORDER BY ocorrencia_id DESC";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			//e retorna os valores
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}
		
		public function deletaOcorrencia($id){
			$db = $this->connection;
			$sql  = "DELETE FROM ocorrencia WHERE ocorrencia_id = :ocorrencia_id";
			$stmt = $db->prepare($sql);
			//passa os parametros
			$stmt->bindParam(':ocorrencia_id', $id, PDO::PARAM_INT);
			//retorna os valores
			return $stmt->execute(); 
		}
		
		public function contaOcorrencia(){
			$db = $this->connection;
			//fazendo select de campos
			$sql= "SELECT ocorrencia_id FROM ocorrencia";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}
		
		//procura todos usuarios
		public function procura($id){
			$db = $this->connection;
			$sql = "SELECT * FROM usuarios WHERE id = :id";
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			//executa
			$stmt->execute();
			//retorna os valores
			return $stmt->fetch(PDO::FETCH_OBJ);
		}
		
		
		public function findLogin($login){
			$db = $this->connection;
			$sql = "SELECT login FROM usuarios WHERE login = :login";
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':login', $login, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}
		
		public function findEmpresa($empresa){
			$db = $this->connection;
			$sql = "SELECT cli_empresa FROM cliente WHERE cli_empresa = :cli_empresa";
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':cli_empresa', $empresa, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}
		
		public function dadoEmpresa($empresa){
			$db = $this->connection;
			$sql = "SELECT * FROM cliente WHERE cli_empresa = :cli_empresa";
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':cli_empresa', $empresa, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}
		
		public function search($nome){
			$db = $this->connection;
			$sql = "SELECT * FROM usuarios WHERE nome = :nome";
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
			//executa
			$stmt->execute();
			//retorna os valores
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}
	
		//deleta um usuario
		public function delete($id){
			$db = $this->connection;
			$sql  = "DELETE FROM usuarios WHERE id = :id";
			$stmt = $db->prepare($sql);
			//passa os parametros
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			//retorna os valores
			return $stmt->execute(); 
		}
	
		public function bloquear($id){
			$db = $this->connection;
			$sql = "UPDATE usuarios SET status = 0 WHERE id = :id";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			return $stmt->execute();
		}
		
		public function aprovar($id){
			$db = $this->connection;
			$sql = "UPDATE usuarios SET status = 1 WHERE id = :id";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			return $stmt->execute();
		}
		
		public function inserir(){
			$db = $this->connection;
			$sql = "INSERT INTO usuarios (id, nome, area, ramal, login, senha, nivel) VALUES (null, ?, ?, ?, ?, ?, ?)";
			$sha1 = sha1($_POST['senha']);
			$stmt = $db->prepare($sql);
			$stmt->bindParam(1, $_POST['nome'], PDO::PARAM_STR);
			$stmt->bindParam(2, $_POST['area'], PDO::PARAM_STR);
			$stmt->bindParam(3, $_POST['ramal'], PDO::PARAM_INT);
			$stmt->bindParam(4, $_POST['login'], PDO::PARAM_STR);
			$stmt->bindParam(5, $sha1, PDO::PARAM_STR);
			$stmt->bindParam(6, $_POST['nivel'], PDO::PARAM_INT);
			return $stmt->execute();
		}
		
		public function registraOcorrencia(){
			$db = $this->connection;
			$sql = "INSERT INTO ocorrencia (ocorrencia_id, cli_nome, cli_empresa, cli_categoria, cli_ocorrencia, data, hora, usuario, situacao) VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?)";
			$data = date('Y-m-d');
			$hora = strftime("%H:%M:%S");
			$situacao = "Pendente";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(1, $_POST['cliente_nome'], PDO::PARAM_STR);
			$stmt->bindParam(2, $_POST['cliente_empresa'], PDO::PARAM_STR);
			$stmt->bindParam(3, $_POST['cliente_categoria'], PDO::PARAM_STR);
			$stmt->bindParam(4, $_POST['cliente_ocorrencia'], PDO::PARAM_STR);
			$stmt->bindParam(5, $data);
			$stmt->bindParam(6, $hora);
			$stmt->bindParam(7, $_POST['usuario'], PDO::PARAM_STR);
			$stmt->bindParam(8, $situacao);
			return $stmt->execute();
		}
		
		public function ins_cliente(){
			$db = $this->connection;
			$sql = "INSERT INTO cliente (cli_id, cli_nome, cli_empresa, cli_email, cli_tel) VALUES (null, ?, ?, ?, ?)";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(1, $_POST['cli_nome'], PDO::PARAM_STR);
			$stmt->bindParam(2, $_POST['cli_empresa'], PDO::PARAM_STR);
			$stmt->bindParam(3, $_POST['cli_email'], PDO::PARAM_STR);
			$stmt->bindParam(4, $_POST['cli_tel'], PDO::PARAM_STR);
			return $stmt->execute();
		}
		
		public function updateCliente($id){
			$db = $this->connection;
			//inserindo a table que contem o nome do banco
			$sql  = "UPDATE cliente SET cli_nome = :cli_nome, cli_empresa = :cli_empresa, cli_email = :cli_email, cli_tel = :cli_tel WHERE cli_id = :cli_id";
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':cli_nome', $_POST['cli_nome'],PDO::PARAM_STR);
			$stmt->bindValue(':cli_empresa', $_POST['cli_empresa'],PDO::PARAM_STR);
			$stmt->bindValue(':cli_email', $_POST['cli_email'],PDO::PARAM_STR);
			$stmt->bindValue(':cli_tel', $_POST['cli_tel'],PDO::PARAM_STR);
			$stmt->bindValue(':cli_id', $id, PDO::PARAM_INT);
			//retornando e executando a ação
			return $stmt->execute();
		}
	
		public function update($id){
			$db = $this->connection;
			//inserindo a table que contem o nome do banco
			$sql  = "UPDATE usuarios SET nome = :nome, area = :area, ramal = :ramal, login = :login, senha = :senha, nivel = :nivel WHERE id = :id";
			$sha1 = sha1($_POST['senha']);
			$stmt = $db->prepare($sql);
			//passando os parametros
			$stmt->bindValue(':nome', $_POST['nome'],PDO::PARAM_STR);
			$stmt->bindValue(':area', $_POST['area'],PDO::PARAM_STR);
			$stmt->bindValue(':ramal', $_POST['ramal'],PDO::PARAM_STR);
			$stmt->bindValue(':login', $_POST['login'],PDO::PARAM_STR);
			$stmt->bindValue(':senha', $sha1, PDO::PARAM_STR);
			$stmt->bindValue(':nivel', $_POST['nivel'],PDO::PARAM_INT);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			//retornando e executando a ação
			return $stmt->execute();
		}
	
		public function procurarReserva($login){
			$db = $this->connection;
			//fazendo select de campos
			$sql= "SELECT bookings.Nquiosque, bookings.cmatricula, bookings.valor, bookings.qtdPessoas, DATE_FORMAT(bookings.date,'%d/%m/%Y') dd, DATE_FORMAT(bookings.dataAtual,'%d/%m/%Y') dd2
				   FROM bookings
				   
				   UNION
				   
				   SELECT bookings1.Nquiosque, bookings1.cmatricula, bookings1.valor, bookings1.qtdPessoas, DATE_FORMAT(bookings1.date,'%d/%m/%Y') dd, DATE_FORMAT(bookings1.dataAtual,'%d/%m/%Y') dd2
				   FROM bookings1
				   WHERE cmatricula = :tempMatricula ORDER BY dd ASC";
			$dados = $db->prepare($sql);
			//envia os parametros
			$dados->bindParam(':tempMatricula', $tempMatricula, PDO::PARAM_STR);
			//se tudo estiver correto ele executa
			$dados->execute();
			//e retorna os valores
			return $dados->fetchAll(PDO::FETCH_OBJ);	
		}
	
		//nivel - usuario administrador
		public function admin($id){
			$db = $this->connection;
			$sql = "UPDATE usuarios SET nivel='1' WHERE id = :id";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':id',$id);
			return $stmt->execute();
		}
	
		//nivel - usuario padrao
		public function padrao($id){
			$db = $this->connection;
			$sql = "UPDATE usuarios SET nivel='2' WHERE id = :id";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':id', $id);
			return $stmt->execute();
		}
	
	}