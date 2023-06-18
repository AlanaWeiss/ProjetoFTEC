<?php
include('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    if (isset($_POST['criar_questionario'])) {
        $materia = $_POST['materia'];
        $titulo = $_POST['titulo'];
        $id = postQuestionario($materia, $titulo);

        return $id;
    }
}

function postQuestionario($materia, $titulo) 
{
    global $pdo;
    
    if (isset($pdo) && !empty($pdo)) {
        $stmt = $pdo->prepare('INSERT INTO questionario (descricao, materia) VALUES (:titulo, :materia)');
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':materia', $materia);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $mensagem = "Registro inserido com sucesso.";
        } else {
            $mensagem = "Erro ao inserir o registro: " . $stmt->errorInfo()[2];
        }

        $id = $pdo->lastInsertId();

        return $id;
    } else {
        echo "Erro ao conectar ao banco de dados.";
    }
}
