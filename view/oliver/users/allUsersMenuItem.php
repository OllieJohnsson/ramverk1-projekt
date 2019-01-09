<?php
namespace Anax\View;

?>

<div class="userList-item">
    <div class="container-row">
        <?= $user->gravatar; ?>
        <a href="<?= url("users/{$user->id}") ?>"><h1><?= $user->username ?></h1></a>
    </div>
    <div class="container-col">
        <p><?= "$user->firstName $user->lastName" ?></p>
        <p class="mail"><?= $user->email ?></p>
    </div>

</div>
