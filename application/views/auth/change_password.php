<?php
$this->load->view('templates/header');
?>
<h1><?php echo lang('change_password_heading');?></h1>

<?php echo $message;?>

<?php echo form_open("auth/change_password", ' class="form-horizontal"');?>
      <div class="control-group">
          <label class="control-label" for="old_pass">Старый пароль</label>
	  <div class="controls">
	      <?php echo form_input($old_password, '', ' id="old_pass" placeholder="***"');?>
	  </div>
      </div>
      <div class="control-group">
          <label class="control-label" for="new_pass">Новый пароль</label>
	  <div class="controls">
	      <?php echo form_input($new_password, '', ' id="new_pass" placeholder="***"');?>
	  </div> 
	  <div class="controls muted"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></div>
      </div>
      <div class="control-group">
          <label class="control-label" for="new_pass_conf">Подтвердите пароль</label>
	  <div class="controls">
	      <?php echo form_input($new_password, '', ' id="new_pass_conf" placeholder="***"');?>
	  </div> 
      </div>
     <?php echo form_input($user_id, '', ' class="span2"');?>
      <p><?php echo form_submit('submit', lang('change_password_submit_btn'), ' class="btn btn-primary"');?></p>

<?php echo form_close();?>
<?php
$this->load->view('templates/footer');
?>