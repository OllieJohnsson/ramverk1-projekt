<?php
namespace Anax\View;

// echo "<pre>";
// var_dump($item->comments[0]->creator->gravatar);
// var_dump($item->comments[0]->getUser()->username);
// var_dump($item->comments[0]->user);
?>

<div class="comment-area">
    <img src="https://img.icons8.com/ios-glyphs/25/D8DDE6/topic.png">
    <div class="count">
        <?= count($item->comments) ?>
    </div>

    <a class="showCommentsButton" href="#">
        <img src="" alt="Visa">
    </a>
</div>

<div class="comments">
    <?= $form ?>

    <div class="replies">
        <?php foreach ($item->comments as $comment): ?>
            <div class="container-row">
                <?= $comment->creator->gravatar ?>
                <div class="container-col user-area">
                    <a href=" <?=url("users/{$comment->creator->id}")?> "><?= $comment->creator->username ?></a>
                    <p class="smallText"> <?= $comment->posted ?></p>
                </div>
            </div>
            <div class="container-row text">
                <?= $comment->text ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
