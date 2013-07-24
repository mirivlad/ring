<?php
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size' 	=> 30
);

?>
<?php
$this->load->view('templates/header');
?>

<div class="span10">

<fieldset>
<legend><?=$title?></legend>
<?php echo form_open($this->uri->uri_string()); ?>

<?php echo $this->dx_auth->get_auth_error(); ?>

<dl>
	<dt><?php echo form_label('Ваш пароль', $password['id']); ?></dt>
	<dd>
		<?php echo form_password($password); ?>
	</dd>
	<dt></dt>
	<dd><?php echo form_submit('cancel', 'Деактивировать', ' class="btn btn-primary"'); ?></dd>
</dl>

<?php echo form_close(); ?>
</fieldset>
</div>
<?php
$this->load->view('templates/footer');
?>