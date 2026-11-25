<?php
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: index.php?status=acesso_negado");
        exit();
    }
include "conexao.php";

    $usuario_id   = $_SESSION['usuario_id'];
    $stmt = $conexao->prepare("SELECT nome, email, foto FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    if (!$usuario) {
        header("Location: logout.php");
        exit();
    }

    $foto = !empty($usuario['foto']) ? $usuario['foto'] : 'img/agenda.png';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Meu Perfil - Agenda</title>
	<link rel="stylesheet" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div class="container perfil-container">
		<div class="perfil-cabecalho">
			<img class="foto-perfil" id="foto-perfil" src="<?php echo h($foto); ?>" alt="Foto do perfil" width="72" height="72">
			<div>
				<h1>Meu Perfil</h1>
				<p><?php echo h($usuario['nome']); ?></p>
			</div>
		</div>

		<?php
			$msgs = mensagens_status();
			$st = $_GET['status'] ?? '';
			if(isset($msgs[$st])){
				echo '<div class="aviso aviso-' . $msgs[$st][0] . '">' . h($msgs[$st][1]) . '</div>';
			}
		?>

		<form action="atualizar_perfil.php" method="post" enctype="multipart/form-data">
			<label for="nome">Nome:</label>
			<input type="text" id="nome" name="nome" value="<?php echo h($usuario['nome']); ?>" maxlength="100" required>

			<label for="email">E-mail:</label>
			<div class="campo-email">
				<input type="email" id="email" name="email" value="<?php echo h($usuario['email']); ?>" disabled>
				<input type="hidden" id="editar_email" name="editar_email" value="0">
				<button type="button" class="btn btn-pesquisar" id="botao-editar-email" aria-controls="email">Editar e-mail</button>
			</div>

			<label for="foto">Foto de perfil:</label>
			<input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/gif,image/webp">
			<small>JPG, PNG, GIF ou WebP. Tamanho máximo: 5 MB.</small>

			<label for="nova_senha">Nova Senha (deixe em branco para não alterar):</label>
			<input type="password" id="nova_senha" name="nova_senha" placeholder="Digite apenas se quiser trocar">

			<div class="acoes-perfil">
				<button type="submit" class="btn btn-salvar">Salvar Alterações</button>
				<a href="agenda.php" class="btn btn-pesquisar">Voltar para Agenda</a>
				<a href="logout.php" class="btn btn-pesquisar">Sair da Conta</a>
			</div>
		</form>
	</div>
	<script>
		const email = document.getElementById('email');
		const editarEmail = document.getElementById('editar_email');
		const botaoEditarEmail = document.getElementById('botao-editar-email');
		const foto = document.getElementById('foto');
		const fotoPerfil = document.getElementById('foto-perfil');
		const fotoOriginal = fotoPerfil.src;

		botaoEditarEmail.addEventListener('click', () => {
			email.disabled = false;
			editarEmail.value = '1';
			botaoEditarEmail.hidden = true;
			email.focus();
		});

		foto.addEventListener('change', () => {
			const arquivo = foto.files[0];
			if (arquivo) {
				fotoPerfil.src = URL.createObjectURL(arquivo);
			} else {
				fotoPerfil.src = fotoOriginal;
			}
		});
	</script>
</body>
</html>