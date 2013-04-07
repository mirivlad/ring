<?php
$this->load->view('templates/header');
?>
    <h1><?php echo lang('index_heading'); ?></h1>
    <p><?php echo lang('index_subheading'); ?></p>

    <div id="infoMessage"><?php echo $message; ?></div>
    <div class="text-center">{pagination}</div>
    <table class="table table-striped table-bordered" width="100%">
        <tr>
            <th><?php echo lang('index_fname_th'); ?></th>
            <th><?php echo lang('index_lname_th'); ?></th>
            <th><?php echo lang('index_email_th'); ?></th>
            <th><?php echo lang('index_groups_th'); ?></th>
            <th><?php echo lang('index_status_th'); ?></th>
            <th><?php echo lang('index_action_th'); ?></th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user->first_name; ?></td>
                <td><?php echo $user->last_name; ?></td>
                <td><?php echo $user->email; ?></td>
                <td>
                    <?php foreach ($user->groups as $group): ?>
                        <?php echo anchor("admin/edit_group/" . $group->id, $group->name); ?><br />
                    <?php endforeach ?>
                </td>
                <td><?php echo ($user->active) ? anchor("admin_panel/deactivate/" . $user->id, '<i style="color:green;" class="icon-lightbulb-idea""></i> '.lang('index_active_link')) : anchor("admin_panel/activate/" . $user->id, '<i style="color:red;" class="icon-lightbulb-idea""></i> '.lang('index_inactive_link')); ?></td>
                <td><?php echo anchor("admin_panel/edit_user/" . $user->id, '<i class="icon-editalt"></i>'); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="text-center">{pagination}</div>
    <p><?php echo anchor('admin_panel/create_user', lang('index_create_user_link')) ?> | <?php echo anchor('admin_panel/create_group', lang('index_create_group_link')) ?></p>
<?php
$this->load->view('templates/footer');
?>