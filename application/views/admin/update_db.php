<?php
$this->load->view('templates/header');
?>

<div class="span10">
    <fieldset><legend><?=$title?></legend>
        Выполнение обновления базы данных до актуального состояния.
        <?php if(isset($error)) echo $error ?>
    </fieldset>
</div>
<?php
$this->load->view('templates/footer');
?>