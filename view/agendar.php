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
		<title>Agendar</title>
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
						<li><a href="../view/usuario.php">Minha Conta</a></li>
					</ul>
					<ul class="left">
						<li class="active"><a href="../view/agendar.php">Agendar</a></li>
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

		?>
		
		<div class="row">
			<div class="small-12 small-centered medium-10 medium-centered large-12 large-centered columns">
				<div class="panel radius" style="background: #444;">
					<h4 style="color: #fff;"><i class="fa fa-check-square-o"></i> Agendar</h4>
				</div>
			</div>
		</div>
		
		<!-- Painel de agendamento -->
		<div class="row">
			<div class="large-12 medium-10 medium-centered columns">
				<ul class="small-block-grid-1 medium-block-grid-3">
					<li><img class="th radius" src="../img/1.jpg" alt=""/><br/><br/><button class="button expand small radius">Quiosque 1</button></li>
					<li><img class="th radius" src="../img/4.jpg" alt="" /><br/><br/><button class="button expand small radius">Quiosque 2</button></li>
					<li><img class="th radius" src="../img/obras.jpg" alt="" /><br/><br/><button class="button expand alert small radius">Quiosque 3 - Breve</button></li>
					<li><img class="th radius" src="../img/obras.jpg" alt="" /><br/><br/><button class="button expand alert small radius">Quiosque 4 - Breve</button></li>
					<li><img class="th radius" src="../img/obras.jpg" alt="" /><br/><br/><button class="button expand alert small">Quiosque 5 - Breve</button></li>
					<li><img class="th radius" src="../img/obras.jpg" alt="" /><br/><br/><button class="button expand alert small">Quiosque 6 - Breve</button></li>
				</ul>
			</div>
		</div>
		
		<!-- Fim painel de agendamento -->
		
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