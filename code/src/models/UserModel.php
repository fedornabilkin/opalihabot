<?php


namespace Fp\Telebot\models;


use Fp\Telebot\Dictionary as D;

class UserModel extends AbstractModel
{
    protected $tableName = 'user';

    /**
     * @param int $id
     * @param string $username
     * @param string $fullname
     * @return int
     */
    public function createUser($id, $username, $fullname)
    {
        return $this->insert([
            'chatid' => $id,
            'username' => $username,
            'fullname' => $fullname
        ]);
    }

    /**
     * @return array|bool
     */
    public function getUsersWithRole()
    {
        $users = $this->db->select(
            'user(u)',
            ["[><]roleuser(ru)" => ["u.id" => "userid"],
                "[><]role(r)" => ["ru.roleid" => "id"]],
            ['u.id', 'u.username', 'u.fullname', 'r.role', 'r.id(roleid)'],
            ["ORDER" => ["u.id" => "ASC"]]);

        return $users;
    }

    /**
     * @return array|bool
     */
    public function getUsers()
    {
        $users = $this->db->select(
            'user(u)', ['u.id', 'u.username', 'u.fullname', 'chatid']);

        return $users;
    }

    /**
     * @param int $id
     * @return int
     */
    public function getUserIdByChatId($id)
    {
        return $this->get('id', ['chatid' => $id]);
    }

    /**
     * @param int $id
     * @return array
     */
    public function getUserByChatId($id)
    {
        return $this->getRow(['chatid' => $id]);
    }

    /**
     * @return array|bool
     */
    public function getModeratorsChatIds()
    {
        $users = $this->getUsersByRole(D::ROLE_MODERATOR);
        return array_column($users, 'chatid');
    }

    /**
     * @return array|bool
     */
    public function getAdminsChatIds()
    {
        $users = $this->getUsersByRole(D::ROLE_ADMIN);
        return array_column($users, 'chatid');
    }

    /**
     * @param integer $roleId
     * @return array|bool
     */
    public function getUsersByRole($roleId)
    {
        return $this->db->select($this->getTableName(), ["[><]roleuser" => ["id" => "userid"]], '*', ["roleid" => ["{$roleId}"]]);
    }

    /**
     * @param int $id
     * @return array
     */
    public function isAdmin($id)
    {
        $roleId = D::ROLE_ADMIN;
        return $this->get(["[><]roleuser" => ["id" => "userid"]], ["chatid"], ["chatid" => [$id], "roleid" => ["{$roleId}"]]);
    }
}
