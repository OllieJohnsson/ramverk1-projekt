<?php
namespace Anax\View;

?>

<div class="userList-item">
    <div class="container-row">
        <?= $user->gravatar($user->email); ?>
        <a class="largeText" href="<?= url("users/{$user->id}") ?>"><?= $user->username ?></a>
    </div>
    <div class="container-col">
        <p><?= "$user->firstName $user->lastName" ?></p>
        <p class="mail"><?= $user->email ?></p>
    </div>

</div>
