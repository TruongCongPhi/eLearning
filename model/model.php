<?php
class Model
{
    protected $host, $db, $user, $pass, $conn;
    public function __construct()
    {
        $this->host = 'localhost';
        $this->db = 'project_k71';
        $this->user = 'root';
        $this->pass = '';
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->conn->connect_error) {
            die($this->conn->connect_error);
        }
        $this->conn->set_charset("utf8");
    }
    //get
    //lấy 1 bản ghi
    public function get($table, $condition)
    {
        if (empty($condition)) {
            $query = "SELECT * FROM $table";
        } else {
            $query = "SELECT * FROM $table WHERE $condition";
        }
        //var_dump($query);
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    //lấy nhiều bản ghi, mặc định là 50
    public function getArray($tableName, $condition, $limit = 50)
    {
        if (empty($condition)) {
            $query = "SELECT * FROM $tableName LIMIT $limit";
        } else {
            $query = "SELECT * FROM $tableName WHERE $condition LIMIT $limit";
        }
        //var_dump($query);
        $result = $this->conn->query($query);
        if ($result && $result->num_rows > 0) {
            return $result;
        } else {
            return null;
        }
    }
    public function getArrayOrder($tableName, $condition, $limit)
    {

        $query = "SELECT * FROM $tableName ORDER BY $condition LIMIT $limit";
        //var_dump($query);
        $result = $this->conn->query($query);
        if ($result && $result->num_rows > 0) {
            return $result;
        } else {
            return null;
        }
    }

    //post
    public function insert($tableName, $columnValueArray = [])
    {
        $columns = array_keys($columnValueArray);
        $values = array_values($columnValueArray);
        $columnString = implode(", ", $columns);
        $valueString = implode("', '", $values);
        $query = "INSERT INTO $tableName($columnString) VALUES ('$valueString')";
        //var_dump($query);
        $result = $this->conn->query($query);
        if ($result)
            return true;
        else
            return false;
    }

    //update
    public function update($tableName, $columnValueArray = [], $condition)
    {
        $statement = '';
        foreach ($columnValueArray as $key => $value) {
            $statement .= "$key='$value', ";
        }
        $statement = substr($statement, 0, -2);
        $query = "UPDATE $tableName SET $statement WHERE $condition";
        //var_dump($query);
        $result = $this->conn->query($query);
        if ($result)
            return true;
        else
            return false;
    }

    //delete
    public function delete($tableName, $condition)
    {
        $query = "DELETE FROM $tableName WHERE $condition";

        $result = $this->conn->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    //count : đếm số lượng bản ghi trong bảng
    public function count($tableName, $condition)
    {
        if (!empty($condition)) {
            $query = "SELECT * FROM $tableName WHERE $condition";
        } else {
            $query = "SELECT * FROM $tableName";
        }
        $result = $this->conn->query($query);
        return $result->num_rows;
    }
}
