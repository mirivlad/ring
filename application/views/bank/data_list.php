<?php
$this->load->view('templates/header');
?>
<fieldset>
    <legend><i class="icon-bookmark"></i> <?= $title ?></legend>

    <?php
    if (is_array($list_data)) {
        ?><div class="text-center"><?= $pagination ?></div>
        <?php foreach ($list_data as $item) { ?>

            <table class="table table-striped table-bordered" width="100%">
                <tr>
                    <th width="2%"><a href="/data/show_data/<?= $item["id_data"] ?>"><?= $item["id_data"] ?></a></th>
                    <th width="20%" style="text-align: center;"><?php echo date("d-m-Y H:i:s", $item["create_date"]); ?></th>
                    <th width="20%"  style="text-align: center;"><a href="/auth/show_profile/<?= $item["author_id"] ?>"><?php echo $this->dx_auth->get_user_name($item["author_id"]); ?></a></th>
                    <th  style="text-align: center;"><?= $item["title"] ?></th>
                </tr>
                <tr>
                    <td colspan="4"><?= $item["description"] ?></td>
                </tr>
            </table>
        <?php
    }
    ?>
        <div class="text-center"><?= $pagination ?></div>
        <?php
    } else {
        ?>
        <h5>
        <?= $list_data ?>
        </h5>
            <?php
        }
        ?>
</fieldset>            
    <?php
    $this->load->view('templates/footer');
    ?>
