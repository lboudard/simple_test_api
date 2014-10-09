<?php
namespace model;

class Song extends Model {
    protected static $table = 'song';
    protected static $pk = 'song_id';
    protected $song_id;
    protected $album;
    protected $title;
    protected $duration;
}
?>
