<?php

/**
 * Class DB
 * @author Radomir Brkovic <radomir.brkovic@enetelsolutions.com>
 * This is basic class for communication with mysql database
 */
class DB
{

    protected $table;
    // PDO Connection
    protected $con = null;

    // Conditional
    protected $conditional = "";

    protected $fields = "";

    protected $orderBy;

    protected $limit;

    protected $attributes = [];

    protected $primaryKey = 'id';

    protected $relations = [];

    function __construct()
    {
        global $app;

        if(!$app->db){
            $dsn = "mysql:dbname={$app->env('DB_NAME')};host={$app->env('DB_HOST')}";

            try {
                $this->con = new PDO($dsn, $app->env('DB_USER'), $app->env('DB_PASSWORD'));
                
                $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $app->db = $this->con;
            } catch (PDOException $e) {
                $app->log('error', 'Connection failed: ' . $e->getMessage());
            }
            
        } else {
            $this->con = $app->db;
        }


    }


    /**
     * @param $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }


    /**
     * @param $table
     * @return $this
     */
    public function table($table)
    {
        $this->table = $table;
        return $this;
    }


    /**
     * @param array|string $fields
     * @return $this
     */
    public function select($fields)
    {
        if (is_array($fields))
            $fields = implode(',', $fields);

        if ($this->fields)
            $this->fields .= ", " . $fields;
        else
            $this->fields = $fields;

        return $this;
    }


    /**
     * @param string $field
     * @param mixed $value
     * @param null $sign
     * @return $this
     */
    public function where($field, $value, $sign = null)
    {
        if (!$sign)
            $sign = "=";
        if (is_string($value))
            $value = '\'' . $value . '\'';

        if ($this->conditional) {
            $this->conditional .= " AND {$field} {$sign} {$value}";
        } else
            $this->conditional = "{$field} {$sign} {$value}";

        return $this;
    }

    /**
     * @param string $field
     * @param mixed $value
     * @param null $sign
     * @return $this
     */
    public function orWhere($field, $value, $sign = null)
    {
        if (!$sign)
            $sign = "=";

        if (is_string($value))
            $value = '\'' . $value . '\'';

        if ($this->conditional) {
            $this->conditional .= " OR {$field} {$sign} {$value}";
        } else
            $this->conditional = "{$field} {$sign} {$value}";

        return $this;
    }

    /**
     * @param string $field
     * @param array $value
     * @return $this
     */
    public function whereIn($field, array $value)
    {
        if (count($value)) {
            if ($this->conditional) {
                $this->conditional .= " AND {$field} IN ('" . implode("', '", $value) . "')";
            } else
                $this->conditional = " {$field} IN ('" . implode("', '", $value) . "')";
        }
        return $this;
    }

    /**
     * @param string $field
     * @param array $value
     * @return $this
     */
    public function orWhereIn($field, array $value)
    {
        if (count($value)) {
            if ($this->conditional) {
                $this->conditional .= " OR {$field} IN ('" . implode("', '", $value) . "')";
            } else
                $this->conditional = " {$field} IN ('" . implode("', '", $value) . "')";
        }
        return $this;
    }

    /**
     * @param $field
     * @param array $value
     * @return $this
     */
    public function whereNotIn($field, array $value)
    {
        if (count($value)) {
            if ($this->conditional) {
                $this->conditional .= " AND {$field} NOT IN ('" . implode("', '", $value) . "')";
            } else
                $this->conditional = " {$field} NOT IN ('" . implode("', '", $value) . "')";

        }


        return $this;
    }

    /**
     * @param $field
     * @param array $value
     * @return $this
     */
    public function orWhereNotIn($field, array $value)
    {
        if (count($value)) {
            if ($this->conditional) {
                $this->conditional .= " OR {$field} NOT IN ('" . implode("', '", $value) . "')";
            } else
                $this->conditional = " {$field} NOT IN ('" . implode("', '", $value) . "')";
        }
        return $this;
    }


    /**
     * @param $column
     * @param string $type
     * @return $this
     */
    public function orderBy($column, $type = "ASC")
    {
        $this->orderBy = " ORDER BY {$column} {$type}";
        return $this;

    }

    /**
     * @return mixed
     */
    public function get()
    {
        global $app;
        $cond = "";

        $output = [];

        if ($this->fields == "") {
            $this->fields = "*";
        }

        if ($this->conditional)
            $cond = "WHERE {$this->conditional}";

        if ($this->orderBy)
            $cond .= $this->orderBy;

        if ($this->limit)
            $cond .= $this->limit;

        $query = "SELECT {$this->fields} FROM {$this->table} " . $cond;

        try {
            $items = $this->con->query($query);

            $this->conditional = "";

            if ($items) {
                $collection = new Collection();
                $output = $items->fetchAll(\PDO::FETCH_CLASS);

                if(count($this->relations)){
                  $this->getRelations($output);
                }

                 foreach ($output as $result) {
                    $this->attributes = (array)$result;
                    $collection->addItem(clone $this);

                }

                return $collection;

            } else
                return null;
        } catch (\PDOException $e) {
            $app->log('error', $e->getMessage() . " \n" . $query);
            exit;
        }


    }

