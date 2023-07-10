const quizForm = document.getElementById('quiz-form');

quizForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Evita o envio do formulário

    const answers = {
        q1: quizForm.q1.value,
        q2: quizForm.q2.value,
        q3: quizForm.q3.value
        };

    const correctAnswers = {
        q1: 'a',
        q2: 'a',
        q3: 'b'
        };

    let score = 0;

    for (let question in answers) {
        if (answers[question] === correctAnswers[question]) {
            score++;
        }
    }

    const resultMessage = `Você acertou ${score} de 3 questões.`;
    alert(resultMessage);
});