(function() {
    let commentButtons = document.getElementByClassName('commentButton');
    let commentForm = document.getElementById('commentForm');

    if (!commentButton || !commentForm) {
        return;
    }

    commentForm.hidden = true;

    commentButton.addEventListener('click', function(event) {
        event.preventDefault()
        console.log("COMMENT!!");
        commentForm.hidden = false;
        commentForm.querySelector("#form-element-text").focus()
        // window.scrollTo(0,document.body.scrollHeight);
    });

    // let cancelButton = document.getElementById('form-element-button');
    //
    // cancelButton.addEventListener('click', function() {
    //     answerForm.querySelector("#form-element-text").value = "";
    //     answerForm.hidden = true;
    //
    // });


})();
