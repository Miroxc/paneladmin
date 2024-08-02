<?php
// consultar_vehiculo.php

// Incluir archivo de configuración de la base de datos
include 'config.php';

// Verificar si se recibió la patente del vehículo por método POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['patente'])) {
    $patente = $_POST['patente'];

    try {
        // Preparar la consulta SQL para seleccionar los datos del vehículo por patente
        $stmt = $pdo->prepare("SELECT * FROM clientes WHERE patente = :patente");

        // Bind parameters
        $stmt->bindParam(':patente', $patente);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado como array asociativo
        $vehiculo = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontraron resultados
        if ($vehiculo) {
            // Devolver los datos del vehículo en formato JSON
            echo json_encode($vehiculo);
        } else {
            // Si no se encontraron datos, devolver un mensaje indicando esto
            echo json_encode(array('error' => 'No se encontraron datos para la patente ingresada.'));
        }
    } catch (PDOException $e) {
        // Capturar errores de PDO
        echo json_encode(array('error' => 'Error al consultar vehículo: ' . $e->getMessage()));
    }
} else {
    // Si no se recibió la patente por POST, devolver un mensaje de error
    echo json_encode(array('error' => 'No se recibió la patente del vehículo.'));
}
?>
