<?php 
include "conexao.php";

$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$endereco = $_POST['endereco'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];

$sql = "INSERT INTO contatos
(nome, email, telefone, endereco, cidade, estado) VALUES ('$nome', '$email', '$telefone', '$endereco', '$cidade', '$estado')";

if (mysqli_query($conexao, $sql)) {
    header("Location: index.php");
    exit(); // É indispensável usar exit() após o header de redirecionamento
} else {
    echo "Erro ao cadastrar: " . mysqli_error($conexao);
}
?>

