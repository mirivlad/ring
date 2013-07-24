<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Проект "Кольцо" - <?= $title ?></title>
        <script src="/assets/js/jquery-1.9.1.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <link href="/assets/css/themes/<?php echo $this->config->item('theme'); ?>/bootstrap.min.css" rel="stylesheet" media="screen">
        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
            #arrow {
                background: #454545;
                height: 2em;
                position: fixed;
                bottom: 1em;
                right: 2em;
                cursor: pointer;
                padding: 0.3em 1em 0.1em 1em;
                border-radius: 0.5em;
                display: none;
                z-index: 9999;
            }
        </style>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/assets/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" media="all" href="/assets/css/font-awesome.min.css" />
        <!--[if IE 7]>
        <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css">
        <![endif]-->
        <?php
        echo $this->notify->initJsCss();
        ?>
        <?php
        if (isset($header_add) AND is_array($header_add)) {
            foreach ($header_add as $value) {
                echo $value;
            }
        }
        ?>
    </head>
    <body>
        <div id="content">
            <div class="navbar navbar-fixed-top" style="margin-bottom: 2em;">
                <div class="navbar-inner">
                    <div class="container">
                        <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>
                        <a class="brand" href="/">Проект "Кольцо"</a>
                        <div class="nav-collapse collapse navbar-responsive-collapse">
                            <ul class="menu nav">
                                <li><a href="/" >Главная</a></li>
                                <li><a href="/about">О проекте</a></li>
                                <li><a href="/github">Развитие движка проекта</a></li>
                                <li><a href="/contacts">Контакты</a></li>
                            </ul>
                            <form class="navbar-search pull-right" action="">
                                <input class="search-query span2" placeholder="Поиск..." type="text">
                            </form>
                            <ul class="nav pull-right">
                                <li class="divider-vertical"></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Действия <b class="caret"></b></a>
                                    <?php
                                    if (!$this->dx_auth->is_logged_in()) {
                                        ?>
                                        <ul class="dropdown-menu">
                                            <li class="nav-header">Вход на сайт</li>
                                            <li>
                                                <form class="form-inline" action="/auth/login" method="post" accept-charset="utf-8" style="margin: 0em 1em 0em 1em;">
                                                    <div class="input-prepend">
                                                        <span class="add-on"><i class="icon-user"></i></span>
                                                        <input type="text" name="username" id="username" class="span2" placeholder="Логин">
                                                    </div>
                                                    <div class="input-prepend">
                                                        <span class="add-on"><i class="icon-key"></i></span>
                                                        <input type="password" name="password" id="password" class="span2" placeholder="Пароль">
                                                    </div>
                                                    <input type="hidden" name="redirect_url" value="<?= current_url() ?>" />
                                                    <input type="hidden" name="remember" value="1" />
                                                    <input name="login" value="Вход" type="submit" class="btn">

                                                </form>
                                            </li>
                                            <li class="divider"></li>
                                            <?php if ($this->dx_auth->allow_registration) { ?>
                                                <li><a href="/auth/register">Регистрация</a></li>
                                            <?php } ?>
                                            <li><a href="/auth/forgot_password">Забыли пароль?</a></li>
                                        </ul>
                                    <?php } else { ?>
                                        <ul class="dropdown-menu">
                                            <li class="nav-header">Данные</li>
                                            <li><a href="/data/add_data">Добавить запись в Банк Данных</a></li>
                                            <li class="divider"></li>
                                            <li class="nav-header">Аккаунт</li>
                                            <li><a href="/auth/edit_profile">Изменить профиль</a></li>
                                            <li><a href="/auth/change_password">Сменить пароль</a></li>
                                            <li><a href="/auth/logout">Выход</a></li>
                                            <?php if ($this->dx_auth->is_admin()) { ?>
                                                <li class="divider"></li>
                                                <li class="nav-header">Администрирование</li>
                                                <li><a href="/admin/users/">Список пользователей</a></li>
                                                <li><a href="/admin">Панель администратора</a></li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </li>
                                <li class="divider-vertical"></li>
                            </ul>
                        </div><!-- /.nav-collapse -->
                    </div>
                </div>

                <?= $this->notify->getMessages() ?>

            </div>
            <div class="container-fluid">
                <div class="row-fluid">
                    <?php $this->load->view('templates/sidebar'); ?>
                    <div class="span10">