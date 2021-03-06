<?php

namespace ConfiSis\Http\Controllers;

use Illuminate\Http\Request;

use ConfiSis\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use ConfiSis\Http\Requests\ActivoFormRequest;
use ConfiSis\Activo;
use ConfiSis\Venta;
use DB;
use Datatables;
use Fpdf;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class ActivoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //index datatable
    public function listar_activo(){
        return view('venta.activo.index');
    }
    public function data_activo(){
        
        $activo = Activo::join('venta', 'activo.idcredito','=','venta.idventa')
        ->select('activo.idcredito','activo.zona','activo.cliente','activo.saldo','activo.proyeccion','activo.vencimiento','activo.estado');
        return Datatables::of($activo)
        
        ->addColumn('action', function($activo){
            return '<a href="editar_activo/'.$activo->idcredito.'" <button title="Editar" class="btn btn-info btn-sm"><i class="fa fa-pencil-square-o"></i></button> </a> <a href="reporte_activo/'.$activo->idcredito.'" <button title="imprimir" class="btn btn-warning btn-sm" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></button></a> <a href="refi_activo/'.$activo->idcredito.'" <button title="Refinanciar" class="btn btn-primary btn-sm"><i class="fa fa-calendar-times-o"></i></button</a> '; 
        })
        ->editColumn('vencimiento', function($activo) {
            return $activo->vencimiento ? with(new Carbon($activo->vencimiento))->format('d/m/Y') : '';
        })
        ->setRowClass(function ($activo){
            $vencimiento = new Carbon($activo->vencimiento);
            $hoy = Carbon::now();
            // dd($hoy, $vencimiento);
            if ($activo->saldo <= 0)
            {
                return $activo->saldo <= 0 ? 'alert-success':''; 
            }
            else
            {
                return ($hoy->greaterThan($vencimiento)) ? 'alert-danger' : '' ;
            }
            
        })
        ->make(true);  
    }
    public function vistactivo(Request $request)
    {
        if ($request)
        {
            $zona=trim($request->get('zona'));
            $activos=DB::table('activo as a')
            ->join('venta as v','a.idcredito','=','v.idventa')
            ->select('a.idcredito','a.zona','a.cliente','a.saldo','a.proyeccion','a.vencimiento','a.estado')
            ->where('a.zona','=',$zona)
            ->orderBy('idcredito','desc')
            ->get();
            return view('movimientos.activo',["activos"=>$activos,"zona"=>$zona]);
        }
    }
    public function create($id)
    {
        $venta=Venta::join('persona', 'venta.idpersona','=','persona.idpersona')
        ->select('venta.idventa','venta.fecha_hora','venta.zona','venta.idpersona','persona.nombre_apellido','venta.monto','venta.plan','venta.fecha_cancela','venta.concepto','venta.empleado','venta.estado')
        ->findOrFail($id);
        return view("venta.activo.create",["venta"=>$venta]);
    }
    public function store (ActivoFormRequest $request)
    {
        $activo=new Activo;

        $activo->idcredito=$request->get('idcredito');
        $activo->zona=$request->get('zona');
        $activo->cliente=$request->get('cliente');
        $activo->saldo=$request->get('saldo');
        $activo->proyeccion=$request->get('proyeccion');
        $activo->vencimiento=$request->get('vencimiento');
        $activo->estado='Activo';       
        $activo->save();
        return Redirect::to('listado_entrega')->with('status', 'Credito Activado');

    }
    public function edit($id)
    {
        $clientes=DB::table('persona')->where('tipo','=','Cliente')
        ->get();
        return view("venta.activo.edit",["clientes"=>$clientes,"activo"=>Activo::findOrFail($id)]);
    }
    public function update(ActivoFormRequest $request,$id)
    {
    	$activo=Activo::findOrFail($id);
      	$activo->zona=$request->get('zona');
        $activo->cliente=$request->get('cliente');
        $activo->saldo=$request->get('saldo');
        $activo->proyeccion=$request->get('proyeccion');
        $activo->vencimiento=$request->get('vencimiento'); 
        $activo->estado=$request->get('estado'); 
        $activo->update();
        return Redirect::to('listado_activo');
    
    }
  
    public function destroy(ActivoFormRequest $request,$id)
    {
    	//mejorar la eleccion de estados
        $activo=Activo::findOrFail($id);
        $activo->estado='Eliminado';
        $activo->update();
        return Redirect::to('listado_activo');
    }
    public function reporte($id){
         //Obtenemos los registros
         $registros=DB::table('activo as a')
            ->join('venta as v','a.idcredito','=','v.idventa')
            ->select('a.idcredito','a.zona','a.cliente','a.saldo','a.proyeccion','a.vencimiento','a.estado')
            ->where('a.idcredito','=',$id)
            ->orderBy('idcredito','desc')
            ->get();

         $pdf = new Fpdf('L','mm','A4');
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado de Creditos Activos "),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190

         $pdf::cell(20,8,utf8_decode("Credito"),1,"","L",true);
         $pdf::cell(10,8,utf8_decode("Zona"),1,"","L",true);
         $pdf::cell(45,8,utf8_decode("Cliente"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Saldo"),1,"","L",true);
         $pdf::cell(30,8,utf8_decode("Proyeccion"),1,"","L",true);
         $pdf::cell(30,8,utf8_decode("Vencimiento"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Estado"),1,"","L",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $saldo=0;
         
         foreach ($registros as $reg)
         {
            $pdf::cell(20,6,utf8_decode($reg->idcredito),1,"","L",true);
            $pdf::cell(10,6,utf8_decode($reg->zona),1,"","L",true);
            $pdf::cell(45,6,utf8_decode($reg->cliente),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->saldo),1,"","L",true);
            $pdf::cell(30,6,utf8_decode($reg->proyeccion),1,"","L",true);
            $pdf::cell(30,6,substr($reg->vencimiento,0,10),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->estado),1,"","L",true);
            $saldo=$saldo+$reg->saldo;
            $pdf::Ln(); 
         }
         $pdf::cell(175,8,utf8_decode("Total de Saldos= ".$saldo),1,"","C",true);
         $pdf::Output();
         exit;
    }

    public function report($zona){
         //Obtenemos los registros
         $registros=DB::table('activo as a')
         ->join('venta as v','a.idcredito','=','v.idventa')
         ->select('a.idcredito','a.zona','a.cliente','a.saldo','a.proyeccion','a.vencimiento','a.estado')
         ->where('a.zona','=',$zona)
         ->orderBy('idcredito','desc')
         ->get();

         $pdf = new Fpdf();
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado de Creditos Activos "),0,"","C");
         $pdf::Ln();
         $pdf::Cell(0,10,utf8_decode("ZONA: ".$zona),0,"","L");
         $pdf::Cell(0,10,utf8_decode("FECHA: ". Date('Y-m-d')),0,"","R");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190

         $pdf::cell(15,8,utf8_decode("Credito"),1,"","L",true);
         $pdf::cell(10,8,utf8_decode("Zona"),1,"","L",true);
         $pdf::cell(70,8,utf8_decode("Cliente"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Saldo"),1,"","L",true);
         $pdf::cell(15,8,utf8_decode("Proy"),1,"","L",true);
         $pdf::cell(30,8,utf8_decode("Vencimiento"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Estado"),1,"","L",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $saldo=0;
         
         foreach ($registros as $reg)
         {
            $pdf::cell(15,6,utf8_decode($reg->idcredito),1,"","L",true);
            $pdf::cell(10,6,utf8_decode($reg->zona),1,"","L",true);
            $pdf::cell(70,6,utf8_decode($reg->cliente),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->saldo),1,"","L",true);
            $pdf::cell(15,6,utf8_decode($reg->proyeccion),1,"","L",true);
            $pdf::cell(30,6,substr($reg->vencimiento,0,10),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->estado),1,"","L",true);
            $saldo=$saldo+$reg->saldo;
            $pdf::Ln(); 
         }
         $pdf::cell(180,8,utf8_decode("Saldos = ".$saldo),1,"","C",true);
         $pdf::Output();
         exit;
    }
     public function planilla(Request $request,$searchText){
         //Obtenemos los registros
         $registros=DB::table('activo as a')
            ->join('venta as v','a.idcredito','=','v.idventa')
            ->select('a.idcredito','a.zona','a.cliente','a.saldo','a.proyeccion','a.vencimiento','a.estado')
            ->where('cliente','LIKE','%'.$searchText.'%')
            ->where('a.estado','=','Activo')
            ->orwhere('idcredito','LIKE','%'.$searchText.'%')
            ->where('a.estado','=','Activo')
            ->orwhere('a.zona','LIKE','%'.$searchText.'%')
            ->where('a.estado','=','Activo')
            ->orwhere('a.estado','LIKE','%'.$searchText.'%')
            ->where('a.estado','=','Activo')
            ->orwhere('a.vencimiento','LIKE','%'.$searchText.'%')
            ->where('a.estado','=','Activo')
            ->orderBy('idcredito','desc')
            ->get();

         $pdf = new Fpdf('L','mm','A4');
         $pdf::AddPage();
         $pdf::SetMargins(10,10,5);
         $pdf::SetAutoPageBreak(true,10);
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Planilla de Cobranza "),0,"","C");
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190

         $pdf::cell(10,8,utf8_decode("n??"),1,"","L",true);
         $pdf::cell(45,8,utf8_decode("Cliente"),1,"","L",true);
         $pdf::cell(14,8,utf8_decode("L"),1,"","L",true);
         $pdf::cell(14,8,utf8_decode("M"),1,"","L",true);
         $pdf::cell(14,8,utf8_decode("Mi"),1,"","L",true);
         $pdf::cell(14,8,utf8_decode("J"),1,"","L",true);
         $pdf::cell(14,8,utf8_decode("V"),1,"","L",true);
         $pdf::cell(14,8,utf8_decode("S"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Saldo"),1,"","L",true);
         $pdf::cell(10,8,utf8_decode("Pro"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Vto"),1,"","L",true);
         
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         
         foreach ($registros as $reg)
         {
            $pdf::cell(10,6,utf8_decode($reg->idcredito),1,"","L",true);
            $pdf::cell(45,6,utf8_decode($reg->cliente),1,"","L",true);
            $pdf::cell(14,6,utf8_decode(" "),1,"","L",true);
            $pdf::cell(14,6,utf8_decode(" "),1,"","L",true);
            $pdf::cell(14,6,utf8_decode(" "),1,"","L",true);
            $pdf::cell(14,6,utf8_decode(" "),1,"","L",true);
            $pdf::cell(14,6,utf8_decode(" "),1,"","L",true);
            $pdf::cell(14,6,utf8_decode(" "),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->saldo),1,"","L",true);
            $pdf::cell(10,6,utf8_decode($reg->proyeccion),1,"","L",true);
            $pdf::cell(20,6,substr($reg->vencimiento,0,10),1,"","L",true);
            $pdf::Ln(); 
         }

         $pdf::Output();
         exit;
    }
}
