const cadQuestForm = document.getElementById("form-cad-quest");

cadQuestForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  const dadosForm = new FormData(cadQuestForm);
  dadosForm.append("add", 1);

  const dados = await fetch("../../php/criar_questionario.php", {
    method: "POST",
    body: dadosForm,
  });

  const resposta = await dados.json();
  alert(resposta.msg);
  if (!resposta.erro) {
    window.location.href = "ques.php?id=" + resposta.id;
  }
});