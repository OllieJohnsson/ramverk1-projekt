<?php
namespace Anax\View;

?>

<div class="container-col list-item">
    <?php include __DIR__.'/../questions/user-area.php'; ?>
    <a class="title" href="<?= url("questions/{$item->id}") ?>"><?= $item->title ?></a>
</div>
