<?php
require('./database.php');
try
{
    $request = "
                    USE camakrwk_azeghmi;
                    DROP TABLE IF EXISTS comments;
                    DROP TABLE IF EXISTS pictures;
                    DROP TABLE IF EXISTS likes;
                    DROP TABLE IF EXISTS users;
                    CREATE TABLE IF NOT EXISTS comments (img_id INT(11) DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, username VARCHAR(255) NOT NULL, date DATE NOT NULL);
                    CREATE TABLE IF NOT EXISTS likes (username VARCHAR(255) NOT NULL, img_id INT(11) NOT NULL);
                    CREATE TABLE IF NOT EXISTS pictures (username VARCHAR(255) DEFAULT NULL, img_link VARCHAR(255) DEFAULT NULL, likes INT(11) DEFAULT NULL, comments INT(11) DEFAULT NULL, id INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL, date DATE DEFAULT NULL, img_filter VARCHAR(255) DEFAULT NULL);
                    CREATE TABLE IF NOT EXISTS users (username VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, mail VARCHAR(255) DEFAULT NULL, valid_key VARCHAR(32) DEFAULT 0, active INT(1) DEFAULT 0, password_key VARCHAR(32) DEFAULT NULL, send_link INT(1) DEFAULT 0, new_comment INT(11) DEFAULT 1);";

    $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $bdd->exec($request);
    echo "Database successfully created.\n";
}
catch (PDOException $e)
{
    die("DB ERROR: ". $e->getMessage());
}
