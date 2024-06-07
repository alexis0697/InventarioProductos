<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class ProductoController extends Controller
{
    // Muestra la lista de productos
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    // Muestra el formulario para crear un nuevo producto
    public function create()
    {
        return view('productos.create');
    }

    // Guarda un nuevo producto en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $producto = new Producto($request->only('nombre', 'descripcion', 'precio', 'cantidad'));

            if ($request->hasFile('imagen')) {
                $path = $request->file('imagen')->store('productos', 'public');
                $producto->imagen = $path;
            }

            $producto->save();

            return response()->json(['success' => 'Producto creado exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al guardar el producto: ' . $e->getMessage()], 500);
        }
    }

    // Actualiza un producto existente en la base de datos
    public function update(Request $request, Producto $producto)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $producto->fill($validatedData);
            if ($request->hasFile('imagen')) {
                if ($producto->imagen) {
                    Storage::disk('public')->delete($producto->imagen);
                }
                $path = $request->file('imagen')->store('imagenes', 'public');
                $producto->imagen = $path;
            }

            $producto->save();
            return response()->json(['success' => 'Producto actualizado exitosamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
    // Elimina un producto de la base de datos
    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        try {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $producto->delete();
            return response()->json(['message' => 'Producto eliminado exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el producto.'], 500);
        }
    }

    // Registra un movimiento de inventario (compra o venta)
    public function registrarMovimiento(Request $request, Producto $producto)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
            'tipo' => 'required|in:entrada,salida',
        ]);

        try {
            $cantidad = $request->cantidad;
            $tipo = $request->tipo;

            if ($tipo == 'entrada') {
                $producto->cantidad += $cantidad;
            } elseif ($tipo == 'salida') {
                if ($producto->cantidad < $cantidad) {
                    return response()->json(['error' => 'No hay suficiente cantidad en el inventario.'], 400);
                }
                $producto->cantidad -= $cantidad;
            }

            $producto->save();

            return response()->json(['success' => 'Movimiento registrado exitosamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}

