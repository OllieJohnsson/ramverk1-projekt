<?php
namespace Anax\View;

$latestUserName = isset($item->latestAnswer) ? $item->latestAnswer->username : null;
$latestUserId = isset($item->latestAnswer) ? $item->latestAnswer->userId : null;
$latestPosted = isset($item->latestAnswer) ? $item->latestAnswer->posted : null;
?>

<div class="question">
    <div class="container-row">
        <?php include 'user-area.php'; ?>
        <div class="container-col" style="text-align: right">
            Senaste
            <a href="<?= url("users/$latestUserId") ?>" class="smallText"><?= $latestUserName ?></a>
            <p class="smallText"><?= $latestPosted ?></p>
        </div>
    </div>

    <a class="largeText" href="<?= url("questions/{$item->questionId}") ?>"><?= $item->title ?></a>
</div>
