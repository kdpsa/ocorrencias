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
						<li class="active"><a href="../view/adm.php">Usuários</a></li>
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
			if (!empty($dado)) :
				foreach ($dado as $info) {
		?>
		
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
		
		<?php
			} endif;
		
			$data = $n->busca();
			if (isset($_POST['atualizar'])):
				$nid    = (int)$_GET['id'];				
				$nome  = $_POST['nome'];
				$area  = $_POST['area'];
				$ramal = $_POST['ramal'];
				$login = $_POST['login'];
				$senha = $_POST['senha'];
				$nivel = $_POST['nivel'];

				$n->update($nid);
				echo "<meta charset='utf-8'/><script>alert('Informações atualizadas com sucesso.'); document.location='../view/adm.php';</script>";
			endif;
			
			if (isset($_GET['action']) && $_GET['action'] == 'delete'):
				$nid = (int)$_GET['id'];
				$rs = $n->delete($nid);
				echo "<meta charset='utf-8'/><script>alert('Usuário deletado com sucesso.'); document.location='../view/adm.php';</script>";
			endif;

			if (isset($_GET['action']) && $_GET['action'] == 'update'):

				$nid = (int)$_GET['id'];
				$rs = $n->procura($nid);
		?>

		<!-- form de atualização dos dados do usuário -->
		<div class="row radius">
			<div class="small-12 small-centered medium-10 medium-centered large-12 large-centered columns">
				<div class="panel radius" style="background: #999;">
					<h4 style=" color: #fff;"><i class="fa fa-pencil-square"></i> Atualizar</h4><br/>
					<form action="" method="post">
						<label for="nome">Nome: <br/></label>
						<input type="text" name="nome" value="<?php echo $rs->nome ?>">
						<label for="area">Departamento: <br/></label>
						<input type="text" name="area" value="<?php echo $rs->area ?>">
						<label for="ramal">Ramal: <br/></label>
						<input type="text" name="ramal" value="<?php echo $rs->ramal ?>">
						<label for="Usuário">Usuário: <br/></label>
						<input type="text" name="login" value="<?php echo $rs->login ?>">
						<label for="senha">Senha: <br/></label>
						<input type="password" name="senha" value="<?php echo $rs->senha ?>"><br/>
						<h6 style=" color: #fff;"><i class="fa fa-users"></i> Nível</h6>
						<?php if ($rs->nivel == 1): ?>
						<input type="radio" value="1" name="nivel" checked> <n style="color: #fff;">Administrador</n>
						<input type="radio" value="2" name="nivel"> <n style="color: #fff;">Usuário</n>
						<?php else: ?>
						<input type="radio" value="1" name="nivel"> <n style="color: #fff;">Administrador</n>
						<input type="radio" value="2" name="nivel" checked> <n style="color: #fff;">Usuário</n>
						<?php endif; ?>
						<br/><br/><button type="submit" class="button radius small success expand" name="atualizar"  onclick="return confirm('Concluir as alterações?')"><i class="fa fa-check-square"></i> Atualizar</button>
					</form>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<!-- fim do form de atualização -->
		
		<!-- Tabela de usuários -->
		<div class="row radius">
			<div class="small-12 small-centered medium-10 medium-centered large-12 large-centered xlarge-12 columns">
				<div class="panel radius" style=" background: #999;">
					<h4 style="color: #fff"><i class="fa fa-users"></i> Lista de usuários</h4>
				</div>
				<table role="grid" class="radius small-12 small-centered medium-12 medium-centered large-12 large-centered columns">
					<thead style="background: #999;">
						<tr>
							<th style="color: #fff;" class="hide-for-small text-center">#</th>
							<th style="color: #fff;" class="text-justify">Nome</th>
							<th style="color: #fff;" class="text-justify hide-for-small">Departamento</th>
							<th style="color: #fff;" class="text-justify">Login</th>
							<th style="color: #fff;" class="text-justify">Nível</th>
							<th style="color: #fff;" class="text-center">Ações</th>
						</tr>
					<thead>
					<?php
						if (isset($_GET['action']) && $_GET['action'] == 'delete'):
							$nid = (int)$_GET['id'];
							$n->delete($nid);
							echo '<script>alert("Conta de usuário deletada com sucesso."); location.href="../view/adm.php";</script>';
						endif;

						if (isset($_GET['action']) && $_GET['action'] == 'block'):
							$nid = (int)$_GET['id'];
							$n->bloquear($nid);
							echo '<script>alert("Conta de usuário bloqueada com sucesso."); location.href="../view/adm.php";</script>';
						endif;

						if (isset($_GET['action']) && $_GET['action'] == 'accept'):
							$nid = (int)$_GET['id'];
							$n->aprovar($nid);
							echo '<script>alert("Conta de usuário ativada com sucesso."); location.href="../view/adm.php";</script>';
						endif;

						if (!empty($data)):
							foreach ($data as $result):
					?>
					<tbody>
						<tr>
							<td class="text-center hide-for-small"><?php echo $result->id; ?></td>
							<td class="text-justify"><?php echo ucwords(strtolower($result->nome)); ?></td>
							<td class="text-justify hide-for-small"><?php echo ucwords(strtolower($result->area)); ?></td>
							<td class="text-justify"><?php echo $result->login; ?></td>
							<td class="text-justify">
								<?php if($result->nivel == 1): $st = "Admin";
									  else: $st = "Usuário"; endif;
								      echo $st; ?>
							</td>
							<td class="text-center">
								<a href="?action=update&id=<?php echo $result->id; ?>"><i class="fa fa-pencil-square fa-2x" style="color: #3498db" title="Editar"></i></a>
								<a href="?action=delete&id=<?php echo $result->id; ?>" onclick="return confirm('Deseja deletar?')"><i class="fa fa-minus-square fa-2x" title="Excluir" style="color: #c0392b;"></i></a>
							</td>
						</tr>
					</tbody>
					<?php endforeach; endif; ?>
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