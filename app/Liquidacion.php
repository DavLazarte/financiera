<?php

namespace ConfiSis;

use Illuminate\Database\Eloquent\Model;

class Liquidacion extends Model
{
    protected $table='liquidacion';

    protected $primaryKey='idliquidacion';

    public $timestamps=true;


    protected $fillable =[
    	'empleado',
    	'periodo',
    	'totalrec',
    	'total_comision',
    	'total',   	
    	'estado'
    	
    ];

    protected $guarded =[

    ];
}
