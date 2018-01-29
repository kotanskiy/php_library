<?php
require_once 'Author.php';
require_once 'Genre.php';
class Book {

    public $id;
    public $name;
    public $number_pages;
    public $authors;
    public $genre;
    public $date;

    function __construct($name, $number_pages, $authors, $genre, $date){
        $this->name = $name;
        $this->number_pages = $number_pages;
        $this->authors = $authors;
        $this->genre = $genre;
        $this->date = $date;
    }

    public function save() {
        global $mysqli;
        $query = "INSERT INTO `Book` (`name`, `number_pages`, `genre_id`, `date`) 
        VALUES ('$this->name', $this->number_pages, {$this->genre->id}, '$this->date')";
        $mysqli->query($query);
        $this->id = $mysqli->insert_id;
        foreach ($this->authors as $author) {
            $mysqli->query("INSERT INTO `Authors_Books` (`author_id`, `book_id`) VALUES ($author->id, $this->id)");
        }
    }

    public function remove() {
        global $mysqli;
        $mysqli->query("DELETE FROM `Authors_Books` WHERE `book_id` = $this->id");
        $mysqli->query("DELETE FROM `Book` WHERE `id` = $this->id;");
    }

    //Надо дописать
    public function update () {
        global $mysqli;
        $query = "UPDATE `Book` SET `name` = '$this->name', `number_pages` = $this->number_pages, `genre_id` = {$this->genre->id}, `date` = '$this->date' WHERE `id` = $this->id";
        $mysqli->query($query);
        $mysqli->query("DELETE FROM `Authors_Books` WHERE `book_id` = $this->id");
        foreach ($this->authors as $author)
            $mysqli->query("INSERT INTO `Authors_Books` (`author_id`, `book_id`) VALUES ($author->id, $this->id)");
    }

    public function is_empty() {
        if (empty($this->name) || empty($this->authors) || empty($this->genre) || empty($this->date)) {
            return true;
        } else {
            return false;
        }
    }

    public static function get_by_id($id) {
        global $mysqli;
        $book_row = $mysqli->query("SELECT * FROM Book WHERE id = $id")->fetch_array();
        $authors_id = $mysqli->query("SELECT author_id FROM Authors_Books WHERE book_id = $id");
        while ($row = $authors_id->fetch_array()) {
            $authors[] = Author::get_by_id($row['author_id']);
        }
        $genre = Genre::get_by_id($book_row['genre_id']);
        $book = new Book($book_row['name'], $book_row['number_pages'], $authors, $genre, $book_row['date']);
        $book->id = $id;
        return $book;
    }
    //list methods
    public static function get_all_order_by_date() {
        global $mysqli;
        $query = "SELECT id FROM Book 
        ORDER BY -Book.date";
        $result = $mysqli->query($query);
        while ($row = $result->fetch_array())
            $books[] = self::get_by_id($row['id']);
        return $books;
    }

    public static function get_books_with_sereval_authors() {
        global $mysqli;
        $query = "SELECT Book.id FROM (
            SELECT Authors_Books.author_id, Authors_Books.book_id FROM Authors_Books
            GROUP BY Authors_Books.book_id HAVING COUNT(*) > 1 
        ) authors_books
        INNER JOIN Book ON authors_books.book_id = Book.id";
        $result = $mysqli->query($query);
        while ($row = $result->fetch_array())
            $books[] = self::get_by_id($row['id']);
        return $books;
    }

    public static function get_range_pages($start=0, $end=9999) {
        global $mysqli;
        $query = "SELECT COUNT(*) AS number_books FROM Book WHERE number_pages BETWEEN $start AND $end";
        return $mysqli->query($query)->fetch_array()['number_books'];
    }

    public static function larger_130_pages() {
        global $mysqli;
        $result = $mysqli->query("SELECT DISTINCT Book.id FROM Book
        INNER JOIN Authors_Books ON Book.id = Authors_Books.book_id
        INNER JOIN Author ON Author.id = Authors_Books.author_id
        WHERE Book.number_pages > 130
        ORDER BY Book.id");
        while ($row = $result->fetch_array())
            $books[] = self::get_by_id($row['id']); 
        return $books;
    }
}