<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth Lang - English
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Author: Daniel Davis
*         @ourmaninjapan
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.09.2013
*
* Description:  English language file for Ion Auth example views
*
*/

// Errors
$lang['error_csrf'] = 'Отправленные вами данные не соответствуют нашей политике безопасности.';

// Login
$lang['login_heading']         = 'Вход на сайт';
$lang['login_subheading']      = 'Введите логин/email и пароль.';
$lang['login_identity_label']  = 'Логин:';
$lang['login_password_label']  = 'Пароль:';
$lang['login_remember_label']  = 'Запомнить:';
$lang['login_submit_btn']      = 'Вход';
$lang['login_forgot_password'] = 'Забыли пароль?';

// Index
$lang['index_heading']           = 'Пользователи';
$lang['index_subheading']        = 'Список пользователей.';
$lang['index_fname_th']          = 'Имя';
$lang['index_lname_th']          = 'Фамилия';
$lang['index_email_th']          = 'Email';
$lang['index_groups_th']         = 'Группы';
$lang['index_status_th']         = 'Статус';
$lang['index_action_th']         = 'Действия';
$lang['index_active_link']       = 'Активный';
$lang['index_inactive_link']     = 'Неактивный';
$lang['index_create_user_link']  = 'Создать пользователя';
$lang['index_create_group_link'] = 'Создать группу';

// Deactivate User
$lang['deactivate_heading']                  = 'Деактивация пользователя';
$lang['deactivate_subheading']               = 'Деактивация пользователя \'%s\'';
$lang['deactivate_confirm_y_label']          = 'Да:';
$lang['deactivate_confirm_n_label']          = 'Нет:';
$lang['deactivate_submit_btn']               = 'Готово';
$lang['deactivate_validation_confirm_label'] = 'подтверждение';
$lang['deactivate_validation_user_id_label'] = 'ID пользователя';

// Create User
$lang['create_user_heading']                           = 'Создание пользователя';
$lang['create_user_subheading']                        = 'Введите информацию о пользователе.';
$lang['create_user_fname_label']                       = 'Имя:';
$lang['create_user_lname_label']                       = 'Фамилия:';
$lang['create_user_company_label']                     = 'Организация:';
$lang['create_user_email_label']                       = 'Email:';
$lang['create_user_phone_label']                       = 'Телефон:';
$lang['create_user_password_label']                    = 'Пароль:';
$lang['create_user_password_confirm_label']            = 'Подтвердить пароль:';
$lang['create_user_submit_btn']                        = 'Создать пользователя';
$lang['create_user_validation_fname_label']            = 'Имя';
$lang['create_user_validation_lname_label']            = 'Фамилия';
$lang['create_user_validation_email_label']            = 'Адрес Email';
$lang['create_user_validation_phone1_label']           = 'Первая часть номера';
$lang['create_user_validation_phone2_label']           = 'Вторая часть номера';
$lang['create_user_validation_phone3_label']           = 'Третья часть номера';
$lang['create_user_validation_company_label']          = 'Организация';
$lang['create_user_validation_password_label']         = 'Пароль';
$lang['create_user_validation_password_confirm_label'] = 'Подтверждение пароля';

// Edit User
$lang['edit_user_heading']                           = 'Изменение пользователя';
$lang['edit_user_subheading']                        = 'Введите информацию о пользователе.';
$lang['edit_user_fname_label']                       = 'Имя:';
$lang['edit_user_lname_label']                       = 'Фамилия:';
$lang['edit_user_company_label']                     = 'Организация:';
$lang['edit_user_email_label']                       = 'Email:';
$lang['edit_user_phone_label']                       = 'Телефон:';
$lang['edit_user_password_label']                    = 'Пароль: (если хотите изменить)';
$lang['edit_user_password_confirm_label']            = 'Подтверждение пароля: (если хотите изменить)';
$lang['edit_user_groups_heading']                    = 'Членство в группах';
$lang['edit_user_submit_btn']                        = 'Сохранить';
$lang['edit_user_validation_fname_label']            = 'Имя';
$lang['edit_user_validation_lname_label']            = 'Фамилия';
$lang['edit_user_validation_email_label']            = 'Адрес Email';
$lang['edit_user_validation_phone1_label']           = 'Первая часть номера';
$lang['edit_user_validation_phone2_label']           = 'Вторая часть номера';
$lang['edit_user_validation_phone3_label']           = 'Третья часть номера';
$lang['edit_user_validation_company_label']          = 'Организация';
$lang['edit_user_validation_groups_label']           = 'Группы';
$lang['edit_user_validation_password_label']         = 'Пароль';
$lang['edit_user_validation_password_confirm_label'] = 'Подтверждение пароля';

