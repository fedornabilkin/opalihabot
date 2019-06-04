<?php


namespace Fp\Telebot\middleware;


use Fp\Telebot\helpers\ConsoleHelper;
use Fp\Telebot\RequestData;

/**
 * Class AbstractMiddleware
 * @package Fp\Telebot\middleware
 */
abstract class AbstractMiddleware
{
    /** @var RequestData */
    protected static $requestData;

    /**
     * @var AbstractMiddleware
     */
    private $next;

    /**
     * Метод используется для построения цепочки объектов middleware.
     *
     * @param AbstractMiddleware $next
     * @return AbstractMiddleware
     */
    public function linkWith(AbstractMiddleware $next): AbstractMiddleware
    {
        $this->next = $next;

        return $next;
    }

    /**
     * Подклассы переопределяют метод для предоставления своих проверок
     *
     * @return bool
     */
    public function check(): bool
    {
        if (!$this->next) {
            return true;
        }

        return $this->next->check();
    }

    /**
     * @param RequestData $data
     */
    public function setData($data)
    {
        self::$requestData = $data;
    }

    /**
     * @return RequestData
     */
    public function getData()
    {
        return self::$requestData;
    }

    /**
     * @return AbstractMiddleware
     */
    protected function getNext()
    {
        return $this->next;
    }

    /**
     * Вставляет мидлвэр между текущим и следующим
     * Если необходимо добавить сразу несколько middleware в середину цепочки, их необходимо линковать через этот метод
     *
     * $mdw = newUserExist();
     * $mdw->linkWith(new RoleCheck())->linkWith(new UserStory());
     *
     * Чтобы добавить new AuthKey() и new RoleCreate() между new RoleCheck() и new UserStory(), необходимо
     *
     * $mdwIns = new AuthKey();
     * $this->insertNext($mdwIns); // в контексте RoleCheck
     * $mdwIns->insertNext(new RoleCreate());
     *
     * @param bool $break
     * @param AbstractMiddleware $middleware
     */
    protected function insertNext(AbstractMiddleware $middleware, $break = false)
    {
        if (!$break) {
            $middleware->linkWith($this->getNext());
        }
        $this->linkWith($middleware);
    }

    /**
     * @return bool
     */
    protected function stopProcessing()
    {
        $this->setError();
        return false;
    }

    protected function setError()
    {

    }

    protected function getErrors()
    {

    }

    /**
     * @param string|array|object $text
     */
    protected function consoleLog($text)
    {
        ConsoleHelper::consoleLog($text);
    }
}
