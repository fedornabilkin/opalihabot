<?php

namespace Fp\Telebot\middleware;

use Fp\Telebot\models\GroupModel;

class GroupCreateMiddleware extends AbstractMiddleware
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
        if (!$this->createGroup() && !self::$requestData->getIsCron()) {
            return $this->stopProcessing();
        }

        return parent::check();
    }

    /**
     * @return int|null
     */
    protected function createGroup()
    {
        $id = null;
        $group = self::$requestData->getGroup();

        if ($group) {
            $id = $this->model->createGroup($group->id, $group->title);

            self::$requestData->setGroupId($id);
        }

        return $id;
    }
}
