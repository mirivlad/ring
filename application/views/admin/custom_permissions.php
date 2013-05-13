<?php
$this->load->view('templates/header');
?>

<div class="span10">
    <fieldset><legend><?=$title?></legend>
    <?php
    echo '<b>Выберите роль для настройки её разрешений.</b><br/><br/>';

    // Build drop down menu
    foreach ($roles as $role) {
	$options[$role->id] = $role->name;
    }

    // Change allowed uri to string to be inserted in text area
    if (!empty($allowed_uri)) {
	$allowed_uri = implode("\n", $allowed_uri);
    }

    if (empty($edit)) {
	$edit = FALSE;
    }

    if (empty($delete)) {
	$delete = FALSE;
    }

    // Build form
    echo form_open($this->uri->uri_string(), ' class="form-inline"');
?>
    <div class="control-group">
	<label class="control-label" for="role">Роль</label>
	<div class="controls">
	    <?php 
		echo form_dropdown('role', $options, $selected_role,' id="role"');
		echo form_submit('show', 'Показать разрешения', ' class="btn btn-primary"');
	    ?>
	</div>
    </div>
<?php
    echo form_label('', 'uri_label');

    echo '<hr/>';

    echo form_checkbox('edit', '1', $edit);
    echo form_label(' Разрешить правку', 'edit_label', 'class="checkbox inline"');
    echo '<br/>';

    echo form_checkbox('delete', '1', $delete);
    echo form_label(' Разрешить удаление', 'delete_label', 'class="checkbox inline"');
    echo '<br/>';

    echo '<br/>';
    echo form_submit('save', 'Сохранить', ' class="btn btn-primary"');

    echo '<br/>';
    echo '<hr/>';
    echo '<br/>';
    echo 'Откройте ' . anchor('auth/custom_permissions/') . ' для просмотра результата, попробуйте войти и проверить пользователя которого вы настраивали.<br/>';
    echo 'Если вы изменяли собственную Роль, то вам требуется перезайти чтобы увидеть изменения.';

    echo form_close();
    ?>
    </fieldset>
</div>
<?php
$this->load->view('templates/footer');