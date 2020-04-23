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

require_once __DIR__."/Config.php";
require_once __DIR__."/DB.php";
require_once __DIR__."/Util.php";
require_once __DIR__."/ObjectDB.php";

class MagicEA
{

    const SELECT = 0, INSERT = 1, UPDATE = 2, DELETE = 3;
    const BAN = 0, MSG = 1;

    private static $instance;

    private $cfg;
    private $adminToken;
    private $db;
    private $util;
    private $objectDb;

    public function __construct()
    {
        self::$instance = $this;
        $this->cfg = Config::get();
        $data = "admin;;-1";
        $this->adminToken = $data.":".$this->createSecret($data);
        $this->db = new DB();
        $this->util = new Util();
        $this->objectDb = new ObjectDB();
    }

    public static function getInstance(): MagicEA
    {
        return self::$instance;
    }

    public function getCfg(): array
    {
        return $this->cfg;
    }

    public function getAdminToken(): string
    {
        return $this->adminToken;
    }

    public function getDb(): DB
    {
        return $this->db;
    }

    public function getUtil(): Util
    {
        return $this->util;
    }

    public function getObjectDb(): ObjectDB
    {
        return $this->objectDb;
    }

    public function getBans(string $token, string $where = ""): array
    {
        $bans = $this->db->select(array("id"), "bans", $where);
        $output = array();
        foreach ($bans->fetchAll() as $ban) {
            if ($this->hasPermission($token, self::SELECT, self::BAN, $ban["id"])) $output[] = (int) $ban["id"];
        }
        return $output;
    }

    public function getMessages(string $token, string $where = ""): array
    {
        $messages = $this->db->select(array("id"), "messages", $where);
        $output = array();
        foreach ($messages->fetchAll() as $message) {
            if ($this->hasPermission($token, self::SELECT, self::MSG, $message["id"])) $output[] = (int) $message["id"];
        }
        return $output;
    }

    public function hasPermission(string $token, int $action, int $type, int $id): bool
    {
        $exploded = explode(":", $token);
        $data = $exploded[0];
        $secret = $exploded[1];
        $hash = $this->createSecret($data);
        if ($hash == $secret) {
            $properties = explode(";", $data);
            if ($properties[2] < time() && $properties[2] != -1) return false;
            switch ($properties[0]) {
                case "player":
                    if ($type == self::BAN) {
                        if ($action == self::SELECT) return $this->getObjectDb()->getBan($this->getAdminToken(), $id)->getUuid() == $properties[1];
                    } elseif ($type == self::MSG) {
                        if ($action <= self::INSERT) return $this->getObjectDb()->getBan($this->getAdminToken(), $this->getObjectDb()->getMessage($this->getAdminToken(), $id)->getRelatedTo())->getUuid() == $properties[1];
                    }
                    break;
                case "moderator":
                    if ($type == self::BAN) {
                        if ($action == self::SELECT) return true;
                    } elseif ($type == self::MSG) {
                        if ($action <= self::INSERT) return true;
                        return $this->getObjectDb()->getMessage($this->getAdminToken(), $id)->getAuthor() == $properties[1];
                    }
                    break;
                case "admin":
                    return true;
            }
        }
        return false;
    }

    public function createSecret($data): string
    {
        return hash_pbkdf2("sha512", $data, $this->cfg["secret"], 4096, 16);
    }

}