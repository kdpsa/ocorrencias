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
		$nivel = $_SESSION['nivel'];
	
		$n = new Crud();
		$data = $n->mostraData();
		$hora = $n->mostraHora();

		if (isset($_GET['action']) && $_GET['action'] == 'view'):
			$id = (int)$_GET['id'];
		endif;
?>

<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="pt-BR" > <![endif]-->
<html class="no-js" lang="pt-BR" >
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Visualizar ocorrência</title>
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
						<li class="has-dropdown">
						<a href="#">Cadastrar</a>
						<ul class="dropdown">
							<li><a href="../view/incluir.php">Cadastrar usuário</a></li>
							<li><a href="../view/incluir-cliente.php">Cadastrar cliente</a></li>
						</ul>
						<li class="has-dropdown active">
							<a href="#">Ocorrência</a>
							<ul class="dropdown">
								<li class="active"><a href="../view/ver_ocorrencias.php">Ver ocorrências</a></li>
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
			if (!empty($dado)) :
				foreach ($dado as $info) { ?>

		<!-- Topo do usuário -->
		<div class="row" style="margin-top: 3%;">
			<div class="small-12 small-centered medium-10 medium-centered large-12 large-centered xlarge-12 xlarge-centered columns">
				<div class="panel radius" style="background: transparent;">
					<p class="text-center" style="color: #fff; font-size: 20px; padding: 40px;"><i class="fa fa-user"></i> Conectado: <?php echo ucwords(strtolower($info->nome)); ?><br/>
					<i class="fa fa-calendar-o"></i> Data: <?php echo $data.' '.$hora; ?></p>
				</div>
			</div>
		</div>
		<!-- Fim topo do usuário -->
		
		<?php } endif; 
			$re = $n->findOcorrencia($id);
			if(!empty($re)):
				foreach($re as $set):
				$dma = $set->data;
				$dma = implode("/",array_reverse(explode("-",$dma)));?>		
		<div class="row radius">
			<div class="small-12 small-centered medium-10 medium-centered large-12 large-centered columns">
				<div class="panel radius" style="background: #999;">
					<h4 style=" color: #fff;"><i class="fa fa-eye"></i> Visualizar Ocorrência</h4><br/>
					<div class="panel radius" style="background: #333">
						<p class="text-left" style="color: #fff;"><i class="fa fa-calendar-o"></i> Data de abertura: <?php echo $dma.' '.$set->hora; ?><br/><i class="fa fa-user"></i> Usuário: <?php echo $set->usuario; ?><br/>
						<i class="fa fa-arrow-right"></i> Num. ocorrência: <?php echo $set->ocorrencia_id; ?>
					</div>
					<p class="text-left" style="color: #fff">Solicitante: <?php echo ucwords(strtolower($set->cli_nome)) ?><br/>
					Empresa: <?php echo $set->cli_empresa; ?><br/>
					Situação: <?php echo $set->situacao; ?><br/>
					Categoria: <?php echo $set->cli_categoria; ?><br/>
					Ocorrência: <?php echo $set->cli_ocorrencia; ?></p>
				</div>
			</div>
		</div>
		<?php endforeach; endif; ?>

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