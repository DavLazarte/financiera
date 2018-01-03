<?php

namespace ConfiSis\Http\Controllers;

use Illuminate\Http\Request;

use ConfiSis\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use ConfiSis\Http\Requests\LiquidacionFormRequest;
use ConfiSis\Liquidacion;
use ConfiSis\Detalle_liquidacion;
use DB;
use Fpdf;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;


class LiquidacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if ($request)
        {
           $query=trim($request->get('searchText'));
           $liquidaciones=DB::table('liquidacion as l')
            ->select('l.idliquidacion','l.empleado','l.periodo','l.totalrec','total_comision','l.total','l.estado','l.created_at')
            ->where('l.idliquidacion','LIKE','%'.$query.'%')
            ->orwhere('l.created_at','LIKE','%'.$query.'%')
            ->orwhere('l.estado','LIKE','%'.$query.'%')
            ->orderBy('l.idliquidacion','desc')
            ->paginate(10);
            return view('administracion.liquidacion.index',["liquidaciones"=>$liquidaciones,"searchText"=>$query]);

        }
    }
    public function create()
    {
        $empleados=DB::table('persona as p')
        ->select('p.idpersona','p.nombre_apellido')
        ->where('tipo','=','empleado')
        ->get();
    	$resumenes=DB::table('resumen')->where('estado','=','pendiente')->get();
        return view("administracion.liquidacion.create",["resumenes"=>$resumenes,"empleados"=>$empleados]);
    }

     public function store (LiquidacionFormRequest $request)
    {
    	try{
        	DB::beginTransaction();
        	$liquidacion=new Liquidacion;
        	$liquidacion->empleado=$request->get('empleado');
        	$liquidacion->periodo=$request->get('periodo');
        	$liquidacion->totalrec=$request->get('totalrec');
        	$liquidacion->total_comision=$request->get('total_comision');
	        $liquidacion->total=$request->get('total');
            $liquidacion->estado='Pendiente';
	        $liquidacion->save();

	        $zona = $request->get('zona');
	        $fecha_inicio = $request->get('fecha_inicio');
	        $fecha_fin = $request->get('fecha_fin');
	        $cobranza = $request->get('cobranza');
	        $comision = $request->get('comision');
	        $anticipo = $request->get('anticipo');
	        $premio = $request->get('premio');
	        $cont = 0;

	        while($cont < count($zona))
	        {
	            $detalle = new Detalle_liquidacion();
	            $detalle->idliquidacion = $liquidacion->idliquidacion;
	            $detalle->zona= $zona[$cont]; 
	            $detalle->fecha_inicio= $fecha_inicio[$cont]; 
	            $detalle->fecha_fin= $fecha_fin[$cont];
	            $detalle->cobranza= $cobranza[$cont];
	            $detalle->comision= $comision[$cont];
	            $detalle->anticipo= $anticipo[$cont];
	            $detalle->premio= $premio[$cont];
	            $detalle->save();
	            $cont=$cont+1;            
	        }
	        DB::commit();
        }catch(\Exception $e)
        {
            DB::rollback();
        }
        return Redirect::to('administracion/liquidacion');
    }

    public function show($id)
    {
    	$liquidacion=DB::table('liquidacion as l')
            ->select('l.idliquidacion','l.empleado','l.periodo','l.totalrec','total_comision','l.total','l.estado','l.created_at')
            ->where('l.idliquidacion','=',$id)
            ->first();

        $detalles=DB::table('Detalle_liquidacion as d')
          		->select('d.iddetalle_liquidacion','d.idliquidacion','d.zona','d.fecha_inicio','d.fecha_fin','d.cobranza','d..comision','d.anticipo','d.premio')
             	->where('d.idliquidacion','=',$id)
             	->get();
        return view("administracion.liquidacion.show",["liquidacion"=>$liquidacion,"detalles"=>$detalles]);
    }

    public function reportec($id){        
        $liquidacion=DB::table('liquidacion as l')
            ->select('l.idliquidacion','l.empleado','l.periodo','l.totalrec','total_comision','l.total','l.estado','l.created_at')
            ->where('l.idliquidacion','=',$id)
            ->first();

        $detalles=DB::table('Detalle_liquidacion as d')
                ->select('d.iddetalle_liquidacion','d.idliquidacion','d.zona','d.fecha_inicio','d.fecha_fin','d.cobranza','d..comision','d.anticipo','d.premio')
                ->where('d.idliquidacion','=',$id)
                ->get();


        $pdf = new Fpdf();
        $pdf::AddPage();
        $pdf::SetFont('Arial','B',14);
        //Inicio con el reporte
         $pdf::SetXY(70,10);
        $pdf::Cell(0,0,utf8_decode('LIQUIDACION DE COMISIONES'));
        $pdf::SetXY(10,20);
        $pdf::Cell(0,0,utf8_decode('PERIODO: '.$liquidacion->periodo));
   		$pdf::SetXY(10,30 );
        $pdf::Cell(0,0,utf8_decode('COD: '.$liquidacion->idliquidacion));
        $pdf::SetXY(10,50 );
        $pdf::Cell(0,0,utf8_decode('EMPLEADO: '.$liquidacion->empleado));

        $pdf::SetFont('Arial','B',14);
        //Inicio con el reporte
        $pdf::SetXY(10,40);
        $pdf::Cell(0,0,substr('EMISION: '.$liquidacion->created_at,0,20));

        //***Parte de la derecha
        $pdf::SetXY(180,69);
        $pdf::setXY(10,78);
        $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
        $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
        $pdf::SetFont('Arial','B',10);
        $pdf::cell(10,8,utf8_decode("Cod"),1,"","L",true);
        $pdf::cell(10,8,utf8_decode("Zona"),1,"","L",true);
        $pdf::cell(25,8,utf8_decode("Inicio"),1,"","L",true);
        $pdf::cell(25,8,utf8_decode("Fin"),1,"","L",true);
        $pdf::cell(30,8,utf8_decode("Cobranza"),1,"","L",true);
        $pdf::cell(30,8,utf8_decode("Comision"),1,"","L",true);
        $pdf::cell(30,8,utf8_decode("Anticipio"),1,"","L",true);
        $pdf::cell(30,8,utf8_decode("Premio"),1,"","L",true);

        //Mostramos los detalles
        $y=89;
        foreach($detalles as $det){
            $pdf::SetXY(10,$y);
            $pdf::MultiCell(10,0,$det->iddetalle_liquidacion);

            $pdf::SetXY(20,$y);
            $pdf::MultiCell(120,0,utf8_decode($det->zona));

            $pdf::SetXY(30,$y);
            $pdf::MultiCell(25,0,substr($det->fecha_inicio,0,10));

            $pdf::SetXY(55,$y);
            $pdf::MultiCell(120,0,substr($det->fecha_fin,0,10));

            $pdf::SetXY(80,$y);
            $pdf::MultiCell(120,0,utf8_decode($det->cobranza));

            $pdf::SetXY(110,$y);
            $pdf::MultiCell(120,0,utf8_decode($det->comision));

            $pdf::SetXY(140,$y);
            $pdf::MultiCell(120,0,utf8_decode($det->anticipo));

            $pdf::SetXY(170,$y);
            $pdf::MultiCell(120,0,utf8_decode($det->premio));

           
            $y=$y+7;
        }

        $pdf::SetXY(160,153);
        $pdf::MultiCell(60,0,"Recaudacion: $ ".sprintf("%0.2F", $liquidacion->totalrec));
        $pdf::SetXY(160,160);
        $pdf::MultiCell(60,0,"Comision: $ ".sprintf("%0.2F", $liquidacion->total_comision));
        $pdf::SetXY(160,167);
        $pdf::MultiCell(60,0,"Total c/ Descuento: $ ".sprintf("%0.2F", $liquidacion->total));

        $pdf::Output();
        exit;
    }
    public function report(){
         //Obtenemos los registros
            $registros=DB::table('liquidacion as l')
            ->select('l.idliquidacion','l.empleado','l.periodo','l.totalrec','total_comision','l.total','l.estado','l.created_at')
            ->orderBy('l.idliquidacion','desc')
            ->get();
         
         //Ponemos la hoja Horizontal (L)
         $pdf = new Fpdf('L','mm','A4');
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado de liquidaciones"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190        
         $pdf::cell(15,8,utf8_decode("Codigo"),1,"","L",true);
         $pdf::cell(40,8,utf8_decode("Periodo"),1,"","L",true);
         $pdf::cell(35,8,utf8_decode("Total Recaudacion"),1,"","L",true);
         $pdf::cell(35,8,utf8_decode("Total Comision"),1,"","L",true);
         $pdf::cell(45,8,utf8_decode("Total"),1,"","R",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $recaudacion=0;
         $comision=0;
         $total=0;
         
         foreach ($registros as $reg)
         {
            $pdf::cell(15,8,utf8_decode($reg->idliquidacion),1,"","L",true);
            $pdf::cell(40,8,utf8_decode($reg->periodo),1,"","L",true);
            $pdf::cell(35,8,utf8_decode($reg->totalrec),1,"","L",true);
            $pdf::cell(35,8,utf8_decode($reg->total_comision),1,"","L",true);
            $pdf::cell(45,8,utf8_decode($reg->total),1,"","R",true);
            $recaudacion=$recaudacion+$reg->totalrec;
            $comision=$comision+$reg->total_comision;
            $total=$total+$reg->total;
            $pdf::Ln(); 
         }
         $pdf::cell(55,8,utf8_decode("TOTALES"),1,"","C",true);
         $pdf::cell(35,8,utf8_decode("Rec = ".$recaudacion),1,"","C",true);
         $pdf::cell(35,8,utf8_decode("Com = ".$comision),1,"","C",true);
         $pdf::cell(45,8,utf8_decode("Liquidacion = ".$total),1,"","C",true);
         $pdf::Output();
         exit;

    }

    public function reporte(Request $request,$searchText){
         //Obtenemos los registros
        if($request){
            $query=trim($request->get('searchText'));
            $registros=DB::table('liquidacion as l')
            ->select('l.idliquidacion','l.empleado','l.periodo','l.totalrec','total_comision','l.total','l.estado','l.created_at')
            ->where('l.idliquidacion','LIKE','%'.$searchText.'%')
            ->orwhere('l.created_at','LIKE','%'.$searchText.'%')
            ->orwhere('l.estado','LIKE','%'.$searchText.'%')
            ->orderBy('l.idliquidacion','desc')
            ->get();
        }
         
         //Ponemos la hoja Horizontal (L)
         $pdf = new Fpdf('L','mm','A4');
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado de liquidaciones"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190        
         $pdf::cell(15,8,utf8_decode("Codigo"),1,"","L",true);
         $pdf::cell(40,8,utf8_decode("Periodo"),1,"","L",true);
         $pdf::cell(35,8,utf8_decode("Total Recaudacion"),1,"","L",true);
         $pdf::cell(35,8,utf8_decode("Total Comision"),1,"","L",true);
         $pdf::cell(45,8,utf8_decode("Total"),1,"","R",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $recaudacion=0;
         $comision=0;
         $total=0;
         
         foreach ($registros as $reg)
         {
         	$pdf::cell(15,8,utf8_decode($reg->idliquidacion),1,"","L",true);
            $pdf::cell(40,8,utf8_decode($reg->periodo),1,"","L",true);
            $pdf::cell(35,8,utf8_decode($reg->totalrec),1,"","L",true);
            $pdf::cell(35,8,utf8_decode($reg->total_comision),1,"","L",true);
            $pdf::cell(45,8,utf8_decode($reg->total),1,"","R",true);
            $recaudacion=$recaudacion+$reg->totalrec;
            $comision=$comision+$reg->total_comision;
            $total=$total+$reg->total;
            $pdf::Ln(); 
         }
         $pdf::cell(55,8,utf8_decode("TOTALES"),1,"","C",true);
         $pdf::cell(35,8,utf8_decode("Rec = ".$recaudacion),1,"","C",true);
         $pdf::cell(35,8,utf8_decode("Com = ".$comision),1,"","C",true);
         $pdf::cell(45,8,utf8_decode("Liquidacion = ".$total),1,"","C",true);
         $pdf::Output();
         exit;

    }

}
