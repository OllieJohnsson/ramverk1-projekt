(function() {
    let answerButtons = document.getElementsByClassName('svaraButton');
    let answerForm = document.getElementById('answerQuestionForm');

    if (!answerButtons || !answerForm) {
        return;
    }

    answerForm.hidden = true;

    for (var i = 0; i < answerButtons.length; i++) {
        answerButtons[i].addEventListener('click', function(event) {
            event.preventDefault();
            answerForm.hidden = false;
            answerForm.querySelector("#form-element-text").focus();
            window.scrollTo(0, document.body.scrollHeight);
        });
    }


    let cancelButton = document.getElementById('form-element-button');

    cancelButton.addEventListener('click', function() {
        answerForm.querySelector("#form-element-text").value = "";
        answerForm.hidden = true;
    });
})();
