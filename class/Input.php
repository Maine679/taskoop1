<?php

/*  Что делает инпут:
 *  берёт данные и подставляет в значение
 *  Проверяет были ли отправлена форма
 *  Проверяет пустой массив глобальный или нет(болеан) (были введены данные или нет.)
 *
 *  get проверяет есть ли значение в массиве и возвращает его иначе не чего не возвращает.
 */

class Input
{
    public const ALL = 0;
    public const GET = 1;
    public const POST = 2;
    public const SESSION = 3;

    /* @param int $type [Optional]
     * Принимает 3 значения по которым проверяет данные в одном или в нескольких глобальных массиввах.
     * Description: Проверяет пустой глобальный массив или нет
     * @return boolean
     */
    public static function exists($type = Input::ALL, $key = null) {

        if(is_null($key)) {

            if ($type == Input::ALL && (!empty($_GET) || !empty($_POST)))
                return true;
            else if ($type == Input::GET && !empty($_GET))
                return true;
            else if ($type == Input::POST && !empty($_POST))
                return true;

            else
                return false;
        } else {
            switch ($type) {
                case self::ALL: {
                    if(!empty($_SESSION[$key]))
                        return true;
                    else if(!empty($_GET[$key]))
                        return true;
                    else if(!empty($_POST[$key]))
                        return true;
                    return false;
                }
                case self::GET: {
                    if(!empty($_GET[$key]))
                        return true;
                    return false;
                }
                case self::POST: {
                    if(!empty($_POST[$key]))
                        return true;
                    return false;
                }
                case self::SESSION: {
                    if(!empty($_SESSION[$key]))
                        return true;
                    return false;
                }
            }
        }
        return false;
    }

    /* @param string $param
     * Имя параметры значение которого следует вернуть
     * @param int $type [Optional]
     * Определяет с каким глобальным массивом мы работает, принимает 4 значения GET, POST, ALL
     *
     * Description: Возвращает данные из указанного глобального массива по имени параметра
     * @return mixed;
     */
    public static function get(string $param, int $type = Input::ALL) {

        if($type == Input::ALL) {
            if(!empty($_GET[$param]))
                return $_GET[$param];
            else if(!empty($_POST[$param]))
                return $_POST[$param];
            else if(!empty($_SESSION[$param]))
                return $_SESSION[$param];
            else return '';
        } else if($type == Input::GET) {
            if(!empty($_GET[$param]))
                return $_GET[$param];
            else return '';
        } else if($type == Input::POST) {
            if(!empty($_POST[$param]))
                return $_POST[$param];
            else return '';
        } else if($type == Input::SESSION) {
            if(!empty($_SESSION[$param]))
                return $_SESSION[$param];
            else return '';
        }
        return '';
    }

    /* @param string $param
     * Наименование параметра который устанавливается
     * @param string $value
     * Значение параметра устанавливаемое в массиве
     * @param int $type [Optional]
     * Тип массива в который будет установлен параметр
     * Description: Устанавливает значение параметра в глобальном массиве.
     * @return boolean
     */
    public static function set(string $param,string $value, int $type = Input::SESSION) {

        if($type == Input::SESSION) {
            $_SESSION[$param] = $value;
            return true;
        }

        return false;
    }
}