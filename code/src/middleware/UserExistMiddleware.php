<?php


namespace Fp\Telebot\middleware;


use Fp\Telebot\models\UserModel;

class UserExistMiddleware extends AbstractMiddleware
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
        $this->existUser();
        return parent::check();
    }

    protected function existUser()
    {
        $userId = $this->isExistUser(self::$requestData->getUserId());
        if (!$userId) {
            $this->insertNext(new UserCreateMiddleware());
        } else {
            self::$requestData->setUserId($userId);
        }
    }

    /**
     * @param int $id
     * @return int
     */
    protected function isExistUser($id)
    {
        return $this->model->getUserIdByChatId($id);
    }
}
