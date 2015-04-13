<?php
$_lang['area_ec_main'] = 'Основные';
$_lang['area_ec_mail'] = 'Почта';
$_lang['area_ec_rating'] = 'Оценки и рейтинг';

$_lang['setting_ec_show_templates'] = 'Показывать вкладку у ресурсов с перечисленными шаблонами';
$_lang['setting_ec_show_templates_desc'] = 'Список id шаблонов через запятую, укажите *, что бы показывать у всех шаблонов';

$_lang['setting_ec_show_resources'] = 'Показывать вкладку у перечисленных ресурсов';
$_lang['setting_ec_show_resources_desc'] = 'Список id ресурсов через запятую, укажите *, что бы показывать у всех ресурсов';

$_lang['setting_ec_frontend_css'] = 'Стили фронтенда';
$_lang['setting_ec_frontend_css_desc'] = 'Путь к файлу со стилями. Если вы хотите использовать собственные стили - укажите путь к ним здесь, или очистите параметр и загрузите их вручную через шаблон сайта';

$_lang['setting_ec_frontend_js'] = 'Скрипты фронтенда';
$_lang['setting_ec_frontend_js_desc'] = 'Путь к файлу со скриптами. Если вы хотите использовать собственные скрипты - укажите путь к ним здесь, или очистите параметр и загрузите их вручную через шаблон сайта';

$_lang['setting_ec_thread_grid_fields'] = 'Список полей цепочек в списке';
$_lang['setting_ec_thread_grid_fields_desc'] = 'Поля, которые будут видны в админке в списке цепочек, через запятую';

$_lang['setting_ec_thread_window_fields'] = 'Список полей при редактировании цепочки';
$_lang['setting_ec_thread_window_fields_desc'] = 'Поля, которые будут видны в админке при редактировании цепочки, через запятую';

$_lang['setting_ec_message_grid_fields'] = 'Список полей сообщений в списке';
$_lang['setting_ec_message_grid_fields_desc'] = 'Поля, которые будут видны в админке в списке сообщений, через запятую';

$_lang['setting_ec_message_window_layout'] = 'Разметка окна редактирования сообщения';
$_lang['setting_ec_message_window_layout_desc'] = 'Строка в JSON формате';


$_lang['setting_ec_mail_notify_user'] = 'Отправлять уведомления пользователям';
$_lang['setting_ec_mail_notify_user_desc'] = 'Если пользователь оставит свою электронную почту, ему будет отправлено уведомление о том, что он оставил сообщение на сайте';

$_lang['setting_ec_mail_notify_manager'] = 'Отправлять уведомления администраторам';
$_lang['setting_ec_mail_notify_manager_desc'] = 'Уведомлять администратора о новых сообщениях на сайте';

$_lang['setting_ec_mail_new_subject_user'] = 'Тема письма-уведомления пользователю о новом сообщения';
$_lang['setting_ec_mail_new_subject_user_desc'] = 'Можно переопределить через параметр newEmailSubjUser сниппета ecForm';

$_lang['setting_ec_mail_new_subject_manager'] = 'Тема письма-уведомления администратора о новом сообщения';
$_lang['setting_ec_mail_new_subject_manager_desc'] = 'Можно переопределить через параметр newEmailSubjManager сниппета ecForm';

$_lang['setting_ec_mail_update_subject_user'] = 'Тема письма-уведомления пользователю об изменении его сообщения (опубликовано или дан ответ)';
$_lang['setting_ec_mail_update_subject_user_desc'] = 'Можно переопределить через параметр updateEmailSubjUser сниппета ecForm';

$_lang['setting_ec_mail_manager'] = 'Электронная почта администратора для уведомления';
$_lang['setting_ec_mail_manager_desc'] = 'Если пусто - будет использована системная настройка emailsender';

$_lang['setting_ec_mail_from'] = 'С какого адреса отправлять уведомления о новых сообщениях';
$_lang['setting_ec_mail_from_desc'] = 'Если пусто - будет использована системная настройка emailsender';

$_lang['setting_ec_mail_from_name'] = 'От чьего имени отправлять уведомления о новых сообщениях';
$_lang['setting_ec_mail_from_name_desc'] = 'Если пусто - будет использована системная настройка site_name';


$_lang['setting_ec_rating_max'] = 'Максимально возможная оценка';
$_lang['setting_ec_rating_max_desc'] = 'Используется для ограничения введенных пользователями данных';

$_lang['setting_ec_rating_wilson_confidence'] = 'Доверительный уровень для рейтинга по Вильсону';
$_lang['setting_ec_rating_wilson_confidence_desc'] = 'Доверительный уровень. 1.0 = 85%, 1.6 = 95%. См. <a href="http://habrahabr.ru/company/darudar/blog/143188/" target="_blank">http://habrahabr.ru/company/darudar/blog/143188/</a>';