<?php

namespace ConfiSis;

use Illuminate\Database\Eloquent\Model;

class Cobranza extends Model
{
    protected $table='cobranza';

    protected $primaryKey='idcobranza';

    public $timestamps=true;


    protected $fillable =[
    	'idventa',
    	'fecha_hora',
    	'zona',
    	'monto',
    	'estado'

    	
    ];

    protected $guarded =[

    ];
}
