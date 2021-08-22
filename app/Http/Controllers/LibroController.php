<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Libro;
use App\Models\Editorial;

class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $libroEncontrado = Libro::select(  
            "libro.id",
            "libro.titulo",
            "libro.genero",
            "libro.idEditorial",            
            "editorial.nombre as nombreEditorial"
        )
        ->join("editorial", "editorial.id","=","libro.idEditorial")
        ->get();

        return response()->json(['status'=>'ok','data'=>$libroEncontrado], 200);
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
        if (!$request->titulo || !$request->genero || $request->idEditorial == 0)
        {            
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        }

        $editorial=Editorial::find($request->idEditorial);

        if (!$editorial)
        {
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ninguna editorial con este código.'])], 404);
		}

        $nuevoLibro=Libro::create($request->all());

        return response()->json(['data'=>$nuevoLibro], 201)->header('Location', url('/api/v1/').'/libro/'.$nuevoLibro->id);
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
        return response()->json(['status'=>'ok','data'=>$libro], 200);
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

        if(!$libro)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún libro con este código.'])], 404);
        }

        $titulo = $request->titulo;
        $genero = $request->genero;
        $idEditorial = $request->idEditorial;

        if (!$request->titulo || !$request->genero || $request->idEditorial == 0)
        {            
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
        }

        $libro->titulo = $titulo;
        $libro->genero = $genero;
        $libro->idEditorial = $idEditorial;
        $libro->save();
        
        return response()->json(['status'=>'ok','data'=>$libro], 200);
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
