<?php

	session_start();

	date_default_timezone_set("America/Sao_Paulo");
	setlocale(LC_ALL,'pt-BR');
	
	require_once '../controller/Database.php';
	require_once '../controller/login.php';
	require_once '../controller/Crud.php';

	if (isset($_GET['logout'])):
		if ($_GET['logout'] == 'ok'):
			login::deslogar_adm();
		endif;
	endif;

	if (isset($_SESSION['administrador'])):
		$nid   = $_SESSION['id'];
		$nome  = $_SESSION['nome'];
		$login = $_SESSION['login'];
		$senha = $_SESSION['senha'];
	
		$n = new Crud();
		$data = $n->mostraData();
		$hora = $n->mostraHora();
?>
<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="pt-BR" > <![endif]-->
<html class="no-js" lang="pt-BR" >
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Incluir</title>
		<link rel="stylesheet" href="../css/normalize.css">
		<link rel="stylesheet" href="../css/foundation.css">
		<link rel="stylesheet" href="../css/app.css">
		<link rel="stylesheet" href="../css/adm.css">
		<script src="../js/vendor/modernizr.js"></script>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link rel="shortcut icon" href="../img/favicon.ico" />
	</head>
	<body>

		<!-- Menu -->
		<div class="contain-to-grid sticky">
			<nav class="top-bar" data-topbar data-options="sticky: on_large" role="navigation">
				<ul class="title-area">
					<li class="name"><h1><a href="#"><strong>MY</strong></a></h1></li>
					<li class="toggle-topbar icon-menu"><a href=""><i class="fa fa-navicon"></i></a></li>
				</ul>
				<section class="top-bar-section">
					<ul class="left">
						<li><a href="../view/adm.php">Usuários</a></li>
						<li class="has-dropdown">
						<a href="#">Clientes</a>
						<ul class="dropdown">
							<li><a href="../view/pesquisar_cliente.php">Procurar cliente</a></li>
						</ul>
						<li class="has-dropdown active">
						<a href="#">Cadastrar</a>
						<ul class="dropdown">
							<li><a href="../view/incluir.php">Cadastrar usuário</a></li>
							<li class="active"><a href="../view/incluir-cliente.php">Cadastrar cliente</a></li>
						</ul>
						<li class="has-dropdown">
							<a href="#">Ocorrência</a>
							<ul class="dropdown">
								<li><a href="../view/ver_ocorrencias.php">Ver ocorrências</a></li>
								<li><a href="../view/registrar_ocorrencia.php">Registrar ocorrência</a></li>
							</ul>
						</li>
					</ul>
					<ul class="right">
						<li><a href="?logout=ok">Sair</a></li>
					</ul>
				</section>
			</nav>
		</div>
		<!-- Fim menu -->
		
		<?php 
			$dado = $n->find($nid); 
		
			if (!empty($dado)):
				foreach ($dado as $info):
		?>
		
		<!-- Topo do usuário -->
		<div class="row" style="margin-top: 3%;">
			<div class="small-12 small-centered medium-10 medium-centered large-12 large-centered xlarge-12 xlarge-centered columns">
				<div class="panel radius" style="background: transparent;">
					<p class="text-center" style="color: #fff; font-size: 20px; padding: 40px;"><i class="fa fa-user"></i> Conectado: <?php echo $info->nome; ?><br/>
					<i class="fa fa-calendar-o"></i> Data: <?php echo $data.' '.$hora; ?></p>
				</div>
			</div>
		</div>
		<!-- Fim topo do usuário -->
		
		<?php endforeach; endif;		
			if (isset($_POST['cadastrar'])):
				$cliente  = $_POST['cli_nome'];
				$result = $n->findEmpresa($cliente);

				if (isset($result)):
					$i = count($result);
				endif;

				if ($i == 1):
					echo '<meta charset="utf-8"/><script>alert("Esta empresa já está cadastrada."); location.href="../view/incluir-cliente.php";</script>';
				else:
					$nome	 = $_POST['cli_nome'];
					$empresa = $_POST['cli_empresa'];
					$email 	 = $_POST['cli_email'];
					$tel 	 = $_POST['cli_tel'];

					if (!$n->ins_cliente()):
						echo '<meta charset="utf-8"/><script>alert("Não foi possível realizar o cadastro.");.location.href="../view/incluir-cliente.php";</script>';
					else:
						echo '<meta charset="utf-8"/><script>alert("Cliente cadastrado com êxito."); location.href="../view/incluir-cliente.php";</script>';
					endif;
				endif;
			endif;
		?>
		
		<div class="row radius">
			<div class="small-12 small-centered medium-12 medium-centered large-12 large-centered columns">
				<div class="panel radius" style="background: #999;">
					<h4 style=" color: #fff;"><i class="fa fa-user-plus"></i> Cadastrar cliente</h4><br/>
					<form data-abide role="form" action="" method="post">
						<div class="name-field">
							<label for="nome">Nome do Cliente:<br/></label>
							<input type="text" name="cli_nome" autofocus required>
							<small class="error">Nome obrigatório</small>
						</div>
						<div class="name=field">
							<label for="empresa">Nome da Empresa:<br/></label>
							<input type="text" name="cli_empresa" required>
							<small class="error">Nome da empresa obrigatório</small>
						</div>
						<div class="name-field">
							<label for="email">E-mail:<br/></label>
							<input type="email" name="cli_email" required>
							<small class="error">E-mail obrigatório</small>
						</div>
						<div class="name-field">
							<label for="login">Tel. Contato:<br/></label>
							<input type="text" name="cli_tel" required>
							<small class="error">Telefone obrigatório</small>
						</div>
						<button type="submit" class="button radius small success expand" name="cadastrar" onclick="return confirm('Finalizar cadastro?')"><i class="fa fa-check"></i> Cadastrar</button>
					</form>
				</div>
			</div>
		</div>
	
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