<?php
include('/conexao.php');

$stmt = $pdo->prepare('SELECT materia FROM conteudos');
$stmt->execute();
$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
