

-- 1. Foydalanuvchilar jadvali
CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `avatar` VARCHAR(255) DEFAULT 'default-avatar.png',
    `role` ENUM('reader', 'translator', 'admin') DEFAULT 'reader',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Manga / Manhwa / Manhua asosiy jadvali
CREATE TABLE `mangas` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `type` ENUM('Manga', 'Manhwa', 'Manhua') DEFAULT 'Manhwa',
    `synopsis` TEXT DEFAULT NULL,
    `cover_image` VARCHAR(255) DEFAULT NULL,
    `rating` DECIMAL(3,2) DEFAULT 0.00,
    `status` ENUM('Ongoing', 'Completed', 'Hiatus') DEFAULT 'Ongoing',
    `views` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Boblar (Chapters) jadvali
CREATE TABLE `chapters` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `manga_id` INT NOT NULL,
    `chapter_number` DECIMAL(6,2) NOT NULL,
    `title` VARCHAR(255) DEFAULT NULL,
    `pages` JSON DEFAULT NULL COMMENT 'Sahifalar rasmlari massivi',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`manga_id`) REFERENCES `mangas`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. O'qish jarayoni (Reading Progress) jadvali
CREATE TABLE `reading_progress` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `manga_id` INT NOT NULL,
    `chapter_id` INT NOT NULL,
    `progress_percent` INT DEFAULT 0,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`manga_id`) REFERENCES `mangas`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`chapter_id`) REFERENCES `chapters`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `user_manga_progress` (`user_id`, `manga_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;