<?php

/*
	It is recommended for you to change 'auth_login_incorrect_password' and 'auth_login_username_not_exist' into something vague.
	For example: Username and password do not match.
*/

$lang['auth_login_incorrect_password'] = "Некоректний логін чи пароль.";
$lang['auth_login_username_not_exist'] = "Некоректний логін чи пароль.";

$lang['auth_username_or_email_not_exist'] = "Ім'я користувача або email неправильні.";
$lang['auth_not_activated'] = "Ваш обліковий запис поки що не активовано. Перевірте ваш email.";
$lang['auth_request_sent'] = "По вашому запиту уже було надіслано листа для зміни паролю. Перевірте ваш email.";
$lang['auth_incorrect_old_password'] = "Ваш старий пароль неправильний.";
$lang['auth_incorrect_password'] = "Неправильний пароль.";

// Email subject
$lang['auth_account_subject'] = "Деталі облікового запису для %s";
$lang['auth_activate_subject'] = "Активація %s";
$lang['auth_forgot_password_subject'] = "Запит нового паролю";

// Email content
$lang['auth_account_content'] = "Вітаємо на сайті %s,

Дякуємо за реєстрацію. Ваш обліковий запис створено.

Ви можете увійти, використовуючи ваш логін або адресу email:

Логін: %s
Email: %s
Пароль: %s

Можете спробувати увійти в систему за посиланням %s

Сподіваємося, що вам у нас сподобається.

Regards,
Команда сайту %s";

$lang['auth_activate_content'] = "Вітаємо на сайті %s,

Для активації облікового запису перейдіть за цим посиланням:
%s

Будь ласка, активуйте ваш обліковий запис на протязі %s годин, після закінчення цього часу вашу реєстрацію буде скасовано і ви зможете зареєструватися повторно.

Ви можете використовувати ваш логін або адресу email для входу в систему.
Деталі вашого облікового запису:

Логін: %s
Email: %s
Пароль: %s

Сподіваємося, що вам у нас сподобається.

Regards,
Команда сайту %s";

$lang['auth_forgot_password_content'] = "%s,

Вы подали запит на зміну паролю, оскільки забули свій старий пароль.
Прослідуйте поза посиланням, щоб завершити операцію зміни паролю:
%s

Ваш новий пароль: %s
Ключ активації: %s

Після завершення зміни паролю ви можете вручну змінити його на той, який вам сподобається.

Якщо у вас є проблемі с доступом, вийдіть на зв'язок з %s.

Regards,
Команда сайту %s";

/* End of file dx_auth_lang.php */
/* Location: ./application/language/english/dx_auth_lang.php */