<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Verifica se um arquivo foi enviado
  if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $imagem = $_FILES['imagem'];

    // Verifica o tipo da imagem (opcional)
    $tipoPermitido = ['image/jpeg', 'image/png'];
    if (!in_array($imagem['type'], $tipoPermitido)) {
      echo "Apenas arquivos JPEG e PNG são permitidos.";
      exit;
    }

    // Define o diretório de destino
    $diretorioDestino = 'caminho/do/diretorio/destino/';

    // Gera um nome único para a imagem
    $nomeImagem = uniqid('imagem_') . '.' . pathinfo($imagem['name'], PATHINFO_EXTENSION);

    // Move a imagem para o diretório de destino
    if (move_uploaded_file($imagem['tmp_name'], $diretorioDestino . $nomeImagem)) {
      echo "Upload da imagem concluído com sucesso!";
    } else {
      echo "Falha ao fazer o upload da imagem.";
    }
  }
}
?>
