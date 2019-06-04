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
    CONST ROLE_QV = 2;
    CONST ROLE_ADMIN = 3;

    CONST REQ_TYPE_CALLBACK = 'callback';
    CONST REQ_TYPE_COMMAND = 'command';
    CONST REQ_TYPE_TEXT = 'text';

    // slash command
    CONST CMD_START = '/start';

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
    CONST BTN_SALES_PANEL = 'Панель продаж';

    CONST BTN_USER_LIST = 'Пользователи';

    CONST BTN_SALES_ONLINE = 'Онлайн продажи';

    CONST BTN_PAST_FACT = 'Продажи за вчера';
    CONST BTN_PAST_FACT_RB = 'Продажи за вчера РБ';
    CONST BTN_PAST_FACT_LV = 'Продажи за вчера LV';

    CONST BTN_PAST_FACT_MAILING = 'Рассылка за вчера';
    CONST BTN_PAST_FACT_MAILING_RB = 'Рассылка за вчера РБ';
    CONST BTN_PAST_FACT_MAILING_LV = 'Рассылка за вчера LV';
    CONST BTN_PAST_FACT_RB_PFM = 'Продажи за вчера РБ-ПФМ';

    // inline buttons
    CONST BTN_INLINE_ROLE_ADMIN = 'Роль админа';
    CONST BTN_INLINE_ROLE_SALE = 'Роль продаж';
    CONST BTN_INLINE_ROLE_GUEST = 'Удалить роль';

    CONST MSG_ERROR = 'Ошибка';
    CONST MSG_ROLE_CHANGE = 'Назначена роль';
    CONST MSG_ROLE_CHANGE_USER = 'Вам назначена роль';

    // images
    CONST IMG_REVENUE = '/code/img.jpg';
}
