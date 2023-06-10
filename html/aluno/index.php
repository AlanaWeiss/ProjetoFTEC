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

//busca nome e email de outros alunos
$stmt = $pdo->prepare("SELECT nome, email FROM usuarios WHERE tipo = 'aluno'");
$stmt->execute();
$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <link rel="stylesheet" href="../../css/aluno.css">
    <link rel="stylesheet" href="../../css/geral.css">
    <link rel="stylesheet" href="../../css/textEditor.css">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>

    <header>
        <div id="sessao-usuario">
            <img class="logo-header" id="logo" src="../../css/assets/research.svg" alt="Lampada " />
            
            <?php include('../../html/geral/avatar.php') ?>

            <div class="esquerda">

                <!-- BUSCA CONTEUDO -->
                <form action="../../php/busca.php" method="post" class="barra-pesquisa">
                    <input type="text" name="search" placeholder="Digite sua pesquisa...">
                    <button type="submit" class="buscaConteudo btn-search"><i class="material-icons">search</i></button>
                </form>

                <!-- LOGOUT -->
                <form action="../../php/logout.php" method="post">
                    <input type="submit" class="logout-bt" value="Logout">
                </form>
            </div>
        </div>
    </header>

    <section class="listaConteudos selecao">
        <div>
            <span class="span-title">
                <?php echo 'Bem-vindo, ' . $_SESSION['usuario'] . '!'; ?>
            </span>
            <form action=# method="GET">
                <select name="materia" id="materia">
                    <?php foreach ($materias as $materia): ?>
                        <option value="<?php echo $materia['materia']; ?>"><?php echo $materia['materia']; ?></option>
                    <?php endforeach; ?>
                </select><br>
                <input type="submit" value="Buscar" class="buscaConteudo">
                <button type="button" id="limpar" class="buscaConteudo">Limpar</button>
            </form>
        </div>
    </section>

    <section class="listaConteudos">
        <?php
        if (isset($_GET['materia'])) {
            $index = 0; //inicializa o contador
        
            echo '<div class="accordion" id="myAccordion">';

            while ($conteudos = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //gera um ID baseado no index
                $accordionId = 'accordion-' . $index;

                echo '<div class="accordion-item">';
                echo '<h2 class="accordion-header" id="' . $accordionId . '">';
                echo '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' . $accordionId . '" aria-expanded="true" aria-controls="collapse-' . $accordionId . '">';
                echo $conteudos['titulo'];
                echo '</button>';
                echo '</h2>';
                echo '<div id="collapse-' . $accordionId . '" class="accordion-collapse collapse" aria-labelledby="' . $accordionId . '" data-bs-parent="#myAccordion">';
                echo '<div class="accordion-body">';
                echo $conteudos['conteudo'];
                echo '</div>';
                echo '</div>';
                echo '</div>';

                $index++; // Incrementa o contador
            }

            // Close the accordion container
            echo '</div>';
        } else {
            echo 'Selecione uma matéria para exibir os conteúdos.';
        }
        ?>
    </section>

    <form action="/../../php/enviaEmail.php" method="post" class="formEmail">
        <div>
            <span class="span-title">Entre em contato: </span>
            <br>
            <Label for="prof">Selecione o destinatário</Label>
            <br>
            <select name="prof" id="prof">
                <?php foreach ($professores as $professor): ?>
                    <option value="<?php echo $professor['nome']; ?>"><?php echo $professor['nome']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="mensagem">Mensagem</label><br>
            <div id="container">
                <textarea id="editor" name="mensagem"></textarea>
            </div>
        </div>
        <div>
            <input type="submit" name="BTEnvia" value="Enviar" class="btnEmail">
        </div>
    </form>

    <section class="areaColegas">
        <button class="btnColegas" onclick="toggleContatos()">Colegas</button>
        <div id="contatosDiv" style="display: none;">
            <table style="margin-top:10px;">
                <thead>
                    <tr>
                        <th class="col-aluno">Aluno</th>
                        <th class="col-email">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alunos as $aluno) { ?>
                        <tr>
                            <td>
                                <?php echo $aluno['nome']; ?>
                            </td>
                            <td>
                                <?php echo $aluno['email']; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="eventos">
        <?php
        include('../../php/lista_eventos.php');
        ?>
    </section>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/super-build/ckeditor.js"></script>
    <script src="/../../js/simpleTextEditor.js"></script>
    <script>
        document.getElementById('limpar').addEventListener('click', function () {
            const url = new URL(window.location.href);
            url.searchParams.delete('materia');
            window.location.href = url.href;
        });
    </script>
    <script>
        function toggleContatos() {
            var contatosDiv = document.getElementById("contatosDiv");
            if (contatosDiv.style.display === "none") {
                contatosDiv.style.display = "block";
            } else {
                contatosDiv.style.display = "none";
            }
        }
    </script>

</body>

</html>