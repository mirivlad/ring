<?php
$this->load->view('templates/header');
?>
<fieldset>
    <legend><?=$title?></legend>

    <?php foreach ($banks as $item) { ?>
        <div class="well well-small">
            <h5>
                <i class="icon-chevron-down"></i> <a href="/bank/index/<?= $item["id_db"] ?>"><?= $item["name"] ?></a>
            </h5>
        </div>
    <?php } ?>
</fieldset>            
<?php
$this->load->view('templates/footer');
?>
