<?php
$this->load->view('templates/header');
?>

<div class="span10">
    <fieldset><legend>{title}</legend>
        Выполнение обновления базы данных до актуального состояния.
        {error}
    </fieldset>
</div>
<?php
$this->load->view('templates/footer');
?>