<?php 
require_once 'models/Author.php';
if ($type == 'update') 
    $author = Author::get_by_id($id);
if (isset($_POST['send'])) {
    if ($type == 'save')
        $author = new Author($_POST['surname'], $_POST['name'], $_POST['date_birth']);
    elseif ($type == 'update') {
        $author->surname = $_POST['surname'];
        $author->name = $_POST['name'];
        $author->date_birth = $_POST['date_birth'];
    }
    if ($author->is_empty()) {
        echo 'Заполните поля отмеченые звездочками';
    } else {
        switch ($type) {
            case 'save':
            $author->save(); 
            echo 'Новый автор создан';
            break;
            case 'update':
            $author->update(); 
            echo 'Автор обновлен';
            break;
        }
    }
}
$button = ($type == 'save') ? 'Добавить' : 'Обновить';
?>
<a href="/">На главную</a><br>
<h3><?=$button.' автора'?></h3>
<form action="" method="post">
    <input type="text" name="surname" placeholder="Фамилия" value="<?=$author->surname?>">*<br>
    <input type="text" name="name" placeholder="Имя" value="<?=$author->name?>">*<br>
    <input type="date" name="date_birth" placeholder="Дата рождения" value="<?=$author->date_birth?>">*<br>
    <input type="submit" name="send" value="<?=$button?>"><br>
</form>