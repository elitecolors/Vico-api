CREATE TABLE `client` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `username` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT
                              'Email as the username',
                          `password` varchar(96) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT
                              'Use password hash with BCRYPT',
                          `created` datetime NOT NULL,
                          `first_name` varchar(96) COLLATE utf8mb4_unicode_ci NOT NULL,
                          `last_name` varchar(96) COLLATE utf8mb4_unicode_ci NOT NULL,
                          PRIMARY KEY (`id`),
                          UNIQUE KEY `UNIQ_70E4FA78F85E0677` (`username`),
                          KEY `username_idx` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE `vico` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `created` datetime NOT NULL,
                        PRIMARY KEY (`id`),
                        KEY `name_idx` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE `project` (
                           `id` int(11) NOT NULL AUTO_INCREMENT,
                           `creator_id` int(11) NOT NULL,
                           `vico_id` int(11) DEFAULT NULL,
                           `created` datetime NOT NULL,
                           `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                           PRIMARY KEY (`id`),
                           KEY `IDX_2FB3D0EE19F89217` (`vico_id`),
                           KEY `creator_idx` (`creator_id`),
                           KEY `created_idx` (`created`),
                           CONSTRAINT `FK_2FB3D0EE19F89217` FOREIGN KEY (`vico_id`) REFERENCES
                               `vico` (`id`),
                           CONSTRAINT `FK_2FB3D0EE61220EA6` FOREIGN KEY (`creator_id`)
                               REFERENCES `client` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;