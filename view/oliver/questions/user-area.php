<?php
namespace Anax\View;

?>

<div class="container-row">
    <?= $item->creator->gravatar ?>
    <div class="container-col user-area">
        <a href=" <?=url("users/{$item->creator->id}")?> "><?= $item->creator->username ?></a>
        <p class="smallText"> <?= $item->posted ?></p>
    </div>
</div>
