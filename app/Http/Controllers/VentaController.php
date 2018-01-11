<?php

namespace ConfiSis\Http\Controllers;

use Illuminate\Http\Request;

use ConfiSis\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use ConfiSis\Http\Requests\VentaFormRequest;
use ConfiSis\Venta;
use DB;

use Fpdf;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class VentaController extends Controller
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
            $ventas=DB::table('venta as v')
            ->join('persona as p','v.idpersona','=','p.idpersona')
            ->select('v.idventa','v.fecha_hora','v.zona','v.idpersona','p.nombre_apellido','v.monto','v.plan','v.fecha_cancela','v.concepto','v.empleado','v.estado')
            ->where('nombre_apellido','LIKE','%'.$query.'%')
            ->orwhere('v.estado','LIKE','%'.$query.'%')
            ->orwhere('v.zona','LIKE','%'.$query.'%')
            ->orwhere('v.fecha_hora','LIKE','%'.$query.'%')
            ->orwhere('v.fecha_cancela','LIKE','%'.$query.'%')
            ->orwhere('idventa','LIKE','%'.$query.'%')
            ->orderBy('idventa','desc')
            ->paginate(7);
            return view('venta.entrega.index',["ventas"=>$ventas,"searchText"=>$query]);
        }
    }
    public function create()
    {
    	$clientes=DB::table('persona')->where('tipo','=','Cliente')
    	->get();
        return view("venta.entrega.create",["clientes"=>$clientes]);
    }
    public function store (VentaFormRequest $request)
    {
        /*$venta=new Venta;

        $venta->fecha_hora    = $request->get('fecha_hora');
        $venta->zona          = $request->get('zona');
        $venta->idpersona     = $request->get('cliente');
        $venta->monto         = $request->get('monto');
        $venta->plan          = $request->get('plan');
        $venta->fecha_cancela = $request->get('fecha_cancela');
        $venta->concepto      = $request->get('concepto');
        $venta->empleado      = $request->get('empleado');
        $venta->estado        = 'Pendiente';       
        $venta->save();
        return Redirect::to('venta/entrega');*/
        if($request->ajax()){
            Venta::create($request->all());
            return response()->json([
                "mensaje" => "creado"
            ]);
        }

    }
    public function edit($id)
    {
        $clientes=DB::table('persona')->where('tipo','=','Cliente')
        ->get();
        return view("venta.entrega.edit",["clientes"=>$clientes,"venta"=>Venta::findOrFail($id)]);
    }
    public function update(VentaFormRequest $request,$id)
    {
    	$venta=Venta::findOrFail($id);

        $venta->fecha_hora=$request->get('fecha_hora');
        $venta->zona=$request->get('zona');
        $venta->idpersona=$request->get('cliente');
        $venta->monto=$request->get('monto');
        $venta->plan=$request->get('plan');
        $venta->fecha_cancela=$request->get('fecha_cancela');
        $venta->concepto=$request->get('concepto');
        $venta->empleado=$request->get('empleado');      
        $venta->update();
        return Redirect::to('venta/entrega');
    
    }
  
    public function destroy($id)
    {
    //cambiar los tipos de estados
        $venta=Venta::findOrFail($id);
        $venta->estado='Activo';
        $venta->update();
        return Redirect::to('venta/entrega');
    }
    public function reporte(){
         //Obtenemos los registros
         $registros=DB::table('venta as v')
            ->join('persona as p','v.idpersona','=','p.idpersona')
            ->select('v.idventa','v.fecha_hora','v.zona','v.idpersona','p.nombre_apellido','v.monto','v.plan','v.fecha_cancela','v.concepto','v.empleado','v.estado')
            ->orderBy('idventa','desc')
            ->get();

         $pdf = new Fpdf();
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado de Entregas"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190

         $pdf::cell(20,8,utf8_decode("Inicio"),1,"","L",true);
         $pdf::cell(10,8,utf8_decode("Zona"),1,"","L",true);
         $pdf::cell(35,8,utf8_decode("Cliente"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Monto"),1,"","L",true);
         $pdf::cell(15,8,utf8_decode("Plan"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Vence"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Concepto"),1,"","L",true);
         $pdf::cell(15,8,utf8_decode("Entrega"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Estado"),1,"","L",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $total=0;
         
         foreach ($registros as $reg)
         {
         	$pdf::cell(20,6,substr($reg->fecha_hora,0,10),1,"","L",true);
            $pdf::cell(10,6,utf8_decode($reg->zona),1,"","L",true);
            $pdf::cell(35,6,utf8_decode($reg->nombre_apellido),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->monto),1,"","L",true);
            $pdf::cell(15,6,utf8_decode($reg->plan),1,"","L",true);
            $pdf::cell(20,6,substr($reg->fecha_cancela,0,10),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->concepto),1,"","L",true);
            $pdf::cell(15,6,utf8_decode($reg->empleado),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->estado),1,"","L",true);
            $total=$total+$reg->monto;
            $pdf::Ln(); 
         }
         $pdf::cell(175,8,utf8_decode("Total Entregas= ".$total),1,"","C",true);
         $pdf::Output();
         exit;
    }
    public function report(Request $request,$searchText){
         //Obtenemos los registros
         $registros=DB::table('venta as v')
            ->join('persona as p','v.idpersona','=','p.idpersona')
            ->select('v.idventa','v.fecha_hora','v.zona','v.idpersona','p.nombre_apellido','v.monto','v.plan','v.fecha_cancela','v.concepto','v.empleado','v.estado')
            ->where('nombre_apellido','LIKE','%'.$searchText.'%')
            ->orwhere('v.estado','LIKE','%'.$searchText.'%')
            ->orwhere('v.zona','LIKE','%'.$searchText.'%')
            ->orwhere('v.fecha_hora','LIKE','%'.$searchText.'%')
            ->orwhere('v.fecha_cancela','LIKE','%'.$searchText.'%')
            ->orwhere('idventa','LIKE','%'.$searchText.'%')
            ->orderBy('idventa','desc')
            ->get();

         $pdf = new Fpdf();
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado de Entregas"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190

         $pdf::cell(20,8,utf8_decode("Inicio"),1,"","L",true);
         $pdf::cell(10,8,utf8_decode("Zona"),1,"","L",true);
         $pdf::cell(35,8,utf8_decode("Cliente"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Monto"),1,"","L",true);
         $pdf::cell(15,8,utf8_decode("Plan"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Vence"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Concepto"),1,"","L",true);
         $pdf::cell(15,8,utf8_decode("Entrega"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Estado"),1,"","L",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $total=0;
         
         foreach ($registros as $reg)
         {
            $pdf::cell(20,6,substr($reg->fecha_hora,0,10),1,"","L",true);
            $pdf::cell(10,6,utf8_decode($reg->zona),1,"","L",true);
            $pdf::cell(35,6,utf8_decode($reg->nombre_apellido),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->monto),1,"","L",true);
            $pdf::cell(15,6,utf8_decode($reg->plan),1,"","L",true);
            $pdf::cell(20,6,substr($reg->fecha_cancela,0,10),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->concepto),1,"","L",true);
            $pdf::cell(15,6,utf8_decode($reg->empleado),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->estado),1,"","L",true);
            $total=$total+$reg->monto;
            $pdf::Ln(); 
         }
         $pdf::cell(175,8,utf8_decode("Entregas= ".$total),1,"","C",true);
         $pdf::Output();
         exit;
    }
}
