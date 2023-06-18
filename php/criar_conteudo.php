<?php
session_start();
include_once('./conexao.php');

$titulo = $_POST['titulo'];
$conteudo = $_POST['conteudo'];
$nome = $_SESSION['usuario'];
$materia = $_POST['materia'];
$sucesso = 0;

$stmt = $pdo->prepare("INSERT INTO conteudos (titulo, conteudo, nome, materia)
                       VALUES (:titulo, :conteudo, :nome, :materia)");
$stmt->bindParam(':titulo', $titulo);
$stmt->bindParam(':conteudo', $conteudo);
$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':materia', $materia);
$stmt->execute();

if ($stmt->rowCount() > 0) {

    $stmt = $pdo->prepare('SELECT email FROM usuarios WHERE tipo = "aluno"');
    $stmt->execute();
    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($alunos);

    $mensagem = $_POST['mensagem'];
    $remetente = "noreply@ananique.kinghost.net";
    $replyTo = $remetente;
    $assunto = "Novo Conteudo Cadastrado em " . $materia;

    $corpo = "Novo conteúdo cadastrado na plataforma. \n";
    $corpo .= "O conteúdo foi cadastrado pelo professor(a) " . $nome . ", com o nome de " . $titulo . ".\n";
    $corpo .= "\n";
    $corpo .= "Não deixe de conferir o novo conteúdo para continuar aprimorando seus conhecimentos";

    $headers = implode(
        "\r\n",
        array(
            "From: $remetente",
            "Reply-To: $replyTo",
            "Return-Path: $remetente",
            "MIME-Version: 1.0",
            "X-Priority: 3",
            "Content-Type: text/html; charset=UTF-8"
        )
    );

    foreach ($alunos as $aluno) {
        $destinatario = $aluno['email'];
        $enviaEmail = mail($destinatario, $assunto, nl2br($corpo), $headers);
    }


    // Enviando o email
    if ($enviaEmail) {
        $mensagem = "Conteudo criado com sucesso.";
        $mensagem .= "\nE-Mail enviado com sucesso!";
    } else {
        $mensagem = "Conteudo criado com sucesso";
        $mensagem .= "\r\n";
        $mensagem .= "\nFalha no envio do E-Mail!";
    }
} else {
    $mensagem = "Erro ao criar conteudo: " . $stmt->errorInfo()[2];
    $mensagem .= "\nFalha no envio do E-Mail!";
}

echo '<form id="redirect-form" method="POST" action="/html/prof/">';
echo '<input type="hidden" name="mensagem" value="' . $mensagem . '">';
echo '</form>';
echo '<script>document.getElementById("redirect-form").submit();</script>';
?>