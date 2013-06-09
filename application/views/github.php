<?php
$this->load->view('templates/header');
?>
<fieldset>
    <legend><?=$title?></legend>
    <h4>Последние изменения в коде проекта. Данные получены из ATOM-ленты GitHub.</h4>
    <hr>
    <br>
    <?php foreach ($news as $item) { ?>
        <div class="well well-small">
            <h5>
                <i class="icon-chevron-down"></i> <a href="<?= $item["link"] ?>"><?= $item["title"] ?></a>
            </h5>
            <div class="well well-small">
                <?= $item["description"] ?>
            </div>
            <div style="margin-top:-0.5em;">
                <i class='icon-time'></i> <?= date("d.m.Y (H:i)", $item["pubDate"]) ?>
                &nbsp;::&nbsp;
                <i class="icon-user"></i> <a href="<?= $item['author_link'] ?>"><?= $item['author'] ?></a>
            </div>
        </div>
    <?php } ?>
</fieldset>            
<?php
$this->load->view('templates/footer');
?>