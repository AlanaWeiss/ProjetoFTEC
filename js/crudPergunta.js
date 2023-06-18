const cadEnuncForm = document.getElementById("form-cad-enunc");

const urlParams = new URLSearchParams(window.location.search);
const idQuestionario = urlParams.get("id");

cadEnuncForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  console.log("clicou", e);

  const dadosForm = new FormData(cadEnuncForm);
  dadosForm.append("add", 1);
  dadosForm.append("questionario", idQuestionario);
  console.log(dadosForm);

  const dados = await fetch("../../php/criar_pergunta.php", {
    method: "POST",
    body: dadosForm,
  });

  const resposta = await dados.json();
  alert(resposta.msg);

  if (!resposta.erro) {
    var myModalEl = document.getElementById("perguntaModal");
    var modal = bootstrap.Modal.getInstance(myModalEl);
    modal.hide();

    var url = new URL(window.location.href);
    var searchParams = url.searchParams;
    searchParams.set("pergunta", resposta.id);
    url.search = searchParams.toString();
    window.history.replaceState(null, null, url.href);

    var myModal = new bootstrap.Modal(document.getElementById("altModal"), {
      keyboard: false,
    });

    myModal.show();
  }
});
