<?php


namespace Fp\Telebot\models;

/**
 * Class AbstractModel
 * @package Fp\Telebot\models
 */
abstract class AbstractModel
{
    protected $db;
    protected $tableName;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * @return mixed
     */
    protected function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @param array $data
     * @return int
     */
    public function insert(array $data)
    {
        $this->db->insert($this->getTableName(), $data);
        return $this->db->id();
    }

    /**
     * @param null $join
     * @param null $columns
     * @param null $where
     * @return array|int
     */
    public function get($join = null, $columns = null, $where = null)
    {
        return $this->db->get($this->getTableName(), $join, $columns, $where);
    }

    /**
     * @param array $cond
     */
    public function delete($cond)
    {
        $this->db->delete($this->getTableName(), $cond);
    }

    /**
     * @param int|array $cond
     * @return array
     */
    public function getRow($cond)
    {
        $where = $cond;
        if (!is_array($cond) && $cond > 0) {
            $where = ["id" => $cond];
        }

        return $this->db->get($this->getTableName(), '*', $where);
    }
}
