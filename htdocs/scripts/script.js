$(document).ready(function() {
    // Evento para abrir el modal de consultar vehículo
    $('.abrir-modal').click(function(event) {
        event.preventDefault(); // Evitar el comportamiento predeterminado del enlace
        $('#modalConsultarVehiculo').modal('show');
    });

    // Manejar el envío del formulario para consultar el vehículo
    $('#formConsultarVehiculo').submit(function(event) {
        event.preventDefault();
        let patente = $('#patente').val();

        // Validar que se haya ingresado una patente
        if (patente.trim() === '') {
            alert('Por favor ingrese la patente del vehículo.');
            return;
        }

        // Realizar la llamada AJAX para consultar el vehículo
        $.ajax({
            url: 'consultar_vehiculo.php', // Ruta al script PHP que maneja la consulta
            method: 'POST',
            data: { patente: patente },
            dataType: 'json',
            success: function(response) {
                console.log('Respuesta del servidor:', response);

                // Mostrar la información del vehículo en el nuevo modal
                $('#modalDatosVehiculo').modal('show');
                $('#datosVehiculoBody').html(`
                    <p><strong>Nombre del cliente:</strong> ${response.nombreCliente}</p>
                    <p><strong>Patente:</strong> ${response.patente}</p>
                    <p><strong>Valor del arreglo:</strong> ${response.valorArreglo}</p>
                    <p><strong>Estado:</strong> ${response.estado}</p>
                `);
            },
            error: function(error) {
                console.error('Error al consultar vehículo:', error);
                alert('Error al consultar el vehículo. Por favor, inténtelo nuevamente.');
            }
        });
    });
});
