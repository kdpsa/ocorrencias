<?php

	require_once '../controller/Crud.php';
	require_once '../controller/Database.php';
	
	$n = new Crud();

	if (isset($_POST['cadastrar'])):
		$login  = $_POST['login'];
		$result = $n->findLogin($login);

		if (isset($result)):
			$i = count($result);
		endif;

		if ($i == 1):
			echo '<meta charset="utf-8"/><script>alert("Este login já está em uso."); location.href="../view/cadastro.php";</script>';
		else:
			$nome   = $_POST['nome'];
			$area	= $_POST['area'];
			$ramal	= $_POST['ramal'];
			$login  = $_POST['login'];
			$senha  = sha1($_POST['senha']);
			$nivel  = $_POST['nivel'];

			if (!$n->inserir()):
				echo '<meta charset="utf-8"/><script>alert("Não foi possível realizar o cadastro.");.location.href="../view/cadastro.php";</script>';
			else:
				echo '<meta charset="utf-8"/><script>alert("Cadastrado com êxito."); location.href="../index.php";</script>';
			endif;
		endif;
	endif;

?>
<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="pt-BR" > <![endif]-->
<html class="no-js" lang="pt-BR" >
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Cadastro</title>
		<link rel="stylesheet" href="../css/normalize.css">
		<link rel="stylesheet" href="../css/foundation.css">
		<link rel="stylesheet" href="../css/app.css">
		<link rel="stylesheet" href="../css/login.css">
		<script src="../js/vendor/modernizr.js"></script>
		<link rel="shortcut icon" href="../img/favicon.ico" />
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	</head>
	<body>

		<!-- Div menu-->
		<div class="contain-to-grid sticky">
			<nav class="top-bar" data-topbar data-options="sticky: on_large" role="navigation">
				<ul class="title-area">
					<li class="name"><h1><a href="#"><strong>MY</strong></a></h1></li>
					<li class="toggle-topbar icon-menu"><a href=""><i class="fa fa-navicon"></i></a></li>
				</ul>
				<section class="top-bar-section">
					<ul class="right">
						<li><a href="../index.php">Acesso</a></li>
						<li class="active"><a href="#">Cadastro</a></li>
					</ul>
				</section>
			</nav>
		</div>
		<!-- Fim div menu -->
		
		<div class="row" style="margin-top: 5%;">
			<form data-abide role="form" action="" method="post">
				<div class="row collapse"><br/>
					<div class="small-12 small-centered medium-6 medium-centered large-5 large-centered columns">
						<div class="form_login">
							<div class="panel clearfix">
								<h3 class="text-left" style="color: #fff; margin-left: 1em; font-size: 22px;"><br/><i class="fa fa-user-plus"></i> Cadastro</h3>
								<div class="large-12 large-centered columns"><hr/>
									<div class="name-field">
										<input type="text" name="nome" placeholder="Nome" autofocus required>
										<small class="error">Nome obrigatório</small>
									</div>
									<div class="name-field">
										<input type="text" name="area" placeholder="Departamento" autofocus required>
										<small class="error">Área obrigatório</small>
									</div>
									<div class="name-field">
										<input type="text" name="ramal" placeholder="Ramal" required>
										<small class="error">Informe um ramal</small>
									</div>
									<div class="name-field">
										<input type="text" name="login" placeholder="Usuário" maxlength="7" required />
										<small class="error">Insira a matrícula</small>
									</div>
									<div class="password-field">
										<input type="password" name="senha" placeholder="Senha" required />
										<small class="error">Insira a senha</small>
									</div>
									<input type="hidden" name="nivel" value="1" />
									<input type="submit" role="button" aria-label="submit form" class="button radius small expand" name="cadastrar" value="Cadastrar" />
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	
		<script src="../js/vendor/jquery.js"></script>
		<script src="../js/foundation.min.js"></script>
		<script> $(document).foundation(); </script>
		
	</body>
</html>