// Create Group
$lang['create_group_title']                  = 'Создание группы';
$lang['create_group_heading']                = 'Создание группы';
$lang['create_group_subheading']             = 'Введите информацию о группе.';
$lang['create_group_name_label']             = 'Название группы:';
$lang['create_group_desc_label']             = 'Описание:';
$lang['create_group_submit_btn']             = 'Создать группу';
$lang['create_group_validation_name_label']  = 'Название группы';
$lang['create_group_validation_desc_label']  = 'Описание';

// Edit Group
$lang['edit_group_title']                  = 'Изменение группы';
$lang['edit_group_saved']                  = 'Группа сохранена';
$lang['edit_group_heading']                = 'Изменение группы';
$lang['edit_group_subheading']             = 'Введите информацию о группе.';
$lang['edit_group_name_label']             = 'Название группы:';
$lang['edit_group_desc_label']             = 'Описание:';
$lang['edit_group_submit_btn']             = 'Сохранить группу';
$lang['edit_group_validation_name_label']  = 'Имя группы';
$lang['edit_group_validation_desc_label']  = 'Описание';

// Change Password
$lang['change_password_heading']                               = 'Изменение пароля';
$lang['change_password_old_password_label']                    = 'Старый пароль:';
$lang['change_password_new_password_label']                    = 'Новый пароль (не короче %s символов):';
$lang['change_password_new_password_confirm_label']            = 'Подтвердите новый пароль:';
$lang['change_password_submit_btn']                            = 'Изменить';
$lang['change_password_validation_old_password_label']         = 'Старый пароль';
$lang['change_password_validation_new_password_label']         = 'Новый пароль';
$lang['change_password_validation_new_password_confirm_label'] = 'Подтверждение нового пароля';

// Forgot Password
$lang['forgot_password_heading']                 = 'Восстановление пароля';
$lang['forgot_password_subheading']              = 'Введите ваш %s так мы сможем отправить вам email с информацией по восстановлению вашего пароля.';
$lang['forgot_password_email_label']             = '%s:';
$lang['forgot_password_submit_btn']              = 'Готово';
$lang['forgot_password_validation_email_label']  = 'Адрес Email';
$lang['forgot_password_username_identity_label'] = 'Имя пользователя';
$lang['forgot_password_email_identity_label']    = 'Email';


// Reset Password
$lang['reset_password_heading']                               = 'Сброс пароля';
$lang['reset_password_new_password_label']                    = 'Новый пароль (не короче %s символов):';
$lang['reset_password_new_password_confirm_label']            = 'Подтвержите новый пароль:';
$lang['reset_password_submit_btn']                            = 'Изменить';
$lang['reset_password_validation_new_password_label']         = 'Новый пароль';
$lang['reset_password_validation_new_password_confirm_label'] = 'Подтверждение нового пароля';

// Activation Email
$lang['email_activate_heading']    = 'Активация аккаунта для %s';
$lang['email_activate_subheading'] = 'Нажмите на ссылку %s.';
$lang['email_activate_link']       = 'Активация аккаунта';

// Forgot Password Email
$lang['email_forgot_password_heading']    = 'Сброс пароля для %s';
$lang['email_forgot_password_subheading'] = 'Нажмите на ссылку %s.';
$lang['email_forgot_password_link']       = 'Сбросить ваш пароль';

// New Password Email
$lang['email_new_password_heading']    = 'Новый пароль для %s';
$lang['email_new_password_subheading'] = 'Ваш пароль был изменен на: %s';

