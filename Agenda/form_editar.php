<?php include "conexao.php"; 

$id = $_GET['id'];
$sql = "SELECT * FROM contatos WHERE id='$id'";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Editar</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<img src="img/agenda.png" width="140" height="140">
		<h1>Editar Contatos</h1>
		<form action="atualizar.php" method="post">	
			<input type="id" name="id" value="<?php echo $dados['id']; ?>">
			<input type="text" name="nome"value="<?php echo $dados['nome']; ?>" required>		
			<input type="email" name="email" value="<?php echo $dados['email']; ?>" required>
			<input type="text" name="telefone" value="<?php echo $dados['telefone']; ?>" required>
			<input type="text" name="endereco" value="<?php echo $dados['endereco']; ?>" required>
			<input type="text" name="cidade" value="<?php echo $dados['cidade']; ?>" required>
			<select name="estado" class="select-estado" required>
				<option value="">Selecione o Estado</option>
				<option value="AC" <?php if($dados['estado']=="AC") echo "select"; ?>>AC</option>
				<option value="AL" <?php if($dados['estado']=="AL") echo "select"; ?>>AL</option>
				<option value="AP" <?php if($dados['estado']=="AP") echo "select"; ?>>AP</option>
				<option value="AM" <?php if($dados['estado']=="AM") echo "select"; ?>>AM</option>
				<option value="BA" <?php if($dados['estado']=="BA") echo "select"; ?>>BA</option>
				<option value="CE" <?php if($dados['estado']=="CE") echo "select"; ?>>CE</option>
				<option value="DF" <?php if($dados['estado']=="DF") echo "select"; ?>>DF</option>
				<option value="ES" <?php if($dados['estado']=="ES") echo "select"; ?>>ES</option>
				<option value="GO" <?php if($dados['estado']=="GO") echo "select"; ?>>GO</option>
				<option value="MA" <?php if($dados['estado']=="MA") echo "select"; ?>>MA</option>
				<option value="MT" <?php if($dados['estado']=="MT") echo "select"; ?>>MT</option>
				<option value="MS" <?php if($dados['estado']=="MS") echo "select"; ?>>MS</option>
				<option value="MG" <?php if($dados['estado']=="MG") echo "select"; ?>>MG</option>
				<option value="PA" <?php if($dados['estado']=="PA") echo "select"; ?>>PA</option>
				<option value="PB" <?php if($dados['estado']=="PB") echo "select"; ?>>PB</option>
				<option value="PR" <?php if($dados['estado']=="PR") echo "select"; ?>>PR</option>
				<option value="PE" <?php if($dados['estado']=="PE") echo "select"; ?>>PE</option>
				<option value="PI" <?php if($dados['estado']=="PI") echo "select"; ?>>PI</option>
				<option value="RJ" <?php if($dados['estado']=="RJ") echo "select"; ?>>RJ</option>
				<option value="RN" <?php if($dados['estado']=="RN") echo "select"; ?>>RN</option>
				<option value="RS" <?php if($dados['estado']=="RS") echo "select"; ?>>RS</option>
				<option value="RO" <?php if($dados['estado']=="RO") echo "select"; ?>>RO</option>
				<option value="RR" <?php if($dados['estado']=="RR") echo "select"; ?>>RR</option>
				<option value="SC" <?php if($dados['estado']=="SC") echo "select"; ?>>SC</option>
				<option value="SP" <?php if($dados['estado']=="SP") echo "select"; ?>>SP</option>
				<option value="SE" <?php if($dados['estado']=="SE") echo "select"; ?>>SE</option>
				<option value="TO" <?php if($dados['estado']=="TO") echo "select"; ?>>TO</option>
			</select>
			<BR>
			<button type="submit">Salvar alteração</button>
		</form>
		
	</div>
</body>
</html>