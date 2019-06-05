<?php


namespace Fp\Telebot\middleware;


use Fp\Telebot\Dictionary;
use Fp\Telebot\models\RoleGroupModel;
use Fp\Telebot\models\RoleUserModel;

class RoleAssignMiddleware extends AbstractMiddleware
{
    public $roleId = Dictionary::ROLE_NO_AUTH;

    /** @var RoleUserModel|RoleGroupModel */
    private $model;
    private $id; // id юзера или группы

    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        $this->consoleLog(self::class);

        $this->prepareModel();
        if (!$this->assignRole()) {
            return $this->stopProcessing();
        }

        return parent::check();
    }

    /**
     * @return int
     */
    protected function assignRole()
    {
        self::$requestData->setRoleId($this->roleId);

        return $this->model->assignRole($this->id, $this->roleId);
    }

    /**
     * Определяет в какой таблице искать роль
     */
    protected function prepareModel(): void
    {
        if ($this->getChatType() === self::$requestData::CHAT_GROUP) {
            $this->id = self::$requestData->getGroupId();
            $this->model = new RoleGroupModel();
        } else {
            $this->id = self::$requestData->getUserId();
            $this->model = new RoleUserModel();
        }
    }
}
