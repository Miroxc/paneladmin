$(document).ready(function() {

    // Función para cargar datos desde el servidor y actualizar la tabla
    function cargarDatos() {
        $.ajax({
            type: 'GET',
            url: 'cargar_datos.php',
            dataType: 'json', // Esperamos JSON como respuesta
            success: function(response) {
                mostrarDatos(response); // Llamar a la función para mostrar los datos
            },
            error: function(xhr, status, error) {
                alert("Error al cargar los datos.");
                console.error(xhr.responseText);
            }
        });
    }

    // Función para mostrar los datos en la tabla
    function mostrarDatos(datos) {
        let tbody = $('#tablaDatos tbody');
        tbody.empty(); // Limpiar el cuerpo de la tabla antes de agregar nuevos datos

        // Verificar si `datos` es un array y tiene elementos
        if ($.isArray(datos) && datos.length > 0) {
            // Recorrer los datos y construir las filas de la tabla
            $.each(datos, function(index, cliente) {
                let fila = `
                    <tr data-id="${cliente.id}">
                        <td>${cliente.id}</td>
                        <td>${cliente.nombreCliente}</td>
                        <td>${cliente.patente}</td>
                        <td>${cliente.valorArreglo}</td>
                        <td>${cliente.estado}</td>
                        <td>
                            <button class="btn btn-danger eliminar-fila">Eliminar</button>
                        </td>
                    </tr>
                `;
                tbody.append(fila); // Agregar la fila al cuerpo de la tabla
            });
        } else {
            console.log("No se recibieron datos válidos desde el servidor.");
        }
    }

    // Llamar a la función para cargar datos al iniciar la página
    cargarDatos();

    // Función para manejar el envío del formulario
    $('#formulario').submit(function(event) {
        event.preventDefault();

        let nombreCliente = $('#nombreCliente').val();
        let patente = $('#patente').val();
        let valorArreglo = $('#valorArreglo').val();
        let estado = $('#estado').val();

        // Validaciones de formulario aquí...

        $.ajax({
            type: 'POST',
            url: 'procesar.php',
            data: {
                nombreCliente: nombreCliente,
                patente: patente,
                valorArreglo: valorArreglo,
                estado: estado
            },
            dataType: 'json', // Esperamos JSON como respuesta
            success: function(response) {
                alert(response.mensaje); // Mostrar mensaje del servidor
                if (response.success) {
                    cargarDatos(); // Actualizar tabla de datos
                    $('#formulario')[0].reset(); // Limpiar formulario
                }
            },
            error: function(xhr, status, error) {
                alert("Error al guardar los datos."); // Manejar errores
                console.error(xhr.responseText);
            }
        });
    });

    // Función para eliminar una fila
    $(document).on('click', '.eliminar-fila', function() {
        if (confirm('¿Está seguro de eliminar esta fila?')) {
            let fila = $(this).closest('tr');
            let id = fila.attr('data-id');

            $.ajax({
                type: 'POST',
                url: 'eliminar.php',
                data: { id: id },
                success: function(response) {
                    alert(response); // Mostrar mensaje del servidor
                    if (response.includes('eliminado')) {
                        fila.remove(); // Eliminar fila de la tabla
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error al eliminar los datos."); // Manejar errores
                    console.error(xhr.responseText);
                }
            });
        }
    });
});
