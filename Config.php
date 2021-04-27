<?php


class Config
{
    /* Param: string $param, array $arr
     * Description: Выводит данные находящиеся в конфиге по указанной вложенности
     * Return: ? $result
     */
    public static function Get(string $param, array $arr) {
        $keys = explode('.',$param);

        foreach ($keys as $key) {
            $arr = $arr[$key];

        }

        return $arr;
    }
}