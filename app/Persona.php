<?php

namespace ConfiSis;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table='persona';

    protected $primaryKey='idpersona';

    public $timestamps=true;


    protected $fillable =[
    	'nombre_apellido',
    	'dni',
    	'domicilio',
    	'telefono',
    	'tipo',
    	'estado'
    ];

    protected $guarded =[

    ];
}
