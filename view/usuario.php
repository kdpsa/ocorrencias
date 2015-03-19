<?php

	session_start();

	date_default_timezone_set("America/Sao_Paulo");
	setlocale(LC_ALL,'pt-BR');
	
	require_once '../controller/Database.php';
	require_once '../controller/login.php';
	require_once '../controller/Crud.php';

	if (isset($_GET['logout'])):
		if ($_GET['logout'] == 'ok'):
			login::deslogar_usuario();
		endif;
	endif;
	
	/* 
	 * Muda a saudação e background do .panel
	 * com base na hora e nos períodos do dia: manhã, tarde e noite
	 */
	$h = date("H");
	
	if ($h >= 0 && $h < 5):
		$msg = "Bom dia,";
		$tempo = 'noite';
	elseif ($h >= 5	&& $h < 12):
		$msg = "Bom dia,";
		$tempo = 'manha';
	elseif ($h >= 12 && $h < 19):
		$msg = "Boa tarde,";
		$tempo = 'tarde';
	elseif ($h >= 19 && $h < 20):
		$msg = "Boa noite,";
		$tempo = 'tarde2';
	else:
		$msg = "Boa noite,";
		$tempo = 'noite';
	endif;
	
	if (isset($_SESSION['usuario'])):
	
		$id	   = $_SESSION['id'];
		$nome  = $_SESSION['nome'];
		$email = $_SESSION['email'];
		$login = $_SESSION['login'];
		$senha = $_SESSION['senha'];
	
		$n = new Crud();
	
