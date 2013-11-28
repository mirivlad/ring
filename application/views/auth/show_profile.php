<?php
$avatar_img = $this->utils->user_get_avatar($user_profile->user_id);
$this->load->view('templates/header');
?>

<div class="span10">

    <fieldset>
        <legend><?= $title ?> : <?= $user_profile->login ?> <a href="/auth/edit_profile/<?=$user_profile->user_id?>"><i class="icon-edit"></i> Редактировать</a></legend>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span1">
                    <img src="/assets/img/avatars/<?= $avatar_img ?>" style="padding-bottom: 0.2em;"/>
                </div>
                <div class="span10">
                        <strong><?= $user_profile->surname ?> <?= $user_profile->first_name ?> <?= $user_profile->middle_name ?></strong><br><br>
                        <strong>Пол: </strong><?= $user_profile->sex ?><br><br>
                        <strong>Дата рождения: </strong><?= $user_profile->birthdate ?><br><br>
                        <strong>Страна: </strong><?= $user_profile->country ?><br><br>
                        <strong>Город: </strong><?= $user_profile->city ?><br><br>
                        <strong>Сайт: <a href="<?= $user_profile->website ?>"><?= $user_profile->website ?></a></strong><br><br>
                    <div class="span10">
                        <?= $user_profile->description ?>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</div>

<?php
$this->load->view('templates/footer');
?>