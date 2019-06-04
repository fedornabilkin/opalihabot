<?php


namespace Fp\Telebot\middleware;


use Fp\Telebot\Dictionary;
use Fp\Telebot\models\RoleUserModel;

class RoleAssignMiddleware extends AbstractMiddleware
{
    public $roleId = Dictionary::ROLE_NO_AUTH;

    private $model;

    public function __construct()
    {
        $this->model = new RoleUserModel();
    }

    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        $this->consoleLog(self::class);
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
        $userId = self::$requestData->getUserId();
        self::$requestData->setRoleId($this->roleId);

        return $this->model->assignRole($userId, $this->roleId);
    }
}
