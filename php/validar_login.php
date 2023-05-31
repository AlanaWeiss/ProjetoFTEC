<?php
include_once('./conexao.php');

$nome = strtolower($_POST['nome']);
$senha = $_POST['senha'];

$stmt = $pdo->prepare('SELECT * FROM usuarios WHERE LOWER(nome) = :nome AND senha = :senha');
$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':senha', $senha);

$stmt->execute();

$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($usuarios == null) {
    $mensagem = "Usuario nao encontrado: " . $stmt->errorInfo()[2];
} else {
    session_start();
    $_SESSION['usuario'] = $usuarios[0]['nome'];
    if ($usuarios[0]['tipo'] == 'administrador') {
        header('Location: /../../html/admin');
    }
    if ($usuarios[0]['tipo'] == 'professor') {
        header('Location: /../../html/prof');
    }
    if ($usuarios[0]['tipo'] == 'aluno') {
        header('Location: /../../html/aluno');
    }
}

echo '<form id="redirect-form" method="POST" action="/../html/login/">';
echo '<input type="hidden" name="mensagem" value="' . $mensagem . '">';
echo '</form>';
echo '<script>document.getElementById("redirect-form").submit();</script>';
?>
