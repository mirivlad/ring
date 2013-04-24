<?php
$this->load->view('templates/header');
?>

<div class="span10">
    <fieldset><legend>{title}</legend>
    <?php
    // Show error
    //echo validation_errors($this->config->item('DX_validation_error_prefix'),$this->config->item('DX_validation_error_suffix'));

    ?>
    <div class="text-center">{pagination}</div>
    <?= form_open($this->uri->uri_string());?>
    <?= form_submit('activate', 'Активировать', ' class="btn btn-primary"');?>
    <hr/>
    <table class="table table-striped table-bordered" width="100%">
        <tr>
            <th></th>
            <th>Логин</th>
            <th>Email</th>
            <th>IP</th>
            <th>Ключ активации</th>
            <th>Дата регистрации</th>
        </tr>
	<?php
	
    foreach ($users as $user) {
	?>
	<tr>
    	    <td>
		    <?= form_checkbox('checkbox_' . $user->id, $user->username) . form_hidden('key_' . $user->id, $user->activation_key) ?>
    	    </td>
    	    <td>
    		<?= $user->username ?>
    	    </td>
    	    <td>
    		<?= $user->email ?>
    	    </td>
    	    <td>
    		<?= $user->last_ip ?>
    	    </td>
    	    <td>
    		<?= $user->activation_key ?>
    	    </td>
    	    <td>
    		<?= date('Y-m-d', strtotime($user->created)) ?>
    	    </td>
    	</tr>
	<?php
    }
    ?>
    </table>
    <?= form_close();?>
    <div class="text-center">{pagination}</div>
    </fieldset>
</div>
<?php
$this->load->view('templates/footer');
?>