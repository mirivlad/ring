<?php
$this->load->view('templates/header');
?>
<fieldset>
    <legend><i class="icon-bookmark"></i> <?= $title ?></legend>
    <p>Возможно что выбранная вами запись никогда не существовала, или же вы намеренно указали неверный идентификатор.</p>
    <p>В любом случае, вы можете вернуться либо к  <a href="/bank">Списку Банков Данных</a> либо <a href="/data/add_data">Добавить</a> собственную запись в один из Банков Данных</p>
</fieldset>            
    <?php
    $this->load->view('templates/footer');
    ?>
