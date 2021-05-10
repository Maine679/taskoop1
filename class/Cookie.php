<?php


class Cookie
{
    private static $keyName = null;

    /**
     * Получает наименование ключа куки из конфигурационного файла.
     * @param void
     * @return string $keyName
     */
    public static function getKeyName() :string {
        if(is_null(self::$keyName)) {
            self::$keyName = Config::Get('cookie.cookie_name', $GLOBALS['config']);
        }
        return self::$keyName;
    }


    /**
     * Функция для получения куки пользователя
     * @param string $key
     * @return string|bool
     * Возвращает или строку или false
     */
    public static function get(string $key) {

        if(!empty($key) && !empty($_COOKIE[$key])) {
            return $_COOKIE[$key];
        }
        return false;
    }

    /**
     * Функция для установки куки пользователю и записи её в базу данных.
     * @param string $key
     * Ключ под которым устанавливается кука
     * @param string $value
     * Значение куки которое будет установлено.
     * @param int $time
     * Время жизни куки
     * @return bool
     * true|false
     */
    public static function put(string $key,string $value,int $time = 86400) :bool {
        if(!empty($key) && !empty($value)) {
            if($time == 86400) {
                $time = $time + time();
            }
            setcookie($key,$value,$time,'/');
        }
        return false;
    }

    /**
     * Удаляет значение ключа у пользователя и в бд
     * @param string $key
     * Ключ по которому будет искать куки у пользователя.
     * @return bool
     */
    public static function delete(string $key) :bool {
        setcookie($key,'', time());
        return true;
    }

    /**
     * Проверяет наличие установленной куки у пользователя.
     * @param string $key
     * Ключ наименования куки в системе.
     * @return bool
     */
    public static function exists(string $key) :bool {
        if(!empty($_COOKIE[$key]))
            return true;
        return false;
    }

}