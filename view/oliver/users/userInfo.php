<?php
namespace Anax\View;

?>

<div class="user-info">
    <div class="flex-center">
        <?= $user->gravatar($user->email, 150); ?>
    </div>

    <table>
        <tr>
            <td>Användarnamn:</td>
            <td><?= $user->username ?></td>
        </tr>
        <tr>
            <td>Namn:</td>
            <td><?= "$user->firstName $user->lastName" ?></td>
        </tr>
        <tr>
            <td>E-post:</td>
            <td><?= $user->email ?></td>
        </tr>
    </table>

    <div class="container-col">
        <h2><?= $h2Prefix ?> frågor</h2>
        <?php if (count($questions) === 0) : ?>
            <p><?= $pPrefix ?> har inte ställt några frågor än.</p>
        <?php endif; ?>
        <?php foreach ($questions as $question) : ?>
            <a href="<?= url("questions/{$question->id}"); ?>"><?= $question->title ?></a>
            <p class="smallGrayText date"><?= $question->posted ?></p>
        <?php endforeach; ?>
    </div>
    <div class="container-col">
        <h2><?= $h2Prefix ?> svar</h2>
        <?php if (count($answers) === 0) : ?>
            <p><?= $pPrefix ?> har inte svarat på någon fråga än.</p>
        <?php endif; ?>
        <?php foreach ($answers as $answer) : ?>
            <a href="<?= url("questions/{$answer->questionId}"); ?>"><?= $answer->text ?></a>
            <p class="smallGrayText date"><?= $answer->posted ?></p>
        <?php endforeach; ?>
    </div>

</div>
