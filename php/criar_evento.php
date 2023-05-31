<?php
session_start();
include_once('./conexao.php');

date_default_timezone_set('America/Sao_Paulo');
$data_atual = strtotime(date('Y-m-d'));

$data = $_POST['dataDoEvento'];
$titulo = $_POST['tituloDoEvento'];
$descricao = $_POST['descricaoDoEvento'];
$criado_por = $_SESSION['usuario'];

if (empty($data) || empty($titulo) || empty($descricao) || empty($criado_por)) {
    $mensagem = "Por favor, preencha todos os campos.";
}

list($ano, $mes, $dia) = explode('-', $data);

if (strtotime($data) <= $data_atual) {
    $mensagem = "A data do evento deve ser maior ou igual à data atual.";
}else{
    $stmt = $pdo->prepare('INSERT INTO eventos (ano, mes, dia, titulo, descricao, criado_por)
                           VALUES (:ano, :mes, :dia, :titulo, :descricao, :criado_por)');
    $stmt->bindParam(':ano', $ano);
    $stmt->bindParam(':mes', $mes);
    $stmt->bindParam(':dia', $dia);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':criado_por', $criado_por);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $mensagem = "Evento criado com sucesso.";
    } else {
        $mensagem = "Erro ao criar evento: " . $stmt->errorInfo()[2];
    }
}


echo '<form id="redirect-form" method="POST" action="/html/prof/">';
echo '<input type="hidden" name="mensagem" value="' . $mensagem . '">';
echo '</form>';
echo '<script>document.getElementById("redirect-form").submit();</script>';
?>
