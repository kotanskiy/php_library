<?php 
require_once 'models/Genre.php';
if ($type == 'update' && isset($id)) 
    $genre = Genre::get_by_id($id);
if (isset($_POST['send'])) {
    if ($type == 'save')
        $genre = new Genre($_POST['name']);
    elseif ($type == 'update')
        $genre->name = $_POST['name'];
    if ($genre->is_empty()) {
        echo 'Заполните поля отмеченые звездочками';
    } else {
        switch ($type) {
            case 'save':
            $genre->save(); 
            echo 'Новый жанр создан';
            break;
            case 'update':
            $genre->update(); 
            echo 'Жанр обновлен';
            break;
        }
    }
}
$button = ($type == 'save') ? 'Добавить' : 'Обновить';
?>
<a href="/">На главную</a><br>
<h3><?=$button.' жанр'?></h3>
<form action="" method="post">
    <input type="text" name="name" placeholder="Название жанра" value="<?=$genre->name?>">*<br>
    <input type="submit" name="send" value="<?=$button?>"><br>
</form>