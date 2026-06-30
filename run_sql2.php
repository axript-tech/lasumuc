<?php
require_once 'includes/db.php';
try {
    $sql = "
    CREATE TABLE IF NOT EXISTS `settings` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `setting_key` varchar(100) NOT NULL,
      `setting_value` text DEFAULT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `setting_key` (`setting_key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    CREATE TABLE IF NOT EXISTS `news` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `title` varchar(255) NOT NULL,
      `content` text NOT NULL,
      `image` varchar(255) DEFAULT NULL,
      `created_at` timestamp DEFAULT current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    INSERT IGNORE INTO `settings` (`setting_key`, `setting_value`) VALUES ('site_logo', '');
    ";
    $pdo->exec($sql);
    
    // Create uploads directory
    if(!is_dir('assets/img/uploads')) {
        mkdir('assets/img/uploads', 0777, true);
    }
    
    echo "Database and directories updated successfully!";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
