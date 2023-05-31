<style>
    body {
        background-color: #010038;
        font-family: Arial, Helvetica, sans-serif;
        color: #fff;
        margin: 0 auto;
        color: black;
    }

    .resultado-busca {
        background-color: white;
        margin: 20px;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px -2px 39px 0px rgba(255, 255, 255, 0.4);
    }

    ul {
        list-style: none;
        color: black;
        padding: 0;
    }

    li:not(:last-child) {
        border-bottom: 1px solid #537ec5;
    }

    h2 {
        margin-bottom: 5px;
    }

    .info-resultado {
        color: gray;
    }

    button {
        background-color: #f39422;
        color: #fff;
        border: none;
        padding: 10px 10px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
</style>
<?php
// Recupera a string de pesquisa do formulário
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Conecta-se ao banco de dados
$db_file = __DIR__ . './../data/FTEC.sqlite';
try {
    $db = new PDO("sqlite:$db_file");
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
    exit;
}

// Pesquisa no banco de dados
$results = searchDatabase($db, $search);

// Função para pesquisar no banco de dados
function searchDatabase($db, $search)
{
    $sql = "SELECT * FROM conteudos WHERE conteudo LIKE :search or titulo like :search";
    $stmt = $db->prepare($sql);
    $search_term = "%$search%";
    $stmt->bindParam(':search', $search_term, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Exibe os resultados da pesquisa
echo "<div class='resultado-busca'>";
echo '<button onclick="window.location.href=\'/html/aluno\'">Voltar para home</button>';
echo '<h1>Resultados busca: </h1>';
if (!empty($results)) {
    echo "<ul>";
    foreach ($results as $row) {
        echo "<li>";
        echo "<div>";
        echo "<h2>" . htmlspecialchars($row["titulo"]) . "</h2>";
        echo "<span class='info-resultado'>" . htmlspecialchars($row["nome"]) . "</span>";
        echo "<span class='info-resultado'> - " . htmlspecialchars($row["materia"]) . "</span>";
        echo "<p>" . $row["conteudo"] . "</p>";
        echo "</div>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "Nenhum resultado encontrado.";
}
echo "<div>";
?>