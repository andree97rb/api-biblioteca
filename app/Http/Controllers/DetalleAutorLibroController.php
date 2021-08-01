<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Libro;

class DetalleAutorLibroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->idLibro == 0 || empty($request->idAutor))
        {            
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        }

        $libro=Libro::find($request->idLibro);

        if (!$libro)
        {
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún libro con este código.'])], 404);
        }

        $nuevoDetalleLibro=$libro->autores()->sync($request->idAutor);

        return response()->json(['data'=>$nuevoDetalleLibro['attached']], 201); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $libro=Libro::find($id);

        if (!$libro)
        {
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún libro con este código.'])], 404);
        }

        return response()->json(['status'=>'ok','data'=>$libro->autores], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $libro = Libro::find($id);

        if (!$libro)
        {
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún libro con este código.'])], 404);
        }

        if (empty($request->idAutor))
        {            
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
        }

        $nuevoDetalleLibro=$libro->autores()->sync($request->idAutor);

        return response()->json(['status'=>'ok','data'=>$nuevoDetalleLibro['attached']], 200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}