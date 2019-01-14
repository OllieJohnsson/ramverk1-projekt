<?php
namespace Anax\View;

$acceptedAnswer = $item->accepted ? '<img class="accepted" src="https://img.icons8.com/ios-glyphs/30/53d794/ok.png">' : null;
$acceptButton = $showAcceptButton ? '<form class="acceptButton" action="'.url("questions/$item->questionId/$item->id").'" method="post"><input type="submit" name="" value="Acceptera svar"></form>' : null;

?>
<div class="question">
    <?= $acceptedAnswer ?>
    <?= $acceptButton ?>
    <?php include 'user-area.php'; ?>
    <?= $item->text ?>
    <?php include 'comment-area.php'; ?>
</div>
