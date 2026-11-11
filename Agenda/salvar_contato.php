<?php 
include "conexao.php";

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: index.php");
    exit();
}

$nome = trim($_POST['nome'] ?? '');
$telefone = somente_digitos($_POST['telefone'] ?? '');

if($nome === '' || $telefone === ''){
    voltar_ao_index('erro_cadastro');
}

try {
    $stmt = mysqli_prepare($conexao, "INSERT INTO contatos (nome, telefone) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $nome, $telefone);
    mysqli_stmt_execute($stmt);
} catch (mysqli_sql_exception $e) {
    // Ex.: colunas NOT NULL sem valor padrão, telefone maior que a coluna etc.
    error_log("Erro ao cadastrar: " . $e->getMessage());
    voltar_ao_index('erro_cadastro');
}

voltar_ao_index('cadastrado'); // exit() já é chamado dentro da função
?>
