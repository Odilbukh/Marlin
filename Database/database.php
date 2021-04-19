<?php

class Database {
    private static $instance = null;
    private $pdo, $query, $error = false, $results, $count;


    /**
     * Инициализация объекта PDO и подключение к базе данных
     */
    private function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=" . Config::get('mysql.host') . ";dbname=" . Config::get('mysql.database'), Config::get('mysql.username'), Config::get('mysql.password'));
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }

    /**
     * Проверка на инициализацию объекта PDO и инициализация самого объекта PDO
     *
     * @return PDO
     */
    public static function getInstance() {

        if(!isset(self::$instance)) {
            self::$instance = new Database;
        }

        return self::$instance;
    }


    /**
     * Выполнение всех запросов в базу данных
     *
     * @param string $sql
     * @param array  $params
     * @return void
     */
    public function query($sql, $params = [])
    {

        $this->error = false;
        $this->query = $this->pdo->prepare($sql);

        if(count($params)) {
            $i = 1;
            foreach($params as $param) {
                $this->query->bindValue($i, $param);
                $i++;
            }
        }


        if(!$this->query->execute()) {
            $this->error = true;
        } else {
            $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
            $this->count = $this->query->rowCount();
        }

        return $this;
    }

    /**
     * Возвращаем информацию на наличие ошибок про выполнения SQL запроса
     *
     * @return void
     */
    public function error()
    {
        return $this->error;
    }

    /**
     * Возвращаем результат из выполненного SQL запроса. Этот медот использования после выполнения метода query()
     *
     * @return void
     */
    public function results()
    {
        return $this->results;
    }

    /**
     * Возвращаем количество элементов из выполненного SQL запроса
     *
     * @return void
     */
    public function count()
    {
        return $this->count;
    }

    public function get($table, $where = [])
    {
        return $this->action('SELECT *', $table, $where);
    }

    /**
     * Подготовка и выполниние SQL запроса для удаления данных из базе данных по ID
     *
     * @param string  $table
     * @param array $where
     * @return void
     */
    public function delete($table, $where = [])
    {
        return $this->action('DELETE', $table, $where);
    }

    public function action($action, $table, $where = [])
    {
        if(count($where) === 3) {

            $operators = ['=', '>', '<', '>=', '<='];

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators)) {

                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if(!$this->query($sql, [$value])->error()) { //true если есть ошибка
                    return $this;
                }
            }
        }

        return false;
    }

    /**
     * Подготовка и выполниние SQL запроса для сохранения данных б базу данных
     *
     * @param string $table
     * @param array  $fields
     * @return void
     */
    public function insert($table, $fields = [])
    {
        $values = '';
        foreach($fields as $field) {
            $values .= "?,";
        }
        $val = rtrim($values, ',');


        $sql = "INSERT INTO {$table} (" . '`' . implode('`, `', array_keys($fields)) . '`' . ") VALUES ({$val})";

        if(!$this->query($sql, $fields)->error()) {
            return true;
        }
        return false;

    }

    /**
     * Подготовка и выполниние SQL запроса для обновления данных в базе данных по ID
     *
     * @param string  $table
     * @param integer $id
     * @param array   $fields
     * @return void
     */
    public function update($table, $id, $fields = [])
    {
        $set = '';
        foreach($fields as $key => $field) {
            $set .= "{$key} = ?,"; // username = ?, password = ?,
        }

        $set = rtrim($set, ','); // username = ?, password = ?

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        if(!$this->query($sql, $fields)->error()){
            return true;
        }

        return false;
    }

    /**
     * Возвращаем первый элемент из выполненного SQL запроса
     *
     * @return void
     */
    public function first()
    {
        return $this->results()[0];
    }

    /**
    * Подготовка SQL запроса для выполнения и вывода всех данных результата SQL запроса
    *
    * @param string $table
    * @return void
    */
    public function getAll($table) {
        $sql = "SELECT * FROM {$table}";
        if(!$this->query($sql)) {
            return $this;
        }
    }
}
