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

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__."/../MagicEA.php";

$instance = new MagicEa();
$response = array("status" => "missing arguments");

if (isset($_GET["token"])) {
    $token = $_GET["token"];
    if (isset($_GET["action"])) {
        switch ($_GET["action"]) {
            case "create":
                if (isset($_GET["relatedto"]) && isset($_GET["author"]) && isset($_GET["timestamp"]) && isset($_GET["message"])) {
                    $message = $instance->getUtil()->createMessage($_GET);
                    $response = array("status" => ($instance->getObjectDb()->insertMessage($token, $message) ? "success" : "error"));
                }
                break;
            case "update":
                if (isset($_GET["id"])) {
                    $update = array();
                    if (isset($_GET["reason"])) $update["message"] = $_GET["message"];
                    $response = array("status" => ($instance->getObjectDb()->updateMessage($token, $_GET["id"], $update) ? "success" : "error"));
                }
                break;
            case "delete":
                if (isset($_GET["id"])) {
                    $response = array("status" => ($instance->getObjectDb()->deleteMessage($token, $_GET["id"]) ? "success" : "error"));
                } else $response = array("status" => "error");
                break;
            default:
                $response = array("status" => "invalid action");
        }
    } elseif (isset($_GET["id"])) {
        $message = $instance->getObjectDb()->getMessage($token, $_GET["id"]);
        if ($message->getId() != -1) $response = array("relatedto" => $message->getRelatedTo(), "author" => $message->getAuthor(), "timestamp" => $message->getTimestamp(), "message" => $message->getMessage());
        else $response = array("status" => "error");
    } else {
        $response = $instance->getMessages($token, (isset($_GET["where"]) ? $_GET["where"] : ""));
    }
}

echo json_encode($response);