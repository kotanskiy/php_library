<?php

class Author {

    public $id;
    public $surname;
    public $name;
    public $date_birth;

    function __construct($surname, $name, $date_birth) {
        $this->surname = $surname;
        $this->name = $name;
        $this->date_birth = $date_birth;
    }

    public function save() {
        global $mysqli;
        $query = "INSERT INTO `Author` (`surname`, `name`, `date_birth`) VALUES 
        ('{$this->surname}', '{$this->name}', '{$this->date_birth}')";
        $mysqli->query($query);
    }

    public function remove() {
        global $mysqli;
        $query = "DELETE FROM `Author` WHERE `id` = $this->id";
        $result = $mysqli->query($query);
    }

    public function update () {
        global $mysqli;
        $query = "UPDATE `Author` SET `surname` = '$this->surname', `name` = '$this->name', `date_birth` = '$this->date_birth' WHERE `id` = '$this->id'";
        $mysqli->query($query);
    }

    public static function get_all() {
        global $mysqli;
        $query = "SELECT * FROM `Author`";
        $result = $mysqli->query($query);
        while ($row = $result->fetch_object()) {
            $author = new Author($row->surname, $row->name, $row->date_birth);
            $author->id = $row->id;
            $authors[] = $author;
        }
        return $authors;
    }

    public static function get_by_id($id) {
        global $mysqli;
        $query = "SELECT * FROM `Author` WHERE `id` = $id";
        $result = $mysqli->query($query);
        $row = $result->fetch_object();
        $author = new Author($row->surname, $row->name, $row->date_birth);
        $author->id = $row->id;
        return $author;
    }

    public function is_empty() {
        if (empty($this->surname) || empty($this->name) || empty($this->date_birth)) {
            return true;
        } else {
            return false;
        }
    }

    public static function get_authors_with_books_last_year() {
        global $mysqli;
        $query = "SELECT Author.surname, Author.name, COUNT(*) AS `count` FROM Author
        INNER JOIN Authors_Books ON Authors_Books.author_id = Author.id
        INNER JOIN Book ON Authors_Books.book_id = Book.id
        WHERE YEAR(Book.date) = YEAR(NOW())
        GROUP BY Author.id";
        $result = $mysqli->query($query);
        while ($row = $result->fetch_array()) 
            $authors[] = $row;
        return $authors; 
    }
}