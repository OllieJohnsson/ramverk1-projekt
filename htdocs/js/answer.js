(function() {
    let answerButton = document.getElementById('svaraButton');
    let answerForm = document.getElementById('answerQuestionForm');

    if (!answerButton || !answerForm) {
        return;
    }

    answerForm.hidden = true;

    answerButton.addEventListener('click', function(event) {
        event.preventDefault()
        console.log("SVARA!!");
        answerForm.hidden = false;
        answerForm.querySelector("#form-element-text").focus()
        window.scrollTo(0,document.body.scrollHeight);
    });

    let cancelButton = document.getElementById('form-element-button');

    cancelButton.addEventListener('click', function() {
        answerForm.querySelector("#form-element-text").value = "";
        answerForm.hidden = true;

    });


})();
