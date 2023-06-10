<?php
include('conexao.php');

$_SESSION['usuario'];

// Verifica se foi enviada uma imagem
if (isset($_POST['imagem'])) {
    $imagemBase64 = $_POST['imagem'];

    // Remove o prefixo "data:image/png;base64,"
    $imagemBase64 = substr($imagemBase64, strpos($imagemBase64, ",") + 1);

    $stmt = $pdo->prepare("UPDATE usuarios SET foto = :foto WHERE nome = :usuario");
    $stmt->bindParam(':usuario', $_SESSION['usuario']);
    $stmt->bindValue(':foto', $imagemBase64);
    $stmt->execute();
}

$stmt = $pdo->prepare("SELECT foto FROM usuarios WHERE nome = :usuario");
$stmt->bindParam(':usuario', $_SESSION['usuario']);
$stmt->execute();
$foto = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>