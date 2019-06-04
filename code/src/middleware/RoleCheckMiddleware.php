<?php


namespace Fp\Telebot\middleware;


use Fp\Telebot\models\RoleUserModel;

class RoleCheckMiddleware extends AbstractMiddleware
{
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
        $this->checkRole();
        return parent::check();
    }

    protected function checkRole()
    {
        $roleId = $this->getRole();

        if (!$roleId) {
            $this->insertNext(new AuthKeyMiddleware());
        } else {
            self::$requestData->setRoleId($roleId);
        }
    }

    /**
     * @return int
     */
    protected function getRole()
    {
        $userId = self::$requestData->getUserId();
        return $this->model->get('roleid', ['userid' => $userId]);
    }
}
