const form = document.querySelector('form');
form.addEventListener('submit', function(e) {
  e.preventDefault();
  const username = document.querySelector('#username').value;
  const password = document.querySelector('#password').value;
  console.log(`Usuário: ${username} Senha: ${password}`);
});