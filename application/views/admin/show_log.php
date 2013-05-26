<?php
$this->load->view('templates/header');
?>

<div class="span10">
    <fieldset><legend><?=$title?></legend>
        <pre><?php print_r($log)?></pre>
    </fieldset>
</div>
<?php
$this->load->view('templates/footer');
?>
