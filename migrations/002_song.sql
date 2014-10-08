CREATE TABLE song (
    `song_id` BIGINT NOT NULL AUTO_INCREMENT,
    #should be foreign key to album model in more complete model
    `album` BIGINT NOT NULL DEFAULT 0,
    `title` VARCHAR(100) NOT NULL,
    `duration` TIME NOT NULL,
    PRIMARY KEY (`song_id`),
    UNIQUE KEY `song_id` (`song_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
