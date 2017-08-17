<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Repos\Gateway\VentasGateway;
use App\Repositories\Eloquent\Repos\VentasRepo;
use App\Ventas;
use Illuminate\Http\Request;

class CorrerVtoServiciosController extends Controller
{
    public function index()
    {
        return view('correr_vto_servicios');
    }

    public function correrVto(Request $request)
    {
        $ventasRepo = new VentasRepo();
        $elem = $request->all();
        $id = $elem['id'];
        $dias = $elem['dias'];
        $venta = $ventasRepo->findWithCuotas($id);

        $venta->correrVto($dias);

    }

    public function ventas()
    {
        $ventasRepo = new VentasGateway();
        $ventas = $ventasRepo->ventasQueNoFueronCobradas();
    }
}
