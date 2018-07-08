<?php

namespace ConfiSis\Http\Controllers;

use Illuminate\Http\Request;

use ConfiSis\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use ConfiSis\Http\Requests\RefinanciacionFormRequest;
use ConfiSis\Refinanciacion;
use ConfiSis\Activo;
use DB;

use Fpdf;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class RefinanciacionController extends Controller
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
            $refinanciaciones=DB::table('refinanciacion as r')
            ->join('venta as v','r.credito','=','v.idventa')
            ->join('persona as p','r.cliente','=','p.nombre_apellido')
            ->select('r.idrefinanciacion','v.zona','r.credito','r.created_at','r.cliente','p.nombre_apellido','r.saldo','r.plan','r.vencimiento','r.estado')
            ->where('credito','LIKE','%'.$query.'%')
            ->orwhere('v.zona','LIKE','%'.$query.'%')
            ->orwhere('r.created_at','LIKE','%'.$query.'%')
            ->orwhere('r.vencimiento','LIKE','%'.$query.'%')
            ->orwhere('r.estado','LIKE','%'.$query.'%')
            ->where('r.estado','=','Activo')
            ->orderBy('idrefinanciacion','desc')
            ->paginate(7);
            return view('venta.refinanciacion.index',["refinanciaciones"=>$refinanciaciones,"searchText"=>$query]);
        }
    }
    public function create($id)
    {
    	$clientes = DB::table('persona')->where('tipo','=','Cliente')
        ->get();
        $activo   = Activo::findOrFail($id);
        
        return view("venta.refinanciacion.create",["clientes"=>$clientes,"activo"=>$activo]);
    }
    public function store (RefinanciacionFormRequest $request)
    {
        $refinanciacion=new Refinanciacion;

        $refinanciacion->credito=$request->get('credito');
        $refinanciacion->cliente=$request->get('cliente');
        $refinanciacion->saldo=$request->get('saldo');
        $refinanciacion->plan=$request->get('plan');
        $refinanciacion->vencimiento=$request->get('vencimiento');
        $refinanciacion->estado='Activo';       
        $refinanciacion->save();
        return Redirect::to('venta/refinanciacion');

    }
    public function edit($id)
    {
        $clientes=DB::table('persona')->where('tipo','=','Cliente')
        ->get();
        return view("venta.refinanciacion.edit",["clientes"=>$clientes,"refinanciacion"=>Refinanciacion::findOrFail($id)]);
    }
    public function update(RefinanciacionFormRequest $request,$id)
    {
    	$refinanciacion=Refinanciacion::findOrFail($id);
        $refinanciacion->cliente=$request->get('cliente');
        $refinanciacion->saldo=$request->get('saldo');
        $refinanciacion->plan=$request->get('plan');
        $refinanciacion->vencimiento=$request->get('vencimiento');
        $refinanciacion->estado='Activo';       
        $refinanciacion->update();
        return Redirect::to('venta/refinanciacion');
    
    }
  
    public function destroy(RefinanciacionFormRequest $request,$id)
    {
        $refinanciacion=Refinanciacion::findOrFail($id);
        $refinanciacion->estado=$request->get('estado');
        $refinanciacion->update();
        return Redirect::to('venta/refinanciacion');
    }
    public function reporte(){
         //Obtenemos los registros
         $registros=DB::table('refinanciacion as r')
            ->join('venta as v','r.credito','=','v.idventa')
            ->join('persona as p','r.cliente','=','p.nombre_apellido')
            ->select('r.idrefinanciacion','v.zona','r.credito','r.created_at','r.cliente','p.nombre_apellido','r.saldo','r.plan','r.vencimiento','r.estado')
            ->orderBy('idrefinanciacion','desc')
            ->get();

         $pdf = new Fpdf();
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado de Creditos Refinanciados"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190

         $pdf::cell(20,8,utf8_decode("Codigo"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Inicio"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Credito"),1,"","L",true);
         $pdf::cell(10,8,utf8_decode("Zona"),1,"","L",true);
         $pdf::cell(35,8,utf8_decode("Cliente"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Saldo"),1,"","L",true);
         $pdf::cell(10,8,utf8_decode("Plan"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Vencimiento"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Estado"),1,"","L",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $saldo=0;
         
         foreach ($registros as $reg)
         {
            $pdf::cell(20,6,utf8_decode($reg->idrefinanciacion),1,"","L",true);
         	$pdf::cell(20,6,substr($reg->created_at,0,10),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->credito),1,"","L",true);
            $pdf::cell(10,6,utf8_decode($reg->zona),1,"","L",true);
            $pdf::cell(35,6,utf8_decode($reg->cliente),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->saldo),1,"","L",true);
            $pdf::cell(10,6,utf8_decode($reg->plan),1,"","L",true);
            $pdf::cell(20,6,substr($reg->vencimiento,0,10),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->estado),1,"","L",true);
            $saldo=$saldo+$reg->saldo;
            $pdf::Ln(); 
         }
         $pdf::cell(175,8,utf8_decode("Saldos= ".$saldo),1,"","C",true);
         $pdf::Output();
         exit;
    }

    public function report(Request $request,$searchText){
         //Obtenemos los registros
         $registros=DB::table('refinanciacion as r')
            ->join('venta as v','r.credito','=','v.idventa')
            ->join('persona as p','r.cliente','=','p.nombre_apellido')
            ->select('r.idrefinanciacion','v.zona','r.credito','r.created_at','r.cliente','p.nombre_apellido','r.saldo','r.plan','r.vencimiento','r.estado')
            ->where('credito','LIKE','%'.$searchText.'%')
            ->orwhere('v.zona','LIKE','%'.$searchText.'%')
            ->orwhere('r.created_at','LIKE','%'.$searchText.'%')
            ->orwhere('r.vencimiento','LIKE','%'.$searchText.'%')
            ->orwhere('r.estado','LIKE','%'.$searchText.'%')
            ->where('r.estado','=','Activo')
            ->orderBy('idrefinanciacion','desc')
            ->get();

         $pdf = new Fpdf();
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado de Creditos Refinanciados"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190

         $pdf::cell(20,8,utf8_decode("Codigo"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Inicio"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Credito"),1,"","L",true);
         $pdf::cell(10,8,utf8_decode("Zona"),1,"","L",true);
         $pdf::cell(35,8,utf8_decode("Cliente"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Saldo"),1,"","L",true);
         $pdf::cell(10,8,utf8_decode("Plan"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Vencimiento"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Estado"),1,"","L",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $saldo=0;
         
         foreach ($registros as $reg)
         {
            $pdf::cell(20,6,utf8_decode($reg->idrefinanciacion),1,"","L",true);
            $pdf::cell(20,6,substr($reg->created_at,0,10),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->credito),1,"","L",true);
            $pdf::cell(10,6,utf8_decode($reg->zona),1,"","L",true);
            $pdf::cell(35,6,utf8_decode($reg->cliente),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->saldo),1,"","L",true);
            $pdf::cell(10,6,utf8_decode($reg->plan),1,"","L",true);
            $pdf::cell(20,6,substr($reg->vencimiento,0,10),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->estado),1,"","L",true);
            $saldo=$saldo+$reg->saldo;
            $pdf::Ln(); 
         }
         $pdf::cell(175,8,utf8_decode("Saldos= ".$saldo),1,"","C",true);
         $pdf::Output();
         exit;
    }
}
