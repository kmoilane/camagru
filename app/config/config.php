<?php
// Database parameters
define("DB_HOST", "localhost");
define("DB_USER", "root");
define('DB_PASS', 'kmoilane!');
define('DB_NAME', 'camagru');

// APPROOT (path to /app)
define("APPROOT", dirname(dirname(__FILE__)));

// URLROOT (dynamic links)
define("URLROOT", "http://localhost/camagru");

// IMGROOT shorter way to get to images
define("IMGROOT", URLROOT . "/public/img");

// ABSOLUTE path to images
define("ABSOLUTE", "C:/wamp64/www/camagru/public/img/");

// SITENAME
define("SITENAME", "Camagru");
?>
