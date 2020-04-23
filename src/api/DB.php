<?php
/*
    magicEA - Easily manage unbanning requests
    Copyright (C) 2020  magicbrothers

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

class DB
{
    private $instance;
    private $connection;

    public function __construct()
    {
        $this->instance = MagicEA::getInstance();
        $cfg = $this->instance->getCfg();
        try {
            $this->connection = new PDO("mysql:host=".$cfg["dbhost"].";dbname=".$cfg["db"], $cfg["dbuser"], $cfg["dbpasswd"]);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    public function select(array $cols, string $table, string $where): PDOStatement
    {
        $sql = "SELECT ".$this->toList($cols, true)." FROM $table".($where == "" ? "" : " WHERE ".$where);

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt;
    }

    public function create(string $table, string $cols): bool
    {
        $sql = "CREATE TABLE IF NOT EXISTS $table ( $cols )";
        return $this->connection->exec($sql);
    }

    public function insert(string $table, array $insert): bool
    {
        $sql = "INSERT INTO $table ( ".$this->toList(array_keys($insert), true)." ) VALUES ( ".$this->toList(array_values($insert))." )";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute();
    }

    public function update(string $table, array $update, string $where): bool
    {
        $sql = "UPDATE $table SET ";
        foreach ($update as $key => $value) {
            $sql .= "$key='$value', ";
        }
        $sql = substr($sql, 0, strlen($sql) - 2).($where == "" ? "" : " WHERE ".$where);
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute();
    }

    public function delete(string $table, string $where): bool
    {
        $sql = "DELETE FROM $table".($where == "" ? "" : " WHERE ".$where);
        return $this->connection->exec($sql);
    }

    public function getLastId(): int
    {
        return $this->connection->lastInsertId();
    }

    private function toList(array $array, bool $removeQuotation = false): string
    {
        $list = str_replace("[", "", str_replace("]", "", json_encode($array)));
        return $removeQuotation ? str_replace("\"", "", $list) : $list;
    }
}