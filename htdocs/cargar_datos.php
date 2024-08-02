<?php

// Incluir el archivo de configuración de la base de datos
include 'config.php';

try {
    // Preparar la consulta SQL para seleccionar todos los clientes
    $stmt = $pdo->prepare("SELECT * FROM clientes");
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Obtener todos los resultados
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Convertir los resultados a formato JSON y devolverlos
    echo json_encode($clientes);
} catch (PDOException $e) {
    echo "Error al cargar datos: " . $e->getMessage();
}
