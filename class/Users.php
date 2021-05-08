<?php


class Users
{
    private $db = null;

    /**
     * Users constructor.
     */
    public function __construct() {
        $this->db = Database::GetExample();
    }

    /**
     * Declartion: Функция для создаения пользователя в базе данных.
     * @param array $fields
     * Принимает массив параметров поле=>значение для записи в бд
     * @return bool
     * true|false
     */
    public function create($fields= []) :bool {
        $this->db->insert('users', $fields);
        return !$this->db->error();
    }

}