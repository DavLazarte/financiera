<?php

namespace ConfiSis;

use Illuminate\Database\Eloquent\Model;

class Resumen extends Model
{
    protected $table='resumen';

    protected $primaryKey='idresumen';

    public $timestamps=true;


    protected $fillable =[
    	'zona',
    	'ingreso_semana',
    	'salida_semana',
    	'anticipo',	
    	'estado'
    	
    ];

    protected $guarded =[

    ];
}
