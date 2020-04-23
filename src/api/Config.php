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

class Config
{
    private static $file = __DIR__."/../cfg.php";

    public static function get(): array
    {
        if (file_exists(Config::$file)) {
            $config = include Config::$file;
        } else {
            $config = array("done_setup" => false);
            Config::save($config);
        }
        return $config;
    }

    public static function save(array $config)
    {
        $config = var_export($config, true);
        file_put_contents(Config::$file, "<?php return $config;");
    }
}