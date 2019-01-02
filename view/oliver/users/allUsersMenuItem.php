<?php
namespace Anax\View;

?>

<div class="user-info">
    <a href="<?= url("users/{$user->id}") ?>"><h2><?= $user->username ?></h2></a>
    <p><?= "$user->firstName $user->lastName" ?></p>
    <p><?= $user->email ?></p>
    <?= $user->gravatar; ?>
</div>
