<?php
require_once 'includes/db_connect.php';
if (isset($_GET['type'])) {
    switch ($_GET['type']) {
        case 'author':
        $form = 'author_form.php'; break;
        case 'book':
        $form = 'book_form.php'; break;
        case 'genre':
        $form = 'genre_form.php'; break;
    }
    $type = 'save';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Создать</title>
</head>
<body>
    <?php
        require_once "includes/$form";
    ?>
</body>
</html>