<?php
$this->load->view('templates/header');
?>

<div class="span10">
    <fieldset><legend>{title}</legend>
    <?php
    // Show error
    //echo validation_errors($this->config->item('DX_validation_error_prefix'),$this->config->item('DX_validation_error_suffix'));


    // Build drop down menu
    $options[0] = 'Нет';
    foreach ($roles as $role) {
	$options[$role->id] = $role->name;
    }

    // Build table
    $this->table->set_heading('', 'ID', 'Название', 'ID родительской роли');

    foreach ($roles as $role) {
	$this->table->add_row(form_checkbox('checkbox_' . $role->id, $role->id), $role->id, $role->name, $role->parent_id);
    }

    // Build form
    echo form_open($this->uri->uri_string(), ' class="form-inline"');
    ?>
    <div class="control-group">
	<label class="control-label" for="parent_role">Родительская роль</label>
	<div class="controls">
	    <?php echo form_dropdown('role_parent', $options, ' id="parent_role"'); ?>
	</div>
    </div>
    <div class="control-group">
	<label class="control-label" for="role_name">Имя роли</label>
	<div class="controls">
	    <?php
	    echo form_input('role_name', '', ' id="role_name"');
	    echo form_submit('add', 'Добавить роль', ' class="btn btn-primary"')." ";
	    echo form_submit('delete', 'Удалить выбранную роль', ' class="btn btn-danger"');
	    ?>
	</div>
    </div>
    <?php
    echo '<hr/>';

    // Show table
    echo $this->table->generate();

    echo form_close();
    ?>
    </fieldset>
</div>
<?php
$this->load->view('templates/footer');