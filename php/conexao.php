<?php
$db_file = __DIR__ . './../data/FTEC.sqlite';

// Verifica se o arquivo do banco de dados já existe
if (!file_exists($db_file)) {
    // Cria o banco de dados
    try {
        $pdo = new PDO("sqlite:$db_file");
    } catch (PDOException $e) {
        echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
        exit();
    }

    // Inclui o script de criação do banco de dados
    // include('./cria_banco.php');
} else {
    // Se o arquivo do banco de dados já existe, apenas conecta ao banco
    try {
        $pdo = new PDO("sqlite:$db_file");
    } catch (PDOException $e) {
        echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
        exit();
    }
}

?>