    /**
     * @return mixed
     */
    public function all()
    {
        global $app;

        $output = [];

        if ($this->fields == "") {
            $this->fields = "*";
        }
        
        $query = "SELECT {$this->fields} FROM {$this->table} ";
        try {
            $items = $this->con->query($query);

            $this->conditional = "";

            if ($items) {
                $collection = new Collection();
                $output = $items->fetchAll(\PDO::FETCH_CLASS);

                foreach ($output as $result) {
                    $this->attributes = (array)$result;

                    $collection->addItem(clone $this);

                }

                return $collection;

            } else
                return null;
        } catch (\PDOException $e) {
            $app->log('error', $e->getMessage());
            exit;
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        global $app;

        if ($this->fields == "") {
            $this->fields = "*";
        }

        $query = "SELECT {$this->fields} FROM {$this->table} WHERE {$this->primaryKey} = {$id}";

        $this->conditional = "";

        try {
            return $this->con->query($query);
        } catch (\PDOException $e) {
            $app->log('error', $e->getMessage());
            exit;
        }
    }


    /**
     * @param array $fields
     * @return integer $lastInsertId
     */
    public function insert(array $fields)
    {
        global $app;
        $value = [];
        $field = [];
        $i = 0;
        foreach ($fields as $key => $row) {

            $value[$i] = ":" . $key;
            $field[$i] = $key;

            $i++;
        }

        try {
            $query = $this->con->prepare("INSERT INTO {$this->table} (" . implode(',', $field) . ") VALUES (" . implode(',', $value) . ")");
            $query->execute($fields);
            return $this->con->lastInsertId();
        } catch (\PDOException $e) {
            $app->log('error', $e->getMessage());
            exit;
        }
    }

    /**
     * @param array $values
     * @return  int
     */
    public function update(array $values)
    {
        global $app;
        $field = [];

        foreach ($values as $key => $row) {
            $field[] = $key . " = :" . $key;

        }
        $cond = "";

        if ($this->conditional)
            $cond = "WHERE {$this->conditional}";
        elseif (isset($this->attributes[$this->primaryKey]))
            $cond = "WHERE {$this->primaryKey} = {$this->attributes[$this->primaryKey]}";

        try {
            $query = $this->con->prepare("UPDATE {$this->table}   SET " . implode(',', $field) . " {$cond}");
            $query->execute($values);

            $this->conditional = "";
        } catch (\PDOException $e) {
            $app->log('error', $e->getMessage());
            exit;
        }
        return $query->rowCount();
    }


    /**
     * delete row
     */
    public function delete()
    {
        global $app;
        $cond = "";

        if ($this->conditional)
            $cond = "WHERE {$this->conditional}";
        elseif (isset($this->attributes[$this->primaryKey]))
            $cond = "WHERE {$this->primaryKey} = {$this->attributes[$this->primaryKey]}";

        try {
            $query = $this->con->prepare("DELETE FROM  {$this->table}  {$cond}");

            $query->execute();

            $this->conditional = "";
        } catch (\PDOException $e) {
            $app->log('error', $e->getMessage());
            exit;
        }
    }


    /**
     * @param $key
     * @return null
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        } else
            return null;
    }


    /**
     *
     * @param string $query
     * @param  $result
     * @return mixed
     */
    public static function query($query, $result = true)
    {
        global $app;
        $className = __CLASS__;
        $db = new $className();
        try {
            $items = $db->con->query($query);

            if($result)
                return $items->fetchAll(\PDO::FETCH_CLASS);
        } catch (\PDOException $e) {
            $app->log('error', $e->getMessage());
            $app->log('error', "SQL QUERY: ".$query);
            exit;
        }

    }

    /**
     *Truncate table
     */
    public function truncate(){
        global $app;

        try {
            $query = $this->con->prepare("TRUNCATE TABLE {$this->table}");

            $query->execute();

            $this->conditional = "";
        } catch (\PDOException $e) {
            $app->log('error', $e->getMessage());
            exit;
        }
    }


    /**
     * @param array $data
     */
    public function getRelations($data){
        foreach ($this->relations as $relation){
            if(method_exists($this, $relation)){
              $this->$relation();
            }
        }
    }

}