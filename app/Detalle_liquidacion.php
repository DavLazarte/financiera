<?php

namespace ConfiSis;

use Illuminate\Database\Eloquent\Model;

class Detalle_liquidacion extends Model
{
    protected $table='detalle_liquidacion';

    protected $primaryKey='iddetalle_liquidacion';

    public $timestamps=true;


    protected $fillable =[
    	'idliquidacion',
        'zona',
    	'fecha_inicio',
    	'fecha_fin',
    	'cobranza',
    	'comision',
    	'anticipo',
    	'premio'
    	
    ];

    protected $guarded =[

    ];
}
