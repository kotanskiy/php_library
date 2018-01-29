<?php

require_once 'config/config.php';

$mysqli = new mysqli($db['server'], $db['user'], $db['password'], $db['name']);

if ($mysqli->connect_errno) {
    printf("<h1 style=\"color: red; text-align: center;\">Ошибка подключения к БД %s</h1> \n", $mysqli->connect_error);
    exit();
}