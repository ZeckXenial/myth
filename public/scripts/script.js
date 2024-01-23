function cargarCrudUsuarios() {
    // Realiza una solicitud Ajax para obtener la vista del CRUD
    $.ajax({
        url: '<?= site_url('components/crud_usuarios') ?>', // Ajusta la URL según tu estructura de carpetas y rutas
        method: 'GET',
        success: function(response) {
            // Carga la vista del CRUD en el contenedor
            $('#crudContainer').html(response);
        },
        error: function() {
            alert('Error al cargar la vista del CRUD');
        },
    });