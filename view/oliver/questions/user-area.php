<?php
namespace Anax\View;

?>

<!-- <div class="container-row align-items-center"> -->
<div class="user-area">
    <?= $item->creator->gravatar ?>
    <div class="container-col text">
        <a href=" <?=url("users/{$item->creator->id}")?> "><?= $item->creator->username ?></a>
        <p class="smallGrayText"> <?= $item->posted ?></p>
    </div>
</div>
