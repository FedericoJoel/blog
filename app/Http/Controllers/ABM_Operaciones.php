<?php

namespace App\Http\Controllers;

use App\Operacion;
use Illuminate\Http\Request;

class ABM_Operaciones extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ABM_operaciones');
    }

    public function store(Request $request)
    {
        $op = Operacion::create($request->all());
        $op->imputaciones()->attach($request['imputacion1'], ['debe' => $request['debe1'], 'haber' => $request['haber1']]);
        $op->imputaciones()->attach($request['imputacion2'], ['debe' => $request['debe2'], 'haber' => $request['haber2']]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Operacion::with('imputaciones')->find($id);
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
        $op = Operacion::with('imputaciones')->find($id);
        $op->fill($request->all());
        $op->imputaciones()->detach();
        $op->imputaciones()->attach($request['imputacion1'], ['debe' => $request['debe1'], 'haber' => $request['haber1']]);
        $op->imputaciones()->attach($request['imputacion2'], ['debe' => $request['debe2'], 'haber' => $request['haber2']]);

        $op->save();
    }

    public function all()
    {
        return Operacion::all();
    }

}
