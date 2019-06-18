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
     * @param array $data
     * @param integer|array $cond
     */
    public function update($data, $cond)
    {
        $where = $this->prepareWhere($cond);
        $this->db->update($this->getTableName(), $data, $where);
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
        $where = $this->prepareWhere($cond);
        $this->db->delete($this->getTableName(), $where);
    }

    /**
     * @param int|array $cond
     * @return array
     */
    public function getRow($cond)
    {
        $where = $this->prepareWhere($cond);
        return $this->db->get($this->getTableName(), '*', $where);
    }

    /**
     * @param int|array $cond
     * @return array
     */
    protected function prepareWhere($cond)
    {
        $where = $cond;
        if (!is_array($cond) && $cond > 0) {
            $where = ["id" => $cond];
        }
        return $where;
    }
}
