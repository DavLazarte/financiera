<?php

namespace ConfiSis\Http\Controllers;

use Illuminate\Http\Request;

use ConfiSis\Http\Requests;

use ConfiSis\Ingreso;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use ConfiSis\Http\Requests\IngresoFormRequest;

use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

use Fpdf;

class IngresoController extends Controller
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
            $ingresos=DB::table('ingreso as i')
            ->join('persona as p','i.empleado','=','p.idpersona')
            ->select('i.idingreso','i.zona','i.empleado','i.created_at','i.monto','i.concepto','i.estado','p.nombre_apellido')
            ->where('i.empleado','LIKE','%'.$query.'%')
            ->orwhere('i.created_at','LIKE','%'.$query.'%')
            ->orwhere('i.zona','LIKE','%'.$query.'%')
            ->orderBy('i.idingreso','asc')
            ->paginate(7);
            return view('administracion.ingreso.index',["ingresos"=>$ingresos,"searchText"=>$query]);
        }
    }
    public function create()
    {
    	$empleados=DB::table('persona')->where('tipo','=','Empleado')
    	->get();
        return view("administracion.ingreso.create",["empleados"=>$empleados]);
    }
    public function store (IngresoFormRequest $request)
    {
        $ingresos=new Ingreso;
     
        $ingresos->zona=$request->get('zona');
        $ingresos->empleado=$request->get('empleado');
        $ingresos->monto=$request->get('monto');
        $ingresos->concepto=$request->get('concepto');
        $ingresos->estado='activo';
        $ingresos->save();
        return Redirect::to('administracion/ingreso');

    }
   
    public function edit($id)
    {
        $ingreso=Ingreso::findOrFail($id);
        $empleados=DB::table('persona')->where('tipo','=','Empleado')
    	->get();
        return view("administracion.ingreso.edit",["empleados"=>$empleados,"ingreso"=>$ingreso]);
    }
    
    
    public function update(IngresoFormRequest $request,$id)
    {
       
        $ingresos=Ingreso::findOrFail($id);
        $ingresos->zona=$request->get('zona');
        $ingresos->empleado=$request->get('empleado');
        $ingresos->monto=$request->get('monto');
        $ingresos->concepto=$request->get('concepto');
        $ingresos->estado=$request->get('estado');

        $ingresos->update();
        return Redirect::to('administracion/ingreso');
    }
   public function reporte (){
         //Obtenemos los registros
         $registros=DB::table('ingreso as i')
            ->join('persona as p','i.empleado','=','p.idpersona')
            ->select('i.idingreso','i.zona','i.empleado','i.created_at','i.monto','i.concepto','i.estado','p.nombre_apellido')
            ->orderBy('i.idingreso','asc')
            ->get();

         $pdf = new Fpdf();
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado de ingresos"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190        
         $pdf::cell(20,8,utf8_decode("Fecha"),1,"","L",true);
         $pdf::cell(40,8,utf8_decode("Zona"),1,"","L",true);
         $pdf::cell(40,8,utf8_decode("Monto"),1,"","L",true);
         $pdf::cell(30,8,utf8_decode("Concepto"),1,"","L",true);
         $pdf::cell(60,8,utf8_decode("Empleado"),1,"","L",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $total=0;
         
         foreach ($registros as $reg)
         {
            $pdf::cell(20,6,substr($reg->created_at,0,10),1,"","L",true);
            $pdf::cell(40,6,utf8_decode($reg->zona),1,"","L",true);
            $pdf::cell(40,6,utf8_decode($reg->monto),1,"","L",true);
            $pdf::cell(30,6,utf8_decode($reg->concepto),1,"","L",true);
            $pdf::cell(60,6,utf8_decode($reg->nombre_apellido),1,"","L",true);
            $total=$total+$reg->monto;
            $pdf::Ln(); 
         }
         $pdf::cell(190,8,utf8_decode("Ingresos = ".$total),1,"","C",true);
         $pdf::Output();
         exit;
    }

    public function report(Request $request,$searchText){
         //Obtenemos los registros
         $registros=DB::table('ingreso as i')
            ->join('persona as p','i.empleado','=','p.idpersona')
            ->select('i.idingreso','i.zona','i.empleado','i.created_at','i.monto','i.concepto','i.estado','p.nombre_apellido')
            ->where('i.empleado','LIKE','%'.$searchText.'%')
            ->orwhere('i.created_at','LIKE','%'.$searchText.'%')
            ->orwhere('i.zona','LIKE','%'.$searchText.'%')
            ->orderBy('i.idingreso','asc')
            ->get();

         $pdf = new Fpdf();
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado de ingresos"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190        
         $pdf::cell(20,8,utf8_decode("Fecha"),1,"","L",true);
         $pdf::cell(40,8,utf8_decode("Zona"),1,"","L",true);
         $pdf::cell(40,8,utf8_decode("Monto"),1,"","L",true);
         $pdf::cell(30,8,utf8_decode("Concepto"),1,"","L",true);
         $pdf::cell(60,8,utf8_decode("Empleado"),1,"","L",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $total=0;
         
         foreach ($registros as $reg)
         {
            $pdf::cell(20,6,substr($reg->created_at,0,10),1,"","L",true);
            $pdf::cell(40,6,utf8_decode($reg->zona),1,"","L",true);
            $pdf::cell(40,6,utf8_decode($reg->monto),1,"","L",true);
            $pdf::cell(30,6,utf8_decode($reg->concepto),1,"","L",true);
            $pdf::cell(60,6,utf8_decode($reg->nombre_apellido),1,"","L",true);
            $total=$total+$reg->monto;
            $pdf::Ln(); 
         }
         $pdf::cell(190,8,utf8_decode("Ingresos = ".$total),1,"","C",true);
         $pdf::Output();
         exit;
    }
}
