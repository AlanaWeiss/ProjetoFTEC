<?php
if (isset($_POST['mensagem'])) {
  echo '<script>alert("' . $_POST['mensagem'] . '");</script>';
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/login.css">
  <link rel="stylesheet" href="../../css/geral.css">
  <title>Login</title>
</head>

<body>
  <main class="loginForm">
    <img id="logo" src="../../css/assets/research.svg" alt="Lampada " />
    <h2>Entre na sua conta</h2>
    <form action="/php/validar_login.php" method="post">
      <label for="nome">Usuário:</label>
      <input type="text" id="nome" name="nome" required></input>
      <label for="senha">Senha:</label>
      <input type="password" id="senha" name="senha" required></input><br>
      <input type="submit" value="Entrar"></input>
    </form>
    </div>
</body>

</html>