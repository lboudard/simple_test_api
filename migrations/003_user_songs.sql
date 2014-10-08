CREATE TABLE user_songs (
    `user_id` BIGINT NOT NULL,
    `song_id` BIGINT NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`user_id`, `song_id`),
    UNIQUE KEY (`user_id`, `song_id`),
    CONSTRAINT FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
    CONSTRAINT FOREIGN KEY (`song_id`) REFERENCES `song` (`song_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE UNIQUE INDEX `user_id_song_id` ON user_songs (`user_id`, `song_id`);
