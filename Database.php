<?php


class Database
{
    private $pdo;
    private static $example = null;

    private $error = false;
    private $result;
    private $countRow;

    private function __construct() {}

    /* Param: null
     * Description: Создаёт, если он не создан и возвращает экземляр класса.
     * Return: Database $example
     */
    public static function GetExample() :Database {}

    /* Param: string $sql
     * Description: Выполняет переданный запрос в функцию к базе данных.
     * Return: Database $example
     */
    public function query(string $sql) :Database {}

    /* Param: string $table, string $selectField, array $param
     * Description: Формирует запрос для выборки данных из бд, принимает название таблицы, поля для выборки, условия в виде двумерного асоциативного массива
     * Return: Database $example
     */
    public function select(string $table, string $selectField = "*",$arr = [['field'=>'id','criterion'=>'like','param'=>'1']]) :Database {}

    /* Param: string $table, string $selectField, array $param
     * Description:  Формирует запрос для удаления данных из бд, принимает название таблицы, поля для выборки, условия в виде двумерного асоциативного массива
     * Return: Return: Database $example
     */
    public function delete(string $table, string $selectField = "*",$arr = [['field'=>'id','criterion'=>'like','param'=>'1']]) :Database {}

    /* Param: string $table, array $param
     * Description: Формирует запрос на добавление в бд. Принимает имя таблицы
     * Return: Database $example
    */
    public function insert(string $table, $arrParam = [['name'=>'Egor','age'=>'29','city'=>'Kharkov']]) :Database {}

    /* Param: string $table
     * Description: Обновляет запись в базе
     * Return: Database $example
     */
    public function update(string $table,$arrParam = [['name'=>'Egor','age'=>'29','city'=>'Kharkov']] ,$arr = [['field'=>'id','criterion'=>'like','param'=>'1']]) :Database {}

    public function error() {}
    public function result() {}
    public function countRow() {}

}