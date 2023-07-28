<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Futbol;
use Illuminate\Support\Facades\Storage;
use App\Models\Referencia;
use Carbon\Carbon;

class FutbolController extends Controller
{
    public $pagoSucess = true;

    public function index()
    {
        $futbols = Futbol::all();
        return view('futbol.index', compact('futbols'));
    }

    public function publicidad()
    {

        return view('futbol.publicidad');
    }

    public function addpublicidad(Request $request)
    {
        // Validar los datos enviados por el formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'time' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen (formato y tamaño)
        ]);

        // Procesar la imagen
        if ($request->hasFile('image')) {
            $imagen = $request->file('image');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();

            // Guardar la imagen en la carpeta "public/images"
            $imagen->storeAs('public/images', $nombreImagen);
        } else {
            $nombreImagen = null; // En caso de que no se haya enviado una imagen
        }

        // Crear y guardar el futbol en la base de datos
        Futbol::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'time' => $request->input('time'),
            'image_path' => $nombreImagen, // Guardamos el nombre de la imagen en la columna "image_path"
        ]);


        // Redireccionar a la página de éxito o a donde desees
        return redirect()->route('futbol.index')->with('success', 'Futbol agregado correctamente.');

    }

    public function pasarela($id)
    {
        Referencia::create([
            'futbol_id' => $id,
        ]);
        $referencia = Referencia::where('futbol_id', $id)->latest()->first();
        $reference = $referencia->id;
        $publicidad = Futbol::find($id);
        return view('futbol.pasarela', compact('publicidad', 'reference'));
    }

    public function respuestaPago(Request $request)
    {
        // Obtener los datos de la respuesta de PayU
        $transactionState = $_REQUEST['transactionState'];

        if ($transactionState) {
            // Si el pago fue exitoso, actualizar el campo "status" del futbol en la base de datos
            $referenceCode = $_REQUEST['referenceCode'];
            $referencia = Referencia::where('id', $referenceCode)->first();
            $futbol = Futbol::find($referencia->futbol_id);
            if ($futbol) {
                // Actualizar el campo "status" del futbol a true
                $futbol->status = true;
                $expirationDate = Carbon::parse($futbol->updated_at)->addMonths($futbol->time);
                $futbol->expiration_date = $expirationDate;
                $futbol->save();
            }
        }
        // Realizar cualquier otra acción que necesites después de manejar la respuesta de PayU

        // return redirect()->route('futbol.index');
        // dd($transactionState, $referenceCode, $futbol);
        return redirect()->route('futbol.index')->with('success', 'Pago completado exitosamente.');
    }
}
