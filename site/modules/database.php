<?php

class Database {
    private $pdo;

    public function __construct($path) {
        $this->pdo = new PDO("sqlite:" . $path);
    }

    public function Execute($sql) {
        return $this->pdo->exec($sql);
    }

    public function Fetch($sql) {
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Create($table, $data) {
        $columns = implode(",", array_keys($data));
        $values = implode(",", array_map(fn($v) => "'$v'", array_values($data)));

        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $this->Execute($sql);

        return $this->pdo->lastInsertId();
    }

    public function Read($table, $id) {
        return $this->Fetch("SELECT * FROM $table WHERE id = $id")[0] ?? null;
    }

    public function Update($table, $id, $data) {
        $set = implode(",", array_map(fn($k, $v) => "$k='$v'", array_keys($data), $data));
        return $this->Execute("UPDATE $table SET $set WHERE id = $id");
    }

    public function Delete($table, $id) {
        return $this->Execute("DELETE FROM $table WHERE id = $id");
    }

    public function Count($table) {
        return $this->Fetch("SELECT COUNT(*) as count FROM $table")[0]['count'];
    }
}