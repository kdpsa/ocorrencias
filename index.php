<?php

	session_start();
	
	require_once 'controller/login.php';
	require_once 'controller/Database.php';
	
	if(!isset($_POST['ok'])):
	
		$login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_MAGIC_QUOTES);
		$senha = sha1(filter_input(INPUT_POST, "senha", FILTER_SANITIZE_MAGIC_QUOTES));
		
		$n = new login();
		$n->setLogin($login);
		$n->setSenha($senha);
		
		$n->logar();
		
	endif;

?>
<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="pt-BR" > <![endif]-->
<html class="no-js" lang="pt-BR" >
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Login</title>
		<link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/foundation.css">
		<link rel="stylesheet" href="css/app.css">
		<link rel="stylesheet" href="css/login.css">
		<script src="js/vendor/modernizr.js"></script>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link rel="shortcut icon" href="img/favicon.ico" />
	</head>
	<body>

		<!-- Div menu-->
		<div class="contain-to-grid sticky">
		
			<nav class="top-bar" data-topbar data-options="sticky: on_large" role="navigation">
				<ul class="title-area">
					<li class="name"><h1><a href="#"><strong>MY v0.3</strong></a></h1></li>
					<li class="toggle-topbar icon-menu"><a href=""><i class="fa fa-navicon"></i></a></li>
				</ul>
			
				<section class="top-bar-section">
					<ul class="right">
						<li class="active"><a href="#">Acesso</a></li>
						<li><a href="view/cadastro.php">Cadastro</a></li>
					</ul>
				</section>
			
			</nav>
			
		</div>
		<!-- Fim div menu -->
		
		<div class="row" style="margin-top: 5%">
			<form data-abide role="form" action="" method="post">
				<div class="row collapse"><br/>
					<div class="small-12 small-centered medium-6 medium-centered large-5 large-centered columns">
						<div class="form_login">
							<div class="panel clearfix">
								<h3 class="text-left" style="color: #fff; margin-left: 1em; font-size: 22px;"><br/><i class="fa fa-lock"></i> Acesso restrito</h3>
								<div class="large-12 large-centered columns"><hr/>
									<div class="name-field">
										<input type="text" name="login" placeholder="Usuário" maxlength="7" autofocus required />
										<small class="error">Insira o usuário</small>
									</div>
									<div class="password-field">
										<input type="password" name="senha" placeholder="Senha" required />
										<small class="error">Insira a senha</small>
									</div>
									<input type="submit" role="button" aria-label="submit form"  class="button radius small expand" value="Entrar" />
									<!--<p class="text-center" style="color: #003780">Esqueceu sua senha? <i class="fa fa-hand-o-right"></i> Recuperar</p>-->
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	
		<script src="js/vendor/jquery.js"></script>
		<script src="js/foundation.min.js"></script>
		<script> $(document).foundation(); </script>
		
	</body>
</html>