<?php
class DB {
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PASS
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function select($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($table, $data) {
        $fields = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        $this->query($sql, $data);
        return $this->conn->lastInsertId();
    }

    public function update($table, $data, $where) {
        $set = [];
        foreach ($data as $field => $value) {
            $set[] = "$field = :$field";
        }
        $set = implode(', ', $set);
        $whereClause = [];
        foreach ($where as $field => $value) {
            $whereClause[] = "$field = :where_$field";
            $data["where_$field"] = $value;
        }
        $whereClause = implode(' AND ', $whereClause);
        $sql = "UPDATE $table SET $set WHERE $whereClause";
        return $this->query($sql, $data);
    }

    public function delete($table, $where) {
        $whereClause = [];
        foreach ($where as $field => $value) {
            $whereClause[] = "$field = :$field";
        }
        $whereClause = implode(' AND ', $whereClause);
        $sql = "DELETE FROM $table WHERE $whereClause";
        return $this->query($sql, $where);
    }

    public function beginTransaction() {
        return $this->conn->beginTransaction();
    }

    public function commit() {
        return $this->conn->commit();
    }

    public function rollBack() {
        return $this->conn->rollBack();
    }
}
?>