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
		<img src="img/agenda.png" width="140" height="140">
		<h1>Agenda de Contatos</h1>
		<form action="salvar_contato.php" method="post">	
			<input type="text" name="nome" placeholder="Nome" required>		
			<input type="email" name="email" placeholder="E-mail" required>
			<input type="text" name="telefone" placeholder="Telefone" required>
			<input type="text" name="endereco" placeholder="Endereço" required>
			<input type="text" name="cidade" placeholder="Cidade" required>
			<select name="estado" class="select-estado" required>
				<option value="">Selecione o Estado</option>
				<option value="AC">AC</option>
				<option value="AL">AL</option>
				<option value="AP">AP</option>
				<option value="AM">AM</option>
				<option value="BA">BA</option>
				<option value="CE">CE</option>
				<option value="DF">DF</option>
				<option value="ES">ES</option>
				<option value="GO">GO</option>
				<option value="MA">MA</option>
				<option value="MT">MT</option>
				<option value="MS">MS</option>
				<option value="MG">MG</option>
				<option value="PA">PA</option>
				<option value="PB">PB</option>
				<option value="PR">PR</option>
				<option value="PE">PE</option>
				<option value="PI">PI</option>
				<option value="RJ">RJ</option>
				<option value="RN">RN</option>
				<option value="RS">RS</option>
				<option value="RO">RO</option>
				<option value="RR">RR</option>
				<option value="SC">SC</option>
				<option value="SP">SP</option>
				<option value="SE">SE</option>
				<option value="TO">TO</option>
			</select>
			<BR>
			<button type="submit">Cadastra</button>
		</form>
		<br><br>
		
		<a href="pesquisar.php" class="btn-pesquisar">Pesquisar Contatos</a>
		
		<br><br>
		<table>
		<tr>
			<th>Nome</th>
			<th>E-mail</th>
			<th>Telefone</th>
			<th>Cidade</th>
			<th>Estado</th>
			<th>Ações</th>
		</tr>
		<?php
			$sql = "SELECT * FROM contatos ORDER BY nome";
			$resultado = mysqli_query($conexao, $sql);
			while($dados = mysqli_fetch_assoc($resultado)){
		?>
		<tr>
			<td><?php echo $dados['nome']; ?></td>
			<td><?php echo $dados['email']; ?></td>
			<td><?php echo $dados['telefone']; ?></td>
			<td><?php echo $dados['cidade']; ?></td>
			<td><?php echo $dados['estado']; ?></td>
			<td>
				<a href="form_editar.php?id=<?php echo $dados['id'];?>">
					<img src="img/edit.png" width="30" height="30"> 
				</a>
				<a onclick="return confirm ('Deseja excluir?')"
				href="form_excluir.php?id=<?php echo $dados['id']; ?>">
					<img src="img/excluir.png" width="30" height="30">
				</a>
			</td>
			
		</tr>
		<?php }?>
		</table>
	</div>
</body>
</html>