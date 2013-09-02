<?php
//$username = array(
//    'name' => 'username',
//    'id' => 'username',
//    'size' => 30,
//    'value' => set_value('username')
//);

$password = array(
    'name' => 'password',
    'id' => 'password',
    'size' => 30,
    'value' => set_value('password')
);

$confirm_password = array(
    'name' => 'confirm_password',
    'id' => 'confirm_password',
    'size' => 30,
    'value' => set_value('confirm_password'),
    'type' => 'password'
);

$email = array(
    'name' => 'email',
    'id' => 'email',
    'maxlength' => 80,
    'size' => 30,
    'value' => set_value('email')
);
$first_name = array(
    'name' => 'first_name',
    'id' => 'first_name',
    'maxlength' => 80,
    'size' => 30,
    'value' => set_value('first_name')
);
$surname = array(
    'name' => 'surname',
    'id' => 'surname',
    'maxlength' => 80,
    'size' => 30,
    'value' => set_value('surname')
);
$captcha = array(
    'name' => 'captcha',
    'id' => 'captcha'
);
?>

<?php
$this->load->view('templates/header');
?>

<div class="span10">

    <fieldset>
        <legend><?=$title?></legend>
        <?php echo form_open($this->uri->uri_string(), ' class="form-vertical"') ?>
        <p><strong><em>Все поля обязательны для заполнения!</em></strong></p>
        <div class="control-group">
            <label class="control-label" for="email"><i class="icon-inbox"></i> Адрес email (используется в качестве логина)</label>
            <div class="controls">
                <?php echo form_input($email) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="password"><i class="icon-key"  style="color:#5f5;"></i> Пароль</label>
            <div class="controls">
                <?php echo form_password($password) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="confirm_password"><i class="icon-key" style="color:#55f;"></i> Повторите пароль</label>
            <div class="controls">
                <?php echo form_input($confirm_password) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="first_name"><i class="icon-user" style="color:#0aa;"></i> Имя</label>
            <div class="controls">
                <?php echo form_input($first_name) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="surname"><i class="icon-user" style="color:#0aa;"></i> Фамилия</label>
            <div class="controls">
                <?php echo form_input($surname) ?>
            </div>
        </div>
        
        <?php 
        if (uri_string() != "admin/create_user") {
            if ($this->dx_auth->captcha_registration) { ?>

            <div class="control-group">
                <label class="control-label" for="captcha"><i class="icon-barcode"></i> Код с картинки</label>
                <div class="controls">
                    <?php echo form_input($captcha) ?>
                </div>
                <div class="controls text-info">Введите код с картинки. Ноля на ней не бывает.</div>
                <div class="controls"><?php echo $this->dx_auth->get_captcha_image(); ?></div>
            </div>
        <?php
            }
        }
        ?>
        <div class="control-group">
            <div class="controls">
                <?php echo form_submit('register', 'Регистрация', ' class="btn btn-primary"'); ?>
            </div>
        </div>
        


        <?php echo form_close() ?>
    </fieldset>
</div>
<?php
$this->load->view('templates/footer');
?>