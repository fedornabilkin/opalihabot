<?php


namespace Fp\Telebot\models;


class RoleGroupModel extends AbstractModel
{
    protected $tableName = 'rolegroup';

    /**
     * Устанавливает роль группе
     *
     * @param $groupId
     * @param $roleId
     * @return int
     */
    public function assignRole($groupId, $roleId)
    {
        $id = $this->db->get($this->getTableName(), 'id', ['groupid' => $groupId]);

        if ($id) {
            $this->db->update($this->getTableName(), [
                'roleid' => $roleId
            ], ['id' => $id]);
        } else {
            $id = $this->insert([
                'groupid' => $groupId,
                'roleid' => $roleId
            ]);
        }

        return $id;
    }
}
