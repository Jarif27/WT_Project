<?php

require_once __DIR__ . '/../config/database.php';

function getAllCategories() {
    global $conn;

    $sql = "SELECT * FROM categories ORDER BY name ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>