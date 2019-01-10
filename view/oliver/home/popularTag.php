<?php
namespace Anax\View;

?>

<div class="container-row popular-tag">
    <a href="<?= url("questions/tag/$item->id") ?>">#<?= $item->name ?>&nbsp;&nbsp;</a>
    <p class="smallGrayText"><?= $item->amount ?></p>
</div>
