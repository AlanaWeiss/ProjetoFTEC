<div id="sessao-usuario">
    <img class="logo-header" id="logo" src="../../css/assets/research.svg" alt="Lampada " />
    <div>
        <span class="span-title">
            <?php echo 'Bem-vindo, ' . $_SESSION['usuario'] . '!'; ?>
        </span>
    </div>
    <form action="/php/logout.php" method="post">
        <input type="submit" class="logout-bt" value="Logout">
    </form>
</div>