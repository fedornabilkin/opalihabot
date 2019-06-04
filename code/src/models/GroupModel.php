<?php


namespace Fp\Telebot\models;


use Fp\Telebot\Dictionary as D;

class GroupModel extends AbstractModel
{
    protected $tableName = 'group';

    /**
     * @param string $id
     * @param string $title
     * @return int
     */
    public function createGroup($id, $title)
    {
        return $this->insert(['chatid' => $id, 'title' => $title]);
    }

    /**
     * @param int $id
     * @return array
     */
    public function getGroupIdByChatId($id)
    {
        return $this->get('id', ['chatid' => $id]);
    }

    /**
     * @return array|bool
     */
    public function getQvChatIds()
    {
        $users = $this->getUsersByRole(D::ROLE_MODERATOR);
        return array_column($users, 'chatid');
    }

    /**
     * @param integer $roleId
     * @return array|bool
     */
    public function getUsersByRole($roleId)
    {
        return $this->db->select($this->getTableName(), ["[><]rolegroup" => ["id" => "groupid"]], '*', ["roleid" => ["{$roleId}"]]);
    }
}
