<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php?status=acesso_negado");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: perfil.php");
    exit();
}

include "conexao.php";

$usuario_id = (int)$_SESSION['usuario_id'];
$nome = trim($_POST['nome'] ?? '');

if (!preg_match('/\A.{1,100}\z/us', $nome)) {
    header("Location: perfil.php?status=perfil_erro");
    exit();
}

$stmt = $conexao->prepare("SELECT email, senha, foto FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$usuario_resultado = $stmt->get_result();
$usuario = $usuario_resultado->fetch_assoc();

if (!$usuario) {
    header("Location: logout.php");
    exit();
}

$email = $usuario['email'];
if (($_POST['editar_email'] ?? '0') === '1') {
    $email = trim($_POST['email'] ?? '');
    if (strlen($email) > 254 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: perfil.php?status=perfil_email_invalido");
        exit();
    }

    $stmt_email = $conexao->prepare("SELECT id FROM usuarios WHERE email = ? AND id <> ?");
    $stmt_email->bind_param("si", $email, $usuario_id);
    $stmt_email->execute();
    $email_resultado = $stmt_email->get_result();
    if ($email_resultado->fetch_assoc()) {
        header("Location: perfil.php?status=perfil_email_existente");
        exit();
    }
}

$foto = $usuario['foto'] ?? '';
$arquivo_novo = '';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
    $arquivo = $_FILES['foto'];
    $extensoes_por_mime = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
    ];

    if ($arquivo['error'] !== UPLOAD_ERR_OK || $arquivo['size'] > 5 * 1024 * 1024 || !is_uploaded_file($arquivo['tmp_name'])) {
        header("Location: perfil.php?status=perfil_imagem_invalida");
        exit();
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = $finfo ? finfo_file($finfo, $arquivo['tmp_name']) : false;
    if ($finfo) {
        finfo_close($finfo);
    }

    if (!isset($extensoes_por_mime[$mime])) {
        header("Location: perfil.php?status=perfil_imagem_invalida");
        exit();
    }

    $pasta_uploads = __DIR__ . DIRECTORY_SEPARATOR . 'uploads';
    if (!is_dir($pasta_uploads) && !mkdir($pasta_uploads, 0755, true)) {
        error_log("Não foi possível criar a pasta de fotos de perfil.");
        header("Location: perfil.php?status=perfil_erro");
        exit();
    }

    $nome_arquivo = 'perfil_' . $usuario_id . '_' . bin2hex(random_bytes(16)) . '.' . $extensoes_por_mime[$mime];
    $arquivo_novo = $pasta_uploads . DIRECTORY_SEPARATOR . $nome_arquivo;
    if (!move_uploaded_file($arquivo['tmp_name'], $arquivo_novo)) {
        error_log("Não foi possível salvar a foto de perfil do usuário " . $usuario_id . ".");
        header("Location: perfil.php?status=perfil_erro");
        exit();
    }

    $foto = 'uploads/' . $nome_arquivo;
}

$senha = $usuario['senha'];
$nova_senha = $_POST['nova_senha'] ?? '';
if ($nova_senha !== '') {
    $senha = password_hash($nova_senha, PASSWORD_DEFAULT);
}

try {
    $stmt_atualizar = $conexao->prepare("UPDATE usuarios SET nome = ?, email = ?, senha = ?, foto = ? WHERE id = ?");
    $stmt_atualizar->bind_param("ssssi", $nome, $email, $senha, $foto, $usuario_id);
    $stmt_atualizar->execute();
} catch (mysqli_sql_exception $e) {
    if ($arquivo_novo !== '' && is_file($arquivo_novo)) {
        unlink($arquivo_novo);
    }

    if ($e->getCode() == 1062 && (($_POST['editar_email'] ?? '0') === '1')) {
        header("Location: perfil.php?status=perfil_email_existente");
        exit();
    }

    error_log("Erro ao atualizar perfil do usuário " . $usuario_id . ": " . $e->getMessage());
    header("Location: perfil.php?status=perfil_erro");
    exit();
}

$foto_anterior = $usuario['foto'] ?? '';
if ($foto_anterior !== '' && $foto_anterior !== $foto && preg_match('/\Auploads\/perfil_' . $usuario_id . '_[a-f0-9]{32}\.(jpg|png|gif|webp)\z/i', $foto_anterior)) {
    $arquivo_anterior = __DIR__ . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $foto_anterior);
    if (is_file($arquivo_anterior)) {
        unlink($arquivo_anterior);
    }
}

$_SESSION['usuario_nome'] = $nome;
$_SESSION['usuario_foto'] = $foto;
header("Location: perfil.php?status=perfil_atualizado");
exit();
?>
