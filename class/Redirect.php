<?php


class Redirect
{
    /**
     * Description: Функция для редиректа на страницы (Обёртка над функцией header)
     * @param $location
     * Путь по которому требуется перейти или код ошибки.
     * @return void
     */
    public static function to($location = null) :void {

        if(is_null($location))
            return;

        if(is_numeric($location)) {
            switch ($location) {
                case 404: {

                    header('HTTP/1.0 Not Found');
                    include '../errors/404.php';
                    exit;
                    break;
                }
            }
        } else {
            header('location: ' . $location);
        }
    }
}