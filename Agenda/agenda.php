<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
	header("Location: index.php?status=acesso_negado");
	exit();
}
include "conexao.php";

$usuario_id   = $_SESSION['usuario_id'];
$usuario_nome = $_SESSION['usuario_nome'] ?? 'Usuário';
$stmt_usuario = $conexao->prepare("SELECT foto FROM usuarios WHERE id = ?");
$stmt_usuario->bind_param("i", $usuario_id);
$stmt_usuario->execute();
$usuario_resultado = $stmt_usuario->get_result();
$usuario = $usuario_resultado->fetch_assoc();
$foto_perfil = !empty($usuario['foto']) ? $usuario['foto'] : 'img/agenda.png';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Agenda</title>
	<link rel="stylesheet" href="style.css?v=<?php echo filemtime(__DIR__ . '/style.css'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body class="agenda-body">
	<main class="container agenda-container">
		<header class="agenda-topbar">
			<div class="agenda-identidade">
				<img class="agenda-avatar" src="<?php echo h($foto_perfil); ?>" alt="Foto de <?php echo h($usuario_nome); ?>" width="52" height="52">
				<div>
					<p class="agenda-sauda">Bem-vindo(a),</p>
					<p class="agenda-usuario"><?php echo h($usuario_nome); ?></p>
				</div>
			</div>
			<nav class="agenda-navegacao" aria-label="Navegação da conta">
				<a href="perfil.php" class="btn agenda-btn-perfil">Meu Perfil</a>
				<a href="logout.php" class="btn agenda-btn-sair">Sair</a>
			</nav>
		</header>

		<section class="agenda-intro">
			<div>
				<h1>Agenda de Contatos</h1>
				<p>Organize seus contatos em um só lugar.</p>
			</div>
		</section>

		<?php
			$msgs = mensagens_status();
			$st = $_GET['status'] ?? '';
			if (isset($msgs[$st])) {
				echo '<div class="aviso aviso-' . $msgs[$st][0] . '">' . h($msgs[$st][1]) . '</div>';
			}
		?>

		<section class="agenda-cadastro">
			<h2>Novo contato</h2>
			<form action="salvar_contato.php" method="post" class="agenda-form">
				<div class="agenda-campo">
					<label for="nome">Nome</label>
					<input type="text" id="nome" name="nome" placeholder="Ex.: Maria Silva" required>
				</div>
				<div class="agenda-campo">
					<label for="telefone">Telefone</label>
					<input type="text" id="telefone" name="telefone" placeholder="(00) 00000-0000" required>
				</div>
				<button type="submit" class="btn btn-salvar agenda-btn-cadastrar">Cadastrar contato</button>
			</form>
		</section>

		<section class="agenda-lista">
			<div class="agenda-lista-topo">
				<div>
					<h2>Seus contatos</h2>
					<p>Veja e gerencie seus contatos cadastrados.</p>
				</div>
				<a href="pesquisar.php" class="btn btn-pesquisar">Pesquisar contatos</a>
			</div>

			<div class="agenda-tabela-wrap">
				<table class="agenda-tabela">
					<thead>
						<tr>
							<th class="col-id">ID</th>
							<th>Nome</th>
							<th>Telefone</th>
							<th class="col-acoes">Ações</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$stmt = $conexao->prepare("SELECT * FROM contatos WHERE usuario_id = ? ORDER BY id");
							$stmt->bind_param("i", $usuario_id);
							$stmt->execute();
							$resultado = $stmt->get_result();

							if ($resultado->num_rows > 0) {
								while ($dados = $resultado->fetch_assoc()) {
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
										onsubmit="return confirm('Deseja excluir este contato?')">
										<input type="hidden" name="id" value="<?php echo h($dados['id']); ?>">
										<button type="submit" class="btn-icone" title="Excluir">
											<img src="img/excluir.png" width="24" height="24" alt="Excluir">
										</button>
									</form>
								</div>
							</td>
						</tr>
						<?php
								}
							} else {
						?>
						<tr>
							<td colspan="4" class="agenda-vazio">Nenhum contato cadastrado ainda.</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</section>
	</main>

	<script src="https://unpkg.com/imask@7.6.1/dist/imask.min.js"></script>
	<script>
		IMask(document.getElementById('telefone'), {
			mask: [{ mask: '(00) 0000-0000' }, { mask: '(00) 00000-0000' }]
		});
	</script>
</body>
</html>
