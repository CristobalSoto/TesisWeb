<?php
namespace App\Http\Controllers;

use App\Precio;
use Illuminate\Http\Request;

class PrecioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return Precio::All();
      /*
        return response()->json(
            $precio = Precio::query()
                ->get(),200);
      */
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
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Precio  $precio
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $precio = Precio::findOrFail($id);
      
    }

    public function custom($tipoP, $producto) 
    {
      $precios = Precio::where('tipo_producto', $tipoP)
                        ->where('producto', $producto)
                        ->get();
                        
      return $precios;
    }

    public function productoSector($tipoP, $producto, $sector) 
    {
      $precios = Precio::where('tipo_producto', $tipoP)
                        ->where('producto', $producto)
                        ->where('sector', $sector)
                        ->get();
                        
      return $precios;
    }
  
  
}
