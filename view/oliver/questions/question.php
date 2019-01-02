<?php
namespace Anax\View;

?>

<div class="question">
    <?php include 'user-area.php'; ?>
    <a class="largeText" href="<?= url("questions/{$item->questionId}") ?>"><?= $item->title ?></a>
</div>
