<?php
session_start();
include('../../php/conexao.php');
// require_once '../../php/conexao.php';


//lista materias com conteudo cadastrado
// $stmt = $pdo->prepare('SELECT nome FROM usuarios');
$stmt = $pdo->prepare("SELECT materia FROM materias");
$stmt->execute();
$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// lista professores para email
$stmt = $pdo->prepare("SELECT nome FROM usuarios WHERE tipo = 'professor'");
$stmt->execute();
$professores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// busca nome e email de outros alunos
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
    <link rel="stylesheet" href="../../css/questionarioaluno.css">
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
                <form action="/php/busca.php" method="post" class="barra-pesquisa">
                    <input type="text" name="search" placeholder="Digite sua pesquisa...">
                    <button type="submit" class="buscaConteudo btn-search btnHovers"><i class="material-icons">search</i></button>
                </form>

                <!-- LOGOUT -->
                <form action="/php/logout.php" method="post">
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

                <!-- SE FOR RODAR LOCAL, UTILIZAR ESSE TRECHO-->
                <?php //var_dump($materias); ?>
                <select name="materia" id="materia">
                    <?php foreach ($materias as $materia): ?>
                        <option value="<?php echo $materia['materia']; ?>"><?php echo $materia['materia']; ?></option>
                    <?php endforeach; ?>
                </select><br> 

                <!-- SE FOR RODAR NO SERVIDOR, UTILIZAR ESSE TRECHO
                <select name="materia2" id="materia2">
                    <?php //foreach ($materias as $material): ?>
                        <option value="<?php //echo $material; ?>"><?php //echo $material; ?></option>
                    <?php //endforeach; ?>
                </select><br>-->


                <input type="submit" value="Buscar" class="buscaConteudo">
                <button type="button" id="limpar" class="buscaConteudo btnHovers">Limpar</button>
            </form>
            
        </div>
    </section>


</body>
</html>
<!--foi aqui que eu mudei-->
<form action="../../php/enviarResposta.php" method="post" class="formEmail">
    <?php
    $stmt = $pdo->prepare("SELECT * FROM pergunta INNER JOIN alternativa ON pergunta.id=alternativa.idPergunta");
    $stmt->execute();
    $questoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $chk= "palamar";
    foreach ($questoes as $questao) {
        if($chk !== $questao['enunciado']) {
            echo "<h3>" . $questao['enunciado'] . "</h3>";
        }
            echo "<div>";
            echo "<input type='radio' name='" . $questao['idPergunta'] . "' value='" . $questao['idPergunta'] . "' data-correct='" . $questao['id'] . "'>";
            echo $questao['descricao'] . "<br>";
            echo "</div>";
            echo '<br>';
        $chk= $questao['enunciado'];
    

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $questoes = array(); // Defina um array vazio para armazenar as questões
        
            // Aqui você deve definir o array $questoes com as perguntas e respostas corretas
        
            $respostasCorretas = 0;
       
            foreach ($questoes as $questao) {
                $selectedAnswer = $_POST[$questao['idPergunta']];
                $respostaCorreta = $questao['corretas'];
        
                if ($selectedAnswer === $respostaCorreta) {
                    $respostasCorretas++;
                }
            }
        
            echo "Total de perguntas: " . count($questoes) . "<br>";
            echo "Respostas corretas: " . $respostasCorretas . "<br>";
            echo "Respostas erradas: " . (count($questoes) - $respostasCorretas) . "<br>";
        }
        
        
    }

    
        //fazer um formulario de 500px;
        //overflow: auto;
    ?>
    
    <!--estilizar btnEnviarRespostas botão para enviar as respotasr, e ver quantas respostas o aluno acertou. 
    OBS.: tem que estilisar esse botão  -->

    <div>
        <input type="submit" name="BTResposta" value="Enviar" class="btnResposta">
    </div>

    </form>

    <form action="/../../php/enviaEmailpQuest.php" method="post" class="formEmail">
    
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
        <button class="btnColegas btnHovers" onclick="toggleContatos()">Colegas</button>
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
   
    
    <script src="/../../js/resultadoquiz.js"></script>
</body>

</html>