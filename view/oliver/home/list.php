<div class="list">
    <h2><?= $list["title"] ?></h2>
    <?php foreach ($list["list"] as $item) : ?>
        <?php include $list["template"]; ?>
    <?php endforeach; ?>
</div>
