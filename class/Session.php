<?php
session_start();

class Session
{

    /**
     * Description: Возвращает данные записанные в сессии по ключу
     * @param string $key
     * Ключ в глобальном массиве сессий
     * @return string
     */
    public static function get($key) :string {
        return $_SESSION[$key];
    }
    /**
     * Description: Проверяет наличие данных сессии по ключу
     * @param string $key
     * Ключ в глобальном массиве сессий
     * @return boolean
     */
    public static function exists(string $key) :bool {
        if(isset($_SESSION[$key]))
            return true;
        return false;
    }

    /**
     * Description: Устанавливает значение по ключу в глобальном массиве сессий.
     * @param string $key
     * Ключ по которому устанавливается значение
     * @param string $value
     * Значение которое устанавливается
     * @return string
     */
    public static function put(string $key,string $value) :string {
        $_SESSION[$key] = $value;
        return $value;
    }

    /**
     * Description: Удаляет данные из глобального массива сессий по ключу
     * @param $key
     * Имя ключа по которому будут удалены данные
     * @return bool
     * true|false
     */
    public static function delete($key) :bool {
        if(isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }
        return false;
    }



}