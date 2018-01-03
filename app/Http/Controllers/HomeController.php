<?php

namespace ConfiSis\Http\Controllers;

use ConfiSis\Http\Requests;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $totales=DB::select('SELECT (select ifnull(sum(v.monto),0) from venta v  where month(v.fecha_hora)=month(curdate()) and v.zona="Activo") as totalventames,(select ifnull(sum(v.monto),0) from venta v  where week(v.fecha_hora)=week(curdate()) and v.estado="Activo") as totalventawek,(select ifnull(sum(v.monto),0) from venta v  where day(v.fecha_hora)=day(curdate()) and v.estado="Activo") as totalventadia,(select ifnull(sum(v.monto),0) from venta v  where year(v.fecha_hora)=year(curdate()) and v.estado="Activo") as totalventaño,(select ifnull(sum(c.monto),0) from cobranza c  where day(c.fecha_hora)=day(curdate()) and c.estado="Activo") as totalpagodia, (select ifnull(sum(c.monto),0) from cobranza c  where week(c.fecha_hora)=week(curdate()) and c.estado="Activo") as totalpagowek,(select ifnull(sum(c.monto),0) from cobranza c  where month(c.fecha_hora)=month(curdate()) and c.estado="Activo") as totalpagomes,(select ifnull(sum(c.monto),0) from cobranza c  where year(c.fecha_hora)=year(curdate()) and c.estado="Activo") as totalpagoaño');

            return view('home',["totales"=>$totales]);
    }
}
