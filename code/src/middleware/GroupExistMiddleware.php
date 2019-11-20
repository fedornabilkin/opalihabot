<?php


namespace Fp\Telebot\middleware;


use Fp\Telebot\models\GroupModel;

class GroupExistMiddleware extends AbstractMiddleware
{
    private $model;

    public function __construct()
    {
        $this->model = new GroupModel();
    }

    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        $this->existGroup();
        return parent::check();
    }

    protected function existGroup()
    {
        $groupId = $this->isExistGroup(self::$requestData->getGroupId());
        if (!$groupId) {
            $this->insertNext(new GroupCreateMiddleware());
        } else {
            self::$requestData->setGroupId($groupId);
        }
    }

    /**
     * @param int $id
     * @return array
     */
    protected function isExistGroup($id)
    {
        return $this->model->getGroupIdByChatId($id);
    }
}
