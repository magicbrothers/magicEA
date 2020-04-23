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

class Util
{
    public function createBan(array $properties): Ban
    {
        $ban = new Ban();
        $ban->setType($properties["type"]);
        $ban->setUuid($properties["uuid"]);
        $ban->setExecutor($properties["executor"]);
        $ban->setReason($properties["reason"]);
        $ban->setTimestamp($properties["timestamp"]);
        $ban->setUntil($properties["until"]);
        $ban->setStatus($properties["status"]);
        return $ban;
    }
    
    public function createMessage(array $properties): Message
    {
        $message = new Message();
        $message->setRelatedTo($properties["relatedto"]);
        $message->setAuthor($properties["author"]);
        $message->setTimestamp($properties["timestamp"]);
        $message->setMessage($properties["message"]);
        return $message;
    }
}