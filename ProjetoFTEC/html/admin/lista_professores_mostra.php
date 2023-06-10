<?php

			include('../php/conexao.php');  

			$nome_professor=$_POST['btn_editar'];

			$stmt = $pdo->prepare("UPDATE FROM usuarios WHERE nome='$nome_professor'");
			$stmt->execute();
			$professores = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			header('location: ../html/admin');

?>