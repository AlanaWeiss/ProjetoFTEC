<?php
include('conexao.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $respostas = $_POST;

    
  $questoesCorretas = -1;

   
foreach ($respostas as $perguntaId => $respostaId) {
          $questoesCorretas++;
     }
 

    
echo "Você acertou " . $questoesCorretas . " questões.";
}


function verificarRespostaCorreta($perguntaId, $respostaId) {
     $stmt = $pdo->prepare("SELECT alternativa FROM idPergunta WHERE : id ");
     $stmt->bindValue(': id', $perguntaId);
     $stmt->execute();
     $respostaCorreta = $stmt->fetchColumn();
     return $respostaId == $respostaCorreta;
}
?>
<br>
<a href="../html/aluno/index.php">VOLTAR</a>