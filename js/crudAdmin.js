function habilitarEdicao(event, userId) {
  event.preventDefault();

  var row = document.getElementById("row-" + userId);
  var inputs = row.getElementsByTagName("input");
  var select = row.querySelector("select");
  var btnEditar = row.querySelector(".btn-editar");
  var btnAtualizar = row.querySelector(".btn-atualizar");
  var btnExcluir = row.querySelector(".btn-excluir");

  if (!inputs[0].disabled) {
    // Se os campos já estão habilitados, desabilitar novamente
    for (var i = 0; i < inputs.length; i++) {
      inputs[i].disabled = true;
    }
    select.disabled = true;
    btnAtualizar.disabled = true;
    btnExcluir.disabled = true;

    btnEditar.classList.remove("btn-editar-ativo");
  } else {
    // Se os campos estão desabilitados, habilitar
    for (var i = 0; i < inputs.length; i++) {
      inputs[i].disabled = false;
    }
    select.disabled = false;
    btnAtualizar.disabled = false;
    btnExcluir.disabled = false;

    btnEditar.classList.add("btn-editar-ativo");
  }

  // Habilitar/desabilitar a função de atualizar imagem apenas quando a edição estiver habilitada
  var avatar = row.querySelector(".avatar");
  if (inputs[0].disabled) {
    avatar.onclick = null;
    avatar.style.cursor = "default";
  } else {
    avatar.onclick = selecionarImagem.bind(null, userId);
    avatar.style.cursor = "pointer";
  }
}

function selecionarImagem(userId) {
  var input = document.createElement('input');
  input.type = 'file';
  input.name = 'avatar';
  input.style.display = 'none';
  
  
  input.onchange = function (e) {
    var file = e.target.files[0];
    var reader = new FileReader();

    reader.onload = function () {
      var novaImagemBase64 = reader.result;

      // Atualiza a nova imagem exibida
      var avatar = document.querySelector('[data-user-id="' + userId + '"]');
      avatar.src = novaImagemBase64;

      // Cria um formulário para enviar a imagem
      var form = new FormData();
      form.append('userId', userId);
      form.append('novaImagem', novaImagemBase64);

      // Envia a requisição AJAX para atualizar o cadastro
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'crudAdmin.php');
      xhr.onload = function () {
        if (xhr.status === 200) {
          var response = xhr.responseText;
          console.log(response);
        }
      };
      xhr.send(form);
    };

    reader.readAsDataURL(file);
  };

  document.body.appendChild(input);
  input.click();
  document.body.removeChild(input);

}

function confirmarExclusao() {
  var confirmacao = confirm("Tem certeza que deseja excluir o cadastro?");

  if (!confirmacao) {
    event.preventDefault();
  }
}

function confirmarAtualizacao() {
  var confirmacao = confirm("Tem certeza que deseja atualizar o cadastro?");

  if (!confirmacao) {
    event.preventDefault();
  }
}