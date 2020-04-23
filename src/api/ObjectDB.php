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

require_once __DIR__."/ban/Ban.php";
require_once __DIR__."/message/Message.php";

class ObjectDB
{

    private $instance;

    public function __construct()
    {
        $this->instance = MagicEA::getInstance();
    }

    public function getBan(string $token, int $id): Ban
    {
        if (!$this->instance->hasPermission($token, MagicEA::SELECT, MagicEA::BAN, $id)) return new Ban();
        $result = $this->instance->getDb()->select(array("type", "uuid", "executor", "reason", "timestamp", "until", "status"), "bans", "id=$id");
        if ($result->rowCount() == 0) return new Ban();
        $row = $result->fetch();
        $ban = $this->instance->getUtil()->createBan($row);
        $ban->setId($id);
        return $ban;
    }

    public function insertBan(string $token, Ban $ban): int
    {
        if (!$this->instance->hasPermission($token, MagicEA::INSERT, MagicEA::BAN, -1)) return -1;
        $this->instance->getDb()->insert("bans", array("type" => $ban->getType(), "uuid" => $ban->getUuid(), "executor" => $ban->getExecutor(), "reason" => $ban->getReason(), "timestamp" => $ban->getTimestamp(), "until" => $ban->getUntil(), "status" => $ban->getStatus()));
        return $this->instance->getDb()->getLastId();
    }

    public function updateBan(string $token, int $id, array $update): bool
    {
        if (!$this->instance->hasPermission($token, MagicEA::UPDATE, MagicEA::BAN, $id)) return false;
        return $this->instance->getDb()->update("bans", $update, "id=$id");
    }

    public function deleteBan(string $token, int $id): bool
    {
        if (!$this->instance->hasPermission($token, MagicEA::DELETE, MagicEA::BAN, $id)) return false;
        return $this->instance->getDb()->delete("bans", "id=$id");
    }

    public function getMessage(string $token, int $id): Message
    {
        if (!$this->instance->hasPermission($token, MagicEA::SELECT, MagicEA::MSG, $id)) return new Message();
        $result = $this->instance->getDb()->select(array("relatedto", "author", "timestamp", "message"), "messages", "id=$id");
        if ($result->rowCount() == 0) return new Message();
        $row = $result->fetch();
        $message = $this->instance->getUtil()->createMessage($row);
        $message->setId($id);
        return $message;
    }

    public function insertMessage(string $token, Message $message): int
    {
        if (!$this->instance->hasPermission($token, MagicEA::INSERT, MagicEA::MSG, -1)) return -1;
        $this->instance->getDb()->insert("messages", array("relatedto" => $message->getRelatedTo(), "author" => $message->getAuthor(), "timestamp" => $message->getTimestamp(), "message" => $message->getMessage()));
        return $this->instance->getDb()->getLastId();
    }

    public function updateMessage(string $token, int $id, array $update): bool
    {
        if (!$this->instance->hasPermission($token, MagicEA::UPDATE, MagicEA::MSG, $id)) return false;
        return $this->instance->getDb()->update("messages", $update, "id=$id");
    }

    public function deleteMessage(string $token, int $id): bool
    {
        if (!$this->instance->hasPermission($token, MagicEA::DELETE, MagicEA::MSG, $id)) return false;
        return $this->instance->getDb()->delete("messages", "id=$id");
    }

}