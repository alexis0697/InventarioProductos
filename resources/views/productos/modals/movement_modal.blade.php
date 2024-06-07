<!-- Modal de Movimiento -->
<div class="modal fade" id="movementModal" tabindex="-1" aria-labelledby="movementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="movementModalLabel">Registrar Movimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="movementForm">
                    <input type="hidden" name="producto_id" id="movementProductId">
                    <div class="mb-3">
                        <label for="movementType" class="form-label">Tipo de Movimiento</label>
                        <select class="form-select" id="movementType" name="tipo" required>
                            <option value="entrada">Entrada</option>
                            <option value="salida">Salida</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="movementQuantity" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="movementQuantity" name="cantidad" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="saveMovement()">Guardar </button>
            </div>
        </div>
    </div>
</div>
