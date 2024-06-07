<!-- Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Agregar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="productForm" method="post" enctype="multipart/form-data">
              <input type="hidden" name="_method" id="formMethod" value="POST">
              <input type="hidden" name="product_id" id="productId">
              <div class="mb-3">
                  <label for="nombre" class="form-label">Nombre del producto</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" required>
              </div>
              <div class="mb-3">
                  <label for="descripcion" class="form-label">Descripción</label>
                  <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
              </div>
              <div class="mb-3">
                  <label for="precio" class="form-label">Precio</label>
                  <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
              </div>
              <div class="mb-3">
                  <label for="cantidad" class="form-label">Cantidad</label>
                  <input type="number" class="form-control" id="cantidad" name="cantidad" required>
              </div>
              <div class="mb-3">
                  <label for="imagen" class="form-label">Imagen del producto</label>
                  <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
              </div>
          </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="saveProduct()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<script>
    window.Laravel = {
        csrfToken: "{{ csrf_token() }}",
        routes: {
            storeProduct: "{{ route('productos.store') }}",
            updateProduct: function(id) {
                return "{{ route('productos.update', ':id') }}".replace(':id', id);
            }
        }
    };
</script>
