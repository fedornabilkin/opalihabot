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

    // callback params names
    CONST CALLBACK_PM_ACTION = 'action';
    // callback command
    CONST CALLBACK_USERS_PANEL = 'usersPanel';
    CONST CALLBACK_ROLES_PANEL = 'rolesPanel';

    // panel names
    CONST PANEL_USER_LIST = 'Пользователи';
    CONST PANEL_CHANGE_ROLE = 'Назначение роли пользователю';

    // speed buttons
    CONST BTN_ADMIN_PANEL = 'Панель администратора';
    CONST BTN_USER_LIST = 'Пользователи';

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
