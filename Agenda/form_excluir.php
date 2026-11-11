<?php
include "conexao.php";

// Exclusão só por POST: um link (GET) pode ser disparado por robôs ou pré-carregamento
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: index.php");
    exit();
}

$id = (int)($_POST['id'] ?? 0);

if($id <= 0){
    voltar_ao_index('nao_encontrado');
}

try {
    $stmt = mysqli_prepare($conexao, "DELETE FROM contatos WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
} catch (mysqli_sql_exception $e) {
    error_log("Erro ao excluir: " . $e->getMessage());
    voltar_ao_index('erro_excluir');
}

voltar_ao_index(mysqli_stmt_affected_rows($stmt) > 0 ? 'excluido' : 'nao_encontrado');
?>
