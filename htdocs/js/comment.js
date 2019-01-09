(function() {
    let showCommentsButtons = document.getElementsByClassName('showCommentsButton');
    let comments = document.getElementsByClassName('comments');

    let expand = 'https://img.icons8.com/ios-glyphs/25/D3D8E1/expand-arrow.png';
    let collapse = 'https://img.icons8.com/ios-glyphs/25/D3D8E1/collapse-arrow.png';


    if (!showCommentsButtons || !comments) {
        return;
    }


    for (var i = 0; i < comments.length; i++) {
        comments[i].classList.add("hidden");

        showCommentsButtons[i].getElementsByTagName('img')[0].src = expand;
        showCommentsButtons[i].id = i;

        showCommentsButtons[i].addEventListener('click', function(event) {
            event.preventDefault();
            comments[event.target.parentElement.id].classList.toggle("hidden");
            event.target.src = event.target.src == expand ? collapse: expand;
            comments[event.target.parentElement.id].querySelector("#form-element-text").focus();
        });
    }
})();
