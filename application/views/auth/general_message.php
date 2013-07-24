<?php
$this->load->view('templates/header');
?>

<div class="span10">
    <fieldset><legend>Системное сообщение</legend>
	<?=$auth_message?>
    </fieldset>
</div>
<?php
$this->load->view('templates/footer');
?>