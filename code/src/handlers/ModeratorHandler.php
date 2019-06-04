<?php


namespace Fp\Telebot\handlers;



/**
 * Class QvHandler
 * @package Fp\Telebot\handlers
 */
class ModeratorHandler extends AbstractHandler
{

    public function __construct()
    {
        $this->consoleLog(self::class);
    }

    public function initModeratorButtons()
    {
        $this->consoleLog('Need moderator button class');
    }
}
