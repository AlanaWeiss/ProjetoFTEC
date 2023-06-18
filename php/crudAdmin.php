<?php
// session_start();
include('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["atualizar"])) {
        $id = $_POST["atualizar"];
        atualizarCadastro($id);
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    }

    if (isset($_POST["excluir"])) {
        $id = $_POST["excluir"];
        excluirCadastro($id);
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    }

    if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['tipo'])) {
        cadastroUsuarioNovo($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['tipo']);
    }
}

function getUsers()
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM usuarios');
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $users;
}

function getTipos()
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM tipos');
    $stmt->execute();
    $tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $tipos;
}

function cadastroUsuarioNovo($nome, $email, $senha, $tipo)
{
    global $pdo;

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];
    $defaultImagePath = 'smile.png';
    $fotoData = file_get_contents($defaultImagePath);
    $fotoBase64 = base64_encode($fotoData);

    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo, foto)
                       VALUES (:nome, :email, :senha, :tipo, :foto)");

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':foto', $fotoBase64);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $mensagem = "Registro inserido com sucesso.";
    } else {
        $mensagem = "Erro ao inserir o registro: " . $stmt->errorInfo()[2];
    }

    echo '<script>alert("' . $mensagem . '"); window.location.href = "../../html/admin/";</script>';
    exit();
}

function excluirCadastro($id)
{
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM usuarios WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function atualizarCadastro($id)
{
    global $pdo;
    $nome = $_POST["nome"];
    $senha = $_POST["senha"];
    $email = $_POST["email"];
    $tipo = $_POST["tipo"];
    $imagemBase64 = $_POST['novaImagem'];

    $stmt = $pdo->prepare("UPDATE usuarios SET foto = :foto WHERE nome = :usuario");
    $stmt->bindParam(':usuario', $_SESSION['usuario']);
    $stmt->bindValue(':foto', $imagemBase64);
    $stmt->execute();

    if($senha != '******'){

        // $stmt = $pdo->prepare("UPDATE usuarios SET nome = :nome, senha = :senha, email = :email, tipo = :tipo, foto = :foto WHERE id = :id");
        $stmt = $pdo->prepare("UPDATE usuarios SET nome = :nome, senha = :senha, email = :email, tipo = :tipo WHERE id = :id");
        
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':tipo', $tipo);
    // $stmt->bindParam(':foto', $imagemBase64);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}
else{
    $stmt = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, tipo = :tipo WHERE id = :id");
        
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':tipo', $tipo);
    // $stmt->bindParam(':foto', $imagemBase64);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

    if ($stmt->rowCount() > 0) {
        $mensagem = "Registro atualizado com sucesso.";
    } else {
        $mensagem = "Erro ao atualizar o registro: " . $stmt->errorInfo()[2];
    }

    echo '<script>alert("' . $mensagem . '"); window.location.href = "../../html/admin/";</script>';
    exit();
}


?>