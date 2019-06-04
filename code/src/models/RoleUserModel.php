<?php


namespace Fp\Telebot\models;


class RoleUserModel extends AbstractModel
{
    protected $tableName = 'roleuser';

    /**
     * Устанавливает роль пользоваетлю
     *
     * @param $userId
     * @param $roleId
     * @return int
     */
    public function assignRole($userId, $roleId)
    {
        $id = $this->db->get($this->getTableName(), 'id', ['userid' => $userId]);

        if ($id) {
            $this->db->update($this->getTableName(), [
                'roleid' => $roleId
            ], ['id' => $id]);
        } else {
            $id = $this->insert([
                'userid' => $userId,
                'roleid' => $roleId
            ]);
        }

        return $id;
    }
}
