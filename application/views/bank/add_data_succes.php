<?php
$this->load->view('templates/header');
$data_title = array(
              'name'        => 'data_title',
              'id'          => 'data_title',
              'value'       => '',
              'maxlength'   => '255',
              'style'       => 'width:50%',
              'placeholder' => 'Введите заголовок...',
            );
$data_description = array(
              'name'        => 'data_description ',
              'id'          => 'data_description ',
              'value'       => '',
              'cols'        => '50',
              'rows'        => '4',
              'style'       => 'width:50%',
              'placeholder' => 'Введите описание...',
            );
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
                <textarea id="data_text" style="width: 90%; height: 200px;" placeholder="Введите ваш текст записи сюда ..."></textarea>
                <script type="text/javascript">
                        $('#data_text').wysihtml5();
                </script>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <?php echo form_submit('add_content', 'Сохранить', ' class="btn btn-primary"'); ?>
                <?php echo form_reset('reset_content', 'Очистить', ' class="btn btn-warning"'); ?>
            </div>
        </div>
    <?php echo form_close() ?>
</fieldset>            
    <?php
    $this->load->view('templates/footer');
    ?>
