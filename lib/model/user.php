<?php
namespace model;

class User extends Model {
    private $user_id;
    private $name;
    private $email;

    public function __construct($user_id){
        $data = self::get($user_id);
        foreach ($data as $k => $v) {
            $this->{$k} = $v;
        }
    }

    public static function getList () {
        $query = static::getDb()->prepare("SELECT * FROM user");
        $query->execute();
        return $query->fetchAll();
    }

    public static function create($params) {
        $email = isset($params['email']) ? $params['email'] : null;
        $name = isset($params['name']) ? $params['name'] : null;
        //TODO email check etc
        $is_valid = $email;
        if (!$is_valid) {
            throw new InvalidModelException('You must input a valid email');
        }
        $db = self::getDb();
        $query = $db->prepare("INSERT INTO user (`name`, `email`) VALUES ('$name', '$email');");
        $query->execute();
        return array('user_id' => $db->lastInsertId('user_id'));
    }

    public function delete() {
        $query = self::getDb()->prepare("DELETE FROM user WHERE user_id = $this->user_id;");
        $query->execute();
        return true;
    }

    public static function get($user_id) {
        $query = static::getDb()->prepare("SELECT * FROM user WHERE user_id = $user_id");
        $query->execute();
        return $query->fetch();
    }

    public function getSongs() {
        $query = self::getDb()->prepare("SELECT song_id, title, album, duration FROM user_songs LEFT JOIN song USING(song_id) WHERE user_id = $this->user_id");
        $query->execute();
        return $query->fetchAll();
    }

    public function addSong($song_id) {
        $query = self::getDb()->prepare("INSERT INTO user_songs (user_id, song_id) VALUES ($this->user_id, $song_id)");
        $query->execute();
        return $song_id;
    }

    public function deleteSong($song_id) {
        $query = self::getDb()->prepare("DELETE FROM user_songs WHERE song_id = $song_id AND user_id = $this->user_id");
        $query->execute();
        return $song_id;
    }
}
?>
