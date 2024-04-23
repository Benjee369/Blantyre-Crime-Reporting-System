document.addEventListener('DOMContentLoaded', function () {
    var questions = document.querySelectorAll('.question');
    questions.forEach(function (question) {
        question.addEventListener('click', function () {
            var answer = this.nextElementSibling;
            answer.classList.toggle('open');
        });
    });
});
