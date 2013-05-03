<?php
$this->load->view('templates/header');
?>
	<div class="span10">
	    <h1>{title}</h1>
            <p><i class="icon-pencil"></i> <?= safe_mailto('me@my-site.com', 'Связаться с нами по почте')?></p>
            <p><img src="http://xkcd.ru/i/378_v1.png"></p>
        </div>
<?php
$this->load->view('templates/footer');
?>