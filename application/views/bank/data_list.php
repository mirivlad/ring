<?php
$this->load->view('templates/header');
?>
<fieldset>
    <legend><i class="icon-bookmark"></i> <?= $title ?>
        <span style="float: right;"><i class="icon-edit"></i> <a href="/data/add_data/<?= $bank_id ?>">Добавить запись в банк</a></span></legend>

    <?php
    if (is_array($list_data)) {
        ?><div class="text-center"><?= $pagination ?></div>
        <?php foreach ($list_data as $item) { ?>

            <table class="table table-striped table-bordered" width="100%">
                <tr>
                    <th width="2%"><a href="/data/show_data/<?= $item->id_data ?>"><?= $item->id_data ?></a></th>
                    <th width="20%" style="text-align: center;"><?php echo date("d-m-Y H:i:s", $item->create_date); ?></th>
                    <th width="20%"  style="text-align: center;"><a href="/auth/show_profile/<?= $item->author_id ?>"><?= $this->dx_auth->get_user_profile_name($item->author_id) ?></a></th>
                    <th  style="text-align: center;"><a href="/data/show_data/<?= $item->id_data ?>"><?= $item->title ?></a></th>
                </tr>
                <tr>
                    <td colspan="4"><?= $item->description ?>


                        <?php
                        $tags = $this->bank_model->show_tag_array($item->id_data);
                        if ($tags) {
                            ?>                                 
                            <p style='margin: .2em .2em .1em .2em; padding-top: .2em; border-top: 1px black dotted;' >
                                <strong>Теги: </strong> 
                                <?php
                                foreach ($tags as $tag => $value) {
                                    ?>

                                    <span class="badge badge-info">
                                        <a style="color:white;" href='/tag/<?= $tag ?>'><?= $value ?></a>
                                    </span>

                                    <?php
                                }
                                ?>
                            </p>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <?php if ($this->bank_model->check_owner_data($item->id_data)) {
                    ?>
                    <tr>
                        <td colspan="4"><strong>Опции: </strong>
                            <a href="/data/edit_data/<?= $item->id_data ?>"><span class="icon icon-edit"></span>Редактировать</a>&nbsp;&nbsp;&nbsp;
                            <a href="/data/delete_data/<?= $item->id_data ?>" onClick="return window.confirm('Уверены что хотите удалить эту запись?')"><span class="icon icon-minus-sign"></span>Удалить</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
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
