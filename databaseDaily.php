<?php
require_once 'Database.php';

$database = new Database();
$stmt = $database->connect()->prepare('
            CALL dailyjob();
        ');
$stmt->execute();