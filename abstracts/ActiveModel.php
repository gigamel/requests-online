<?php
namespace abstracts;

use PDO;
use vendor\ASh\Db\DataObject;
use abstracts\Model;

abstract class ActiveModel extends Model
{
    /**
     * @param string $field
     * @param mixed $value
     * @return null|object
     */
    public function getBy($field = null, $value = null)
    {
        $result = null;
        
        $field = is_string($field) ? $field : '';
        $field = empty(trim($field)) ? null : $field;

        if (!empty($field) && !empty($value) && method_exists($this, 'table')
            && DataObject::connect() !== null) {
            $query = 'SELECT * FROM '.$this->table().' WHERE '.$field.' = :value';
            
            $stm = DataObject::$dbh->prepare($query);
            $stm->bindValue(':value', $value);
            $stm->execute();
            
            $array = $stm->fetch(PDO::FETCH_ASSOC);
            if (!empty($array)) {
                $className = static::class;
                $result = new $className;
                $result->load($array);
            }
        }
        
        return $result;
    }
    
    /**
     * @return int
     */
    public function getCount()
    {
        $result = 0;
        
        if (method_exists($this, 'table') && DataObject::connect() !== null) {
            $stm = DataObject::$dbh->prepare('SELECT COUNT(*) AS total FROM '.$this->table());
            $stm->execute();
            
            $result = $stm->fetch(PDO::FETCH_ASSOC)['total'];
        }
        
        return $result;
    }
    
    /**
     * @param int $limit
     * @param int $offset
     * @param string $order
     * @param string $cond
     * @return array
     */
    public function getList($limit = null, $offset = 0, $order = '', $cond = '')
    {
        $result = [];
        
        $limit = ($limit === null) ? 20 : (int) $limit;
        if (method_exists($this, 'table') && $limit > 0 && DataObject::connect() !== null) {
            $offset = (int) $offset;
            $offset = ($offset < 0) ? 0 : $offset;
            
            $query = 'SELECT * FROM '.$this->table();
            if (is_string($cond) && !empty(trim($cond))) {
                $query .= ' WHERE '.$cond;
            }
            if (is_string($order) && !empty(trim($order))) {
                $query .= ' ORDER BY '.$order;
            }
            $query .= ' LIMIT :limit OFFSET :offset';
            
            $stm = DataObject::$dbh->prepare($query);
            $stm->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stm->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stm->execute();
            
            $className = static::class;
            $array = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach ($array as $key => $item) {
                $result[$key] = new $className;
                $result[$key]->load($item);
            }
        }
        
        return $result;
    }
}