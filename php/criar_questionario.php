<?php
include_once 'conexao.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$query = "INSERT INTO questionario (descricao, materia) VALUES (:descricao, :materia)";
$cad_quest = $pdo->prepare($query);
$cad_quest->bindParam(':descricao', $dados['titulo']);
$cad_quest->bindParam(':materia', $dados['materia']);

$cad_quest->execute();
$lastId = $pdo->lastInsertId();

if ($cad_quest->rowCount()) {
    $retorna = ['erro' => false, 'msg' => 'Cadastrado com sucesso.', 'id' => $lastId];
} else {
    $retorna = ['erro' => true, 'msg' => 'Erro!'];
}

echo json_encode($retorna);