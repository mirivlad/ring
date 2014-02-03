<?php
$this->load->view('templates/header');
?>
<fieldset>
    <legend><i class="icon-bookmark"></i> <?= $title ?></legend>
<?php 
foreach ($tags as $tag) { 
?>
        <span class="badge badge-info" style="margin-bottom: 0.5em">
            <a style="color:white;" href='/tags/index/<?= $tag->id_tag ?>'><?= $tag->name ?> (<?=$this->bank_model->get_data_by_tag($tag->id_tag)->num_rows()?>)</a>
        </span>
<?php 
}
?>
</fieldset>            
<?php
$this->load->view('templates/footer');
?>
