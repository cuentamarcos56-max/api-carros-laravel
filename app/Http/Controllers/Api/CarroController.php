<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carro;
use Illuminate\Http\Request;

class CarroController extends Controller
{
    // LISTAR
    public function index()
    {
        $carros = Carro::all();

        return response()->json([
            'ok' => true,
            'data' => $carros
        ]);
    }

    // CREAR
    public function store(Request $request)
    {
        $request->validate([
            'placas' => 'required',
            'serie' => 'required',
            'color' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $rutaFoto = null;

        if ($request->hasFile('foto')) {
            $rutaFoto = $request->file('foto')->store('carros', 'public');
        }

        $carro = Carro::create([
            'placas' => $request->placas,
            'serie' => $request->serie,
            'color' => $request->color,
            'foto' => $rutaFoto
        ]);

        return response()->json([
            'ok' => true,
            'mensaje' => 'Carro creado correctamente',
            'data' => $carro
        ]);
    }

    // OBTENER UNO
    public function show($id)
    {
        $carro = Carro::find($id);

        if (!$carro) {
            return response()->json([
                'ok' => false,
                'error' => 'Carro no encontrado'
            ], 404);
        }

        return response()->json([
            'ok' => true,
            'data' => $carro
        ]);
    }

    // ACTUALIZAR
    public function update(Request $request, $id)
    {
        $carro = Carro::find($id);

        if (!$carro) {
            return response()->json([
                'ok' => false,
                'error' => 'Carro no encontrado'
            ], 404);
        }

        $request->validate([
            'placas' => 'required',
            'serie' => 'required',
            'color' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        if ($request->hasFile('foto')) {
            $rutaFoto = $request->file('foto')->store('carros', 'public');
            $carro->foto = $rutaFoto;
        }

        $carro->placas = $request->placas;
        $carro->serie = $request->serie;
        $carro->color = $request->color;

        $carro->save();

        return response()->json([
            'ok' => true,
            'mensaje' => 'Carro actualizado correctamente',
            'data' => $carro
        ]);
    }

    // ELIMINAR
    public function destroy($id)
    {
        $carro = Carro::find($id);

        if (!$carro) {
            return response()->json([
                'ok' => false,
                'error' => 'Carro no encontrado'
            ], 404);
        }

        $carro->delete();

        return response()->json([
            'ok' => true,
            'mensaje' => 'Carro eliminado correctamente'
        ]);
    }
}