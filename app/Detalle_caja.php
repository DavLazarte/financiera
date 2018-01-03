<?php

namespace ConfiSis;

use Illuminate\Database\Eloquent\Model;

class Detalle_caja extends Model
{
    protected $table='detalle_caja';

    protected $primaryKey='iddetalle_caja';

    public $timestamps=true;


    protected $fillable =[
    	'caja',
    	'zonaingreso',
    	'ingreso',
    	'montoingreso',
    	'zonasalida',
    	'salida',
    	'concepto',
    	'montosalida',     	
    	'estado'
    	
    ];

    protected $guarded =[

    ];
}
