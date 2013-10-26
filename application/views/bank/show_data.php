<?php
$this->load->view('templates/header');
?>
<fieldset style='border-bottom: 1px black dotted;'>
    <legend style='border: 0px;'><i class="icon-bookmark"></i> <?= $title ?><br>
        <span class="label label-success">
            <i class="icon-user" style="color:white;"></i> <a style='color:#EEFF86;' href='/auth/show_profile/<?= $info['author_id'] ?>'><?= $author_name ?></a>
        </span> 
        <span class="label label-success">
            <i class="icon-time" style="color:white;"></i> <?php echo date("d-m-Y H:i:s", $info["create_date"]); ?>
        </span>
        <strong style="font-size: 0.5em; float: right;"><a href="/data/edit_data/<?=$info["id_data"]?>"><span class="icon icon-edit"></span>Редактировать</a>&nbsp;&nbsp;&nbsp;
            <a href="/data/delete_data/<?=$info["id_data"]?>" onClick="return window.confirm('Уверены что хотите удалить эту запись?')"><span class="icon icon-minus-sign"></span>Удалить</a>
        </strong>
    </legend>
    <p style='padding-bottom: 2px; border-bottom: 1px black dotted; border-top: 1px black dotted;' >
        <strong>Теги: </strong>
        <?php
        foreach ($tags as $tag => $value) {
            ?>
            <span class="badge badge-info"><a style="color:white;" href='/tag/<?= $tag ?>'><?= $value ?></a></span>
            <?php
        }
        ?>
    </p>
    <p><?= $info['content'] ?></p>
</fieldset>
<p style='padding-bottom: 2px; border-bottom: 1px black dotted;' >
    <strong>Теги: </strong>
    <?php
    foreach ($tags as $tag => $value) {
        ?>
        <span class="badge badge-info"><a style="color:white;" href='/tag/<?= $tag['id_tag'] ?>'><?= $value ?></a></span>
            <?php
        }
        ?>
</p>
<?php
$this->load->view('templates/footer');
?>
