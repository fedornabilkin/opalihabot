<?php


namespace Fp\Telebot\handlers;


use Fp\Telebot\buttons\SaleButtons;

/**
 * Class QvHandler
 * @package Fp\Telebot\handlers
 */
class QvHandler extends AbstractHandler
{

    public function __construct()
    {
        $this->consoleLog(self::class);
    }

    public function initQvButtons()
    {
        $buttons = new SaleButtons();
        $this->pushMethod($buttons->getSendMessage());
    }
}
