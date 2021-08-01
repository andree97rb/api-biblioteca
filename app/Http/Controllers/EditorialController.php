<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Editorial;

class EditorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $editorial=Cache::remember('cacheeditorial',20/60, function()
        {
            return Editorial::all();
        });

        return response()->json(['status'=>'ok','data'=>$editorial], 200);
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
        if (!$request->nombre || !$request->pais)
		{
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        }

        $nuevaEditorial=Editorial::create($request->all());

        return response()->json(['data'=>$nuevaEditorial], 201)->header('Location', url('/api/v1/').'/editorial/'.$nuevaEditorial->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $editorial=Editorial::find($id);

		if (!$editorial)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ninguna editorial con este código.'])], 404);
		}

        return response()->json(['status'=>'ok','data'=>$editorial], 200);
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
        $editorial = Editorial::find($id);

        if(!$editorial)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ninguna editorial con este código.'])], 404);
        }

        $nombre = $request->nombre;
        $pais = $request->pais;

        if (!$request->nombre || !$request->pais)
        {
            return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
        }

        $editorial->nombre = $nombre;
        $editorial->pais = $pais;
        $editorial->save();

        return response()->json(['status'=>'ok','data'=>$editorial], 200);
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