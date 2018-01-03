<?php

namespace ConfiSis;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table='venta';

    protected $primaryKey='idventa';

    public $timestamps=true;


    protected $fillable =[
    	'fecha_hora',
    	'zona',
    	'idpersona',
    	'monto',
     	'plan',
    	'fecha_cancela',
    	'concepto',
    	'empleado',
    	'estado'
    	
    ];

    protected $guarded =[

    ];
}
