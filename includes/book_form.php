<?php 
require_once 'models/Book.php';
require_once 'models/Author.php';
require_once 'models/Genre.php';
$authors = Author::get_all(); 
$genres = Genre::get_all();
if ($type == 'update')
    $book = Book::get_by_id($id);
if (isset($_POST['send'])) {
    if (!empty($_POST['authors'])) {
        foreach ($authors as $author) {
            foreach($_POST['authors'] as $id) {
                if ($author->id == $id) 
                    $result_authors[] = $author;
            }
        }
    }
    foreach ($genres as $genre) {
        if ($genre->id == $_POST['genre'])
            $result_genre = $genre;
    }
    if ($type == 'save')
        $book = new Book($_POST['name'], $_POST['number_pages'], $result_authors, $result_genre, $_POST['date']);
    elseif ($type == 'update') {
        $book->name = $_POST['name'];
        $book->number_pages = $_POST['number_pages'];
        $book->authors = $result_authors;
        $book->genre = $result_genre;
        $book->date = $_POST['date'];
    }
    if ($book->is_empty()) {
        echo 'Заполните поля отмеченые звездочками';
    } else {
        switch ($type) {
            case 'save':
            $book->save(); 
            echo 'Новая книга создана';
            break;
            case 'update':
            $book->update(); 
            echo 'Книга обновлена';
            break;
        }
    }
}
$button = ($type == 'save') ? 'Добавить' : 'Обновить';
?>
<h3><?=$button.' книгу'?></h3>
<form action="" method="post">
    <input type="text" name="name" placeholder="Название книги" value="<?=$book->name?>">*<br>
    <input type="number" name="number_pages" placeholder="кол-во страниц" value="<?=$book->number_pages?>"><br>
    <?php if (!empty($authors)): ?>
        Авторы, которые написали эту книгу:*<br>
        <?php foreach ($authors as $author): ?>
            <input type="checkbox" name="authors[]" value="<?=$author->id?>" 
            <?php
            if (isset($book))
                foreach ($book->authors as $a)
                    if ($a->id == $author->id)
                        echo 'checked';            
            ?>
            ><?=$author->surname.' '.$author->name?><br>
        <?php endforeach; ?>
    <?php else: ?>
        <span style="color: red;">Перед добавлением книги вам нужно добавить автора.</span><br>
    <?php endif; ?>
    <?php if (!empty($genres)): ?>
        Жанр:*<br>
        <?php foreach ($genres as $genre): ?>
            <input type="radio" name="genre" value="<?=$genre->id?>" <?php if ($genre->id == $book->genre->id) echo 'checked'; ?>><?=$genre->name?><br>
        <?php endforeach; ?>
    <?php else: ?>
        <span style="color: red;">Перед добавлением книги вам нужно добавить жанр.</span><br>
    <?php endif; ?>
    Дата:*<br>
    <input type="date" name="date" value="<?=$book->date?>"><br>
    <input type="submit" name="send" value="<?=$button?>"><br>

</form>