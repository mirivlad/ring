<?php
$old_password = array(
    'name' => 'old_password',
    'id' => 'old_password',
    'size' => 30,
    'value' => set_value('old_password')
);

$new_password = array(
    'name' => 'new_password',
    'id' => 'new_password',
    'size' => 30
);

$confirm_new_password = array(
    'name' => 'confirm_new_password',
    'id' => 'confirm_new_password',
    'size' => 30
);
?>
<?php
$this->load->view('templates/header');
?>

<div class="span10">
    <fieldset><legend><?=$title?></legend>
	<?php echo form_open($this->uri->uri_string(), ' class="form-inline"'); ?>

	<?php echo $this->dx_auth->get_auth_error(); ?>

	<dl>
	    <dt><?php echo form_label('Старый пароль', $old_password['id']); ?></dt>
	    <dd>
		<?php echo form_password($old_password); ?>
	    </dd>

	    <dt><?php echo form_label('Новый пароль', $new_password['id']); ?></dt>
	    <dd>
		<?php echo form_password($new_password); ?>
	    </dd>

	    <dt><?php echo form_label('Подтвердите новый пароль', $confirm_new_password['id']); ?></dt>
	    <dd>
		<?php echo form_password($confirm_new_password); ?>
	    </dd>

	    <br>
	    <dd><?php echo form_submit('change', 'Сменить пароль', ' class="btn btn-primary"'); ?></dd>
	</dl>

	<?php echo form_close() ?>
    </fieldset>
</div>
<?php
$this->load->view('templates/footer');
?>