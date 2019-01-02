<?php
namespace Anax\View;

$tagText = count($item->tags) > 0 ? "taggar:" : null;
?>

<div class="question">
    <?php include 'user-area.php'; ?>

    <h1 class="largeText"><?= $item->title ?></h1>
    <p class="smallText tags-area">
        <?= $tagText ?>
        <?php foreach ($item->tags as $tag) : ?>
            <a href="<?= url("questions/tag/{$tag->id}") ?>"><?= "#$tag->name" ?></a>
        <?php endforeach; ?>
    </p>

    <p class="questionText"><?= $item->text ?></p>

    <?php include 'comment-area.php'; ?>
</div>
