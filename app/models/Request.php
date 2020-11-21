<?php
namespace app\models;

use PDO;
use abstracts\ActiveModel;
use vendor\ASh\Db\DataObject;

class Request extends ActiveModel
{
    public $email;
    public $id;
    public $name;
    public $phone;
    
    /**
     * @return boolean
     */
    public function valid()
    {
        $errors = [];
        
        if (!preg_match('/^[a-zA-Zа-яА-Я ]{2,}$/ui', trim($this->name))) {
            $errors[] = 'некорректное имя';
        }
        
        if (!preg_match('/^((\+?[0-9]{1} ?\(?[0-9]{3}\)? ?)?[0-9]{3}([- ]+)?[0-9]{2}([- ]+)?[0-9]{2})$/', $this->phone)) {
            $errors[] = 'некорректный телефон (пример: 79000000000 или 2000000)';
        }
        
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'некорректный e-mail (пример: example@mail.com)';
        }
        
        if (count($errors) > 0) {
            return $errors;
        }
        
        return true;
    }
    
    /**
     * @return string
     */
    public function table()
    {
        return 'request';
    }
    
    /**
     * @return int
     */
    public function insert()
    {
        $result = 0;

        if (method_exists($this, 'table') && DataObject::connect() !== null) {            
            $query = 'INSERT INTO '.$this->table();
            $query .= ' SET email = :email, name = :name, phone = :phone';
            
            $stm = DataObject::$dbh->prepare($query);
            $stm->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stm->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stm->bindValue(':phone', $this->phone, PDO::PARAM_STR);            
            $stm->execute();
            
            $result = DataObject::$dbh->lastInsertId();
        }
        
        return $result;
    }
    
    /**
     * @return boolean
     */
    public function delete()
    {
        if (method_exists($this, 'table') && DataObject::connect() !== null) {
            $query = 'DELETE FROM '.$this->table().' WHERE id = :id';
            
            $stm = DataObject::$dbh->prepare($query);
            $stm->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stm->execute();
            
            return true;
        }
        
        return false;
    }
}