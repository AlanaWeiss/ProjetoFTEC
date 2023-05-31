<?php
include_once('./conexao.php');

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$tipo = $_POST['tipo'];

$stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo)
                       VALUES (:nome, :email, :senha, :tipo)");

$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':senha', $senha);
$stmt->bindParam(':tipo', $tipo);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $mensagem = "Registro inserido com sucesso.";
} else {
    $mensagem = "Erro ao inserir o registro: " . $stmt->errorInfo()[2];
}

echo '<form id="redirect-form" method="POST" action="/../html/admin/">';
echo '<input type="hidden" name="mensagem" value="' . $mensagem . '">';
echo '</form>';
echo '<script>document.getElementById("redirect-form").submit();</script>';
?>