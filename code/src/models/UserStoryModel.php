<?php


namespace Fp\Telebot\models;


class UserStoryModel extends AbstractModel
{
    protected $tableName = 'userstory';

    public function lastCommand()
    {
        $messages = $this->db->select(
            $this->getTableName(),
            ['id', 'text', 'datetime'],
            [
                "ORDER" => ["id" => "DESC"],
                'LIMIT' => 15
            ]
        );

        return $messages;
    }
}