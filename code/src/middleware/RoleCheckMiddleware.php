<?php


namespace Fp\Telebot\middleware;


use Fp\Telebot\models\AbstractModel;
use Fp\Telebot\models\RoleGroupModel;
use Fp\Telebot\models\RoleUserModel;

class RoleCheckMiddleware extends AbstractMiddleware
{
    /** @var AbstractModel */
    private $model;
    private $id; // id юзера или группы
    private $fieldName = 'userid'; // название поля в таблице roleuser или rolegroup

    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        $this->consoleLog(self::class);
        $this->checkRole();
        return parent::check();
    }

    protected function checkRole(): void
    {
        if (self::$requestData->getIsCron()){
            $this->consoleLog('isCron');
            return;
        }

        $this->prepareModel();
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
        return $this->model->get('roleid', [$this->fieldName => $this->id]);
    }

    /**
     * Определяет в какой таблице искать роль
     */
    protected function prepareModel(): void
    {
        if ($this->getChatType() === self::$requestData::CHAT_GROUP) {
            $this->id = self::$requestData->getGroupId();
            $this->fieldName = 'groupid';
            $this->model = new RoleGroupModel();
        } else {
            $this->id = self::$requestData->getUserId();
            $this->model = new RoleUserModel();
        }
    }
}
