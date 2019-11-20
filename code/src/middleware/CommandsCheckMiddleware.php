<?php


namespace Fp\Telebot\middleware;


use Fp\Telebot\buttons\AdminButtons;
use Fp\Telebot\buttons\GuestButtons;
use Fp\Telebot\buttons\ModeratorButtons;
use Fp\Telebot\commands\AdminCommands;
use Fp\Telebot\commands\CronCommands;
use Fp\Telebot\commands\GuestCommands;
use Fp\Telebot\commands\ModeratorCommands;
use Fp\Telebot\Dictionary as D;
use Fp\Telebot\handlers\AdminHandler;
use Fp\Telebot\handlers\CronHandler;
use Fp\Telebot\handlers\GuestHandler;
use Fp\Telebot\handlers\ModeratorHandler;

class CommandsCheckMiddleware extends AbstractMiddleware
{

    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        $this->setHandler();
        return parent::check();
    }

    protected function setHandler()
    {
        $data = $this->getData();

        $roleId = ($data->getIsCron()) ? 0 : $data->getRoleId();
        $commands = null;

        switch ($roleId) {
            case D::ROLE_MODERATOR:
                $commands = new ModeratorCommands(new ModeratorHandler(new ModeratorButtons()));
                break;
            case D::ROLE_ADMIN:
                $commands = new AdminCommands(new AdminHandler(new AdminButtons()));
                break;
            case D::ROLE_NO_AUTH:
                $commands = new GuestCommands(new GuestHandler(new GuestButtons()));
                break;
            default:
                $commands = new CronCommands(new CronHandler());
                break;
        }

        $commands->getHandler()->setData($data);
        $data->setCommands($commands);
    }
}
