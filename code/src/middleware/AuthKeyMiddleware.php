<?php


namespace Fp\Telebot\middleware;


use Fp\Telebot\models\RoleAuthModel;

/**
 * Class AuthKeyMiddleware
 * @package Fp\Telebot\middleware
 */
class AuthKeyMiddleware extends AbstractMiddleware
{
    private $model;

    public function __construct()
    {
        $this->model = new RoleAuthModel();
    }

    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        $roleId = $this->getRole();

        $middleware = new RoleAssignMiddleware();
        if ($roleId) {
            $middleware->roleId = $roleId;
        }
        $this->linkWith($middleware);

        return parent::check();
    }

    /**
     * @return array
     */
    protected function getRole()
    {
        $authKey = self::$requestData->getText();
        $roleId = $this->model->get('roleid', ['auth' => $authKey]);

        if ($roleId) {
            $this->consoleLog('Activated');
            $this->model->delete(['auth' => $authKey]);
        }

        return $roleId;
    }
}
