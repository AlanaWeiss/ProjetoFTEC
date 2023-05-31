<?php
session_start();
include_once('./conexao.php');

$titulo = $_POST['titulo'];
$conteudo = $_POST['conteudo'];
$nome = $_SESSION['usuario'];
$materia = $_POST['materia'];

$stmt = $pdo->prepare("INSERT INTO conteudos (titulo, conteudo, nome, materia)
                       VALUES (:titulo, :conteudo, :nome, :materia)");
$stmt->bindParam(':titulo', $titulo);
$stmt->bindParam(':conteudo', $conteudo);
$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':materia', $materia);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $mensagem = "Conteudo criado com sucesso.";
} else {
    $mensagem = "Erro ao criar conteudo: " . $stmt->errorInfo()[2];
}

echo '<form id="redirect-form" method="POST" action="/html/prof/">';
echo '<input type="hidden" name="mensagem" value="' . $mensagem . '">';
echo '</form>';
echo '<script>document.getElementById("redirect-form").submit();</script>';
?>