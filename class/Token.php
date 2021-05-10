<?php
require_once "Config.php";
require_once "Session.php";



class Token
{
    /**
     * Description: Служит для генерации уникального ключа сессии, записи его
     * @param void
     * @return string
     */
    public static function Generate() :string {
        return Session::put(Config::Get('session.session_token',$GLOBALS['config']),md5(uniqid()));
    }

    /**
     * Description: Сверяет переданный токен с записанным в сессиях
     * @param $token
     * Токен полученный из формы
     * @return bool
     * true|false
     */
    public static function Check($token) :bool {
        if(!isset($token))
            return false;

        $key = Config::Get('session.session_token',$GLOBALS['config']);

        if(Session::get($key) == $token) {
            Session::delete($key);
            return true;
        }
        return false;
    }
}