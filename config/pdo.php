<?php

function getPdo(): PDO {
    // Détection automatique
    if (in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1']) 
        || strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false) {
        $dsn = 'mysql:host=localhost;dbname=portfolio;charset=utf8mb4';
        $user = 'root';
        $password = '';
    } else {
        $dsn = 'mysql:host=thomasbportfolio.mysql.db;dbname=thomasbportfolio;charset=utf8mb4';
        $user = 'thomasbportfolio';
        $password = 'DxdK6EyUE3';
    }

    try {
        $db = new PDO($dsn, $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db;
    } catch (PDOException $e) {
        die('Erreur BDD : ' . $e->getMessage());
    }
}