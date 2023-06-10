<?php
    include('../../php/busca_avatar.php')
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="./css/geral.css">
</head>
<body>
    <div class="divAvatar">
        <?php
        $avatar = $foto[0]['foto'];
        echo '<img class="avatar" src="data:image/png;base64,' . $avatar . '" alt="Avatar" onclick="selecionarImagem()">';
        // echo '<br>';
        // echo $avatar;
        ?>
    </div>
    <script src="/../../js/avatar.js"></script>
</body>
</html>