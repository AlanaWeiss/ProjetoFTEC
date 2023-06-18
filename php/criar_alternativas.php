<?php
include_once 'conexao.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

try {
    $queryAlt1 = "INSERT INTO alternativa (descricao, idPergunta) VALUES (:descricao, :idPergunta)";
    $cad_alt1 = $pdo->prepare($queryAlt1);
    $cad_alt1->bindParam(':descricao', $dados['alternativa_1']);
    $cad_alt1->bindParam(':idPergunta', $dados['pergunta']);

    $cad_alt1->execute();
    $alt1Id = $pdo->lastInsertId();

    $queryAlt2 = "INSERT INTO alternativa (descricao, idPergunta) VALUES (:descricao, :idPergunta)";
    $cad_alt2 = $pdo->prepare($queryAlt2);
    $cad_alt2->bindParam(':descricao', $dados['alternativa_2']);
    $cad_alt2->bindParam(':idPergunta', $dados['pergunta']);

    $cad_alt2->execute();
    $alt2Id = $pdo->lastInsertId();


    $queryAlt3 = "INSERT INTO alternativa (descricao, idPergunta) VALUES (:descricao, :idPergunta)";
    $cad_alt3 = $pdo->prepare($queryAlt3);
    $cad_alt3->bindParam(':descricao', $dados['alternativa_3']);
    $cad_alt3->bindParam(':idPergunta', $dados['pergunta']);

    $cad_alt3->execute();
    $alt3Id = $pdo->lastInsertId();


    $queryCorreta = "INSERT INTO alternativaPergunta (idAlternativa, idPergunta) VALUES (:idAlternativa, :idPergunta)";
    $cad_correta = $pdo->prepare($queryCorreta);
    $cad_correta->bindParam(':idPergunta', $dados['pergunta']);

    switch ($dados['correta']) {
        case 1:
            $cad_correta->bindParam(':idAlternativa', $alt1Id);
        case 2:
            $cad_correta->bindParam(':descricao', $alt2Id);
            break;
        case 3:
            $cad_correta->bindParam(':descricao', $alt3Id);
            break;
        default:
            break;
    }
    $cad_correta->execute();
    $corretaId = $pdo->lastInsertId();



    if ($alt1Id && $alt2Id && $alt3Id) {
        $retorna = ['erro' => false, 'msg' => 'Cadastrado com sucesso.'];
    } else {
        $retorna = ['erro' => true, 'msg' => 'Erro!'];
    }

    echo json_encode($retorna);
} catch (PDOException $e) {
    echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
    exit();
}
