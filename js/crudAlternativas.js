const myModalEl = document.getElementById("altModal");
const modalAlt = bootstrap.Modal.getInstance(myModalEl);
const cadAltForm = document.getElementById("form-cad-alt");

myModalEl.addEventListener("hidden.bs.modal", function (event) {
  var url = new URL(window.location.href);
  var searchParams = url.searchParams;
  searchParams.delete("pergunta");
  url.search = searchParams.toString();
  window.location.href = url.href;
});

function validarFormulario() {
  const inputsCorretas = document.querySelectorAll(
    'input[type="radio"][id^="correta_"]'
  );
  let peloMenosUmaSelecionada = false;

  for (var i = 0; i < inputsCorretas.length; i++) {
    if (inputsCorretas[i].checked) {
      peloMenosUmaSelecionada = true;
      break;
    }
  }

  if (!peloMenosUmaSelecionada) {
    alert("Selecione pelo menos uma opção correta.");
    return false;
  }
  return true;
}

cadAltForm.addEventListener("submit", async (e) => {
  e.preventDefault();

  const podeSalvar = validarFormulario();

  if (podeSalvar) {
    const urlParamsAlt = new URLSearchParams(window.location.search);
    const idPergunta = urlParamsAlt.get("pergunta");

    const dadosForm = new FormData(cadAltForm);

    dadosForm.append("add", 1);
    dadosForm.append("questionario", idQuestionario);
    dadosForm.append("pergunta", idPergunta);
    console.log(dadosForm);

    const dados = await fetch("../../php/criar_alternativas.php", {
      method: "POST",
      body: dadosForm,
    });

    const resposta = await dados.json();
    alert(resposta.msg);
    console.log(resposta);
    if (!resposta.erro) {
      console.log("deu");
      var myModalEl1 = document.getElementById("altModal");
      var modal = bootstrap.Modal.getInstance(myModalEl1);
      modal.hide();
    }
  }
});