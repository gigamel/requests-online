<?php

namespace abstracts;

use vendor\ASh\Db\DataObject;
use abstracts\Model;

abstract class ActiveModel extends Model
{
    public const
        DEFAULT_LIST_LIMIT = 20,
        DEFAULT_LIST_OFFSET = 0
    ;
    
    /**
     * @param string $field
     * @param mixed $value
     *
     * @return null|$this
     */
    public function getBy(string $field, $value = null)
    {
        $field = trim($field);
        
        if (
            empty($field) ||
            empty($value) ||
            !method_exists($this, 'table') ||
            DataObject::connect() === null
        ) {
            return null;
        }

        $query = 'SELECT * FROM ' . $this->table() . 
            ' WHERE ' . $field . ' = :value';

        $stm = DataObject::$dbh->prepare($query);
        $stm->bindValue(':value', $value);
        $stm->execute();

        $array = $stm->fetch(\PDO::FETCH_ASSOC);
        
        if (empty($array)) {
            return null;
        }
        
        $className = static::class;
        $result = new $className();
        $result->load($array);
        
        return $result;
    }
    
    /**
     * @param string $cond
     *
     * @return int
     */
    public function getCount(string $cond): int
    {
        if (!method_exists($this, 'table') || DataObject::connect() === null) {
            return 0;
        }
        
        $query = 'SELECT COUNT(*) AS total FROM ' . $this->table();
        if (is_string($cond) && !empty($cond = trim($cond))) {
            $query .= ' WHERE ' . $cond;
        }

        $stm = DataObject::$dbh->prepare($query);
        $stm->execute();

        return $stm->fetch(\PDO::FETCH_ASSOC)['total'];
    }
    
    /**
     * @param int $limit
     * @param int $offset
     * @param string $order
     * @param string $cond
     *
     * @return array
     */
    public function getList(
        int $limit = self::DEFAULT_LIST_LIMIT,
        int $offset = self::DEFAULT_LIST_OFFSET,
        string $order = '',
        string $cond = ''
    ): array {
        if (!method_exists($this, 'table') || DataObject::connect() === null) {
            return [];
        }

        $limit = ($limit < 1) ? self::DEFAULT_LIST_LIMIT : $limit;
        $offset = ($offset < 0) ? self::DEFAULT_LIST_OFFSET : $offset;

        $query = 'SELECT * FROM ' . $this->table();
        if (is_string($cond) && !empty($cond = trim($cond))) {
            $query .= ' WHERE ' . $cond;
        }
        if (is_string($order) && !empty($order = trim($order))) {
            $query .= ' ORDER BY ' . $order;
        }
        $query .= ' LIMIT :limit OFFSET :offset';

        $stm = DataObject::$dbh->prepare($query);
        $stm->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stm->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stm->execute();

        $className = static::class;
        $array = $stm->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];
        foreach ($array as $key => $item) {
            $result[$key] = new $className;
            $result[$key]->load($item);
        }

        return $result;
    }
}
