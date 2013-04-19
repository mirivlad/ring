<?php
$login = array(
    'name' => 'login',
    'id' => 'login',
    'maxlength' => 80,
    'size' => 30,
    'value' => set_value('login')
);
?>
<?php
$this->load->view('templates/header');
?>

<div class="span10">
    <fieldset><legend accesskey="D" tabindex="1">{title}</legend>
<?php echo form_open($this->uri->uri_string(), ' class="form-inline"'); ?>

	<?php echo $this->dx_auth->get_auth_error(); ?>


	<div class="control-group">
	    <label class="control-label" for="login">Введите ваш логин или email:</label>
	    <div class="controls">
		<?php echo form_input($login, ' placeholder="Логин/email"'); ?>
		<?php echo form_submit('reset', 'Сбросить пароль', ' class="btn btn-primary"'); ?>
	    </div>
		<?php echo form_error($login['name'], "<div class='controls text-error'>", "</div>"); ?>    
	</div>
	    <?php echo form_close() ?>
    </fieldset>
</div>
<?php
$this->load->view('templates/footer');
?>