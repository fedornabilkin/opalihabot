<?php


namespace Fp\Telebot\middleware;


use Fp\Telebot\Dictionary as D;
use Fp\Telebot\models\UserModel;

class UserCreateMiddleware extends AbstractMiddleware
{
    private $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        $this->consoleLog(self::class);
        if (!$this->createUser() && !self::$requestData->getIsCron()) {
            $this->consoleLog('Creat user filed!');
            return $this->stopProcessing();
        }

        $users = (new UserModel())->getUsers();
        if(count($users) === 1){
            $middleware = new RoleAssignMiddleware();
            $middleware->roleId = D::ROLE_ADMIN;
            $this->linkWith($middleware);
        }

        return parent::check();
    }

    /**
     * @return int|null
     */
    protected function createUser()
    {
        $id = null;
        $user = self::$requestData->getUser();

        if ($user) {
            $id = $this->model->createUser(
                $user->id,
                $user->username,
                $user->first_name . " " . $user->last_name
            );

            self::$requestData->setUserId($id);
        }

        return $id;
    }
}
