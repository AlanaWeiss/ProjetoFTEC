<?php
session_start();
?>

<script>
  var mensagem = "<?php echo $_SESSION['mensagem']; ?>";
  alert(mensagem);
  window.location.href = document.referrer;
</script>

<?php
unset($_SESSION['mensagem']);
?>