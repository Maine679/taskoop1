<?php


class Validate
{

    /**
     * Для записи ошибок валидации.
     */
    private static array $error = [''];

    public function __construct() {

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

        if(empty(self::$error)) {
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
//        if(!self::is_error())
//            return;

        var_dump(self::$error);

        //Отображаем ошибки.
        foreach (self::$error as $value) {
            echo "{$value}<br>";
        }

//        self::$error = [];

    }

    /**
     * Description: Функция проверяет введённые данные пользователем на указанные условия во втором параметре
     * и записывает информацию об ошибках в массив.
     * @param array $param
     * Передаём глобальный массив Get или Post
     * @param array $checks
     * Массив содержащий условия для проверки
     *
     * @return void
     */
    public static function Check(array $param,array $checks) :void {

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
                        if(strlen($param[$item]) < $value) {
                            self::set_error("Поле {$item} должно быть не короче {$value} символов.");
                        }
                        break;
                    }
                    case 'max': {
                        if(strlen($param[$item]) >= $value) {
                            self::set_error("Поле {$item} должно быть не длинее {$value} символов.");
                        }
                        break;
                    }
                    case 'unique': {
                        break;
                    }
                    case 'matches': {
                        if($param[$item] !== $param[$value]) {
                            self::set_error("Поле {$item} должно совпадать с полем {$value}.");
                        }
                        break;
                    }
                }
            }
        }
    }

}



/*Поля не ищезают
 *
 * Правила валидации:
 *  свободное имя
 *  пароли совпадают
 *  длина больше указаннго количества
 *  если есть ошибки то мы их записываем
 *  Отображаем ошибки по требованию.
 */


//    $validation->Check($_POST,
//        [
//            'username'=> [
//                'required' => true,
//                'min' => 6,
//                'max' => 25,
//                'unique' => 'users'
//            ],
//            'password'=> [
//                'required' => true,
//                'min' => 4
//            ],
//            'password_confirm' => [
//                'required' => true,
//                'matches' => 'password'
//            ]
//        ]
//    );
//
//
//
//
//
//    if($validation->passed()) {
//        echo "passed";
//    }
//
//}
