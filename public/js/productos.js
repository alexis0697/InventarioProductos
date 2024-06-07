$('#productsTable').DataTable({
    language: {
        url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json'
    },
    responsive: true,
    searching: true,
});
function saveProduct() {
    var formData = new FormData(document.getElementById('addProductForm'));

    // Agrega el token CSRF
    formData.append('_token', '{{ csrf_token() }}');

    $.ajax({
        url: "{{ route('productos.store') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log('Producto guardado', response);
            $('#addProductModal').modal('hide');
        },
        error: function (xhr, status, error) {
            console.error('Error al guardar', xhr.responseText);
        }
    });
}
