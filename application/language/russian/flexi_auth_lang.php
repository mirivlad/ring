<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Name: flexi auth lang - English
 * 
 * Author: 
 * Rob Hussey
 * flexiauth@haseydesign.com
 * haseydesign.com/flexi-auth
 *
 * Released: 13/09/2012
 *
 * Description:
 * English language file for flexi auth
 *
 * Requirements: PHP5 or above and Codeigniter 2.0+
 */
// Account Creation
$lang['account_creation_successful'] = 'Ваш аккаунт создан.';
$lang['account_creation_unsuccessful'] = 'Создание аккаунта прервано.';
$lang['account_creation_duplicate_email'] = 'Аккаунт с таким email уже существует.';
$lang['account_creation_duplicate_username'] = 'Аккаунт с таким именем уже есть.';
$lang['account_creation_duplicate_identity'] = 'Аккаунт с таким идентификатором уже существует.';
$lang['account_creation_insufficient_data'] = 'Недостаточно данных для создания аккаунта. Убедитесь в корректности отправляемых идентификатора и пароля.';

// Password
$lang['password_invalid'] = "Поле %s неверно.";
$lang['password_change_successful'] = 'Пароль изменен.';
$lang['password_change_unsuccessful'] = 'Отправляемый вами пароль не совпадает с известным нам.';
$lang['password_token_invalid'] = 'Ваш токен пароля неверен или период его действия истек.';
$lang['email_new_password_successful'] = 'Новый пароль выслан вам на почту.';
$lang['email_forgot_password_successful'] = 'Вам отправлено письмо с инструкцией для сброса пароля.';
$lang['email_forgot_password_unsuccessful'] = 'Не удалось сбросить пароль.';

// Activation
$lang['activate_successful'] = 'Аккаунт активирован.';
$lang['activate_unsuccessful'] = 'Не удалось активировать аккаунт.';
$lang['deactivate_successful'] = 'Аккаунт деактивирован';
$lang['deactivate_unsuccessful'] = 'Не удалось деактивировать аккаунт.';
$lang['activation_email_successful'] = 'Вам было отправлено письмо с инструкцией по активации.';
$lang['activation_email_unsuccessful'] = 'Не удалось отправить email с инструкцией по активации.';
$lang['account_requires_activation'] = 'Ваш аккаунт требует активации через email.';
$lang['account_already_activated'] = 'Ваш аккаунт уже активирован.';
$lang['email_activation_email_successful'] = 'Для активации вашего нового email-адреса, на ваш старый адрес было отправлено письмо.';
$lang['email_activation_email_unsuccessful'] = 'Не удалось выслать письмо для активации вашего нового email.';

// Login / Logout
$lang['login_successful'] = 'Вход выполнен.';
$lang['login_unsuccessful'] = 'Вход невыполнен.';
$lang['logout_successful'] = 'Выход завершен.';
$lang['login_details_invalid'] = 'Данные вашего логина неверны.';
$lang['captcha_answer_invalid'] = 'Неверный ответ CAPTCHAt.';
$lang['login_attempts_exceeded'] = 'Выполнено максимальное количество попыток входа, подождите немного перед следующей попыткой.';
$lang['login_session_expired'] = 'Время сеанса истекло.';
$lang['account_suspended'] = 'Работа вашего аккаунта приостановлена.';

// Account Changes
$lang['update_successful'] = 'Информация об аккаунте обновлена.';
$lang['update_unsuccessful'] = 'Не удалось обновить информацию об аккаунте.';
$lang['delete_successful'] = 'Информация об аккаунте удалена.';
$lang['delete_unsuccessful'] = 'Не удалось удалить аккаунт.';

// Form Validation
$lang['form_validation_duplicate_identity'] = "Аккаунтс  этим email-адресом или именем пользователя уже существует.";
$lang['form_validation_duplicate_email'] = "Этот Email в поле %s не доступен.";
$lang['form_validation_duplicate_username'] = "Имя пользователя в поле %s не доступно.";
$lang['form_validation_current_password'] = "Поле %s неверное.";