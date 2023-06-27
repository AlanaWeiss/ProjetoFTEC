<?php
session_start();
if (isset($_POST['mensagem'])) {
  echo '<script>alert("' . $_POST['mensagem'] . ' ");</script>';
}
include('../../php/conexao.php');
include('../../php/crudAdmin.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="../../css/admin.css">
  <link rel="stylesheet" href="../../css/geral.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>
    <?php echo $_SESSION['usuario']; ?>
  </title>
</head>

<body>
  <header>
    <div id="sessao-usuario">
      <img class="logo-header" id="logo" src="../../css/assets/research.svg" alt="Lampada" />
      <form action="/php/logout.php" method="post">
        <input type="submit" class="logout-bt" value="Logout">
      </form>
    </div>
  </header>

  <main class="form">
    <span class="span-title">
      <?php echo 'Bem-vindo, ' . $_SESSION['usuario'] . '!'; ?>
    </span>

    <h2>Cadastro de Usuário</h2>
    <form method="post" action="../../php/crudAdmin.php">
      <label for="nome">Nome:</label>
      <input type="text" id="nome" name="nome" required><br><br>
      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" required><br><br>
      <label for="senha">Senha:</label>
      <input type="password" id="senha" name="senha" required><br><br>
      <label for="tipo">Tipo:</label>
      <input type="radio" id="aluno" name="tipo" value="aluno" checked>
      <label for="aluno">Aluno</label>
      <input type="radio" id="administrador" name="tipo" value="administrador">
      <label for="administrador">Administrador</label>
      <input type="radio" id="professor" name="tipo" value="professor">
      <label for="professor">Professor</label><br><br>
      <input type="submit" value="Cadastrar" class="btnCadastro">
    </form>
  </main>

  <!-- Tabela de usuários -->
  <div class="listaUsuarios">
    <h2>Usuários</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
      <table>
        <tr class="cabecalho">
          <th>ID</th>
          <th>Nome</th>
          <th>Senha</th>
          <th>Email</th>
          <th>Tipo</th>
          <th>Foto</th>
          <th>Ações</th>
        </tr>

        <?php
        $users = getUsers();
        $tipos = getTipos();

        if (!empty($users)) {
          foreach ($users as $user) {
            echo '<tr id="row-' . $user["id"] . '">';
            //id
            echo '<td>' . $user["id"] . '</td>';
            //nome
            echo '<td><input type="text" value="' . $user["nome"] . '" name="nome" disabled></td>';
            //password
            echo '<td><input type="password" value="******" name="senha" disabled></td>';
            //email
            echo '<td><input type="text" value="' . $user["email"] . '" name="email" disabled></td>';
            //tipo
            echo '<td><select class="opcao" name="tipo" id="tipo" disabled>';
            foreach ($tipos as $tipo) {
              $selected = ($user["tipo"] === $tipo["tipo"]) ? "selected" : "";
              echo '<option value="' . $tipo["tipo"] . '" ' . $selected . '>' . $tipo["tipo"] . '</option>';
            }
            echo '</select></td>';
            //foto
            echo '<td>';
            echo '<div class="divAvatar">';
            // echo '<input type="file" name="avatar" style="display:none">';
            echo '<img class="avatar" src="data:image/png;base64,' . $user["foto"] . '" alt="Avatar" data-user-id="' . $user["id"] . '">';
            echo '</div>';
            echo '</td>';
            //ações
            echo '<td class="acoes">';
            echo '<div>';
            echo '<button class="btnAcoes btn-editar" onclick="habilitarEdicao(event, ' . $user["id"] . ')">Editar</button>';
            echo '<button type="submit" name="atualizar" value="' . $user["id"] . '" class="btnAcoes btn-atualizar" onclick="confirmarAtualizacao()" disabled>Atualizar</button>';
            echo '<button type="submit" name="excluir" value="' . $user["id"] . '" class="btnAcoes btn-excluir" onclick="confirmarExclusao()" disabled>Excluir</button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
          }
        } else {
          echo '<tr><td colspan="5">Nenhum usuário encontrado.</td></tr>';
        }
        ?>
      </table>
    </form>
  </div>
  <script src="../../js/crudAdmin.js"></script>
  <!-- <script src="../../js/avatar.js"></script> -->
</body>
</html>