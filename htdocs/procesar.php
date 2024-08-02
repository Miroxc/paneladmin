<?php
// Incluir archivo de configuración de la base de datos
include 'config.php';

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombreCliente'], $_POST['patente'], $_POST['valorArreglo'], $_POST['estado'])) {
    // Obtener los datos del formulario
    $nombreCliente = $_POST['nombreCliente'];
    $patente = $_POST['patente'];
    $valorArreglo = $_POST['valorArreglo'];
    $estado = $_POST['estado'];

    // Insertar los datos en la base de datos
    try {
        // Preparar la consulta SQL
        $stmt = $pdo->prepare("INSERT INTO clientes (nombreCliente, patente, valorArreglo, estado) VALUES (:nombreCliente, :patente, :valorArreglo, :estado)");

        // Bind de parámetros
        $stmt->bindParam(':nombreCliente', $nombreCliente);
        $stmt->bindParam(':patente', $patente);
        $stmt->bindParam(':valorArreglo', $valorArreglo);
        $stmt->bindParam(':estado', $estado);

        // Ejecutar consulta
        $stmt->execute();

        // Preparar respuesta JSON
        $response = array(
            'success' => true,
            'mensaje' => 'Datos guardados correctamente.'
        );
    } catch (PDOException $e) {
        // Error al insertar en la base de datos
        $response = array(
            'success' => false,
            'mensaje' => 'Error al guardar los datos: ' . $e->getMessage()
        );
    }

    // Devolver respuesta JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Si no se recibieron datos esperados
    $response = array(
        'success' => false,
        'mensaje' => 'No se recibieron datos válidos.'
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
