<?php include "conexao.php"; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Login - Agenda</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<img src="img/agenda.png" width="140" height="140">
		<h1>Login</h1>
		<br><br><br><br><br>
		<?php
			$msgs = mensagens_status();
			$st = $_GET['status'] ?? '';
			if(isset($msgs[$st])){
				echo '<div class="aviso aviso-' . $msgs[$st][0] . '">' . h($msgs[$st][1]) . '</div>';
			}
		?>
		<form action="validar_login.php" method="post">
			<label for="email">E-mail:</label>	
			<input type="email" id="email" name="email" placeholder="seu@email.com" required>		
			
			<label for="senha">Senha:</label>	
			<input type="password" id="senha" name="senha" placeholder="Sua senha..." required>
			<br>
			<button type="submit" class="btn btn-salvar">Entrar</button>
		</form>
		<br><br>
		
		<a href="cadastro.php" class="btn btn-pesquisar">Criar uma conta</a>
	</div>
</body>
</html>
