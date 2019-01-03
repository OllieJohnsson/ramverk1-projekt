(function() {
    let commentButtons = document.getElementsByClassName('commentButton');
    let showCommentsButtons = document.getElementsByClassName('showCommentsButton');
    let commentForm = document.getElementById('commentForm');
    let comments = document.getElementsByClassName('comments');

    let expand = 'https://img.icons8.com/ios-glyphs/25/D3D8E1/expand-arrow.png';
    let collapse = 'https://img.icons8.com/ios-glyphs/25/D3D8E1/collapse-arrow.png';

    // if (!commentButtons || !commentForm) {
    if (!commentButtons) {
    // if (true) {
        return;
    }


    // for (var i = 0; i < comments.length; i++) {
    //     comments[i].classList.add("hidden");
    // }



    // commentForm.hidden = true;

    for (var i = 0; i < comments.length; i++) {
        comments[i].classList.add("hidden");

        // console.log(comments[i]);
        // if (comments[i].length < 1) {
        //     console.log("mindre än 1");
        //     // showCommentsButtons[i].classList.add("hidden");
        // }

        showCommentsButtons[i].getElementsByTagName('img')[0].src = expand;
        showCommentsButtons[i].id = i;



        // commentButtons[i].addEventListener('click', function(event) {
        //     event.preventDefault();
        //     console.log("COMMENT!!");
        //     commentForm.hidden = false;
        //     commentForm.querySelector("#form-element-text").focus()
        // });

        showCommentsButtons[i].addEventListener('click', function(event) {
            event.preventDefault();
            comments[event.target.parentElement.id].classList.toggle("hidden");
            event.target.src = event.target.src == expand ? collapse: expand;
        });
    }



    // let cancelButton = document.getElementById('form-element-button');
    //
    // cancelButton.addEventListener('click', function() {
    //     answerForm.querySelector("#form-element-text").value = "";
    //     answerForm.hidden = true;
    //
    // });


})();
