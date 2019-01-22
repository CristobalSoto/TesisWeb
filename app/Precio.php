<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    protected $table = ('odepa_precios');
    protected $hidden = ['variedad', 'calidad', 'precio_mínimo', 'precio_máximo'];

}
