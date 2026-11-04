<?php include "conexao.php"; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Agenda</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<h1>Pesquisar Contatos</h1>
		<a href="index.php">Voltar para Agenda</a><br><br>
		<form method="get" action="">
			<input 
				type="text" name="nome" class="campo-pesquisa" 
				placeholder="Digite o nome do contato"
				value="<?php 
					if(isset($_GET['nome'])){
						echo trim($_GET['nome']);
					} else{
						echo '';
					}
				?>">
				<button type="submit">
		</form>
		
	<?php 
	if(isset($_GET['nome'])){
		$nome = trim($_GET['nome']);
		
		$sql = "SELECT * FROM contatos
		WHERE nome LIKE '%$nome%'
		ORDER BY nome";
		
		$resultado = mysqli_query($conexao, $sql);
		$total = mysqli_num_rows($resultado);
	?>
		<div class='total-registros'>Foram encontrados<?php echo $total;?>contato(s)</div>
		
		<?php if($total > 0){ ?>
			<div class="resultados">
				<table>
					<tr>
						<th>Nome</th>
						<th>E-mail</th>
						<th>Telefone</th>
						<th>Cidade</th>
						<th>Estado</th>
					</tr>
					<?php while($contato = mysqli_fetch_assoc($resultado)){ ?>
						<tr>
							<td><?php echo htmlspecialchars($contato['nome']); ?></td>
							<td><?php echo htmlspecialchars($contato['email']); ?></td>
							<td><?php echo htmlspecialchars($contato['telefone']); ?></td>
							<td><?php echo htmlspecialchars($contato['cidade']); ?></td>
							<td><?php echo htmlspecialchars($contato['estado']); ?></td>
						</tr>
					<?php } ?>
				</table>
			</div>
		<?php } else { ?>
			<div class="erro-pesquisa">
				Nenhum contato encontrado.
			</div>
		<?php } ?>
	<?php } ?>
	</div>
</body>
</html>