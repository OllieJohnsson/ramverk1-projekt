<?php
namespace Anax\View;

?>

<div class="container-row">
    <?= $item->gravatar ?>
    <div class="container-col user-area">
        <a href=" <?=url("users/{$item->userId}")?> "><?= $item->username ?></a>
        <p class="smallText"> <?= $item->posted ?></p>
    </div>
</div>
