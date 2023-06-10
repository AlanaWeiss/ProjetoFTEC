function selecionarImagem() {
    var input = document.createElement('input');
    input.type = 'file';

    input.onchange = function (e) {
        var file = e.target.files[0];
        var reader = new FileReader();

        reader.onload = function () {
            var imagemBase64 = reader.result;

            // Envia a imagem para o servidor
            enviarImagem(imagemBase64);
        };

        reader.readAsDataURL(file);
    };

    input.click();
}

function enviarImagem(imagemBase64) {
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = ''; // Preencha com a URL do script PHP que processa o envio da imagem

    var hiddenField = document.createElement('input');
    hiddenField.type = 'hidden';
    hiddenField.name = 'imagem';
    hiddenField.value = imagemBase64;

    form.appendChild(hiddenField);
    document.body.appendChild(form);

    form.submit();
}