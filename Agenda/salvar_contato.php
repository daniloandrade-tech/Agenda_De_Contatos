<?php 
session_start();
include "conexao.php";

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: agenda.php");
    exit();
}

$nome = trim($_POST['nome'] ?? '');
$usuario_id = $_SESSION['usuario_id'];
$telefone = somente_digitos($_POST['telefone'] ?? '');

if($nome === '' || $telefone === ''){
    voltar_a_agenda('erro_cadastro');
}

try {
    $stmt = mysqli_prepare($conexao, "INSERT INTO contatos (usuario_id, nome, telefone) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iss", $usuario_id, $nome, $telefone);
    mysqli_stmt_execute($stmt);
} catch (mysqli_sql_exception $e) {
    // Ex.: colunas NOT NULL sem valor padrão, telefone maior que a coluna etc.
    error_log("Erro ao cadastrar: " . $e->getMessage());
    voltar_a_agenda('erro_cadastro');
}

voltar_a_agenda('cadastrado'); // exit() já é chamado dentro da função
?>