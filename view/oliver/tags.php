<?php
namespace Anax\View;

?>

<!-- <h1><?= $title ?></h1> -->


<ul class="tagsList">
    <?php foreach ($tags as $tag) : ?>
        <li><a href="<?= url("questions/tag/{$tag->id}") ?>"><?= "#$tag->name" ?></a></li>
    <?php endforeach; ?>
</ul>
