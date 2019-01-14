<?php
namespace Anax\View;

$tagText = count($item->tags) > 0 ? "taggar:" : null;
?>

<div class="question">
    <?php include 'user-area.php'; ?>

    <p class="largeText"><?= $item->title ?></p>
    <p class="smallText tags-area">
        <?= $tagText ?>
        <?php foreach ($item->tags as $tag) : ?>
            <a href="<?= url("questions/tag/{$tag->id}") ?>"><?= "#$tag->name" ?></a>
        <?php endforeach; ?>
    </p>

    <?= $item->text ?>

    <?php include 'comment-area.php'; ?>
</div>
