<?php
/**
 * Created by PhpStorm.
 * User: fedornabilkin
 * Date: 09.06.2019
 * Time: 11:04
 */

namespace Fp\Telebot\models;


class NotesModel extends AbstractModel
{
    protected $tableName = 'notes';

    public function getNotesByUserId($id)
    {
        return $this->db->select($this->getTableName(),'*', ["userid" => ["{$id}"]]);
    }
}