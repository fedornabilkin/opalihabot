<?php


namespace Fp\Telebot\handlers;


use Fp\Telebot\Dictionary as D;
use Fp\Telebot\models\GroupModel;
use Fp\Telebot\models\UserModel;
use function array_merge;

/**
 * Class CronHandler
 * @package Fp\Telebot\handlers
 */
class CronHandler extends AbstractHandler
{

    public function __construct()
    {
        $this->consoleLog(self::class);
    }

    public function sendFileFiled()
    {
        $this->sendAdmin(0);
    }

    public function sendFileUpdate()
    {
        $this->sendAdmin(1);
    }

    public function sendMonitoring()
    {
        $this->sendAdmin(2);
    }

    /**
     * @param int $data
     */
    public function sendAdmin($data)
    {
        switch ($data) {
            case 0:
                $text = 'Файл не обновился';
                break;
            case 1:
                $text = 'Файл обновился';
                break;
            case 2:
                $text = "Файл не обновился, рассылка пользователям не произведена.\nЗапущен процесс мониторинга.";
                break;
            default:
                $text = 'Статус обновления файла ошибочный';
        }

        $chatIds = (new UserModel())->getAdminsChatIds();

        $m = $this->setMethodMultipleChats($text, $chatIds);
        $this->pushMethod($m);
    }

    public function sendGroup()
    {
        $chatIds = (new GroupModel())->getQvChatIds();

        $messages = [
            $this->getPastFactContent(D::BTN_PAST_FACT),
            $this->getPastFactContent(D::BTN_PAST_FACT_RB),
            $this->getPastFactContent(D::BTN_PAST_FACT_LV),
            $this->getPastFactContent(D::BTN_PAST_FACT_RB_PFM),
        ];

        $this->setMultipleMessagesMultipleChats($messages, $chatIds);
    }

    public function sendUser()
    {
        $chatIds = (new UserModel())->getAdminsChatIds();

        $messages = [
            $this->getPastFactContent(D::BTN_PAST_FACT),
            $this->getPastFactContent(D::BTN_PAST_FACT_RB),
            $this->getPastFactContent(D::BTN_PAST_FACT_LV),
            $this->getPastFactContent(D::BTN_PAST_FACT_RB_PFM),
        ];

        $this->setMultipleMessagesMultipleChats($messages, $chatIds);
    }

    public function sendDetailed()
    {
        $chatIds = (new UserModel())->getAdminsChatIds();
        $additionalChats = [];
        if (defined('USER_CHAT_IDS') && is_array(USER_CHAT_IDS)) {
            $additionalChats = USER_CHAT_IDS;
        }
        $chatIds = array_merge($chatIds, $additionalChats);

        $messages = [
            $this->getPastFactContent(D::BTN_PAST_FACT_RB_PFM),
        ];

        $this->setMultipleMessagesMultipleChats($messages, $chatIds);
    }
}
