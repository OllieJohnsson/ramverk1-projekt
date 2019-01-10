<?php
namespace Anax\View;

$title = $item->latestAnswer ? "Senaste" : null;
$latestUserName = $item->latestAnswer ? $item->latestAnswer[0]->creator->username : null;
$latestUserId = $item->latestAnswer ? $item->latestAnswer[0]->creator->id : null;
$latestPosted = $item->latestAnswer ? $item->latestAnswer[0]->posted : null;
$latestGravatar = $item->latestAnswer ? $item->latestAnswer[0]->creator->gravatar : null;
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
                    <a href="<?= url("users/$latestUserId") ?>" class="smallText"><?= $latestUserName ?></a>
                    <p class="smallGrayText" style="margin: 0;"><?= $latestPosted ?></p>
                </div>
                <?= $latestGravatar ?>
            </div>
        </div>
    </div>

    <a class="largeText" href="<?= url("questions/{$item->id}") ?>"><?= $item->title ?></a>
</div>
