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

class Ban
{

    const BAN = 0;
    const MUTE = 1;

    private $id = -1;
    private $type = -1;
    private $uuid = "";
    private $executor = "";
    private $reason = "";
    private $timestamp = -1;
    private $until = -1;
    private $status = -1;

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getExecutor(): string
    {
        return $this->executor;
    }

    public function getReason(): string
    {
        return $this->reason;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getUntil(): int
    {
        return $this->until;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setType(int $type)
    {
        $this->type = $type;
    }

    public function setUuid(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function setExecutor(string $executor)
    {
        $this->executor = $executor;
    }

    public function setReason(string $reason)
    {
        $this->reason = $reason;
    }

    public function setTimestamp(int $timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function setUntil(int $until)
    {
        $this->until = $until;
    }

    public function setStatus(int $status)
    {
        $this->status = $status;
    }

}