<?php

namespace ConfiSis;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table='ingreso';

    protected $primaryKey='idingreso';

    public $timestamps=true;


    protected $fillable =[
        'zona',
    	'empleado',
    	'monto',
        'concepto',
       	'estado'
    	
    ];

    protected $guarded =[

    ];
}
