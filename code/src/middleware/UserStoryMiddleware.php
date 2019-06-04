<?php


namespace Fp\Telebot\middleware;


use Fp\Telebot\models\UserStoryModel;

class UserStoryMiddleware extends AbstractMiddleware
{
    private $model;

    public function __construct()
    {
        $this->model = new UserStoryModel();
    }

    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        $this->consoleLog(self::class);
        $this->saveStory();
        return parent::check();
    }

    protected function saveStory()
    {
        $userId = self::$requestData->getUserId();
        $text = self::$requestData->getText();

        if ($userId > 0 && $text) {
            $this->model->insert(['userid' => $userId, 'text' => $text]);
            $this->consoleLog($text);
        }
    }
}
