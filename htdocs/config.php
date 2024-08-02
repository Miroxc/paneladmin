<?php

// Nombre del archivo de la base de datos SQLite
$db_file = __DIR__ . 'taller.db';

// Intenta conectar a la base de datos SQLite
try {
    $pdo = new PDO("sqlite:" . $db_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Crear la tabla si no existe (opcional, dependiendo de la lógica de tu aplicación)
    $pdo->exec("CREATE TABLE IF NOT EXISTS clientes (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    nombreCliente TEXT NOT NULL,
                    patente TEXT NOT NULL,
                    valorArreglo REAL NOT NULL,
                    estado TEXT NOT NULL
                )");
} catch (PDOException $e) {
    die("No se pudo conectar a la base de datos: " . $e->getMessage());
}
