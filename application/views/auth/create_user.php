<?php
$this->load->view('templates/header');
?>
<h1><?php echo lang('create_user_heading');?></h1>
<p><?php echo lang('create_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/create_user");?>
      <div class="input-prepend">
          <span class="add-on"><i class="icon-user" style="color: #2a2;"></i></span>
            <?php echo form_input($first_name, '', '  class="span10" placeholder="Имя"');?>
      </div><br>
      <div class="input-prepend">
          <span class="add-on"><i class="icon-user" style="color: #a22;"></i></span>
            <?php echo form_input($last_name, '', '  class="span10" placeholder="Фамилия"');?>
      </div><br>
      <div class="input-prepend">
          <span class="add-on"><i class="icon-bank"></i></span>
            <?php echo form_input($company, '', '  class="span10" placeholder="Организация"');?>
      </div><br>
      <div class="input-prepend">
          <span class="add-on"><i class="icon-emailalt"></i></span>
            <?php echo form_input($email, '', '  class="span10" placeholder="Email"');?>
      </div><br>
      <div class="input-prepend">
          <span class="add-on"><i class="icon-phonealt"></i></span>
            <?php echo form_input($phone1, '', '  class="span1" placeholder="+7"');?> -
            <?php echo form_input($phone2, '', '  class="span2" placeholder="999"');?> -
            <?php echo form_input($phone3, '', '  class="span5" placeholder="999999"');?>
      </div><br>
      <div class="input-prepend">
          <span class="add-on"><i class="icon-key" style="color: #2a2;"></i></span>
            <?php echo form_input($password, '', '  class="span10" placeholder="Пароль"');?>
      </div><br>
      <div class="input-prepend">
          <span class="add-on"><i class="icon-key" style="color: #a22;"></i></span>
            <?php echo form_input($email, '', '  class="span10" placeholder="Подтвердите пароль"');?>
      </div>
      <p><?php echo form_submit('submit', lang('create_user_submit_btn'), ' class="btn btn-primary"');?></p>

<?php echo form_close();?>
<?php
$this->load->view('templates/footer');
?>