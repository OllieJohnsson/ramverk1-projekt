<?php
namespace Anax\View;

?>




<a href="<?= url("users/$user->id") ?>"><?= $user->username ?></a>
<p>Frågor: <?= $user->questions ?></p>
<p>Svar: <?= $user->answers ?></p>
<p>Kommentarer: <?= $user->questionComments + $user->answerComments ?></p>
