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
        if(self::exists($key))
            return $_SESSION[$key];
        return '';
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
        if(self::exists($key)) {
            unset($_SESSION[$key]);
            return true;
        }
        return false;
    }

    /**
     * Description: Функция для вывода и установки флеш сообщений.
     * @param string $key
     * Ключ по которому устанавливается и выводится сообщение.
     * @param string $message
     * Текст сообщения которого требуется отобразить.
     * @return string|null
     */
    public static function flash(string $key, string $message = '') :?string {
        if(self::exists($key) && $message == '') {
            $message = self::get($key);
            self::delete($key);
            return $message;

        } else {
            self::put($key,$message);
        }
        return null;
    }



}