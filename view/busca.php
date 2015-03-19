<?php

	if (isset($_GET["txtNome"])) { 
   
		$nome = $_GET["txtNome"]; 
   
		// Conexao com o banco de dados 

		$server = "localhost"; 
		$user = "root"; 
		$senha = ""; 
		$base = "system";
		
		$conexao = mysql_connect($server, $user, $senha) or die("Erro na conexão ao banco de dados."); 
		mysql_select_db($base); 
   
		// Verifica se a variável está vazia 
   
		if (empty($nome)) { 
			$sql = "SELECT * FROM cliente";
		} else { 
			$nome .= "%";
			$sql = "SELECT * FROM cliente WHERE cli_nome LIKE '$cli_nome'";
		} 
   
		sleep(1); 
   
		$result = mysql_query($sql); 
		$cont = mysql_affected_rows($conexao); 
		// Verifica se a consulta retornou linhas 
		if ($cont > 0) { 
			$dados = mysql_num_rows($result);
			echo '<center><i class="fa fa-check-square" style="color: #0c0"></i> <b>OK!<br/></b>Sua busca retornou <b>'.$dados.'</b> registro(s).</center><br/><br/>'; 
			$tabela = '<thead style="background: #999;">
									<tr>
										<th style="color: #fff;" class="text-center">Cliente</th>
										<th style="color: #fff;" class="text-center">Empresa</th>
										<th style="color: #fff;" class="text-center">E-mail</th>
										<th style="color: #fff;" class="text-center">Telefone</th>
										<th style="color: #fff;" class="text-center">Ações</th>
									</tr>
								<thead>
								<tbody>
									<tr>'; 
			$return = "$tabela"; 
   
			while ($linha = mysql_fetch_array($result)) { 
				$return.= "<td class='text-center'>". utf8_encode($linha["id"]). "</td>"; 
				$return.= "<td class='text-center'>". utf8_encode($linha["nome"]). "</td>"; 				
				$return.= "<td class='text-center'>". utf8_encode($linha["matricula"]). "</td>"; 
				$return.= "<td class='text-center'>". utf8_encode($linha["cpf"]) . "</td>";
				$return.= "<td class='text-center'>". utf8_encode($linha["status"]) . "</td>";
				$return.= "</tr>"; }
				echo $return.="</tbody></table>"; 
		} else {
			echo "<center><i class='fa fa-close' style='color: #ff0000;'> <b>Ops!</b><br/> Nenhum registro encontrado.</font></center><br/><br/>";
		} 
	
	} 
	
?>