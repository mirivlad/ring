<?php

$first_name = array(
    'name' => 'first_name',
    'id' => 'first_name',
    'size' => 30,
    'value' => $user_profile->first_name
);
$middle_name = array(
    'name' => 'middle_name',
    'id' => 'middle_name',
    'size' => 30,
    'value' => $user_profile->middle_name
);
$surname = array(
    'name' => 'surname',
    'id' => 'surname',
    'size' => 30,
    'value' => $user_profile->surname
);
$country = array(
    'name' => 'country',
    'id' => 'country',
    'size' => 30,
    'value' => $user_profile->country
);
$city = array(
    'name' => 'city',
    'id' => 'city',
    'size' => 30,
    'value' => $user_profile->city
);
$website = array(
    'name' => 'website',
    'id' => 'website',
    'size' => 30,
    'value' => $user_profile->website
);
$description = array(
    'name' => 'description',
    'id' => 'description',
    'cols' => 70,
    'rows' => 5,
    'class' => 'span7',
    'value' => $user_profile->description
);
$this->load->helper('date');
$birthdate = array(
    'name' => 'birthdate',
    'id' => 'birthdate',
    'size' => 16,
    'value' => date("d-m-Y",strtotime($user_profile->birthdate))
);

$sex_options = array(
    'men' => "мужской",
    'woman' => "женский",
    'not_set' => "не указано"
);

?>

<?php
$this->load->view('templates/header');
?>

<div class="span10">

    <fieldset>
        <legend>{title} : <?= $user_profile->login ?></legend>
        <?php echo form_open($this->uri->uri_string(), ' class="form-horizontal"') ?>
        <div class="control-group">
            <label class="control-label" for="surname">Фамилия</label>
            <div class="controls">
                <?php echo form_input($surname) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="first_name">Имя</label>
            <div class="controls">
                <?php echo form_input($first_name) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="middle_name">Отчество</label>
            <div class="controls">
                <?php echo form_input($middle_name) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="sex">Пол</label>
            <div class="controls">
                <?php echo form_dropdown('sex', $sex_options, $user_profile->sex, 'id="sex"') ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="birthdate">Дата рождения</label>
            <div class="controls">
                <div class="input-append date dropdown-toggle" id="dp3" data-date="<?= $birthdate['value'] ?>" data-date-format="dd-mm-yyyy" data-toggle="dropdown">
                    <?php echo form_input($birthdate) ?>
                    <span class="add-on"><i class="icon-calendar"></i></span>
                </div>
            </div>
        </div>    
        <div class="control-group">
            <label class="control-label" for="country">Страна</label>
            <div class="controls">
                <?php echo form_input($country) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="city">Город</label>
            <div class="controls">
                <?php echo form_input($city) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="website">Web-сайт</label>
            <div class="controls">
                <?php echo form_input($website) ?>
                <span class="text-warning">url вашего сайта вместе с http://</span>
            </div>
        </div>        


        <div class="control-group">
            <label class="control-label" for="description">Подпись</label>
            <div class="controls">
                <?php echo form_textarea($description) ?>
                <br>
                <span class="text-warning">Только текст. Максимум 1000 символов. Любые теги запрещены.</span>
            </div>
        </div>   


        <div class="control-group">
            <div class="controls">
                <?php echo form_submit('save', 'Сохранить', ' class="btn btn-primary"'); ?>
            </div>
        </div>



        <?php echo form_close() ?>
    </fieldset>
</div>

<?php
$this->load->view('templates/footer');
?>