<?php
include_once('conexao.php');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$mes_atual = date('m');

$stmt = $pdo->prepare('SELECT * 
                       FROM eventos 
                       WHERE mes >= ?'); 
$stmt->execute([$mes_atual]);
$eventos = $stmt->fetchAll();

ob_start();

if (empty($eventos)) {
    echo 'Nenhum evento encontrado.';
} else {
$count_eventos = count($eventos);
    $eventos_por_mes = [];
    foreach ($eventos as $evento) {
        $mes = ucfirst(strftime('%B', strtotime("$evento[ano]-$evento[mes]-01")));
        $eventos_por_mes[$mes][] = $evento;
    }
    echo '<div class="eventos-container">';
    foreach ($eventos_por_mes as $mes => $eventos_mes) {
        echo '<div class="evento-mes">';
        echo "<h2>$mes</h2>";
        echo '<table class="evento-tabela">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Mês</th>';
        echo '<th>Dia</th>';
        echo '<th>Título</th>';
        echo '<th>Descrição</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($eventos_mes as $evento) {
            echo '<tr>';
            echo "<td>$evento[mes]</td>";
            echo "<td>$evento[dia]</td>";
            echo "<td>$evento[titulo]</td>";
            echo "<td>$evento[descricao]</td>";
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }
    echo '</div>';
}

$saida = ob_get_clean();
echo $saida;
?>
