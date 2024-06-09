$(document).ready(function() {
    // Inicializar DataTable con opciones de idioma en español y ajustes responsivos
    var table = $('#productsTable').DataTable({
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
            "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
            "infoFiltered": "(filtrado de _MAX_ entradas totales)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        responsive: true,
        searching: true,
    });

    // Ajustar columnas al cambiar el tamaño de la ventana
    $(window).resize(function() {
        table.columns.adjust().responsive.recalc();
    });

    // Configurar botones de eliminar
    $(document).on('click', '.delete-button', function() {
        const productId = $(this).data('id');
        const deleteUrl = $(this).data('url');
        window.deleteProduct(productId, deleteUrl);
    });

    // Configurar botones de movimiento de inventario
    $(document).on('click', '.movement-button', function() {
        const productId = $(this).data('id');
        window.openMovementModal(productId);
    });

    // Reiniciar campos del formulario al cerrar el modal
    $('#addProductModal').on('hidden.bs.modal', function() {
        $('#productForm').trigger("reset");
        document.getElementById('formMethod').value = 'POST';
        $('#productForm').find('input[name="_method"]').remove();
    });
});

// Función para guardar o actualizar un producto
window.saveProduct = function() {
    var form = document.getElementById('productForm');
    var formData = new FormData(form);
    var url = form.getAttribute('action');
    var method = document.getElementById('formMethod').value;

    // Log FormData para depuración
    for (var pair of formData.entries()) {
        console.log(pair[0] + ': ' + (pair[1] instanceof Blob ? pair[1].name : pair[1]));
    }

    // Ejecutar solicitud AJAX para guardar o actualizar el producto
    $.ajax({
        url: url,
        type: 'POST', 
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'Producto guardado exitosamente.'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#addProductModal').modal('hide');
                    location.reload();
                }
            });
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error al guardar',
                text: 'No se pudo guardar el producto: ' + xhr.responseText
            });
        }
    });
};

// Función para cargar datos del producto en el formulario de edición
window.editProduct = function(product) {
    document.getElementById('modalTitle').textContent = 'Editar Producto';
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('productForm').action = window.Laravel.routes.updateProduct(product.id);

    document.getElementById('productId').value = product.id;
    document.getElementById('nombre').value = product.nombre;
    document.getElementById('descripcion').value = product.descripcion;
    document.getElementById('precio').value = product.precio;
    document.getElementById('cantidad').value = product.cantidad;

    // Asegurar que el campo _method exista y esté configurado correctamente
    var methodInput = document.getElementById('_method');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        document.getElementById('productForm').appendChild(methodInput);
    }

    $('#addProductModal').modal('show');
};

// Función para mostrar una imagen en modal
window.showImageModal = function(imageUrl) {
    $('#fullSizeImage').attr('src', imageUrl);
    $('#imageViewerModal').modal('show');
};

// Función para eliminar un producto
window.deleteProduct = function(productId, deleteUrl) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken
                },
                success: function(result) {
                    Swal.fire(
                        'Eliminado!',
                        'El producto ha sido eliminado.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        'No se pudo eliminar el producto. Intente de nuevo.',
                        'error'
                    );
                }
            });
        }
    });
}

// Función para abrir el modal de movimientos de inventario
window.openMovementModal = function(productId) {
    document.getElementById('movementProductId').value = productId;
    $('#movementModal').modal('show');
};

// Función para registrar un movimiento de inventario
window.saveMovement = function() {
    var form = document.getElementById('movementForm');
    var formData = new FormData(form);
    formData.append('_token', window.Laravel.csrfToken);

    $.ajax({
        url: `/productos/${document.getElementById('movementProductId').value}/movimientos`,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'Movimiento registrado exitosamente.'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#movementModal').modal('hide');
                    location.reload();
                }
            });
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo registrar el movimiento.',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Cerrar'
            });
        }
    });
};
