<?php
namespace anax\View;

$titleH1 = isset($title) ? '<div class="flex-center">'."<h1>".$title."</h1></div>" : null;

$icon = '<img src="https://img.icons8.com/ios/15/53d794/back-filled.png">';
$backButton = isset($back) ? '<div class="flex-left icon-button">'."<a href=".url($back['link']).">{$icon}{$back['name']}</a></div>" : null;

if (isset($action)) {
    $id = slugify($action["name"])."Button";
};

$actionButton = isset($action) ? '<div class="flex-right">'."<a class='${id}' id='${id}' href=".url($action['link']).">{$action['name']}</a></div>" : null;
?>

<div class="container-col header">
    <?= $titleH1 ?>
    <div class="container-row">
        <?= $backButton ?>
        <?= $actionButton ?>
    </div>
</div>
