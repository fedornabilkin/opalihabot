<?php
/**
 * Created by PhpStorm.
 * User: fedornabilkin
 * Date: 09.06.2019
 * Time: 11:08
 */

namespace Fp\Telebot\models;


class NotifyModel extends AbstractModel
{
    protected $tableName = 'notify';

    /**
     * @param array $data
     * @return int
     */
    public function addNotify(array $data): int
    {
        $id = $this->db->get($this->getTableName(), 'id', [
            'notesid' => $data['notesid'],
            'timecode' => $data['timecode'],
            'daycode' => $data['daycode'],
        ]);

        if (!$id) {
            $id = $this->insert($data);
        }

        return $id;
    }

    /**
     * @param int $timeCode
     * @param int $dayCode
     * @return array|bool
     */
    public function getNotify(int $timeCode, int $dayCode): array
    {
        $rows = $this->db->select(
            'notify(nf)',
            ["[><]notes(nt)" => ["nf.notesid" => "id"],
                "[><]user(u)" => ["nt.userid" => "id"]],
            ['nt.id', 'nt.text', 'u.chatid', 'nf.timecode', 'nf.daycode'],
            [
                'nt.status' => 1,
                'nf.timecode' => $timeCode,
                'nf.daycode' => $dayCode
            ]);

        return $rows;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getNotifyByNotesId(int $id): array
    {
        $rows = $this->db->select('notify', ['timecode', 'daycode'], [
            'notesid' => $id,
            'ORDER' => ['timecode' => 'ASC']
        ]);
        return $rows;
    }
}