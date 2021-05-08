<?php
session_start();


require_once "Database.php";

class Validate
{

    /**
     * Для записи ошибок валидации.
     */
    public static array $error = [];

    /**
     * Description: Получает ошибки возникшие во время исполнения скрипта.
     * @param void
     * @return array;
     */
    private static function get_error() :array {
        return self::$error;
    }
    /**
     * Description: Записывает ошибки возникшие во время проверок.
     * @param string $error
     * Передаёт текст ошибки
     * @return void;
     */
    private static function set_error(string $error) :void {
        self::$error[] = $error;
    }

    /**
     * Description: Если были ошибки - уведомляет об этом.
     * @Param void
     * @Return boolean
     */
    public static function is_error() :bool {

        if(empty(self::$error) && empty($_SESSION['error'])) {
            return false;
        }
        return true;
    }

    /**
     * Description: Возвращает все ошибки которые возникли в процессе проверки формы.
     * @Param void
     * @Return Void
     */
    public static function show_error() :void {
        //Если ошибок нет - выходим.
        if(!self::is_error() && empty($_SESSION['error']))
            return;

        if(self::is_error()) {
            //Отображаем ошибки.
            foreach (self::$error as $value) {
                echo "{$value}<br>";
            }
        }
        //Здесь реализована передача через сессии так как ошибки не сохранялись.
        if(!empty($_SESSION['error'])) {
            //Отображаем ошибки.
            foreach ($_SESSION['error'] as $value) {
                echo "{$value}<br>";
            }
        }
    }

    /**
     * Description: Функция проверяет введённые данные пользователем на указанные условия во втором параметре
     * и записывает информацию об ошибках в массив.
     * @param array $param
     * Передаём глобальный массив Get или Post
     * @param array $checks
     * Массив содержащий условия для проверки
     *
     * @return bool
     * true|false
     */
    public static function Check(array $param,array $checks) :bool {

        foreach ($checks as $item => $check) {

            foreach ($check as $key => $value) {
                switch ($key) {
                    case 'required': {
                        if($value) {
                            if (empty($param[$item])) {
                                self::set_error("Поле {$item} обязательно для заполнения.");
                            }
                        }
                        break;
                    }
                    case 'min': {
                        if (!empty($param[$item])) {
                            if (strlen($param[$item]) < $value) {
                                self::set_error("Поле {$item} должно быть не короче {$value} символов.");
                            }
                        }
                        break;
                    }
                    case 'max': {
                        if (!empty($param[$item])) {
                            if (strlen($param[$item]) >= $value) {
                                self::set_error("Поле {$item} должно быть не длинее {$value} символов.");
                            }
                        }
                        break;
                    }
                    case 'unique': {
                        if (!empty($param[$item])) {
                            if(!empty($value)) {
                                Database::GetExample()->select($value,'*',[['field'=>'name','criterion'=>'=','param'=>$param[$item]]]);
                                if(Database::GetExample()->countRow() > 0) {
                                    self::set_error("Такой username уже используется, выберите другой.");
                                }
                            }

                        }
                        break;
                    }
                    case 'matches': {
                        if (!empty($param[$item]) && !empty($param[$value])) {
                            if ($param[$item] !== $param[$value]) {
                                self::set_error("Поле {$item} должно совпадать с полем {$value}.");
                            }
                        }
                        break;
                    }
                }
            }
        }

        unset($_SESSION['error']);
        $_SESSION['error'] = self::get_error();

        return !self::is_error();
    }
}