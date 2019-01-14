<?php
namespace Anax\View;

?>
<div class="container-col list-item">
    <div class="container-row">

    </div>
    <div class="container-row gravatar-username">

        <?= $item->gravatar($item->email, 35) ?>
        <a href="<?= url("users/$item->id") ?>"><?= $item->username ?></a>
    </div>
    <div class="container-row active-icons">

            <img src="https://img.icons8.com/ios-glyphs/25/D8DDE6/ask-question.png">
            <div class="count">
                <?= $item->noQuestions ?>
            </div>

            <img src="https://img.icons8.com/ios-glyphs/25/D8DDE6/response.png">
            <div class="count">
                <?= $item->noAnswers ?>
            </div>

            <img src="https://img.icons8.com/ios-glyphs/25/D8DDE6/speech-bubble-with-dots.png">
            <div class="count">
                <?= $item->noComments ?>
            </div>

    </div>
</div>
