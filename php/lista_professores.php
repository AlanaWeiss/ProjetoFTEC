<?php

include('./conexao.php');



$stmt = $pdo->prepare("SELECT nome FROM usuarios WHERE tipo = 'professor'");

$stmt->execute();

$professores = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>