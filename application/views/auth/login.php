<?php
$username = array(
	'name'	=> 'username',
	'id'	=> 'username',
	'size'	=> 30,
	'value' => set_value('username')
);

$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30
);

$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0'
);

$confirmation_code = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8
);
//echo "<pre>";
//print_r(get_defined_vars());
//echo "</pre>";
?>
<?php
$this->load->view('templates/header');
?>

<div class="span10">
{ip}
<fieldset><legend>{title}</legend>
<?php echo form_open($this->uri->uri_string(), ' class="form-horizontal"')?>

<?php echo $this->dx_auth->get_auth_error(); ?>

<div class="control-group">
    <label class="control-label" for="inputName">Имя</label>
    <div class="controls">
        <input type="text" id="inputName" placeholder="Имя" name="username">
    </div>
    <?php echo form_error($username['name'], "<div class='controls text-error'>", "</div>"); ?>    
</div>
<div class="control-group">
    <label class="control-label" for="inputPassword">Пароль</label>
    <div class="controls">
        <input type="password" id="inputPassword" placeholder="Пароль" name="password">
    </div>
    <?php echo form_error($password['name'], "<div class='controls text-error'>", "</div>"); ?>
</div>    


<?php if ($show_captcha): ?>
<div class="control-group">
    <label class="control-label" for="inputcaptcha">Символы с картинки</label>
    <div class="controls">
        <input type="text" id="inputcaptcha" placeholder="Код с картинки" name="captcha">
    </div>
    <div class="controls text-info">Введите символы с этой картинки. Ноля на ней не бывает.</div>
    <div class="controls">
        <?php echo $this->dx_auth->get_captcha_image(); ?>
    </div>
    <?php echo form_error($confirmation_code['name'], "<div class='controls text-error'>", "</div>"); ?>
</div>    
<?php endif; ?>
<div class="control-group">
    <div class="controls">
        <label class="checkbox">
            <input type="checkbox" name="remember" value="1"> Запомнить меня
        </label>
    <?php echo form_submit('login','Вход', ' class="btn btn-primary"');?>
    </div>
</div>
<?php echo anchor($this->dx_auth->forgot_password_uri, 'Забыл пароль');?>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php
        if ($this->dx_auth->allow_registration) {
                echo anchor($this->dx_auth->register_uri, 'Регистрация');
        };
?>

<?php echo form_close()?>
</fieldset>
</div>
<?php
$this->load->view('templates/footer');
?>