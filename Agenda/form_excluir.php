<?php
session_start();
include "conexao.php";

$usuario_id = $_SESSION['usuario_id'];


// Exclusão só por POST: um link (GET) pode ser disparado por robôs ou pré-carregamento
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: agenda.php");
    exit();
}

$id = (int)($_POST['id'] ?? 0);

if($id <= 0){
    voltar_a_agenda('nao_encontrado');
}

try {
    $stmt = mysqli_prepare($conexao, "DELETE FROM contatos WHERE id = ? AND usuario_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $id, $usuario_id);
    mysqli_stmt_execute($stmt);
} catch (mysqli_sql_exception $e) {
    error_log("Erro ao excluir: " . $e->getMessage());
    voltar_a_agenda('erro_excluir');
}

voltar_a_agenda(mysqli_stmt_affected_rows($stmt) > 0 ? 'excluido' : 'nao_encontrado');
?>