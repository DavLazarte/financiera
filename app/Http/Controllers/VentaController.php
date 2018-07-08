<?php

namespace ConfiSis\Http\Controllers;

use Illuminate\Http\Request;

use ConfiSis\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use ConfiSis\Http\Requests\VentaFormRequest;
use ConfiSis\Venta;
use ConfiSis\Persona;
use DB;
use Datatables;

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
    //index datatable
    public function listar_entrega(){
        return view('venta.entrega.index');
    }
    public function data_entrega(){
        $venta = Venta::join('persona', 'venta.idpersona','=','persona.idpersona')
            ->select('venta.idventa','venta.fecha_hora','venta.zona','venta.idpersona','persona.nombre_apellido','venta.monto','venta.plan','venta.fecha_cancela','venta.concepto','venta.empleado','venta.estado')
            ->where('venta.estado','!=','Cancelado');
            return Datatables::of($venta)
            ->addColumn('action', function($venta){
                if ($venta->estado !=='PENDIENTE') {
                    return '<a href="editar_entrega/'.$venta->idventa.'" <button title="Editar" class="btn btn-info btn-sm"><i class="fa fa-pencil-square-o"></i></button></a>  <a href="eliminar_entrega/'.$venta->idventa.'" <button title="Eliminar" class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></button></a> <a href="reporte_entrega/'.$venta->idventa.'" <button title="imprimir" class="btn btn-warning btn-sm" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></button></a>';
                }
                else
                {
                    return '<a href="activar_entrega/'.$venta->idventa.'" <button title="Activar" class="btn btn-success btn-sm"><i class="fa fa-power-off" aria-hidden="true"></i></button></a> <a href="editar_entrega/'.$venta->idventa.'" <button title="Editar" class="btn btn-info btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> <a href="eliminar_entrega/'.$venta->idventa.'" <button title="Eliminar" class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></button></a> <a href="reporte_entrega/'.$venta->idventa.'" <button title="imprimir" class="btn btn-warning btn-sm" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></button></a>';
                }
            })
            ->editColumn('fecha_hora', function($venta) {
            return $venta->fecha_hora ? with(new Carbon($venta->fecha_hora))->format('m/d/Y') : '';
            })
            ->editColumn('fecha_cancela', function($venta) {
            return $venta->fecha_cancela ? with(new Carbon($venta->fecha_cancela))->format('m/d/Y') : '';
            })
            ->make(true);
    }
    public function vistaentrega(Request $request)
    {
        if ($request)
        {
            $zona=trim($request->get('zona'));
            $fecha=trim($request->get('fecha'));
            $ventas=DB::table('venta as v')
            ->join('persona as p','v.idpersona','=','p.idpersona')
            ->select('v.idventa','v.fecha_hora','v.zona','v.idpersona','p.nombre_apellido','v.monto','v.plan','v.fecha_cancela','v.concepto','v.empleado','v.estado')
            ->where('v.zona','=',$zona)
            ->where('v.fecha_hora','=',$fecha)
            ->orderBy('idventa','desc')
            ->get();
            return view('movimientos.entrega',["ventas"=>$ventas,"zona"=>$zona,"fecha"=>$fecha]);
        }
    }
    public function create()
    {
    	$clientes = DB::table('persona')->where('tipo','=','Cliente')
    	->get();
        return view("venta.entrega.create",["clientes"=>$clientes]);
    }
    public function store (VentaFormRequest $request)
    {
        // if($request->ajax()){
        //     Venta::create($request->all());
        //     return response()->json([
        //         "mensaje" => "creado"
        //     ]);
        // }
        //store sin ajax 
        $venta=new Venta;
        $venta->fecha_hora    = $request->get('fecha_hora');
        $venta->zona          = $request->get('zona');
        $venta->idpersona     = $request->get('cliente');
        $venta->monto         = $request->get('monto');
        $venta->plan          = $request->get('plan');
        $venta->fecha_cancela = $request->get('fecha_cancela');
        $venta->concepto      = $request->get('concepto');
        $venta->empleado      = $request->get('empleado');
        $venta->estado        = 'PENDIENTE';       
        $venta->save();
        return back()->with('status','cargado');
    }
    public function edit($id)
    {
        $clientes = Persona::where('tipo','=','Cliente')->get();
        $venta    = Venta::findOrFail($id);
        return view("venta.entrega.edit",["clientes"=>$clientes,"venta"=>$venta]);
    }
    public function update(VentaFormRequest $request,$id)
    {
    	$venta                = Venta::findOrFail($id);
        $venta->fecha_hora    = $request->get('fecha_hora');
        $venta->zona          = $request->get('zona');
        $venta->idpersona     = $request->get('cliente');
        $venta->monto         = $request->get('monto');
        $venta->plan          = $request->get('plan');
        $venta->fecha_cancela = $request->get('fecha_cancela');
        $venta->concepto      = $request->get('concepto');
        $venta->empleado      = $request->get('empleado');      
        $venta->update();
        return redirect('listado_entrega');
        //back()->with('info', 'Entrega cargada correctamente');
        //Redirect::to('venta/entrega');
    }
  
    public function destroy($id)
    {
    //cambiar los tipos de estados
        $venta         = Venta::findOrFail($id);
        $venta->estado = 'Cancelado';
        $venta->update();
        return redirect('listado_entrega')->with('status','Entrega Eliminada Correctamente');
    }
    
    public function reporte($id){
         //Obtenemos los registros
         $registros=DB::table('venta as v')
            ->join('persona as p','v.idpersona','=','p.idpersona')
            ->select('v.idventa','v.fecha_hora','v.zona','v.idpersona','p.nombre_apellido','v.monto','v.plan','v.fecha_cancela','v.concepto','v.empleado','v.estado')
            ->where('v.idventa','=',$id)
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
         $pdf::cell(55,8,utf8_decode("Cliente"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Monto"),1,"","L",true);
         $pdf::cell(10,8,utf8_decode("Plan"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Vence"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Concepto"),1,"","L",true);
         $pdf::cell(15,8,utf8_decode("Entrega"),1,"","L",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $total=0;
         
         foreach ($registros as $reg)
         {
         	$pdf::cell(20,6,substr($reg->fecha_hora,0,10),1,"","L",true);
            $pdf::cell(10,6,utf8_decode($reg->zona),1,"","L",true);
            $pdf::cell(55,6,utf8_decode($reg->nombre_apellido),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->monto),1,"","L",true);
            $pdf::cell(10,6,utf8_decode($reg->plan),1,"","L",true);
            $pdf::cell(20,6,substr($reg->fecha_cancela,0,10),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->concepto),1,"","L",true);
            $pdf::cell(15,6,utf8_decode($reg->empleado),1,"","L",true);
            $total = $total+$reg->monto;
            $pdf::Ln(); 
         }
         $pdf::cell(170,8,utf8_decode("TOTAL ENTREGAS = ".$total),1,"","C",true);
         $pdf::Output();
         exit;
    }
    public function report($zona, $fecha){
         //Obtenemos los registros
         //dd($zona, $fecha);
         $registros=DB::table('venta as v')
            ->join('persona as p','v.idpersona','=','p.idpersona')
            ->select('v.idventa','v.fecha_hora','v.zona','v.idpersona','p.nombre_apellido','v.monto','v.plan','v.fecha_cancela','v.concepto','v.empleado','v.estado')
            ->where('v.zona','=',$zona)        
            ->where('v.fecha_hora','=',$fecha)        
            ->orderBy('idventa','desc')
            ->get();

         $pdf = new Fpdf();
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado de Entregas"),0,"","C");
         $pdf::Ln();
         $pdf::Cell(0,10,utf8_decode("ZONA: ".$zona),0,"","L");
         $pdf::Cell(0,10,utf8_decode("FECHA: ".$fecha),0,"","R");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190

         $pdf::cell(20,8,utf8_decode("Inicio"),1,"","L",true);
         $pdf::cell(10,8,utf8_decode("Zona"),1,"","L",true);
         $pdf::cell(55,8,utf8_decode("Cliente"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Monto"),1,"","L",true);
         $pdf::cell(10,8,utf8_decode("Plan"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Vence"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Concepto"),1,"","L",true);
         $pdf::cell(15,8,utf8_decode("Entrega"),1,"","L",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $total=0;
         
         foreach ($registros as $reg)
         {
            $pdf::cell(20,6,substr($reg->fecha_hora,0,10),1,"","L",true);
            $pdf::cell(10,6,utf8_decode($reg->zona),1,"","L",true);
            $pdf::cell(55,6,utf8_decode($reg->nombre_apellido),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->monto),1,"","L",true);
            $pdf::cell(10,6,utf8_decode($reg->plan),1,"","L",true);
            $pdf::cell(20,6,substr($reg->fecha_cancela,0,10),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->concepto),1,"","L",true);
            $pdf::cell(15,6,utf8_decode($reg->empleado),1,"","L",true);
            $total = $total+$reg->monto;
            $pdf::Ln(); 
         }
         $pdf::cell(170,8,utf8_decode("MONTO TOTAL DE ENTREGAS = ".$total),1,"","C",true);
         $pdf::Output();
         exit;
    }
}
