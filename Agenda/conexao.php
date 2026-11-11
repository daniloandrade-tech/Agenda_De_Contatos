<?php
$conexao = mysqli_connect("localhost", "root", "ceub123456", "agenda");

if(!$conexao){
	die("Erro de conexão");
}
mysqli_set_charset($conexao, "utf8mb4");

// Mensagens exibidas no topo do index (só códigos fixos vão pela URL)
function mensagens_status(){
	return [
		'cadastrado'      => ['ok',   'Contato cadastrado com sucesso.'],
		'atualizado'      => ['ok',   'Contato atualizado com sucesso.'],
		'excluido'        => ['ok',   'Contato excluído com sucesso.'],
		'erro_cadastro'   => ['erro', 'Não foi possível cadastrar o contato.'],
		'erro_atualizar'  => ['erro', 'Não foi possível atualizar o contato.'],
		'erro_excluir'    => ['erro', 'Não foi possível excluir o contato.'],
		'nao_encontrado'  => ['erro', 'Contato não encontrado.'],
	];
}

function voltar_ao_index($status){
	header("Location: index.php?status=" . urlencode($status));
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
