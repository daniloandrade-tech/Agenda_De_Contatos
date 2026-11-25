<?php
include "conexao.php";

try{
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $conexao->prepare($sql);

        $stmt->execute([
            $nome,
            $email,
            $senha_hash
        ]);

        header("Location: index.php?status=cadastrado");
        exit();
    }
} catch(PDOException $e) {
    if($e->getCode() == 23000) { 
        header("Location: index.php?status=erro_cadastro");
    } else {
        header("Location: index.php?status=erro_cadastro");
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Cadastro - Agenda</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<img src="img/agenda.png" width="140" height="140">
		<h1>Criar Conta</h1>
		<br><br><br><br><br>
		<?php
			$msgs = mensagens_status();
			$st = $_GET['status'] ?? '';
			if(isset($msgs[$st])){
				echo '<div class="aviso aviso-' . $msgs[$st][0] . '">' . h($msgs[$st][1]) . '</div>';
			}
		?>
		<form action="cadastro.php" method="post">
			<label for="nome">Nome:</label>	
			<input type="text" id="nome" name="nome" placeholder="Seu nome..." required>		

			<label for="email">E-mail:</label>	
			<input type="email" id="email" name="email" placeholder="seu@email.com" required>		
			
			<label for="senha">Senha:</label>	
			<input type="password" id="senha" name="senha" placeholder="Crie uma senha..." required>
			<br>
			<button type="submit" class="btn btn-salvar">Cadastrar</button>
		</form>
		<br><br>
		
		<a href="agenda.php" class="btn btn-pesquisar">Já tenho conta (Login)</a>
	</div>
</body>
</html>