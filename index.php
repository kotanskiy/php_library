<?php 
require_once 'includes/db_connect.php';
require_once 'models/Book.php';
require_once 'models/Genre.php';
require_once 'models/Author.php';
$books = Book::get_all_order_by_date();
$genres = Genre::get_all();
$authors = Author::get_all();
$get_books_with_sereval_authors = Book::get_books_with_sereval_authors();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Библиотека</title>
</head>
<body>
<ul>
    <li><a href="/create.php?type=genre">Добавить жанр</a></li>
    <li><a href="/create.php?type=author">Добавить автора</a></li>
    <li><a href="/create.php?type=book">Добавить книгу</a></li>
</ul><br>
<?php 
    if (isset($_COOKIE['error'])) {
        echo '<span style="color:red;">'.$_COOKIE['error'].'</span>';
    }
?>
<h3>Список книг (Отсортированые по дате от новых к старым)</h3> 
<table style="border: solid black 1px;">
    <th>Книга</th>
    <th>ФИ автора</th>
    <th>Жанр</th>
    <th>Редактировать</th>
    <th>Удалить</th>
    <?php foreach ($books as $book): ?>
        <tr style="background-color: silver;">
            <td><?=$book->name?></td>
            <td style="border: solid black 1px;">
                <?php foreach ($book->authors as $author): ?>
                    <?=$author->surname.' '.$author->name?><br>
                <?php endforeach; ?>
            </td>
            <td><?=$book->genre->name?></td>
            <td><a href="/edit.php?type=book&id=<?=$book->id?>">Редактировать</a></td>
            <td><a href="/remove.php?type=book&id=<?=$book->id?>">Удалить</a></td>
        </tr>
    <?php endforeach; ?>
</table>
<br>
<h3>Список авторов</h3>
<table style="border: solid black 1px;">
    <th>ФИ автора</th>
    <th>Редактировать</th>
    <th>Удалить</th>
    <?php foreach ($authors as $author): ?>
        <tr style="border: solid black 1px;">
            <td><?=$author->surname.' '.$author->name?></td>
            <td><a href="/edit.php?type=author&id=<?=$author->id?>">Редактировать</a></td>
            <td><a href="/remove.php?type=author&id=<?=$author->id?>">Удалить</a></td>
        </tr>
    <?php endforeach; ?>
</table>
<br>
<h3>Список жанров</h3>
<table style="border: solid black 1px;">
    <th>Жанр</th>
    <th>Редактировать</th>
    <th>Удалить</th>
    <?php foreach ($genres as $genre): ?>
        <tr style="border: solid black 1px;">
            <td><?=$genre->name?></td>
            <td><a href="/edit.php?type=genre&id=<?=$genre->id?>">Редактировать</a></td>
            <td><a href="/remove.php?type=genre&id=<?=$genre->id?>">Удалить</a></td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Книги с несколькими авторами</h3>
<table style="border: solid black 1px;">
    <th>Книга</th>
    <th>Автор</th>
    <?php foreach ($get_books_with_sereval_authors as $book): ?>
        <tr style="background-color: silver;">
            <td><?=$book->name?></td>
            <td style="border: solid black 1px;">
                <?php foreach ($book->authors as $author): ?>
                    <?=$author->surname.' '.$author->name?><br>
                <?php endforeach;?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Диапазоны книг(Диапазон, кол-во книг)</h3>
<b>50-150 стр.:</b> <?=Book::get_range_pages($start=50, $end=150)?> книг<br>
<b>150-300 стр.:</b> <?=Book::get_range_pages($start=150, $end=300)?> книг<br>
<b>300-450 стр.:</b> <?=Book::get_range_pages($start=300, $end=450)?> книг<br>
<b>450-600 стр.:</b> <?=Book::get_range_pages($start=450, $end=600)?> книг<br>
<b>600-... стр.:</b> <?=Book::get_range_pages($start=600)?> книг<br>

<h3>Автора книг с книжками больше 130 страниц (ФИ автора, название книжки, кол-во страниц)</h3>
<table style="border: solid black 1px;">
    <th>ФИ автора</th>
    <th>название книжки</th>
    <th>кол-во страниц</th>
    <?php foreach (Book::larger_130_pages() as $book): ?>
        <tr style="background-color: silver;">
            <td style="border: solid black 1px;">
                <?php foreach ($book->authors as $author): ?>
                    <?=$author->surname.' '.$author->name?><br>
                <?php endforeach;?>
            </td>
            <td><?=$book->name?></td>
            <td><?=$book->number_pages?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Автора с книгами выпущенные за последний год</h3>
<table style="border: solid black 1px;">
    <th>ФИ автора</th>
    <th>кол-во книг</th>
    <?php foreach (Author::get_authors_with_books_last_year() as $author): ?>
        <tr style="background-color: silver;">
            <td><?=$author['surname'].' '.$author['name']?></td>
            <td><?=$author['count']?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Список жанров с кол-вом книг</h3>
<table style="border: solid black 1px;">
    <th>Жанр</th>
    <th>кол-во книг</th>
    <?php foreach (Genre::get_count_genres() as $genre): ?>
        <tr style="background-color: silver;">
            <td><?=$genre['name']?></td>
            <td><?=$genre['count']?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>