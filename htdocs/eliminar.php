<?php

// Incluir el archivo de configuración de la base de datos
include 'config.php';

// Verificar si se recibió el ID del cliente a eliminar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Obtener el ID del cliente a eliminar
    $id = $_POST['id'];

    try {
        // Preparar la consulta SQL para eliminar el cliente por su ID
        $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = :id");
        
        // Bind parameters
        $stmt->bindParam(':id', $id);
        
        // Ejecutar la consulta
        $stmt->execute();

        // Devolver una respuesta exitosa
        echo "Cliente eliminado correctamente.";
    } catch (PDOException $e) {
        echo "Error al eliminar cliente: " . $e->getMessage();
    }
}
