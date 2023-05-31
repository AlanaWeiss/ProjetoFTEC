<?php
include('conexao.php');
$materia = $_GET['materia'];

$stmt = $pdo->prepare("SELECT * FROM conteudos WHERE materia = :materia");
$stmt->bindParam(':materia', $materia);
$stmt->execute();

?>