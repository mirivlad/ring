<?php
$this->load->view('templates/header');
?>
<div class="span10">
    <h1><?php echo lang('login_heading'); ?></h1>
    <p><?php echo lang('login_subheading'); ?></p>

    <div id="infoMessage"><?php echo $message; ?></div>

    <?php echo form_open("auth/login"); ?>

    <p>
        <?php echo lang('login_identity_label', 'indentity'); ?>
        <?php echo form_input($identity); ?>
    </p>

    <p>
        <?php echo lang('login_password_label', 'password'); ?>
        <?php echo form_input($password); ?>
    </p>

    <p>
        <?php echo lang('login_remember_label', 'remember'); ?>
        <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"'); ?>
    </p>


    <p><?php echo form_submit('submit', lang('login_submit_btn'), ' class="btn btn-primary"');?></p>

    <?php echo form_close(); ?>

    <p><a href="forgot_password"><?php echo lang('login_forgot_password'); ?></a></p>
</div>
<?php
$this->load->view('templates/footer');
?>