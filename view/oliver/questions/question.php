<?php
namespace Anax\View;

$title = isset($latestAnswer) ? "Senaste" : null;
$latestAnswerUserId = isset($latestAnswer) ? $latestAnswer->creator->id : null;
$latestAnswerUserName = isset($latestAnswer) ? $latestAnswer->creator->username : null;
$latestAnswerUserGravatar = isset($latestAnswer) ? $latestAnswer->creator->gravatar($latestAnswer->creator->email, 35) : null;
$latestAnswerPosted = isset($latestAnswer) ? $latestAnswer->posted : null;
?>

<div class="question">
    <div class="container-row">
        <?php include 'user-area.php'; ?>
        <div class="container-col user-area" style="text-align: right; align-items: flex-end;">

            <div class="container-row" style="justify-content: flex-end; align-items: center;">
                <div class="count" style="margin-right: 0.2rem; margin-bottom: 0.2rem;"><?= $item->numberOfAnswers ?></div>
                <img src="https://img.icons8.com/ios-glyphs/20/D3D8E1/reply-arrow.png">
            </div>

            <p class="smallGrayText title"><?= $title ?></p>
            <div class="container-row align-items-center">
                <div class="container-col" style="margin-right: 0.5rem;">
                    <a href="<?= url("users/$latestAnswerUserId") ?>" class="smallText"><?= $latestAnswerUserName ?></a>
                    <p class="smallGrayText" style="margin: 0;"><?= $latestAnswerPosted ?></p>
                </div>
                <?= $latestAnswerUserGravatar ?>
            </div>
        </div>
    </div>

    <a class="largeText" href="<?= url("questions/{$item->id}") ?>"><?= $item->title ?></a>
</div>
