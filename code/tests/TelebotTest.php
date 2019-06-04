<?php

namespace Fp\Tests\Telebot;

use Exception;

class TelebotTest
{
    /**
     * Проверка доступности файла "Онлайн продажи"
     * @throws Exception
     */
    public function testOnlineSales()
    {
        $onlineSalesImg = file_get_contents(WKHTML_URL);
        if (!$onlineSalesImg) {
            throw new Exception('Ошибка получения файла "Онлайн продажи"');
        }

        $imgSize = mb_strlen($onlineSalesImg);
        if ($imgSize < 150000) {
            throw new Exception('Размер файла "Онлайн продажи" меньше ожидаемого');
        }
    }

    /**
     * Проверка "Продажи за вчера"
     * @throws Exception
     */
    public function testPastFact()
    {
        $pastFactText = file_get_contents(PAST_FACT_FILE_PATH);
        if (!$pastFactText) {
            throw new Exception('Файл "Продажи за вчера" не найден');
        }

        if (!strpos($pastFactText, 'План:')) {
            throw new Exception('Файл "Продажи за вчера" не корректен');
        }
    }
}
