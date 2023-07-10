<?php
include('../../php/conexao.php');
session_start();

if (isset($_POST['mensagem'])) {
    echo '<script>alert("' . $_POST['mensagem'] . '");</script>';
}

$stmt = $pdo->prepare('SELECT materia FROM materias');
$stmt->execute();
$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT * FROM questionario');
$stmt->execute();
$questionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../../css/prof.css">
    <link rel="stylesheet" href="../../css/geral.css">
    <link rel="stylesheet" href="../../css/textEditor.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>
        <?php echo $_SESSION['usuario']; ?>
    </title>
</head>

<body>
    <header>
        <div id="sessao-usuario">
            <img class="logo-header" id="logo" src="../../css/assets/research.svg" alt="Lampada " />

            <?php include('../../html/geral/avatar.php') ?>


            <form action="/php/logout.php" method="post">
                <input type="submit" class="logout-bt" value="Logout">
            </form>
        </div>
    </header>
    <main>
        <section class="section">
            <div>
                <span class="span-title">
                    <?php echo 'Bem-vindo, ' . $_SESSION['usuario'] . '!'; ?>
                </span>
            </div>
            <form action='/../../php/criar_conteudo.php' method="post">
                <h2>Cadastrar um novo conteudo</h2><br>

                <!-- SE FOR RODAR LOCAL, UTILIZAR ESSE TRECHO -->
                <!-- <select name="materia" id="materia" required>
                    <?php // foreach ($materias as $materia): ?>
                        <option value="<?php // echo $materia['materia']; ?>"><?php // echo $materia['materia']; ?></option>
                    <?php // endforeach; ?>
                </select> -->

                <!-- SE FOR RODAR NO SERVIDOR, UTILIZAR ESSE TRECHO -->
                <select name="materia" id="materia" required>

                    <?php foreach ($materias as $materia): ?>
                        <option value="<?php echo $materia; ?>"><?php echo $materia; ?></option>
                    <?php endforeach; ?>
                </select><br>

                <div>
                    <label for="titulo">Titulo</label><br>
                    <input type="text" name="titulo" value=""><br>
                </div>
                <div>
                    <label for="conteudo">Conteúdo</label><br>
                    <div id="container">
                        <textarea id="editor" name="conteudo">
                    </textarea>
                    </div>
                </div>

                <input type="submit" value="Cadastrar Conteúdo" class="cadConteudo">
            </form>
        </section>

        <section class="section">
            <h3>Questionários</h3>

            <?php foreach ($questionarios as $quest) : ?>
                <span>
                    <?php echo $quest['descricao']; ?>
                    (<?php echo $quest['materia']; ?>)
                </span><br>
            <?php endforeach; ?>

            <button type="button" class="btnCriarQuest btnHovers" data-bs-toggle="modal" data-bs-target="#questModal">
                Criar questionário
            </button>

        </section>

        <section class="section">
            <form action="/../../php/criar_evento.php" method="post">

                <div>
                    <label for="dataDoEvento">Data:</label><br>
                    <input type="date" id="data" name="dataDoEvento">
                </div>

                <div>
                    <label for="tituloDoEvento">Titulo do Evento</label><br>
                    <input type="text" name="tituloDoEvento">
                </div>

                <div>
                    <label for="descricaoDoEvento">Descrição do Evento</label><br>
                    <textarea name="descricaoDoEvento"></textarea>
                </div>

                <input type="submit" value="Cadastrar Evento" class="cadEvento">
            </form>
        </section>
    </main>


    <!-- MODAL NOVO QUESTIONÁRIO -->
    <div class="modal fade" id="questModal" tabindex="-1" aria-labelledby="questModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="questModalLabel">Novo formulário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-cad-quest">
                        <strong>Informações sobre o questionário</strong>
                        <div class="mb-3">
                            <label for="titulo" class="col-2">Título: </label>
                            <input type="text" name="titulo" id="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="materia" class="col-2">Matéria:</label>
                            <select name="materia" id="materia" required>
                                <?php foreach ($materias as $materia) : ?>

                                    <option value="<?php echo $materia; ?>">
                                        <?php echo $materia; ?>
                      </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                            <button id="cad-quest-btn" type="submit" class="btnSalvarQuest btnHovers">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/super-build/ckeditor.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="../../js/crudQuestionario.js"></script>
    <script src="/../../js/textEditor.js"></script>
    <script>
        var editor = ClassicEditor.create(document.querySelector('#editor'));
        var conteudoInput = document.querySelector('#conteudo'); // Campo de entrada escondido para o conteúdo

        function atribuirConteudo() {
            conteudoInput.value = editor.getData();
        }

        document.querySelector('form').addEventListener('submit', atribuirConteudo);
    </script>
</body>

</html>