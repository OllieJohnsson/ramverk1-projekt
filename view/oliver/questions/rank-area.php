<?php
namespace Anax\View;

// var_dump($item->rank);
?>

<div class="rank-area">
    <?= $rankUpForm ?>
    <p class="grayText"><?= "$item->rankScore poäng" ?></p>
    <?= $rankDownForm ?>
</div>
