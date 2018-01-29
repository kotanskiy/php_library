<?php
require_once 'includes/db_connect.php';

switch ($_GET['type']) {
    case 'book':
    $file = 'book_form.php';
    break;
    case 'author':
    $file = 'author_form.php';
    break;
    case 'genre':
    $file = 'genre_form.php';
    break;
}
$type = 'update';
$id = $_GET['id'];

require_once 'includes/'.$file;