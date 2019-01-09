<?php
namespace Anax\View;

?>




<a href="<?= url("questions/$question->id") ?>"><?= $question->title ?></a>
<p class="smallGrayText date"><?= $question->posted ?></p>
