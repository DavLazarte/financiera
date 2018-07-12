<?php

namespace ConfiSis\Http\Controllers;

use Illuminate\Http\Request;

use ConfiSis\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use ConfiSis\Http\Requests\CobranzaFormRequest;
use ConfiSis\Cobranza;
use ConfiSis\Activo;
use DB;

use Fpdf;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class CobranzaController extends Controller
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
            $pagos=DB::table('cobranza as c')
            ->join('venta as v','c.idventa','=','v.idventa')
            ->join('persona as p','v.idpersona','=','p.idpersona')
            ->select('c.idcobranza','c.idventa','c.fecha_hora','c.zona','p.nombre_apellido','c.monto','c.estado')
            ->where('nombre_apellido','LIKE','%'.$query.'%')
            ->orwhere('c.idventa','LIKE','%'.$query.'%')
            ->orwhere('c.fecha_hora','LIKE','%'.$query.'%')
            ->orwhere('c.zona','LIKE','%'.$query.'%')
            ->orderBy('idcobranza','desc')
            ->paginate(10);
            return view('cobranza.pago.index',["pagos"=>$pagos,"searchText"=>$query]);
        }
    }
    public function create()
    {
    	$creditos=DB::table('activo as a')
    	->join('persona as p','a.cliente','=','p.nombre_apellido')
    	->select('p.nombre_apellido','a.cliente','a.idcredito','a.zona','a.saldo','a.proyeccion','a.vencimiento','a.estado')
    	->where('a.estado','=','Activo')
        ->orwhere('a.estado','=','Refinanciado')
    	->get();
        return view("cobranza.pago.create",["creditos"=>$creditos]);
    }
    public function store (CobranzaFormRequest $request)
    {
        $pago=new Cobranza;
        $pago->idventa=$request->get('idventa');
        $pago->fecha_hora=$request->get('fecha_hora');
        $pago->zona=$request->get('zona');
        $pago->monto=$request->get('monto');
        $pago->estado='Activo';       
        $pago->save();
        $activo=Activo::findOrFail($request->get('idventa'));
        //dd($activo->saldo);
        //dd($activo->saldo);
        if ($activo->saldo == 0.00) 
        {
            $activo->estado='Cancelado';
            $activo->update();
        }
        return back()->with('status','cargado');
    
        // if($request->ajax()){
        //     Cobranza::create($request->all());
        //     return response()->json([
        //         "mensaje" => "creado"
        //     ]);
            
        // }
        
    }
    public function edit($id)
    {
        $creditos=DB::table('activo as a')
        ->join('persona as p','a.cliente','=','p.nombre_apellido')
    	->select('p.nombre_apellido','a.cliente','a.idcredito','a.zona','a.saldo','a.proyeccion','a.vencimiento','a.estado')       
        ->where('a.estado','=','Activo')
        ->orwhere('a.estado','=','Refinanciado')
        ->get();
        return view("cobranza.pago.edit",["creditos"=>$creditos,"cobranza"=>Cobranza::findOrFail($id)]);
    }
    public function update(CobranzaFormRequest $request,$id)
    {
        $pago=Cobranza::findOrFail($id);

        $pago->idventa=$request->get('credito');
        $pago->fecha_hora=$request->get('fecha_hora');
        $pago->zona=$request->get('zona');
        $pago->monto=$request->get('monto');
        $pago->estado='Activo';           
        $pago->update();
        return Redirect::to('cobranza/pago');
    
    }
  
    public function destroy($id)
    {
        $pago=Cobranza::findOrFail($id);
        $pago->estado='Cancelado';
        $pago->update();
        return Redirect::to('cobranza/pago');
    }
    public function reporte(){
         //Obtenemos los registros
         $registros=DB::table('cobranza as c')
            ->join('venta as v','c.idventa','=','v.idventa')
            ->join('persona as p','v.idpersona','=','p.idpersona')
            ->select('c.idcobranza','c.idventa','c.fecha_hora','c.zona','p.nombre_apellido','c.monto','c.estado')
            ->orderBy('idcobranza','asc')
            ->get();

         $pdf = new Fpdf();
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado de Pagos"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190

         $pdf::cell(15,8,utf8_decode("Codigo"),1,"","L",true);
         $pdf::cell(15,8,utf8_decode("Credito"),1,"","L",true);
         $pdf::cell(25,8,utf8_decode("Fecha"),1,"","L",true);
         $pdf::cell(10,8,utf8_decode("Zona"),1,"","L",true);
         $pdf::cell(55,8,utf8_decode("Cliente"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Monto"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Estado"),1,"","L",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $pago=0;
         
         foreach ($registros as $reg)
         {
         	$pdf::cell(15,6,utf8_decode($reg->idcobranza),1,"","L",true);
            $pdf::cell(15,6,utf8_decode($reg->idventa),1,"","L",true);
            $pdf::cell(25,6,substr($reg->fecha_hora,0,10),1,"","L",true);
            $pdf::cell(10,6,utf8_decode($reg->zona),1,"","L",true);
            $pdf::cell(55,6,utf8_decode($reg->nombre_apellido),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->monto),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->estado),1,"","L",true);
            $pago=$pago+$reg->monto;
            $pdf::Ln(); 
         }
         $pdf::cell(160,8,utf8_decode("Cobranza = ".$pago),1,"","C",true);
         $pdf::Output();
         exit;
    }
    public function report(Request $request,$searchText){
         //Obtenemos los registros
         $registros=DB::table('cobranza as c')
            ->join('venta as v','c.idventa','=','v.idventa')
            ->join('persona as p','v.idpersona','=','p.idpersona')
            ->select('c.idcobranza','c.idventa','c.fecha_hora','c.zona','p.nombre_apellido','c.monto','c.estado')
            ->where('nombre_apellido','LIKE','%'.$searchText.'%')
            ->orwhere('c.idventa','LIKE','%'.$searchText.'%')
            ->orwhere('c.fecha_hora','LIKE','%'.$searchText.'%')
            ->orwhere('c.zona','LIKE','%'.$searchText.'%')
            ->orderBy('idcobranza','asc')
            ->get();

         $pdf = new Fpdf();
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado de Pagos"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190

         $pdf::cell(15,8,utf8_decode("Codigo"),1,"","L",true);
         $pdf::cell(15,8,utf8_decode("Credito"),1,"","L",true);
         $pdf::cell(25,8,utf8_decode("Fecha"),1,"","L",true);
         $pdf::cell(10,8,utf8_decode("Zona"),1,"","L",true);
         $pdf::cell(55,8,utf8_decode("Cliente"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Monto"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Estado"),1,"","L",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $pago=0;
         
         foreach ($registros as $reg)
         {
            $pdf::cell(15,6,utf8_decode($reg->idcobranza),1,"","L",true);
            $pdf::cell(15,6,utf8_decode($reg->idventa),1,"","L",true);
            $pdf::cell(25,6,substr($reg->fecha_hora,0,10),1,"","L",true);
            $pdf::cell(10,6,utf8_decode($reg->zona),1,"","L",true);
            $pdf::cell(55,6,utf8_decode($reg->nombre_apellido),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->monto),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->estado),1,"","L",true);
            $pago=$pago+$reg->monto;
            $pdf::Ln(); 
         }
         $pdf::cell(160,8,utf8_decode("Cobranza".$pago),1,"","C",true);
         $pdf::Output();
         exit;
    }  
}
