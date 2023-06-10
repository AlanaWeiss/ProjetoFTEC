<?php

			include('../php/conexao.php');  

			$nome_professor=$_POST['btn_delete'];




			$stmt = $pdo->prepare("DELETE FROM usuarios WHERE nome='$nome_professor'");
			$stmt->execute();
			$professores = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			
			header('location: ../html/admin/lista_professores.php');

?>