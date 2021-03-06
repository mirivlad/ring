<?php
$this->load->view('templates/header');
$bank = $this->bank_model->bank_info($info->db_id);
//print_r($bank);
?>
<fieldset style='border-bottom: 1px black dotted;'>
    <legend style='border: 0px;'><i class="icon-bookmark"></i> <?= $title ?>
        <?php if ($this->bank_model->check_owner_data($info->id_data)) {
            ?>
            <strong style="font-size: 0.5em; float: right;"><a href="/data/edit_data/<?= $info->id_data ?>"><span class="icon icon-edit"></span>Редактировать</a>&nbsp;&nbsp;&nbsp;
                <a href="/data/delete_data/<?= $info->id_data ?>" onClick="return window.confirm('Уверены что хотите удалить эту запись?')"><span class="icon icon-minus-sign"></span>Удалить</a>
            </strong>
            <?php
        }
        ?><br>
        <a class="btn btn-info" href="/bank/index/<?= $bank->id_db ?>" style="color: white;">
            Банк данных :: <?= $bank->name ?>
        </a><br>
        <span class="label label-success">
            <i class="icon-user" style="color:white;"></i> <a style='color:#EEFF86;' href='/auth/show_profile/<?= $info->author_id ?>'><?= $author_name ?></a>
        </span> 
        <span class="label label-success">
            <i class="icon-time" style="color:white;"></i> <?php echo date("d-m-Y H:i:s", $info->create_date); ?>
        </span>

    </legend>


    <?php
    if (is_array($tags)) {
        ?><p style='padding-bottom: 2px; border-bottom: 1px black dotted; border-top: 1px black dotted;' >
            <strong>Теги: </strong>
            <?php
            foreach ($tags as $tag => $value) {
                ?>
                <span class="badge badge-info"><a style="color:white;" href='/tags/index/<?= $tag ?>'><?= $value ?></a></span>
                <?php
            }
            ?></p>
            <?php
        }
        ?>

    <p><?= $info->content ?></p>
</fieldset>
<?php
if (is_array($tags)) {
    ?><p style='padding-bottom: 2px; border-bottom: 1px black dotted; border-top: 1px black dotted;' >
        <strong>Теги: </strong>
        <?php
        foreach ($tags as $tag => $value) {
            ?>
            <span class="badge badge-info"><a style="color:white;" href='/tag/<?= $tag ?>'><?= $value ?></a></span>
                <?php
            }
            ?></p>
    <?php
}
$this->load->view('templates/footer');
?>
