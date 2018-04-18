<?php

namespace ConfiSis\Http\Controllers;

use Illuminate\Http\Request;

use ConfiSis\Http\Requests;

use ConfiSis\Salida;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use ConfiSis\Http\Requests\SalidaFormRequest;

use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

use Fpdf;


class SalidaController extends Controller
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
            $salidas=DB::table('salida as s')
            ->select('s.idsalida','s.created_at','s.zona','s.monto','s.concepto','s.observaciones','s.estado')
            ->where('s.zona','LIKE','%'.$query.'%')
            ->orwhere('s.created_at','LIKE','%'.$query.'%')
            ->orderBy('s.idsalida','asc')
            ->paginate(7);
            return view('administracion.salida.index',["salidas"=>$salidas,"searchText"=>$query]);
        }
    }
    public function create()
    {
        return view("administracion.salida.create");
    }
    public function store (SalidaFormRequest $request)
    {
        $salidas=new Salida;
     
        $salidas->zona=$request->get('zona');
        $salidas->monto=$request->get('monto');
        $salidas->concepto=$request->get('concepto');
        $salidas->observaciones=$request->get('observaciones');
        $salidas->estado='Pendiente';
        $salidas->save();
        return Redirect::to('administracion/salida');

    }
    public function show($id)
    {
        return view("administracion.salida.show",["salidas"=>Salida::findOrFail($id)]);
    }
    public function edit($id)
    {
        $salida=Salida::findOrFail($id);
        return view("administracion.salida.edit",["salida"=>$salida]);
    }
    
    
    public function update(SalidaFormRequest $request,$id)
    {
       
        $salidas=Salida::findOrFail($id);

        $salidas->zona=$request->get('zona');
        $salidas->monto=$request->get('monto');
        $salidas->concepto=$request->get('concepto');
        $salidas->observaciones=$request->get('observaciones');
        $salidas->estado=$request->get('estado');

        $salidas->update();
        return Redirect::to('administracion/salida');
    }
    public function reporte(){
         //Obtenemos los registros
         $registros=DB::table('salida as s')
            ->select('s.idsalida','s.created_at','s.zona','s.monto','s.concepto','s.observaciones','s.estado')
            ->orderBy('s.idsalida','asc')
            ->get();

         $pdf = new Fpdf();
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado de Salidas"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190        
         $pdf::cell(20,8,utf8_decode("Fecha"),1,"","L",true);
         $pdf::cell(40,8,utf8_decode("zona"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Monto"),1,"","L",true);
         $pdf::cell(50,8,utf8_decode("Concepto"),1,"","L",true);
         $pdf::cell(60,8,utf8_decode("Observaciones"),1,"","L",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $total=0;
         
         foreach ($registros as $reg)
         {
            $pdf::cell(20,6,substr($reg->created_at,0,10),1,"","L",true);
            $pdf::cell(40,6,utf8_decode($reg->zona),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->monto),1,"","L",true);
            $pdf::cell(50,6,utf8_decode($reg->concepto),1,"","L",true);
            $pdf::cell(60,6,utf8_decode($reg->observaciones),1,"","L",true);
            $total=$total+$reg->monto;
            $pdf::Ln(); 
         }
         $pdf::cell(190,8,utf8_decode("Salidas = ".$total),1,"","C",true);
         $pdf::Output();
         exit;
    }
    public function report(Request $request,$searchText){
         //Obtenemos los registros
         $registros=DB::table('salida as s')
            ->select('s.idsalida','s.created_at','s.zona','s.monto','s.concepto','s.observaciones','s.estado')
            ->where('s.zona','LIKE','%'.$searchText.'%')
            ->orwhere('s.created_at','LIKE','%'.$searchText.'%')
            ->orderBy('s.idsalida','asc')
            ->get();

         $pdf = new Fpdf();
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado de Salidas"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190        
         $pdf::cell(20,8,utf8_decode("Fecha"),1,"","L",true);
         $pdf::cell(40,8,utf8_decode("zona"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Monto"),1,"","L",true);
         $pdf::cell(50,8,utf8_decode("Concepto"),1,"","L",true);
         $pdf::cell(60,8,utf8_decode("Observaciones"),1,"","L",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $total=0;
         
         foreach ($registros as $reg)
         {
            $pdf::cell(20,6,substr($reg->created_at,0,10),1,"","L",true);
            $pdf::cell(40,6,utf8_decode($reg->zona),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->monto),1,"","L",true);
            $pdf::cell(50,6,utf8_decode($reg->concepto),1,"","L",true);
            $pdf::cell(60,6,utf8_decode($reg->observaciones),1,"","L",true);
            $total=$total+$reg->monto;
            $pdf::Ln(); 
         }
         $pdf::cell(190,8,utf8_decode("Salidas = ".$total),1,"","C",true);
         $pdf::Output();
         exit;
    }
}
