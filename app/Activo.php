<?php

namespace ConfiSis;

use Illuminate\Database\Eloquent\Model;

class Activo extends Model
{
    protected $table='activo';

    protected $primaryKey='idcredito';

    public $timestamps=true;


    protected $fillable =[
        'zona',
    	'cliente',
    	'saldo',
    	'proyeccion',
    	'vencimiento',     	
    	'estado'
    	
    ];

    protected $guarded =[

    ];
}
