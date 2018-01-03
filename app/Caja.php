<?php

namespace ConfiSis;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table='caja';

    protected $primaryKey='idcaja';

    public $timestamps=true;


    protected $fillable =[
        'totalingreso',
        'totalsalida',
        'totalsuma',    	
    	'estado'
    	
    ];

    protected $guarded =[

    ];
}
