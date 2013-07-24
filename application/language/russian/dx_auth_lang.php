<?php

/*
	It is recommended for you to change 'auth_login_incorrect_password' and 'auth_login_username_not_exist' into something vague.
	For example: Username and password do not match.
*/

$lang['auth_login_incorrect_password'] = "Неверный логин или пароль.";
$lang['auth_login_username_not_exist'] = "Неверный логин или пароль.";

$lang['auth_username_or_email_not_exist'] = "Имя пользователя или email неверны.";
$lang['auth_not_activated'] = "Ваш аккаунт пока не активирован. Проверьте ваш email.";
$lang['auth_request_sent'] = "По вашему запросу вам уже было направлено письмо для смены пароля. Проверьте ваш email.";
$lang['auth_incorrect_old_password'] = "Ваш старый пароль неверен.";
$lang['auth_incorrect_password'] = "Неправильный пароль.";

// Email subject
$lang['auth_account_subject'] = "Детали аккаунта для %s";
$lang['auth_activate_subject'] = "Активация %s";
$lang['auth_forgot_password_subject'] = "Запрос нового пароля";

// Email content
$lang['auth_account_content'] = "Приветствуем на сайте %s,

Спасибо за регистрацию. Ваш аккаунт создан.

Вы можете войти используя ваш логин или email адрес:

Логин: %s
Email: %s
Пароль: %s

Можете попробовать войти в систему перейдя  %s

Надеемся что вам у нас понравится.

Regards,
Команда сайта %s";

$lang['auth_activate_content'] = "Приветствуем на сайте %s,

Для активации аккаунта пожалуйста пройдите по этой ссылке:
%s

Пожалуйста, активируйте ваш аккаунт в течении %s часов, по истечении этого времени ваша регистрация будет отменена и вы сможете зарегистрироваться вновь.

Вы можете использовать ваш логин или адрес email для входа в систему.
Детали вашей учетной записи:

Логин: %s
Email: %s
Пароль: %s

Надеемся, что вам у нас понравится :)

Regards,
Команда сайта %s";

$lang['auth_forgot_password_content'] = "%s,

Вы запросили смену пароля, так как забылисвой старый пароль.
Проследуйте по ссылке чтобы завершить восстановление пароля:
%s

Ваш новый пароль: %s
Ключ активации: %s

После того как вы заверщите процесс смены пароля, Вы сможете сменить ваш новый пароль на тот который вам нравится.

Если у вас какие-то проблемы с доступом, свяжитесь с %s.

Regards,
Команда сайта %s";

/* End of file dx_auth_lang.php */
/* Location: ./application/language/english/dx_auth_lang.php */