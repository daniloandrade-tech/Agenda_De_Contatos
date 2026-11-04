<?php
include "conexao.php";

$id= $_POST['id'];

$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$endereco = $_POST['endereco'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];

$sql = "UPDATE contatos SET

nome='$nome',
email='$email',
telefone='$telefone',
endereco='$endereco',
cidade='$cidade',
estado='$estado'

WHERE id='$id'"; 

mysqli_query($conexao,$sql);

header("Location: index.php");
?>