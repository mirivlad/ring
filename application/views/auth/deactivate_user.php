<?php
$this->load->view('templates/header');
?>
<h1><?php echo lang('deactivate_heading'); ?></h1>

<p><?php echo sprintf(lang('deactivate_subheading'), $user->username); ?></p>

<div class="btn-group" data-toggle-name="confirm" data-toggle="buttons-radio" >
  <button type="button" class="btn btn-danger" data-toggle="button" value="0">Неактивный</button>
  <button type="button" class="btn btn-info" data-toggle="button" value="1">Активный</button>
</div>

<?php echo form_open("auth/deactivate/" . $user->id, ' class="form-horizontal"'); ?>
<input type="hidden" id="confirm" value="" />

<?php echo form_hidden($csrf); ?>
<?php echo form_hidden(array('id' => $user->id)); ?>

<br><br>

<p><?php echo form_submit('submit', lang('deactivate_submit_btn'), ' class="btn btn-primary"'); ?></p>

<?php echo form_close(); ?>

<?php
$this->load->view('templates/footer');
?>