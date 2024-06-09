@extends('layouts.app')

@section('content')
<div class="container mt-5" style="background-color: #f0f2f5;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="text-center mb-4">Productos</h2>
            <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="bi bi-plus-circle"></i>
            </button>
            <div class="p-4 bg-white shadow-lg" style="border-radius: 0.5rem;">
                <div class="table-responsive">
                    <table id="productsTable" class="table table-striped table-bordered bg-white">
                        <thead class="thead-light">
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $producto)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ $producto->imagen ? asset('storage/' . $producto->imagen) : asset('storage/productos/default.png') }}" alt="Imagen del producto" style="width: 50px; height: auto; cursor: pointer;" onclick="showImageModal('{{ $producto->imagen ? asset('storage/' . $producto->imagen) : asset('storage/productos/default.png') }}')">
                                </td>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->descripcion }}</td>
                                <td>${{ number_format($producto->precio, 2) }}</td>
                                <td>{{ $producto->cantidad }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $producto->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            Acciones
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $producto->id }}">
                                            <li>
                                                <a class="dropdown-item" href="#" onclick="editProduct({{ json_encode($producto) }})">
                                                    <i class="bi bi-pencil-square"></i> Editar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item delete-button" href="#" data-id="{{ $producto->id }}" data-url="{{ route('productos.destroy', $producto->id) }}">
                                                    <i class="bi bi-trash"></i> Eliminar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item movement-button" href="#" data-id="{{ $producto->id }}">
                                                    <i class="bi bi-arrow-left-right"></i> Movimiento
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('productos.modals.add_product')
@include('productos.modals.image_viewer')
@include('productos.modals.movement_modal')
@vite(['resources/js/productos.js'])

@endsection
