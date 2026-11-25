<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$config_banco = require __DIR__ . '/config/database.php';

try {
	$conexao = new mysqli(
		$config_banco['host'],
		$config_banco['username'],
		$config_banco['password'],
		$config_banco['database'],
		$config_banco['port']
	);
	$conexao->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
	error_log("Falha na conexão com o banco de dados: " . $e->getMessage());
	http_response_code(500);
	exit("Não foi possível conectar ao banco de dados. Verifique a configuração da hospedagem.");
}

// Mensagens exibidas no topo do index (só códigos fixos vão pela URL)

function mensagens_status(){
	return [
		'cadastrado'       => ['ok',   'Contato cadastrado com sucesso.'],
		'atualizado'       => ['ok',   'Contato atualizado com sucesso.'],
		'excluido'         => ['ok',   'Contato excluído com sucesso.'],
		'erro_cadastro'    => ['erro', 'Não foi possível cadastrar o contato.'],
		'erro_atualizar'   => ['erro', 'Não foi possível atualizar o contato.'],
		'erro_excluir'     => ['erro', 'Não foi possível excluir o contato.'],
		'nao_encontrado'   => ['erro', 'Contato não encontrado.'],
		'usuario_criado'   => ['ok',   'Conta criada com sucesso! Faça seu login.'],
		'email_existente'  => ['erro', 'Este e-mail já está cadastrado.'],
		'login_invalido'   => ['erro', 'E-mail ou senha incorretos.'],
		'acesso_negado'    => ['erro', 'Faça login para acessar a agenda.'],
		'saiu' => ['ok', 'Você saiu da sua conta com segurança.'],
		'perfil_atualizado' => ['ok', 'Perfil atualizado com sucesso.'],
		'perfil_email_existente' => ['erro', 'Este e-mail já está sendo usado por outra conta.'],
		'perfil_email_invalido' => ['erro', 'Informe um e-mail válido para alterá-lo.'],
		'perfil_imagem_invalida' => ['erro', 'Envie uma imagem JPG, PNG, GIF ou WebP de até 5 MB.'],
		'perfil_erro' => ['erro', 'Não foi possível atualizar o perfil. Tente novamente.'],
	];
}

function voltar_a_agenda($status){
	header("Location: agenda.php?status=" . urlencode($status));
	exit();
}

// Escapa texto para exibir com segurança no HTML
function h($texto){
	return htmlspecialchars((string)$texto, ENT_QUOTES, 'UTF-8');
}

// Mantém só os dígitos do telefone (a máscara é apenas visual)
function somente_digitos($texto){
	return preg_replace('/\D+/', '', (string)$texto);
}

// Exibe o telefone formatado: (00) 00000-0000 ou (00) 0000-0000
function formatar_telefone($telefone){
	$d = somente_digitos($telefone);
	if(strlen($d) == 11){
		return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $d);
	}
	if(strlen($d) == 10){
		return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $d);
	}
	return $telefone;
}
?>