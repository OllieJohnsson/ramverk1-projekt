(function() {
    let form = document.getElementById('addQuestionForm');

    if (!form) {
        return;
    }

    let tag = document.getElementById('form-element-tag');
    let allTags = document.getElementById('form-element-allTags');
    let button = document.getElementById('form-element-button');
    let tagsArea = document.createElement('ul');

    tagsArea.id = "tagsArea";

    let tags = [];

    button.addEventListener('click', function() {
        let lowerTags = tags.map(tag => {
            return tag.toLowerCase();
        });

        if (tag.value === "" || lowerTags.includes(tag.value.toLowerCase())) {
            return;
        }
        if (!document.getElementById('tagsArea')) {
            form.getElementsByTagName('fieldset')[0].appendChild(tagsArea);
        }
        tags.push(tag.value);
        tag.value = "";
        tag.focus();

        tagsArea.innerHTML = null;
        tags.forEach(tag => {
            tagsArea.innerHTML += `<li>${tag}</li>`;
        });

        allTags.value = tags;
    });
})();
