<?php include "conexao.php"; 

$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conexao, "SELECT id, nome, telefone FROM contatos WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$dados = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if(!$dados){
	header("Location: index.php");
	exit();
}
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
		<br><br><br><br>
		<form action="atualizar.php" method="post">	
			<label for="id">ID do Contato: </label>
			<!-- Campo desabilitado NÃO é enviado pelo formulário, por isso o ID vai em um campo hidden -->
			<input type="text" id="id" value="<?php echo h($dados['id']); ?>" disabled>
			<input type="hidden" name="id" value="<?php echo h($dados['id']); ?>">
			<label for="nome">Nome: </label>
			<input type="text" id="nome" name="nome" value="<?php echo h($dados['nome']); ?>" required>
			<label for="telefone">Telefone:</label>		
			<input type="text" id="telefone" name="telefone" value="<?php echo h(formatar_telefone($dados['telefone'])); ?>" placeholder="(00) 00000-0000" required>
			<BR>
			
			<div class="grupo-botoes">
				<!-- Botão Salvar (ação principal) -->
				<button type="submit" class="btn btn-salvar">
					Salvar
				</button>

				<!-- Botão Limpar: esvazia Nome e Telefone (o ID não muda) -->
				<button type="button" class="btn btn-limpar" onclick="limparCampos()">
					Limpar
				</button>

				<!-- Botão Voltar (ação de navegação) -->
				<a href="index.php" class="btn btn-voltar">
					Voltar
				</a>
			</div>
		</form>
		
	</div>

	<script src="https://unpkg.com/imask@7.6.1/dist/imask.min.js"></script>
	<script>
		IMask(document.getElementById('telefone'), {
			mask: [{ mask: '(00) 0000-0000' }, { mask: '(00) 00000-0000' }]
		});

		function limparCampos(){
			document.getElementById('nome').value = '';
			var tel = document.getElementById('telefone');
			tel.value = '';
			tel.dispatchEvent(new Event('input')); // atualiza a máscara
			document.getElementById('nome').focus();
		}
	</script>
</body>
</html>
