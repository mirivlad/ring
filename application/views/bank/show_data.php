<?php
$this->load->view('templates/header');
?>
<fieldset>
    <legend><i class="icon-bookmark"></i> <?= $title ?><br>
        <span class="label label-success">
            <i class="icon-user" style="color:white;"></i> <a href='/auth/show_profile/<?= $info['author_id'] ?>'><?=$author_name?></a>
        </span> 
        <span class="label label-success">
            <i class="icon-time" style="color:white;"></i> <?php echo date("d-m-Y H:i:s", $info["create_date"]); ?>
        </span>
    </legend>
        <p><?= $info['content'] ?></p>
</fieldset>
<p>
    Теги: 
    <?php
    foreach ($tags as $tag => $value){
     ?>
        <span class="badge badge-info"><a href='/tag/<?=$tag['id_tag']?>'><?=$value?></a></span>
    <?php
    }
    ?>
</p>
    <?php
    $this->load->view('templates/footer');
    ?>
