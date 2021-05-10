<?php

require_once "Config.php";

class Database
{
    private $pdo = null;
    private static $example = null;

    private $error = null;
    private $errorCode = null;
    private $result;
    private $countRow;


    private function __construct() {
        $this->pdo = new PDO("mysql:host=" . Config::Get('mysql.host',$GLOBALS['config']) . ";dbname=" . Config::Get('mysql.database',$GLOBALS['config']),Config::Get('mysql.username',$GLOBALS['config']),Config::Get('mysql.password',$GLOBALS['config']));
    }

    /* Param: null
     * Description: Создаёт, если он не создан и возвращает экземляр класса.
     * Return: Database $example
     */
    public static function GetExample() :Database {

        if(!self::$example)
            self::$example = new Database();

        return self::$example;
    }

    /* Param: string $sql
     * Description: Выполняет переданный запрос в функцию к базе данных, подставляя параметры переданные вместе с запросом.
     * Return: Database $example
     */
    public function query(string $sql, array $params = []) :Database {

        $query = $this->pdo->prepare($sql);

        if(count($params)) {
            $num = 1;
            foreach ($params as $param) {
                $query->bindValue($num, $param);
                $num++;
            }
        }


        if(!$query->execute())
            $this->error = true;


        $this->countRow = null;
        $this->result = null;
        //Ставим в null что бы сбросить состояние ошибки предыдушего запроса.
        $this->errorCode = null;
        $this->errorCode = $query->errorCode();

        //Если код ошибки - нет ошибок, ставим что в целом ошибок нет. (Нам не нужно разбираться со всеми типами кодов
        //Просто есть или нет.
        $this->error = $this->errorCode == 0 ? false:true;


        if(!$this->error) {
            $this->countRow = $query->rowCount();
            $this->result = $query->fetchAll(PDO::FETCH_OBJ);
        }
        return $this;
    }



    /*Param: string $query, array $arr, $param
     *Description:Получает начало сформированого запроса, формирует условие. 3 параметр заполняется данными для запроса.
     * Return: string $query
     */
    public function formatCondition(string $query,array $arr = [], &$params = []) :?string {

        $operators = ['=','<','>','>=','<=','!=','<>','<=>','LIKE'];

        $count = count($arr);
        if($count) {

            $query = $query . " WHERE ";
            //Цикл по параметрам.
            foreach ($arr as $item) {
                if (in_array($item['criterion'], $operators)) {

                    $query = $query . " {$item['field']} {$item['criterion']} ?";

                    $params[] = $item['param']; //Добавляем параметр для передачи запросу Database::query.

                    //Если больше параметров не ожидается то закрываем запрос, иначе ставим запятую.
                    if(--$count)
                        $query = $query . ',';
                    else
                        $query = $query . ';';

                } else { //Если что-то пошло не так, значит выкидываем с ошибкой.
                    $this->error = true;
                    return null;
                }
            }

        } else {
            $query = $query . ";";
        }

        return $query;
    }

//    SELECT * FROM users
//    DELETE FROM users
//    UPDATE users SET

    /**

     *
     * @Param
     *
     * Return: Database $example
     */


    /**
     * Description: Формирует запрос для выборки данных из бд, принимает название таблицы, поля для выборки,
     * условия в виде двумерного асоциативного массива
     * @param string $table
     * Имя таблицы в базе данных.
     * @param string $selectField
     * какие поля требуется получить, если * значит все.
     * @param array $arr
     * [['field'=> 'Наименование поля в бд','criterion'=>'Параметр сравнения','param'=>'значение для сравнения' ]]
     * @return $this
     * возвращает объект класса Database
     */
    public function select(string $table, string $selectField = "*",array $arr = []) :Database {
//        ['field'=>'id','criterion'=>'like','param'=>'1']


        //Если не прописана таблица - то тут наши полномочия всё...
        if(!$table) {
            $this->error = true;
            return $this;
        }

        $params = []; //Массив для параметров передеваемых в метод Database::query.

        //Формируем базовый запрос.
        $query = "SELECT {$selectField} FROM {$table}";
        $query = $this->formatCondition($query,$arr,$params); //Использовал передачу по ссылке, не уверен что это самый безопастный способ.

        if(!empty($query)) {
            $this->query($query,$params);
        }

        return $this;
    }

    /* Param: string $table, string $selectField, array $param
     * Description:  Формирует запрос для удаления данных из бд, принимает название таблицы, поля для выборки, условия в виде двумерного асоциативного массива
     * Return: Return: Database $example
     */
    public function delete(string $table,$arr = [['field'=>'id','criterion'=>'like','param'=>'1']]) :Database {
        // ['field'=>'id','criterion'=>'like','param'=>'1']

        //Если не прописана таблица - то тут наши полномочия всё...
        if(!$table) {
            $this->error = true;
            return $this;
        }

        $params = []; //Массив для параметров передеваемых в метод Database::query.

        //Формируем базовый запрос.
        $query = "DELETE FROM {$table}";

        $query = $this->formatCondition($query,$arr,$params); //Использовал передачу по ссылке, не уверен что это самый безопастный способ.

        if(!empty($query)) {
            $this->query($query,$params);
        }

        return $this;
    }

    /* Param: string $table, array $param
     * Description: Формирует запрос на добавление в бд. Принимает имя таблицы
     * Return: Database $example
    */
    public function insert(string $table, $arrParam = [['name'=>'Egor','age'=>'29','city'=>'Kharkov']]) :Database {
        //Если не прописана таблица - то тут наши полномочия всё...
        if(!$table) {
            $this->error = true;
            return $this;
        }

        $params = []; //Массив для параметров передеваемых в метод Database::query.

        //Формируем базовый запрос.
        $query = "INSERT INTO {$table} ( ";

        $strValue = "VALUES (";

        $count = count($arrParam);
        foreach ($arrParam as $key => $value) {
            $count--;
            if ($count > 0) {
                $query = $query . " {$key},";
                $strValue = $strValue . "?,";
            } else {
                $query = $query . " {$key}) ";
                $strValue = $strValue . "?) ";
            }
            $params[] = $value;
        }

        //Доформировываем запрос.
        $query = $query . $strValue;

        $this->query($query,$params);

        return $this;
    }


    /* Param: string $table
     * Description: Обновляет запись в базе
     * Return: Database $example
     */
    public function update(string $table,$arrParam = [['name'=>'Egor','age'=>'29','city'=>'Kharkov']] ,$arr = [['field'=>'id','criterion'=>'like','param'=>'1']]) :Database {

        //Если не прописана таблица - то тут наши полномочия всё...
        if(!$table) {
            $this->error = true;
            return $this;
        }

        $params = []; //Массив для параметров передеваемых в метод Database::query.

        //Формируем базовый запрос.
        $query = "UPDATE {$table} SET ";

        $count = count($arrParam);
        foreach ($arrParam as $key => $value) {
            $count--;
            if($count > 0) {
                $query = $query . " {$key}=?,";
            } else {
                $query = $query . " {$key}=? ";
            }
            $params[] = $value;
        }


        $query = $this->formatCondition($query,$arr,$params); //Использовал передачу по ссылке, не уверен что это самый безопастный способ.

        if(!empty($query)) {
            $this->query($query,$params);
        }

        var_dump($query);
        var_dump($params);

        return $this;
    }

    public function error() {
        return $this->error;
    }
    public function result() {
        return $this->result;
    }
    public function countRow() {
        return $this->countRow;
    }
    //Добавлена для возможности получить большую информативность.
    public function errorCode() {
        return $this->errorCode;
    }




}