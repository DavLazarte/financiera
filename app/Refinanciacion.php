<?php

namespace ConfiSis;

use Illuminate\Database\Eloquent\Model;

class Refinanciacion extends Model
{
    protected $table='refinanciacion';

    protected $primaryKey='idrefinanciacion';

    public $timestamps=true;


    protected $fillable =[
    	'credito',
    	'cliente',
    	'saldo',
    	'plan',
    	'vencimiento',     	
    	'estado'
    	
    ];

    protected $guarded =[

    ];
}
