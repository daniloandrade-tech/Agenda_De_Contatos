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
		<br><br><br><br><br>
		<?php
			$msgs = mensagens_status();
			$st = $_GET['status'] ?? '';
			if(isset($msgs[$st])){
				echo '<div class="aviso aviso-' . $msgs[$st][0] . '">' . h($msgs[$st][1]) . '</div>';
			}
		?>
		<form action="salvar_contato.php" method="post">
			<label for="nome">Nome:</label>	
			<input type="text" id="nome" name="nome" placeholder="Nome ..." required>		
			<label for="telefone">Telefone:</label>	
			<input type="text" id="telefone" name="telefone" placeholder="(00) 00000-0000" required>
			<BR>
			<button type="submit" class="btn btn-salvar">Cadastrar</button>
		</form>
		<br><br>
		
		<a href="pesquisar.php" class="btn btn-pesquisar">Pesquisar Contatos</a>
		
		<br><br>
		<table>
		<tr>
			<th class="col-id">ID</th>
			<th>Nome</th>
			<th>Telefone</th>
			<th class="col-acoes">Ações</th>
		</tr>
		<?php
			$sql = "SELECT * FROM contatos ORDER BY id";
			$resultado = mysqli_query($conexao, $sql);
			while($dados = mysqli_fetch_assoc($resultado)){
		?>
		<tr>
			<td class="col-id"><?php echo h($dados['id']); ?></td>
			<td><?php echo h($dados['nome']); ?></td>
			<td><?php echo h(formatar_telefone($dados['telefone'])); ?></td>
			<td class="col-acoes">
				<div class="acoes">
					<a href="form_editar.php?id=<?php echo h($dados['id']); ?>" title="Editar">
						<img src="img/edit.png" width="24" height="24" alt="Editar">
					</a>
					<form action="form_excluir.php" method="post" class="form-excluir"
					onsubmit="return confirm('Deseja excluir?')">
						<input type="hidden" name="id" value="<?php echo h($dados['id']); ?>">
						<button type="submit" class="btn-icone" title="Excluir">
							<img src="img/excluir.png" width="24" height="24" alt="Excluir">
						</button>
					</form>
				</div>
			</td>
			
		</tr>
		<?php }?>
		</table>
	</div>

	<script src="https://unpkg.com/imask@7.6.1/dist/imask.min.js"></script>
	<script>
		IMask(document.getElementById('telefone'), {
			mask: [{ mask: '(00) 0000-0000' }, { mask: '(00) 00000-0000' }]
		});
	</script>
</body>
</html>
