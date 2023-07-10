<?php
include_once('../../php/conexao.php');
session_start();
$questionarioId  = $_GET['id'];


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../../css/geral.css">
    <link rel="stylesheet" href="../../css/prof.css">
    <link rel="stylesheet" href="../../css/textEditor.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Criar Ques</title>
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
        <h1 class="mt-4 mb-4 ms-5">Criar Questionário</h1>
        <section class="section">
            <h2>Informações</h2>
            <?php
            $query = "SELECT descricao, materia FROM questionario WHERE id = :questionarioId";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':questionarioId', $questionarioId, SQLITE3_INTEGER);
            $stmt->execute();

            if ($stmt->rowCount() >= 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $descricao = $row['descricao'];
                $materia = $row['materia'];

                echo "<div>
            <strong>Título: </strong> <span>$descricao</span>
            </div>";
                echo "<div>
            <strong>Matéria: </strong> <span>$materia</span>
            </div>";
            } else {
                echo "Nenhum registro encontrado para o ID fornecido.";
            }
            ?>
        </section>

        <section class="section">
            <button type="button" class="btnCriarPergunta btnHovers" data-bs-toggle="modal" data-bs-target="#perguntaModal">
                Criar pergunta
            </button>
            <strong class="d-block mt-4 mb-4">Perguntas criadas: </strong>
            <?php
            try {
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = "SELECT * FROM pergunta WHERE questionario = :questionarioId";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':questionarioId', $questionarioId, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() >= 0) {
                    echo '<ul class="list-group">';

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $pergunta = $row['enunciado'];

                        echo '<li class="list-group-item">';
                        echo '<h5 class="mb-1">' . $pergunta . '</h5>';
                        echo '</li>';
                    }

                    echo '</ul>';
                } else {
                    echo '<p>No questions found for the provided questionnaire.</p>';
                }
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
            ?>
        </section>

        <!-- MODAL NOVa PERGUNTA -->
        <div class="modal fade" id="perguntaModal" tabindex="-1" aria-labelledby="perguntaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="perguntaModalLabel">Nova pergunta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-cad-enunc">
                            <strong>Informações sobre a pergunta</strong>
                            <div class="mb-3">
                                <label for="enunciado">Enunciado:</label>
                                <input type="text" name="enunciado" id="enunciado" required>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                <button id="cad-enunc-btn" type="submit" class="btnAddAlter btnHovers">Adicionar
                                    Alternativas</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL ALTERNATIVAS -->
        <div class="modal fade" id="altModal" tabindex="-1" aria-labelledby="altModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="altModalLabel">Alternativas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-cad-alt">
                            <strong>Adicione alternativas</strong>
                            <div class="border-bottom pb-3">

                                <label for="alternativa_1>">Alternativa 1:</label>
                                <input type="text" name="alternativa_1">
                                <label for="correta_1">Correta:</label>
                                <input type="radio" name="correta" id="correta_1" value="1">
                            </div>

                            <div class="border-bottom pb-3">

                                <label for="alternativa_2>">Alternativa 2:</label>
                                <input type="text" name="alternativa_2">
                                <label for="correta_2">Correta:</label>
                                <input type="radio" name="correta" id="correta_2" value="2">
                            </div>

                            <div class="border-bottom pb-3">

                                <label for="alternativa_3>">Alternativa 3:</label>
                                <input type="text" name="alternativa_3">
                                <label for="correta_3">Correta:</label>
                                <input type="radio" name="correta" id="correta_3" value="3">
                            </div>

                            <div class="modal-footer">
                                <button id="cad-alt-btn" type="submit" class="btnSalvarQuest btnHovers">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <style>

    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="../../js/crudPergunta.js"></script>
    <script src="../../js/crudAlternativas.js"></script>
</body>

</html>