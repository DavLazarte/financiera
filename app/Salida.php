<?php

namespace ConfiSis;

use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    protected $table='salida';

    protected $primaryKey='idsalida';

    public $timestamps=true;


    protected $fillable =[
    	'zona',
    	'monto',
    	'concepto',
    	'observaciones',   	
    	'estado'
    	
    ];

    protected $guarded =[

    ];
}
