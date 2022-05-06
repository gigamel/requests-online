<?php

namespace app\models;

use abstracts\ActiveModel;
use vendor\ASh\Db\DataObject;

class Request extends ActiveModel
{
    private const REGEX_PHONE = '/^((\+?[0-9]{1} ?\(?[0-9]{3}\)? ?)?[0-9]{3}' .
        '([- ]+)?[0-9]{2}([- ]+)?[0-9]{2})$/';

    /** @var string */
    public $email;
    
    /** @var int */
    public $id;
    
    /** @var string */
    public $name;
    
    /** @var string */
    public $phone;
    
    /** @var array */
    protected $errors;
    
    public function __construct()
    {
        $this->errors = [];
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        if (!method_exists($this, 'table') || DataObject::connect() === null) {
            return false;
        }

        $query = 'DELETE FROM ' . $this->table() . ' WHERE id = :id';

        $stm = DataObject::$dbh->prepare($query);
        $stm->bindValue(':id', $this->id, \PDO::PARAM_INT);
        $stm->execute();

        return true;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return (bool)count($this->errors);
    }

    /**
     * @return int
     */
    public function insert(): int
    {
        if (!method_exists($this, 'table') || DataObject::connect() === null) {
            return 0;
        }

        $query = 'INSERT INTO ' . $this->table() .
            ' SET email = :email, name = :name, phone = :phone';

        $stm = DataObject::$dbh->prepare($query);
        $stm->bindValue(':email', $this->email, \PDO::PARAM_STR);
        $stm->bindValue(':name', $this->name, \PDO::PARAM_STR);
        $stm->bindValue(':phone', $this->phone, \PDO::PARAM_STR);
        $stm->execute();

        return DataObject::$dbh->lastInsertId();
    }

    /**
     * @return string
     */
    public function table(): string
    {
        return 'request';
    }

    /**
     * @return void
     */
    public function valid(): void
    {
        if (!preg_match('/^[a-zA-Zа-яА-Я ]{2,}$/ui', trim($this->name))) {
            $this->errors[] = 'некорректное имя';
        }
        
        if (!preg_match(self::REGEX_PHONE, $this->phone)) {
            $this->errors[] = 'некорректный телефон ' .
                '(пример: 79000000000 или 2000000)';
        }
        
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'некорректный e-mail (пример: example@mail.com)';
        }
    }
}
