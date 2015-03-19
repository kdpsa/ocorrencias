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
		$nid	   = $_SESSION['id'];
		$nome  = $_SESSION['nome'];
		$login = $_SESSION['login'];
		$senha = $_SESSION['senha'];
		$nivel = $_SESSION['nivel'];
	
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
		<title>Ver Ocorrências</title>
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
								<li ><a href="../view/registrar_ocorrencia.php">Registrar ocorrência</a></li>
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
		
		<?php $dado = $n->find($nid); if (!empty($dado)) :
				foreach ($dado as $info): ?>

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
		
		<?php endforeach; endif; 
			if (isset($_GET['action']) && $_GET['action'] == 'delete'):
				$nid = (int)$_GET['id'];
				$n->deletaOcorrencia($id);
				echo '<script>alert("Ocorrência deletada com sucesso."); location.href="../view/ver_ocorrencias.php";</script>';
			endif; 
			
			if (isset($_GET['action']) && $_GET['action'] == 'view'):
				$id = (int)$_GET['ocorrencia_id'];
				header("Location: ../view/visualizar.php?id=".$id);
			endif; ?>

		<!-- Tabela de ocorrências -->
		<div class="row radius">
			<div class="small-12 small-centered medium-10 medium-centered large-12 large-centered xlarge-12 columns">
				<div class="panel radius" style=" background: #999;">
					<h4 style="color: #fff"><i class="fa fa-navicon"></i> Ocorrências</h4>
				</div>
					<?php $data = $n->buscaOcorrencia(); if (!empty($data)): ?>
				<table role="grid" class="radius small-12 small-centered medium-12 medium-centered large-12 large-centered columns">
					<thead style="background: #999;">
						<tr>
							<th style="color: #fff;" class="text-left">Cliente</th>
							<th style="color: #fff;" class="text-left">Solic.</th>
							<th style="color: #fff;" class="text-left hide-for-small">Aberto por</th>
							<th style="color: #fff;" class="text-left hide-for-small">Data de abertura</th>
							<th style="color: #fff;" class="text-left hide-for-small">Categoria</th>
							<th style="color: #fff;" class="text-left">Situação</th>
							<th style="color: #fff;" class="text-center">Ações</th>
						</tr>
					<thead>
					<?php foreach ($data as $result): ?>
					<tbody>
						<tr>
							<td class="text-left"><?php echo $result->cli_empresa; ?></td>
							<td class="text-left"><?php echo ucwords(strtolower($result->cli_nome)); ?></td>
							<td class="text-left hide-for-small"><?php echo $result->usuario; ?></td>
							<td class="text-left hide-for-small"><?php echo date('d/m/Y', strtotime($result->data)).' '.$result->hora; ?></td>
							<td class="text-left hide-for-small"><?php echo $result->cli_categoria; ?></td>
							<td class="text-left">
							<?php if($result->situacao == "Pendente"): ?>
								<n style="color:#c0392b">Pendente</n>
							<?php else: echo $result->situacao; endif; ?>
							</td>
							<td class="text-center">
								<a href="visualizar.php?action=view&id=<?php echo $result->ocorrencia_id; ?>"><i class="fa fa-eye fa-2x" style="color: #3498db" title="Visualizar"></i></a>
								<a href="?action=delete&id=<?php echo $result->ocorrencia_id; ?>" onclick="return confirm('Deletar esta ocorrência?')"><i class="fa fa-minus-square fa-2x" title="Excluir" style="color: #c0392b;"></i></a>
							</td>
						</tr>
					</tbody>
					<?php endforeach; else: ?>
						<div class="panel radius" style="background: #999;">
							<p class="text-center" style="color: #fff;"><i class="fa fa-exclamation-triangle" style="color: #f1c40f"></i> Nenhuma ocorrência.</p>
						</div>
					<?php endif; ?>
				<table>
			</div>
		</div>
		<!-- Fim tabela de ocorrências -->

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