<?php
namespace Anax\View;

?>

<div class="comment-area">
    <?php include 'rank-area.php'; ?>
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
        <?php foreach ($item->comments as $comment) : ?>
            <div class="user-area" style="margin-left: 1rem;">
                <?= $comment->creator->gravatar($comment->creator->email, 30) ?>
                <div class="container-col text">
                    <a href=" <?=url("users/{$comment->creator->id}")?> "><?= $comment->creator->username ?></a>
                    <p class="smallGrayText"> <?= $comment->posted ?></p>
                </div>
            </div>
            <div class="container-row text comment-text">
                <?= $comment->text ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
