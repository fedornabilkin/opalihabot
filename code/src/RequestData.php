<?php


namespace Fp\Telebot;


use Fp\Telebot\commands\AbstractCommands;
use unreal4u\TelegramAPI\Telegram\Types\User;

class RequestData
{
    private $tgLog;
    private $loop;

    private $updateData;

    private $message;
    private $text;
    private $arguments;

    private $user;
    private $userId;
    private $roleId;

    private $group;
    private $groupId;

    private $isCron;
    private $isCallback;
    private $isCommand;

    private $commandType;
    private $commandValue = 0;
    private $commands;

    private $methods;

    CONST CHAT_PRIVATE = 'private';
    CONST CHAT_GROUP = 'group';

    /**
     * @return mixed
     */
    public function getTgLog()
    {
        return $this->tgLog;
    }

    /**
     * @param mixed $tgLog
     */
    public function setTgLog($tgLog): void
    {
        $this->tgLog = $tgLog;
    }

    /**
     * @return mixed
     */
    public function getLoop()
    {
        return $this->loop;
    }

    /**
     * @param mixed $loop
     */
    public function setLoop($loop): void
    {
        $this->loop = $loop;
    }

    /**
     * @return mixed
     */
    public function getUpdateData()
    {
        return $this->updateData;
    }

    /**
     * @param mixed $updateData
     */
    public function setUpdateData($updateData): void
    {
        $this->updateData = $updateData;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text): void
    {
        $this->text = $text;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     */
    public function setArguments($arguments): void
    {
        $this->arguments = $arguments;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * @param int $roleId
     */
    public function setRoleId($roleId): void
    {
        $this->roleId = $roleId;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group): void
    {
        $this->group = $group;
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param mixed $groupId
     */
    public function setGroupId($groupId): void
    {
        $this->groupId = $groupId;
    }

    /**
     * @return bool
     */
    public function getIsCron()
    {
        return $this->isCron;
    }

    /**
     * @param bool $isCron
     */
    public function setIsCron($isCron): void
    {
        $this->isCron = $isCron;
    }

    /**
     * @return bool
     */
    public function getIsCallback()
    {
        return $this->isCallback;
    }

    /**
     * @param bool $isCallback
     */
    public function setIsCallback($isCallback): void
    {
        $this->isCallback = $isCallback;
    }

    /**
     * @return bool
     */
    public function getIsCommand()
    {
        return $this->isCommand;
    }

    /**
     * @param bool $isCommand
     */
    public function setIsCommand($isCommand): void
    {
        $this->isCommand = $isCommand;
    }

    /**
     * @return mixed
     */
    public function getCommandType()
    {
        return $this->commandType;
    }

    /**
     * @param mixed $commandType
     */
    public function setCommandType($commandType): void
    {
        $this->commandType = $commandType;
    }

    /**
     * @return mixed
     */
    public function getCommandValue()
    {
        return $this->commandValue;
    }

    /**
     * @param mixed $commandValue
     */
    public function setCommandValue($commandValue): void
    {
        $this->commandValue = $commandValue;
    }

    /**
     * @return AbstractCommands
     */
    public function getCommands()
    {
        return $this->commands;
    }

    /**
     * @param AbstractCommands $commands
     */
    public function setCommands($commands): void
    {
        $this->commands = $commands;
    }

    /**
     * @return mixed
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param mixed $methods
     */
    public function setMethods($methods): void
    {
        $this->methods = $methods;
    }

}
