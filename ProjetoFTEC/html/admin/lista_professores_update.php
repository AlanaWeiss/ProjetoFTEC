<?php

			include('../../php/conexao.php');
            $nome_professor=$_POST['btn_editar'];
            var_dump($nome_professor);

            $nome = $_POST['nome'];
	        $email = $_POST['email'];
	        $senha = $_POST['senha'];

            
            $stmt = $pdo->prepare("UPDATE usuarios SET  nome = '$nome', email = '$email', senha = '$senha'  WHERE nome='$nome_professor'");
            
            $stmt->execute();
           
            $professores = $stmt->fetchAll(PDO::FETCH_ASSOC);


            header('location: lista_professores.php');
?>




