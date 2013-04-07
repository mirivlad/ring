<?php
$this->load->view('templates/header');
?>
<h1><?php echo lang('create_group_heading');?></h1>
<p><?php echo lang('create_group_subheading');?></p>

<?php echo $message;?>

<?php echo form_open("admin_panel/create_group");?>

      <p>
            <?php echo lang('create_group_name_label', 'group_name');?>
            <?php echo form_input($group_name, '', ' class="span2"');?>
      </p>

      <p>
            <?php echo lang('create_group_desc_label', 'description');?>
            <?php echo form_input($description, '', ' class="span2"');?>
      </p>

      <p><?php echo form_submit('submit', lang('create_group_submit_btn'), ' class="btn btn-primary"');?></p>

<?php echo form_close();?>
<?php
$this->load->view('templates/footer');
?>