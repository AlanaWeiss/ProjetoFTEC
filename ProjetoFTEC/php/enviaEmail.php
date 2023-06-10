<?php
session_start();
include('./conexao.php');

$stmt = $pdo->prepare('SELECT email FROM usuarios WHERE nome = :usuario');
$stmt->bindValue(':usuario', $_SESSION['usuario']);
$stmt->execute();
$aluno = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT email FROM usuarios WHERE nome = :prof');
$stmt->bindValue(':prof', $_POST['prof']);
$stmt->execute();
$professor = $stmt->fetchAll(PDO::FETCH_ASSOC);

$nome = $_SESSION['usuario'];
$email = $aluno[0]['email'];
$mensagem = $_POST['mensagem'];

$remetente = "noreply@ananique.kinghost.net";
$destinatario = $professor[0]['email'];
$replyTo = $remetente;
$assunto = "Contato Plataforma SPEC";

$conteudo = "Nome = $nome \n";
$conteudo .= "Email = {$aluno[0]['email']} \n";
$conteudo .= "Mensagem = $mensagem \n";

$headers = implode(
    "\n",
    array(
        "From: $remetente",
        "Reply-To: $replyTo",
        "Return-Path: $remetente",
        "MIME-Version: 1.0",
        "X-Priority: 3",
        "Content-Type: text/html; charset=UTF-8"
    )
);
$enviaEmail = mail($professor[0]['email'], $assunto, nl2br($conteudo), $headers);

//Enviando o email 
if ($enviaEmail) {
    $mensagem = "E-Mail enviado com sucesso!";
} else {
    $mensagem = "Falha no envio do E-Mail!";
}

echo '<form id="redirect-form" method="POST" action="/../html/aluno/">';
echo '<input type="hidden" name="mensagem" value="' . $mensagem . '">';
echo '</form>';
echo '<script>document.getElementById("redirect-form").submit();</script>';
?>