<?php
include "conexao.php";

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: index.php");
    exit();
}

$id = (int)($_POST['id'] ?? 0);
$nome = trim($_POST['nome'] ?? '');
$telefone = somente_digitos($_POST['telefone'] ?? '');

if($id <= 0 || $nome === '' || $telefone === ''){
    voltar_ao_index('erro_atualizar');
}

try {
    $stmt = mysqli_prepare($conexao, "UPDATE contatos SET nome = ?, telefone = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssi", $nome, $telefone, $id);
    mysqli_stmt_execute($stmt);
} catch (mysqli_sql_exception $e) {
    error_log("Erro ao atualizar: " . $e->getMessage());
    voltar_ao_index('erro_atualizar');
}

// affected_rows = 0 também ocorre quando nada mudou, então confirma se o ID existe
$check = mysqli_prepare($conexao, "SELECT id FROM contatos WHERE id = ?");
mysqli_stmt_bind_param($check, "i", $id);
mysqli_stmt_execute($check);
mysqli_stmt_store_result($check);

voltar_ao_index(mysqli_stmt_num_rows($check) > 0 ? 'atualizado' : 'nao_encontrado');
?>
