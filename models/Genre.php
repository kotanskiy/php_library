<?php

class Genre {

    public $id;
    public $name;
    public $date_created;

    function __construct($name) {
        $this->name = $name;
    }

    public function save() {
        global $mysqli;
        $query = "INSERT INTO `Genre` (`name`) VALUES ('{$this->name}')";
        $mysqli->query($query);
    }

    public function remove() {
        global $mysqli;
        $query = "DELETE FROM `Genre` WHERE `id` = $this->id";
        $mysqli->query($query);
    }

    public function update () {
        global $mysqli;
        $query = "UPDATE `Genre` SET `name` = '$this->name', `date_created` = '$this->date_created' WHERE `id` = '$this->id'";
        $mysqli->query($query);
    }

    public static function get_all() {
        global $mysqli;
        $query = "SELECT * FROM `Genre`";
        $result = $mysqli->query($query);
        while ($row = $result->fetch_object()) 
            $authors[] = $row;
        return $authors;
    }

    public function is_empty() {
        if (empty($this->name)) {
            return true;
        } else {
            return false;
        }
    }

    public static function get_by_id($id) {
        global $mysqli;
        $query = "SELECT * FROM `Genre` WHERE `id` = $id";
        $result = $mysqli->query($query);
        $row = $result->fetch_array();
        $genre = new Genre($row['name']);
        $genre->date_created = $row['date_created'];
        $genre->id = $row['id'];
        return $genre;
    }

    public static function get_count_genres() {
        global $mysqli;
        $query = "SELECT Genre.name, COUNT(*) AS `count` FROM Genre
        INNER JOIN Book ON Book.genre_id = Genre.id
        GROUP BY Genre.id";
        $result = $mysqli->query($query);
        while ($row = $result->fetch_array())
            $genres[] = $row;
        return $genres; 
    }
}