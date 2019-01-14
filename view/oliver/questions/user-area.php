<?php
namespace Anax\View;

?>

<div class="user-area">
    <?= $item->gravatar($item->creator->email, 40) ?>
    <div class="container-col text">
        <a href=" <?=url("users/{$item->creator->id}")?> "><?= $item->creator->username ?></a>
        <p class="smallGrayText"> <?= $item->posted ?></p>
    </div>
</div>
