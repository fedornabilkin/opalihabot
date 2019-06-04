<?php


namespace Fp\Telebot\middleware;


use Fp\Telebot\commands\AdminCommands;
use Fp\Telebot\commands\CronCommands;
use Fp\Telebot\commands\GuestCommands;
use Fp\Telebot\commands\ModeratorCommands;
use Fp\Telebot\Dictionary as D;

class CommandsCheckMiddleware extends AbstractMiddleware
{

    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        $this->consoleLog(self::class);
        $this->setHandler();

        return parent::check();
    }

    protected function setHandler()
    {
        $data = self::$requestData;

        $roleId = ($data->getIsCron()) ? 0 : $data->getRoleId();
        $commands = null;

        switch ($roleId) {
            case D::ROLE_MODERATOR:
                $commands = new ModeratorCommands();
                break;
            case D::ROLE_ADMIN:
                $commands = new AdminCommands();
                break;
            case D::ROLE_NO_AUTH:
                $commands = new GuestCommands();
                break;
            default:
                $commands = new CronCommands();
                break;
        }

        $commands->getHandler()->setData($data);
        $data->setCommands($commands);
    }
}