?>
<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="pt-BR" > <![endif]-->
<html class="no-js" lang="pt-BR" >
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Início</title>
		<link rel="stylesheet" href="../css/normalize.css">
		<link rel="stylesheet" href="../css/foundation.css">
		<link rel="stylesheet" href="../css/app.css">
		<link rel="stylesheet" href="../css/adm.css">
		<script src="../js/vendor/modernizr.js"></script>
		<link rel="shortcut icon" href="../img/animated_favicon.gif" type="image/gif">
		<link rel="icon" href="../img/favicon.ico" type="image/x-icon">
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	</head>
	<body>

		<!-- Menu -->
		<div class="contain-to-grid sticky">
			<nav class="top-bar" data-topbar data-options="sticky: on_large" role="navigation">
				<ul class="title-area">
					<li class="name"><h1><a href="#"><strong>AFPESP</strong></a></h1></li>
					<li class="toggle-topbar icon-menu"><a href=""><i class="fa fa-navicon"></i></a></li>
				</ul>
				<section class="top-bar-section">
					<ul class="left">
						<li class="active"><a href="../view/usuario.php">Minha Conta</a></li>
					</ul>

					<ul class="left">
						<li><a href="../view/agendar.php">Agendar</a></li>
					</ul>

					<ul class="left">
						<li><a href="../view/meus_agendamentos.php">Meus Agendamentos</a></li>
					</ul>
					<ul class="left">
						<li><a href="">Fale Conosco</a></li>
					</ul>
					<ul class="left">

						<li><a href="">Ajuda</a></li>
					</ul>
					<ul class="right">
						<li><a href="?logout=ok">Sair</a></li>
					</ul>
				</section>

			</nav>

		</div>
		<!-- Fim menu -->
		
		<?php 
			
			/* 
			 * Foreach para o nome do usuário
			 * mudar depois de finalizar a atualização dos dados.
			 * 
			 * @var $dado = recebe as informações da funcao Crud::find($id)
			 * @var $info = recebe as informações da variavel $dado para retornar os dados
			 *
			 * Data: 26/12/2014
			 *
			 */
			
			$dado = $n->find($id); 
		
			if (!empty($dado)) {
				foreach ($dado as $info) {

		?>
		
		<!-- Topo do usuário -->
		<div class="row" style="margin-top: 3%;">
			<div class="small-12 small-centered medium-10 medium-centered large-12 large-centered columns">
				<div class="panel radius <?php echo $tempo; ?>">
					<p class="text-center hide-for-large hide-for-small hide-for-xlarge" id="msg" style="color: #fff; font-size: 26px; padding: 40px;"><?php echo $msg .'<br/><i class="fa fa-user"></i> '. $info->nome; ?>.</p>
					<p class="text-center hide-for-medium hide-for-large" id="msg" style="color: #fff; font-size: 26px; padding: 40px;"><?php echo $msg .'<br/><i class="fa fa-user"></i> '. $info->nome; ?>.</p>
					<p class="text hide-for-small hide-for-medium hide-for-xlarge" id="msg" style="color: #fff; font-size: 26px; padding: 40px;"><?php echo $msg .'<br/><i class="fa fa-user"></i> '. $info->nome; ?>.</p>
				</div>
			</div>
		</div>
		<!-- Fim topo do usuário -->
		
		<?php
			
				}
			}
		
			$data = $n->find($id);
			
			/*
			 *
			 * Função para atualizar as informações do usuario
			 * 
			 * @function Crud::update($id) = Passa por parametro os dados do usuario e os
			 * armazena no banco de dados, com base no número do id
			 *
			 * Data: 26/12/2014
			 *
			 */
		
			if(isset($_POST['atualizar'])):
			
				$id    = (int)$_GET['id'];				
				$nome  = $_POST['nome'];
				$login = $_POST['login'];
				$senha = $_POST['senha'];
				
				$n->updateUser($id);
				
				echo "<meta charset='utf-8'/><script>alert('Informações atualizadas com sucesso.'); document.location='../view/usuario.php';</script>";
				/*echo "<div class='alert alert-success'>
					<button class='btn btn-success' class='close' data-dismiss='alert'>x</button>
					<class='text-success'>Atualizado com sucesso.</class>
				</div>";*/
			
			endif;

			/* 
			 * Foreach para buscar os dados do usuario baseado no número do id
			 * 
			 * @var $rs = recebe as informações da função Crud::procura($id)
			 * @var $id = recebe o id, que é passado por parametro para a função Crud::procura()
			 *
			 * @date: 26/12/2014
			 *
			 */

			if(isset($_GET['action']) && $_GET['action'] == 'update'){

				$id = (int)$_GET['id'];
				$rs = $n->procura($id);
			
		?>

		<!-- form de atualização dos dados do usuário -->
		<div class="row radius">
			<div class="small-12 small-centered medium-10 medium-centered large-8 large-centered columns">
				<div class="panel radius" style="background: #444;">
					<h4 style="color: #fff;"><i class="fa fa-edit"></i> Atualizar</h4><br/>
					<form action="" method="post">
						<input type="text" name="nome" value="<?php echo $rs->nome ?>">
						<input type="text" name="login" value="<?php echo $rs->login ?>">
						<input type="text" name="email" value="<?php echo $rs->email ?>">
						<input type="password" name="senha" value="<?php echo $rs->senha ?>">
						<button type="submit" class="button radius small success expand" name="atualizar"><i class="fa fa-check"></i> Atualizar</button>
					</form>
				</div>
			</div>
		</div>
		<?php } ?>
		<!-- fim form -->
		
		<!-- Tabela de usuários -->
		<div class="row radius">
			<div class="small-12 small-centered medium-10 medium-centered large-12 large-centered columns">
			<div class="panel radius" style="background : #444;">
				<h4 style="color: #fff;"><i class="fa fa-bars"></i> Minhas informações</h4>
			</div>
				<table role="grid" class="small-12 small-centered medium-12 medium-centered large-12 large-centered columns">
					<thead style="background: #444;">
						<tr>
							<th style="color: #fff;">Nome</th>
							<th style="color: #fff;" class="hide-for-small">CPF</th>
							<th style="color: #fff;" class="hide-for-small">E-mail</th>
							<th style="color: #fff;">Matrícula</th>
							<th style="color: #fff;">Alterar</th>
						</tr>
					<thead>
					
					<?php
						
						/* 
						 * Foreach para buscar os dados do usuario baseado no número do id
						 * 
						 * @var $data   = recebe as informações da funçao Crud::find($id)
						 * @var $result = recebe as informações de $data para retornar os dados
						 *
						 * Data: 26/12/2014
						 *
						 */

						if (!empty($data)) {
						foreach ($data as $result) {

					?>
					<tbody>
						<tr>
							<td class="text-justify"><?php echo $result->nome; ?></td>
							<td class="text-justify hide-for-small"></td>
							<td class="text-justify hide-for-small"><?php echo $result->email; ?></td>
							<td class="text-justify"><?php echo $result->login; ?></td>
							<td class="text-center">
								<a href="?action=update&id=<?php echo $result->id; ?>"><i class="fa fa-pencil-square fa-2x" title="Editar"></i></a>
						</tr>
					</tbody>
					<?php } } ?>
				<table>
			</div>
		</div>
		<!-- Fim tabela de usuários -->
		
		<script src="../js/vendor/jquery.js"></script>
	
		<script src="../js/foundation.min.js"></script>
		<script> $(document).foundation(); </script>
		
	</body>
</html>
<?php

	else:
	
		echo "<meta charset='utf-8'/><script>alert('Você não tem permissão para fazer isso.'); document.location='../index.php';</script>";
	
	endif;

?>