<?php
$this->load->view('templates/header');
?>

<div class="span10">
    <fieldset><legend>{title}</legend>

 
<?php   
    // Show error
    //echo validation_errors($this->config->item('DX_validation_error_prefix'),$this->config->item('DX_validation_error_suffix'));
    echo form_open($this->uri->uri_string());

    echo form_submit('ban', 'Забанить', ' class="btn btn-warning"') . " ";
    echo form_submit('unban', 'Разбанить', ' class="btn btn-primary"') . " ";
    echo form_submit('reset_pass', 'Сбросить пароль', ' class="btn btn-danger"');

    echo '<hr/>';
    ?>

    <div class="text-center">{pagination}</div>
    <table class="table table-striped table-bordered" width="100%">
        <tr>
            <th></th>
            <th>ID</th>
            <th>Аватар</th>
            <th>Логин</th>
            <th>Email</th>
            <th>Роль</th>
            <th>Бан</th>
            <th>Последний IP</th>
            <th>Последний вход</th>
            <th>Дата регистрации</th>
            <th>Опции</th>
        </tr>
	<?php
	foreach ($users as $user) {
	    $banned = ($user->banned == 1) ? '<i style="color:red;">Забанен</i>' : '<i style="color:green;">Не забанен</i>';
            $avatar = $this->user_profile->get_profile_field($user->id, "avatar")->result()[0]->avatar;
            
	    ?>
    	<tr>
    	    <td><?php echo form_checkbox('checkbox_' . $user->id, $user->id) ?></td>
    	    <td><?= $user->id ?></td>
            <td><img src="/assets/img/avatars/<?=$avatar?>"</td>
    	    <td><?= $user->username ?></td>
    	    <td><?= $user->email ?></td>
    	    <td><?= $user->role_name ?></td>
    	    <td><div class="text-center"><?= $banned ?></div></td>
    	    <td><?= $user->last_ip ?></td>
    	    <td><?= date('Y-m-d', strtotime($user->last_login)) ?></td>
    	    <td><?= date('Y-m-d', strtotime($user->created)) ?></td>
            <td><a href="/auth/edit_profile/<?= $user->id ?>"><i class="icon-edit"></i> Изменить профиль</a></td>
    	</tr>
	    <?php
	}
	?>
    </table>
    <?php echo form_close(); ?>
    <div class="text-center">{pagination}</div>
    </fieldset>
</div>
<?php
$this->load->view('templates/footer');
?>