<?php

namespace ConfiSis\Http\Controllers;

use Illuminate\Http\Request;

use ConfiSis\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use ConfiSis\Http\Requests\CajaFormRequest;
use ConfiSis\Caja;
use ConfiSis\Detalle_caja;
use DB;
use Fpdf;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;


class CajaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('caja');
    }
    public function index(Request $request)
    {
        if ($request)
        {
           $query=trim($request->get('searchText'));
           $cajas=DB::table('caja as c')
            ->select('c.idcaja','c.created_at','c.estado','c.totalingreso','c.totalsalida','c.totalsuma')
            ->where('c.idcaja','LIKE','%'.$query.'%')
            ->orwhere('c.created_at','LIKE','%'.$query.'%')
            ->orwhere('c.estado','LIKE','%'.$query.'%')
            ->orderBy('c.idcaja','desc')
            ->paginate(10);
            return view('administracion.caja.index',["cajas"=>$cajas,"searchText"=>$query]);

        }
    }
    public function create()
    {
    	$ingresos = DB::table('ingreso')   -> where('estado','=','Pendiente')->orwhere('estado','=','Permanente')->get();
    	$salidas  = DB::table('salida')    -> where('estado','=','Pendiente')->orwhere('estado','=','Permanente')->get();
    	$personas = DB::table('persona')   -> where('tipo','=','Empleado')->get();
    	$cajas    = DB::table('caja as c') -> orderBy('c.idcaja','desc')->first();
    
        return view("administracion.caja.create",["personas"=>$personas,"cajas"=>$cajas,"ingresos"=>$ingresos,"salidas"=>$salidas]);
    }

     public function store (CajaFormRequest $request)
    {
    	//try{
        	DB::beginTransaction();
        	$caja               = new Caja;
        	$caja->totalingreso = $request->get('totalingreso');
        	$caja->totalsalida  = $request->get('totalsalida');
	        $caja->totalsuma    = $request->get('totalsuma');
            $caja->estado       = 'Cerrada';
	        $caja->save();

	        $zonaingreso        = $request->get('zonaingreso');
	        //$ingreso            = $request->get('ingreso');
	        $montoingreso       = $request->get('montoingreso');
	        $zonasalida         = $request->get('zonasalida');
	        //$salida             = $request->get('salida');
	        $montosalida        = $request->get('montosalida');
	        $concepto           = $request->get('concepto');
            
            $cont = 0;

	        while($cont < count($zonaingreso))
	        {
	            $detalle               = new Detalle_caja();
	            $detalle->caja         = $caja->idcaja;
	            $detalle->zonaingreso  = $zonaingreso[$cont]; 
	            //$detalle->ingreso      = $ingreso[$cont];
	            $detalle->montoingreso = $montoingreso[$cont];
	            $detalle->zonasalida   = $zonasalida[$cont];
	            //$detalle->salida       = $salida[$cont];
	            $detalle->montosalida  = $montosalida[$cont];
	            $detalle->concepto     = $concepto[$cont];
	            $detalle->save();
	            $cont=$cont+1;            
	        }
	        DB::commit();

        /*}catch(\Exception $e)
        {
          	DB::rollback();
        }*/
        return Redirect::to('administracion/caja');
    }

    public function show($id)
    {
    	$caja=DB::table('caja as c')
            ->select('c.idcaja','c.created_at','c.estado','c.totalingreso','c.totalsalida','c.totalsuma')
            ->where('c.idcaja','=',$id)
            ->first();

        $detalles=DB::table('detalle_caja as d')
          		->select('d.iddetalle_caja','d.caja','d.zonaingreso','d.ingreso','d.montoingreso','d.zonasalida','d.salida','d.montosalida','d.concepto')
             	->where('d.caja','=',$id)
             	->get();
        return view("administracion.caja.show",["caja"=>$caja,"detalles"=>$detalles]);
    }
    public function edit($id){ 

        $caja = DB::table('caja as v')
         ->select('v.idcaja','v.estado','v.total_caja','v.sena','v.cuota','v.fecha_cuota','v.saldo')
         ->where('v.idcaja','=',$id)
         ->first();    
        return view("cajas.caja.edit",["caja"=>$caja]);
    }
    
    public function reportec($id){
         //Obtengo los datos
        
        $caja=DB::table('caja as c')
            ->select('c.idcaja','c.created_at','c.estado','c.totalingreso','c.totalsalida','c.totalsuma')
            ->where('c.idcaja','=',$id)
            ->first();

        $detalles=DB::table('detalle_caja as d')
          	->select('d.iddetalle_caja','d.caja','d.zonaingreso','d.ingreso','d.montoingreso','d.zonasalida','d.salida','d.montosalida','d.concepto')
           	->where('d.caja','=',$id)
           	->get();


        $pdf = new Fpdf();
        $pdf::AddPage();
        $pdf::SetFont('Arial','B',14);
        //Inicio con el reporte
   		$pdf::SetXY(170,20);
        $pdf::Cell(0,0,utf8_decode('N° '.$caja->idcaja));

        $pdf::SetFont('Arial','B',14);
        //Inicio con el reporte
        $pdf::SetXY(170,40);
        $pdf::Cell(0,0,substr($caja->created_at,0,10));

        //***Parte de la derecha
        $pdf::SetXY(180,69);
        $pdf::setXY(10,78);
        $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
        $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
        $pdf::SetFont('Arial','B',10);
        $pdf::cell(10,8,utf8_decode("Cod"),1,"","L",true);
        $pdf::cell(10,8,utf8_decode("Z.ing"),1,"","L",true);
        $pdf::cell(20,8,utf8_decode("Ing"),1,"","L",true);
        $pdf::cell(30,8,utf8_decode("Monto Ing"),1,"","L",true);
        $pdf::cell(10,8,utf8_decode("Z.sal"),1,"","L",true);
        $pdf::cell(10,8,utf8_decode("Sal"),1,"","L",true);
        $pdf::cell(30,8,utf8_decode("Monto sal"),1,"","L",true);
        $pdf::cell(70,8,utf8_decode("Concepto"),1,"","L",true);

        //Mostramos los detalles
        $y=89;
        foreach($detalles as $det){
            $pdf::SetXY(10,$y);
            $pdf::MultiCell(10,0,$det->iddetalle_caja);

            $pdf::SetXY(20,$y);
            $pdf::MultiCell(120,0,utf8_decode($det->zonaingreso));

            $pdf::SetXY(30,$y);
            $pdf::MultiCell(25,0,utf8_decode($det->ingreso));

            $pdf::SetXY(50,$y);
            $pdf::MultiCell(120,0,utf8_decode($det->montoingreso));

            $pdf::SetXY(80,$y);
            $pdf::MultiCell(120,0,utf8_decode($det->zonasalida));

            $pdf::SetXY(95,$y);
            $pdf::MultiCell(120,0,utf8_decode($det->salida));

            $pdf::SetXY(105,$y);
            $pdf::MultiCell(120,0,utf8_decode($det->montosalida));

            $pdf::SetXY(130,$y);
            $pdf::MultiCell(120,0,utf8_decode($det->concepto));

           
            $y=$y+7;
        }

        $pdf::SetXY(187,153);
        $pdf::MultiCell(20,0,"$/. ".sprintf("%0.2F", $caja->totalingreso));
        $pdf::SetXY(187,160);
        $pdf::MultiCell(20,0,"$/. ".sprintf("%0.2F", $caja->totalsalida));
        $pdf::SetXY(187,167);
        $pdf::MultiCell(20,0,"$/. ".sprintf("%0.2F", $caja->totalsuma));

        $pdf::Output();
        exit;
    }
    public function report(){
         //Obtenemos los registros
            $registros=DB::table('caja as c')
            ->select('c.idcaja','c.created_at','c.estado','c.totalingreso','c.totalsalida','c.totalsuma')
            
            ->orderBy('c.idcaja','desc')
            ->get();

         //Ponemos la hoja Horizontal (L)
         $pdf = new Fpdf('L','mm','A4');
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado de cajas"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190        
         $pdf::cell(15,8,utf8_decode("Codigo"),1,"","L",true);
         $pdf::cell(40,8,utf8_decode("Fecha"),1,"","L",true);
         $pdf::cell(35,8,utf8_decode("Total Ingreso"),1,"","L",true);
         $pdf::cell(35,8,utf8_decode("Total Salida"),1,"","L",true);
         $pdf::cell(45,8,utf8_decode("Total Suma"),1,"","R",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $ingreso=0;
         $salida=0;
         $total=0;
         
         foreach ($registros as $reg)
         {
            $pdf::cell(15,8,utf8_decode($reg->idcaja),1,"","L",true);
            $pdf::cell(40,8,substr($reg->created_at,0,10),1,"","L",true);
            $pdf::cell(35,8,utf8_decode($reg->totalingreso),1,"","L",true);
            $pdf::cell(35,8,utf8_decode($reg->totalsalida),1,"","L",true);
            $pdf::cell(45,8,utf8_decode($reg->totalsuma),1,"","R",true);
            $ingreso=$ingreso+$reg->totalingreso;
            $salida=$salida+$reg->totalsalida;
            $total=$total+$reg->totalsuma;
            $pdf::Ln(); 
         }
         $pdf::cell(55,8,utf8_decode("TOTALES"),1,"","C",true);
         $pdf::cell(35,8,utf8_decode("Ing = ".$ingreso),1,"","C",true);
         $pdf::cell(35,8,utf8_decode("Sali = ".$salida),1,"","C",true);
         $pdf::cell(45,8,utf8_decode("Total Suma = ".$total),1,"","C",true);
         $pdf::Output();
         exit;

    }
    
    public function reporte(Request $request,$searchText){
         //Obtenemos los registros
        if($request){
            $query=trim($request->get('searchText'));
            $registros=DB::table('caja as c')
            ->select('c.idcaja','c.created_at','c.estado','c.totalingreso','c.totalsalida','c.totalsuma')
            ->where('c.idcaja','LIKE','%'.$searchText.'%')
            ->orwhere('c.created_at','LIKE','%'.$searchText.'%')
            ->orwhere('c.estado','LIKE','%'.$searchText.'%')
            ->orderBy('c.idcaja','desc')
            ->get();
        }
         
         //Ponemos la hoja Horizontal (L)
         $pdf = new Fpdf('L','mm','A4');
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado de cajas"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190        
         $pdf::cell(15,8,utf8_decode("Codigo"),1,"","L",true);
         $pdf::cell(40,8,utf8_decode("Fecha"),1,"","L",true);
         $pdf::cell(35,8,utf8_decode("Total Ingreso"),1,"","L",true);
         $pdf::cell(35,8,utf8_decode("Total Salida"),1,"","L",true);
         $pdf::cell(45,8,utf8_decode("Total Suma"),1,"","R",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $ingreso=0;
         $salida=0;
         $total=0;
         
         foreach ($registros as $reg)
         {
         	$pdf::cell(15,8,utf8_decode($reg->idcaja),1,"","L",true);
            $pdf::cell(40,8,substr($reg->created_at,0,10),1,"","L",true);
            $pdf::cell(35,8,utf8_decode($reg->totalingreso),1,"","L",true);
            $pdf::cell(35,8,utf8_decode($reg->totalsalida),1,"","L",true);
            $pdf::cell(45,8,utf8_decode($reg->totalsuma),1,"","R",true);
            $ingreso=$ingreso+$reg->totalingreso;
            $salida=$salida+$reg->totalsalida;
            $total=$total+$reg->totalsuma;
            $pdf::Ln(); 
         }
         $pdf::cell(55,8,utf8_decode("TOTALES"),1,"","C",true);
         $pdf::cell(35,8,utf8_decode("Ing = ".$ingreso),1,"","C",true);
         $pdf::cell(35,8,utf8_decode("Sali = ".$salida),1,"","C",true);
         $pdf::cell(45,8,utf8_decode("Total Suma = ".$total),1,"","C",true);
         $pdf::Output();
         exit;

    }

    
}
