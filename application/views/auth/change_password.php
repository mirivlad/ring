<?php
$this->load->view('templates/header');
?>
<h1><?php echo lang('change_password_heading');?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/change_password");?>
      <div class="input-prepend">
          <span class="add-on">Старый пароль</span>
            <?php echo form_input($old_password, '', '  class="span10" placeholder="***"');?>
      </div><br>
      <span class="small"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></span><br>
      <div class="input-prepend">
          <span class="add-on">Новый пароль</span>
            <?php echo form_input($new_password, '', '  class="span10" placeholder="***"');?>
      </div>
      <br>
      <div class="input-prepend">
          <span class="add-on">Подтвердите пароль</span>
            <?php echo form_input($new_password_confirm, '', '  class="span10" placeholder="***"');?>
      </div><br>
     <?php echo form_input($user_id, '', ' class="span2"');?>
      <p><?php echo form_submit('submit', lang('change_password_submit_btn'), ' class="btn btn-primary"');?></p>

<?php echo form_close();?>
<?php
$this->load->view('templates/footer');
?>