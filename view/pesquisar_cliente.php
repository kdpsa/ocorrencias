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
		<title>Pesquisar cliente</title>
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
						<li class="has-dropdown active">
						<a href="#">Clientes</a>
						<ul class="dropdown">
							<li class="active"><a href="../view/pesquisar_cliente.php">Procurar cliente</a></li>
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
			if (!empty($dado)):
				foreach ($dado as $info):
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

		<?php endforeach; endif; 
		
			if (isset($_GET['action']) && $_GET['action'] == 'delete'):
				$nid = (int)$_GET['id'];
				$n->deleteCliente($nid);
				echo '<script>alert("Cliente deletado com sucesso."); location.href="../view/pesquisar_cliente.php";</script>';
			endif;
			
			if (isset($_POST['atualizar'])):
				$nid    = (int)$_GET['id'];				
				$nome	 = $_POST['cli_nome'];
				$empresa = $_POST['cli_empresa'];
				$email 	 = $_POST['cli_email'];
				$tel 	 = $_POST['cli_tel'];

				$n->updateCliente($nid);
				echo "<meta charset='utf-8'/><script>alert('Informações atualizadas com sucesso.'); document.location='../view/pesquisar_cliente.php';</script>";
			endif;

			if (isset($_GET['action']) && $_GET['action'] == 'update'):

				$nid = (int)$_GET['id'];
				$rs = $n->buscaCliente($nid);
		?>

		<!-- form de atualização dos dados do usuário -->
		<div class="row radius">
			<div class="small-12 small-centered medium-10 medium-centered large-12 large-centered columns">
				<div class="panel radius" style="background: #999;">
					<h4 style=" color: #fff;"><i class="fa fa-pencil-square"></i> Atualizar</h4><br/>
					<form action="" method="post">
						<label for="nome">Nome: <br/></label>
						<input type="text" name="cli_nome" value="<?php echo $rs->cli_nome ?>">
						<label for="area">Empresa: <br/></label>
						<input type="text" name="cli_empresa" value="<?php echo $rs->cli_empresa ?>">
						<label for="ramal">E-mail: <br/></label>
						<input type="text" name="cli_email" value="<?php echo $rs->cli_email ?>">
						<label for="Usuário">Telefone: <br/></label>
						<input type="text" name="cli_tel" value="<?php echo $rs->cli_tel ?>">
						<br/><button type="submit" class="button radius small success expand" name="atualizar"  onclick="return confirm('Concluir as alterações?')"><i class="fa fa-check-square-o"></i> Atualizar</button>
					</form>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<!-- fim do form de atualização -->

		<!-- Painel de pesquisa -->
        <div class="row radius">
			<div class="small-12 small-centered medium-10 medium-centered large-12 large-centered columns">
				<div class="panel radius" style="background: #999;">
					<h4 class="text-center" style="color: #fff;"><i class="fa fa-search"></i> Pesquisar cliente</h4><br/>
					<form data-abide role="form" action="<?php $_SERVER['PHP_SELF']?>" method="post">
						<div class="row radius">
							<div class="small-12 small-centered medium-10 medium-centered large-8 large-centered columns">
								<div class="large-12 large-centered columns">
									<div class="name-field">
										<input type="text" name="nome" placeholder="Informe o nome da empresa" autofocus />
										<!--<small class="error">Informe um nome para realizar a pesquisa</small>-->
										<input type="submit" role="button" title="Clique para pesquisar" aria-label="submit form" class="button radius primary small expand" name="pesquisar" value="Pesquisar" /><br/>
									</div>
								</div>
							</div>
						</div>        
					</form>
				</div>
			</div>

			<!-- Resultado da busca -->
			<div class="row-fluid" style="margin-top: 1%;">
				<div class="small-12 small-centered medium-10 medium-centered large-12 large-centered xlarge-12 columns">
					<div class="panel radius" style="background: #999; color: #fff;">
						<h4 style="color: #fff;"><i class="fa fa-th-list"></i> Resultado da busca</h4>
					</div>
					<table role="grid" class="radius small-12 small-centered medium-12 medium-centered large-12 large-centered columns">
						<thead style="background: #999;">
							<tr>
								<th style="color: #fff;" class="text-center">Cliente</th>
								<th style="color: #fff;" class="text-center">Empresa</th>
								<th style="color: #fff;" class="text-center hide-for-small">E-mail</th>
								<th style="color: #fff;" class="text-center">Telefone</th>
								<th style="color: #fff;" class="text-center hide-for-small">Alterar</th>
								<th style="color: #fff;" class="text-center hide-for-small">Excluir</th>
							</tr>
						</thead>
						<?php if(isset($_POST['pesquisar'])){
						
							$nome = strip_tags(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_MAGIC_QUOTES));
							$param   = array(':nome'=>$nome.'%');

							try{
							
								$pdo = new PDO("mysql:host=localhost; dbname=system","root","");
								$sql = $pdo->prepare('SELECT * FROM cliente WHERE cli_empresa LIKE :nome ORDER BY cli_empresa ASC');
								$sql->execute($param);
								$resultado = $sql->fetchAll(PDO::FETCH_OBJ);
								
							}catch(PDOException $e){
								echo 'Erro: '.$e->getMessage();
							} 
						
							if($resultado):
					
								$cont = $sql->rowCount($resultado);
								
								if($cont == 1):
									echo '<p class="text-center" style="color: #fff"><i class="fa fa-check-square" style="color: #0c0;"></i> <b>OK!</b><br/>Sua busca retornou <b>1</b> registro.</p>';
								else:
									echo '<p class="text-center" style="color: #fff"><i class="fa fa-check-square" style="color: #0c0;"></i> <b>OK!</b><br/>Sua busca retornou <b>'.$cont.'</b> registros.</p>';
								endif;
								
								foreach($resultado as $res):
									echo '<tbody>';
									echo '<tr>';
									echo '<td class=""';
									echo '<td class="text-center">'.$res->cli_nome.'</td>';
									echo '<td class="text-center">'.utf8_encode($res->cli_empresa).'</td>';
									echo '<td class="text-center hide-for-small">'.$res->cli_email.'</td>';
									echo '<td class="text-center">'.$res->cli_tel.'</td>';
									echo "<td class=\"text-center hide-for-small\"><a href='?action=update&id=". $res->cli_id . "'onclick='return confirm(\"Atualizar os dados do cliente?\")'><i class=\"fa fa-pencil-square fa-2x\" style=\"color: #3498db\" title=\"Alterar\"></i></a></td>";
									echo "<td class=\"text-center hide-for-small\"><a href='?action=delete&id=". $res->cli_id . "'onclick='return confirm(\"Deseja remover o cliente?\")'><i class=\"fa fa-minus-square fa-2x\" style=\"color: #c0392b\" title=\"Excluir\"></i></a></td>";
								endforeach;
							else:
								echo "<p class='text-center' style='color: #fff'><i class='fa fa-minus-square' style='color: #ff0000;'></i> <b>Ops!</b><br/>Nenhum resultado.</p>";
							endif;
						
						} ?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- Fim resultado da busca -->
		</div>
		<!-- Fim painel de pesquisa -->

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