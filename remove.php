<?php
require_once 'includes/db_connect.php';
require_once 'models/Book.php';
require_once 'models/Author.php';
require_once 'models/Genre.php';

switch ($_GET['type']) {
    case 'book':
    Book::get_by_id($_GET['id'])->remove();
    break;
    case 'author':
    Author::get_by_id($_GET['id'])->remove();
    break;
    case 'genre':
    Genre::get_by_id($_GET['id'])->remove();
    break;
}
setcookie('error', $mysqli->error, time() + 2);
header('Location: /');
