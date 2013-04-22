<?php
$this->load->view('templates/header');
?>

<div class="span10">
    <fieldset><legend>{title}</legend>
	<?php
	// Build drop down menu
	foreach ($roles as $role) {
	    $options[$role->id] = $role->name;
	}

	// Change allowed uri to string to be inserted in text area
	if (!empty($allowed_uris)) {
	    $allowed_uris = implode("\n", $allowed_uris);
	}

	// Build form
	echo form_open($this->uri->uri_string());
	?>
	<div class="control-group">
	    <div class="input-prepend input-append">
		<span class="add-on">Роль</span>
		<?php
		echo form_dropdown('role', $options, ' style="height:0.9em;"');
		echo form_submit('show', 'Показать', ' class="btn btn-info"')
		?>


	    </div>
	</div>
	<?php
	echo form_label('', 'uri_label');

	echo '<hr/>';

	echo '<h5>Разрешенные URI (Один URI на линию) :</h5>';

	echo "<blockquote class='text-info'>Введите <span class='label label-info'>'/'</span> для разрешения доступа Роли ко всем URI.<br/>";
	echo "Введите <span class='label label-info'>'/controller/'</span> для разрешения доступа Роли к контроллеру и всем его функциям.<br/>";
	echo "Введите <span class='label label-info'>'/controller/function/'</span> для разрешения доступа Роли только к определенной ункции контроллера.<br/><br/>";
	echo "<div class='label label-warning'>Эти правила будут работать только если в вашем контроллере используется функция check_uri_permissions()</div></blockquote>.";

	echo form_textarea('allowed_uris', $allowed_uris, ' class="span6"');

	echo '<br/>';
	echo form_submit('save', 'Сохранить права доступа к URI', ' class="btn btn-primary"');

	echo form_close();
	?>
    </fieldset>
</div>
<?php
$this->load->view('templates/footer');
?>