<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Autor;

class AutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $autor=Cache::remember('cacheautor',20/60, function()
        {
            return Autor::all();
        });

        return response()->json(['status'=>'ok','data'=>$autor], 200);
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
        if (!$request->nombres || !$request->apellidos || !$request->fechaNacimiento || !$request->nacionalidad)
		{         
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        }

        $nuevoAutor=Autor::create($request->all());

        return response()->json(['data'=>$nuevoAutor], 201)->header('Location', url('/api/v1/').'/autor/'.$nuevoAutor->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $autor=Autor::find($id);

		if (!$autor)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún autor con este código.'])], 404);
		}

        return response()->json(['status'=>'ok','data'=>$autor], 200);
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
        $autor = Autor::find($id);

        if(!$autor)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún autor con este código.'])], 404);
        }

        $nombres = $request->nombres;
        $apellidos = $request->apellidos;
        $fechaNacimiento = $request->fechaNacimiento;
        $nacionalidad = $request->nacionalidad;
      
        if (!$request->nombres || !$request->apellidos || !$request->fechaNacimiento || !$request->nacionalidad)
        {
            return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
        }

        $autor->nombres = $nombres;
        $autor->apellidos = $apellidos;
        $autor->fechaNacimiento = $fechaNacimiento;
        $autor->nacionalidad = $nacionalidad;
        $autor->save();

        return response()->json(['status'=>'ok','data'=>$autor], 200);
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