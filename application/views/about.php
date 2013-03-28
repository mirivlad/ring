<?php
$this->load->view('templates/header');
?>

<div class="container-fluid">
    <div class="row-fluid">
	<div class="span2">
	    <ul class="nav nav-list">
		<li class="nav-header">List header</li>
		<li class="active"><a href="#">Home</a></li>
		<li><a href="#">Library</a></li>
	    </ul>
	</div>
	<div class="span10">
	    <h1>О проекте CI-Проект</h1>
	    <p>The page you are looking at is being generated dynamically by CodeIgniter.</p>
	    <p>If you would like to edit this page you'll find it located at:</p>

	    <code>application/views/welcome_message.php</code>

	    <p>The corresponding controller for this page is found at:</p>

	    <code>application/controllers/welcome.php</code>

	    <p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p>
	</div>
    </div>
</div>

<?php
$this->load->view('templates/footer');
?>