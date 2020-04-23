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

class Message
{

    const BAN = 0;
    const MUTE = 1;

    private $id = -1;
    private $relatedTo = -1;
    private $author = "";
    private $timestamp = -1;
    private $message = "";

    public function getId(): int
    {
        return $this->id;
    }

    public function getRelatedTo(): int
    {
        return $this->relatedTo;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setRelatedTo(int $relatedTo)
    {
        $this->relatedTo = $relatedTo;
    }

    public function setAuthor(string $author)
    {
        $this->author = $author;
    }

    public function setTimestamp(int $timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
    }

}