<?php


namespace Fp\Telebot\commands;


use Fp\Telebot\Dictionary as D;
use Fp\Telebot\handlers\AbstractHandler;
use Fp\Telebot\helpers\ConsoleHelper;

/**
 * Class AbstractCommands
 * @package Fp\Telebot\commands
 */
abstract class AbstractCommands
{
    /**
     * Объект обработчика запросов
     *
     * @var AbstractHandler $handler
     */
    private $handler;

    /**
     * Название метода из объекта обработчика, который будет вызван с помощью call_user_func.
     * Методы не должны принимать параметров, все данные необходимо загрузить в свойства объекта обработчика.
     *
     * @var string $handlerMethod
     */
    private $handlerMethod;

    /**
     * @return AbstractHandler
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @param AbstractHandler $handler
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;
    }

    /**
     * Возвращает массив [object, method], если метод существует и может быть вызван функцией call_user_func
     *
     * @param string $type
     * @param string $value
     * @return array|null
     */
    public function getHandlerFunc(string $type, string $value)
    {
        $handlers = $this->getCommands();
        $handle = $handlers[$type][$value] ?? null;

        if (is_array($handle) && isset($handle[0]) && isset($handle[1])) {
            $this->setHandler($handle[0]);
            $this->handlerMethod = $handle[1];
        } else {
            $this->handlerMethod = $handle;
        }

        return ($this->isValidHandlerFunc()) ? [$this->handler, $this->handlerMethod] : null;
    }

    /**
     * Массив с обработчиками для колбэк запросов
     *
     * @return array
     */
    abstract public function getCommandsCallback();

    /**
     * Массив обработчиков для команд, начинающихся с "/"
     *
     * @return array
     */
    abstract public function getCommandsCmd();

    /**
     * Массив обработчиков для обычных текстовых сообщений
     *
     * @return array
     */
    abstract public function getCommandsText();

    /**
     * @return array
     */
    protected function getCommands()
    {
        $help = [
            D::CMD_HELP => [$this->getHandler(), 'getHelp'],
            '?' => [$this->getHandler(), 'getHelp'],
        ];
        return [
            D::REQ_TYPE_CALLBACK => $this->getCommandsCallback(),
            D::REQ_TYPE_COMMAND => array_merge($help, $this->getCommandsCmd()),
            D::REQ_TYPE_TEXT => $this->getCommandsText()
        ];
    }

    /**
     * @return bool
     */
    protected function isValidHandlerFunc()
    {
        return method_exists($this->handler, $this->handlerMethod) && is_callable([$this->handler, $this->handlerMethod]);
    }

    /**
     * @param string|array|object $text
     */
    protected function consoleLog($text)
    {
        ConsoleHelper::consoleLog($text);
    }
}
