<?php
include('../../php/conexao.php');
session_start();

//lista materias com conteudo cadastrado
$stmt = $pdo->prepare('SELECT DISTINCT materia FROM conteudos');
$stmt->execute();
$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

//lista professores para email
$stmt = $pdo->prepare("SELECT nome FROM usuarios WHERE tipo = 'professor'");
$stmt->execute();
$professores = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['materia'])) {
    include('../../php/lista_conteudo.php');
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../../css/aluno.css">
    <link rel="stylesheet" href="../../css/geral.css">
    <link rel="stylesheet" href="../../css/textEditor.css">


    <title>
        <?php echo $_SESSION['usuario']; ?>
    </title>
</head>

<body>
    <header>
        <div id="sessao-usuario">
            <h1>
                <?php echo 'Bem-vindo, ' . $_SESSION['usuario'] . '!'; ?>
            </h1>
            <form action="/php/busca.php" method="post" class="barra-pesquisa">
                <input type="text" name="search" placeholder="Digite sua pesquisa...">
                <button type="submit" class="buscaConteudo btn-search"><i class="material-icons">search</i></button>
            </form>

            <form action="/php/logout.php" method="post">
                <input type="submit" class="logout-bt" value="Logout">
            </form>
        </div>
    </header>

    <section class="listaConteudos">
        <form action="#" method="GET">
            <select name="materia" id="materia">
                <?php foreach ($materias as $materia): ?>
                    <option value="<?php echo $materia['materia']; ?>"><?php echo $materia['materia']; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Buscar" class="buscaConteudo">
            <br>
            <button type="button" id="limpar" class="buscaConteudo">Limpar</button>
        </form>

        <?php
        if (isset($_GET['materia'])) {
            $materia = $_GET['materia'];
            $stmt = $pdo->prepare("SELECT * FROM conteudos WHERE materia = :materia");
            $stmt->bindParam(':materia', $materia);
            $stmt->execute();

            while ($conteudos = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<h3>' . $conteudos['titulo'] . '</h3>';
                echo '<p>Professor: ' . $conteudos['nome'] . ' | ' . $conteudos['materia'] . '</p>';
                echo '<p>Descrição: ' . $conteudos['conteudo'] . '</p>';
                echo '<hr>';
            }
        } else {
            echo '<br>Selecione uma matéria para exibir os conteúdos.';
        }
        ?>
    </section>

    <form action="/../../php/enviaEmail.php" method="post" class="formEmail">
        <Label for="prof">Selecione o destinatário</Label>
        <select name="prof" id="prof">
            <?php foreach ($professores as $professor): ?>
                <option value="<?php echo $professor['nome']; ?>"><?php echo $professor['nome']; ?></option>
            <?php endforeach; ?>
        </select>
        <label for="mensagem">Mensagem</label><br>
        <div id="container">
            <textarea id="editor" name="mensagem"></textarea>
        </div>
        <input type="submit" value="Enviar" class="btnEmail">
    </form>

    <section class="eventos">
        <?php
        include('../../php/lista_eventos.php');
        ?>
    </section>
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/super-build/ckeditor.js"></script>
    <script src="/../../js/simpleTextEditor.js"></script>
    <script>
        document.getElementById('limpar').addEventListener('click', function () {
            const url = new URL(window.location.href);
            url.searchParams.delete('materia');
            window.location.href = url.href;
        });
    </script>


</body>

</html>