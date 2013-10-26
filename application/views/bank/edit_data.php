<?php
$this->load->view('templates/header');


//$bank_options = array();
//foreach ($banks as $value) {
//    $bank_options[$value['id_db']] = $value['name'];
//}
?>
<fieldset>
    <legend><i class="icon-edit"></i> <?= $title ?></legend>
    <?php echo form_open($this->uri->uri_string(), ' class="form-horizontal" method="post"') ?>
    <div class="control-group">
        <label class="control-label" for="data_title">Заголовок записи</label>
        <div class="controls">
            <?php echo form_input($data_title) ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="data_description">Описание записи</label>
        <div class="controls">
            <?php echo form_textarea($data_description) ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="data_text">Текст записи</label>
        <div class="controls">
            <?php echo form_textarea($data_text) ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="data_tag">Теги</label>
        <div class="controls">
            <input type="text" name="data_tag" placeholder="Теги" class="tm-input"/>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <?php echo form_submit('save_content', 'Сохранить', ' class="btn btn-primary"'); ?>
            <?php echo form_reset('reset_content', 'Очистить', ' class="btn btn-warning"'); ?>
        </div>
    </div>
    <input type="hidden" name="data_id" value="<?= $data_id ?>" />
    <?php echo form_close() ?>
</fieldset>            
<?php
$this->load->view('templates/footer');
?>