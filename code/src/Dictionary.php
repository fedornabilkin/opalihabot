<?php


namespace Fp\Telebot;

/**
 * Class Dictionary
 * @package Fp\Telebot
 */
class Dictionary
{

    // user roles
    CONST ROLE_NO_AUTH = 1;
    CONST ROLE_MODERATOR = 2;
    CONST ROLE_ADMIN = 3;

    CONST REQ_TYPE_CALLBACK = 'callback';
    CONST REQ_TYPE_COMMAND = 'command';
    CONST REQ_TYPE_TEXT = 'text';

    // slash command
    CONST CMD_START = '/start';
    CONST CMD_HELP = '/help';
    CONST CMD_ADD = '/add';

    // text commands
    CONST T_UK = 'УК';
    CONST T_TAXI = 'Taxi';
    CONST T_APTEKA = 'Аптеки';
    CONST T_NOTES = 'Записи';

    // callback params names
    CONST CALLBACK_PM_ACTION = 'action';
    // callback command
    CONST CALLBACK_USERS_PANEL = 'usersPanel';
    CONST CALLBACK_ROLES_PANEL = 'rolesPanel';
    CONST CALLBACK_NOTES_PANEL = 'notesPanel';
    CONST CALLBACK_TIME_PANEL = 'timePanel';

    CONST CALLBACK_NOTES_TOGGLE = 'toggleNote';
    CONST CALLBACK_NOTES_REMOVE = 'removeNote';
    CONST CALLBACK_NOTIFY_CLEAR = 'notifyClear';

    CONST CALLBACK_NOTIFY_ADD_DAY = 'addDayNotify';
    CONST CALLBACK_NOTIFY_ADD_TIME = 'addTimeNotify';

    // panel names
    CONST PANEL_USER_LIST = 'Пользователи';
    CONST PANEL_CHANGE_ROLE = 'Назначение роли пользователю';
    CONST PANEL_NOTES_LIST = 'Список ваших записей';

    // speed buttons
    CONST BTN_ADMIN_PANEL = 'Панель администратора';
    CONST BTN_MODERATOR_PANEL = 'Панель модератора';
    CONST BTN_USER_PANEL = 'Панель пользователя';
    CONST BTN_USER_LIST = 'Пользователи';
    CONST BTN_LAST_CMD_LIST = 'Последние команды';

    // inline buttons
    CONST BTN_INLINE_ROLE_ADMIN = 'Админ';
    CONST BTN_INLINE_ROLE_SALE = 'Модератор';
    CONST BTN_INLINE_ROLE_GUEST = 'Гость';

    CONST MSG_ERROR = 'Ошибка';
    CONST MSG_ROLE_CHANGE = 'Назначена роль';
    CONST MSG_ROLE_CHANGE_USER = 'Вам назначена роль';

    // images
    CONST IMG_REVENUE = '/code/img.jpg';
}
