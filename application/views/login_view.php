<?php
$this->load->view('templates/header');
?>

<h2>User Login</h2>

<?php if (!empty($message)) { ?>
    <div id="message">
        <?php echo $message; ?>
    </div>
<?php } ?>

<?php echo form_open(current_url(), 'class="form-horizontal"'); ?>  	
<fieldset>
    <legend>Вход в систему</legend>
    <ul class="unstyled">
        <li>
            <div class="input-prepend">
                <span class="add-on">Логин</span>
                <input class="span10" id="prependedInput" type="text" placeholder="Логин" name="login_identity" value="<?php //echo set_value('login_identity', 'admin@admin.com'); ?>"/>
            </div>
            &nbsp;
            <div class="input-prepend">
                <span class="add-on">Пароль</span>
                <input class="span10" id="prependedInput" type="password" placeholder="Пароль" name="login_password" value="<?php //echo set_value('login_password', 'password123'); ?>"/>
            </div> 
            
            <input type="submit" name="login_user" id="submit" value="Вход" class="btn btn-primary" style="margin-left: 1.4em;">
        </li>
        <?php
        # Below are 2 examples, the first shows how to implement 'reCaptcha' (By Google - http://www.google.com/recaptcha),
        # the second shows 'math_captcha' - a simple math question based captcha that is native to the flexi auth library. 
        # This example is setup to use reCaptcha by default, if using math_captcha, ensure the 'auth' controller and 'demo_auth_model' are updated.
        # reCAPTCHA Example
        # To activate reCAPTCHA, ensure the 'if' statement immediately below is uncommented and then comment out the math captcha 'if' statement further below.
        # You will also need to enable the recaptcha examples in 'controllers/auth.php', and 'models/demo_auth_model.php'.
        #/*
        if (isset($captcha)) {
            echo "<li>\n";
            echo $captcha;
            echo "</li>\n";
        }
        #*/

        /* math_captcha Example
          # To activate math_captcha, ensure the 'if' statement immediately below is uncommented and then comment out the reCAPTCHA 'if' statement just above.
          # You will also need to enable the math_captcha examples in 'controllers/auth.php', and 'models/demo_auth_model.php'.
          if (isset($captcha))
          {
          echo "<li>\n";
          echo "<label for=\"captcha\">Captcha Question:</label>\n";
          echo $captcha.' = <input type="text" id="captcha" name="login_captcha" class="width_50"/>'."\n";
          echo "</li>\n";
          }
          # */
        ?>
        <li class="checkbox">
            <div >
                Запомнить меня <input type="checkbox" name="remember_me" value="1" <?php //echo set_checkbox('remember_me', 1); ?>/>
            </div>
            
        </li>
        <li>
            <small>Note: On this demo, 3 failed login attempts will raise security on the account, activating a 10 second time limit ban per login attempt (20 secs after 9+ attempts), and activation of a captcha that must be completed to login.</small> 
        </li>
        <li>
            <hr/>
            <a href="/auth/forgotten_password">Reset Forgotten Password</a>
        </li>
        <li>
            <a href="/auth/resend_activation_token">Resend Account Activation Token</a>
        </li>
    </ul>
</fieldset>

<fieldset>
    <legend>New Users</legend>
    <ul>
        <li>
            New users can register for an account.
        </li>
        <li>
            <hr/>
            <a href="/auth/register_account" class="">Register New Account</a>
        </li>
    </ul>
</fieldset>
<?php echo form_close(); ?>

<?php
$this->load->view('templates/footer');
?>