<?php

namespace ConfiSis\Http\Controllers;

use Illuminate\Http\Request;

use ConfiSis\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use ConfiSis\Http\Requests\ResumenFormRequest;
use ConfiSis\Resumen;
use DB;

use Fpdf;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class ResumenController extends Controller
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
            $resumenes=DB::table('resumen as r')
            ->select('r.idresumen','r.zona','r.ingreso_semana','r.salida_semana','r.anticipo','r.estado','r.created_at')
            ->where('r.zona','LIKE','%'.$query.'%')
            ->orwhere('r.idresumen','LIKE','%'.$query.'%')
            ->orderBy('idresumen','desc')
            ->paginate(7);
            return view('administracion.resumen.index',["resumenes"=>$resumenes,"searchText"=>$query]);
        }
    }
    public function create()
    {
    	$totales=DB::select('SELECT (select ifnull(sum(v.monto),0) from venta v  where week(v.fecha_hora)=week(curdate()) and v.zona="Z0") as salidaz0,(select ifnull(sum(v.monto),0) from venta v  where week(v.fecha_hora)=week(curdate()) and v.zona="Z1") as salidaz1,(select ifnull(sum(v.monto),0) from venta v  where week(v.fecha_hora)=week(curdate()) and v.zona="Z2") as salidaz2,(select ifnull(sum(v.monto),0) from venta v  where week(v.fecha_hora)=week(curdate()) and v.zona="Z3") as salidaz3,(select ifnull(sum(v.monto),0) from venta v  where week(v.fecha_hora)=week(curdate()) and v.zona="Z4") as salidaz4,(select ifnull(sum(v.monto),0) from venta v  where week(v.fecha_hora)=week(curdate()) and v.zona="Z5") as salidaz5,(select ifnull(sum(v.monto),0) from venta v  where week(v.fecha_hora)=week(curdate()) and v.zona="Z6") as salidaz6,(select ifnull(sum(c.monto),0) from cobranza c  where week(c.fecha_hora)=week(curdate()) and c.zona="Z0") as ingresoz0,(select ifnull(sum(c.monto),0) from cobranza c  where week(c.fecha_hora)=week(curdate()) and c.zona="Z1") as ingresoz1,(select ifnull(sum(c.monto),0) from cobranza c  where week(c.fecha_hora)=week(curdate()) and c.zona="Z2") as ingresoz2,(select ifnull(sum(c.monto),0) from cobranza c  where week(c.fecha_hora)=week(curdate()) and c.zona="Z3") as ingresoz3,(select ifnull(sum(c.monto),0) from cobranza c  where week(c.fecha_hora)=week(curdate()) and c.zona="Z4") as ingresoz4,(select ifnull(sum(c.monto),0) from cobranza c  where week(c.fecha_hora)=week(curdate()) and c.zona="Z5") as ingresoz5,(select ifnull(sum(c.monto),0) from cobranza c  where week(c.fecha_hora)=week(curdate()) and c.zona="Z6") as ingresoz6,(select ifnull(sum(s.monto),0) from salida s  where week(s.created_at)=week(curdate()) and s.concepto="Anticipo" and s.zona="Z0") as anticipoz0,(select ifnull(sum(s.monto),0) from salida s  where week(s.created_at)=week(curdate()) and s.concepto="Anticipo" and s.zona="Z1") as anticipoz1,(select ifnull(sum(s.monto),0) from salida s  where week(s.created_at)=week(curdate()) and s.concepto="Anticipo" and s.zona="Z2") as anticipoz2,(select ifnull(sum(s.monto),0) from salida s  where week(s.created_at)=week(curdate()) and s.concepto="Anticipo" and s.zona="Z3") as anticipoz3,(select ifnull(sum(s.monto),0) from salida s  where week(s.created_at)=week(curdate()) and s.concepto="Anticipo" and s.zona="Z4") as anticipoz4,(select ifnull(sum(s.monto),0) from salida s  where week(s.created_at)=week(curdate()) and s.concepto="Anticipo" and s.zona="Z5") as anticipoz5,(select ifnull(sum(s.monto),0) from salida s  where week(s.created_at)=week(curdate()) and s.concepto="Anticipo" and s.zona="Z6") as anticipoz6');

        return view("administracion.resumen.create",["totales"=>$totales]);
    }
    public function store (ResumenFormRequest $request)
    {
        $resumen=new Resumen;
        $resumen->zona=$request->get('zona');
        $resumen->ingreso_semana=$request->get('ingreso_semana');
        $resumen->salida_semana=$request->get('salida_semana');
        $resumen->anticipo=$request->get('anticipo');
        $resumen->estado='pendiente';       
        $resumen->save();
        return Redirect::to('administracion/resumen');

    }
    public function edit($id)
    {
        $resumens=DB::table('resumen')->get();
        return view("administracion.resumen.edit",["resumens"=>$resumens,"resumen"=>Resumen::findOrFail($id)]);
    }
    public function update(ResumenFormRequest $request,$id)
    {
        $resumen=Resumen::findOrFail($id);

        $resumen->zona=$request->get('zona');
        $resumen->ingreso_semana=$request->get('ingreso_semana');
        $resumen->salida_semana=$request->get('salida_semana');
        $resumen->anticipo=$request->get('anticipo');           
        $resumen->update();
        return Redirect::to('administracion/resumen');
    
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
         $registros=DB::table('resumen as r')
            ->select('r.idresumen','r.zona','r.ingreso_semana','r.salida_semana','r.anticipo','r.estado','r.created_at')
            ->orderBy('idresumen','desc')
            ->get();

         $pdf = new Fpdf();
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Resumenes"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190

         $pdf::cell(25,8,utf8_decode("Fecha"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Zona"),1,"","L",true);
         $pdf::cell(45,8,utf8_decode("Ingreso Semanal"),1,"","L",true);
         $pdf::cell(45,8,utf8_decode("Salida Semanal"),1,"","L",true);
         $pdf::cell(40,8,utf8_decode("Anticipo"),1,"","L",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $ingreso=0;
         $salida=0;
         $anticipo=0;
         
         foreach ($registros as $reg)
         {
            $pdf::cell(25,6,substr($reg->created_at,0,10),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->zona),1,"","L",true);
            $pdf::cell(45,6,utf8_decode($reg->ingreso_semana),1,"","L",true);
            $pdf::cell(45,6,utf8_decode($reg->salida_semana),1,"","L",true);
            $pdf::cell(40,6,utf8_decode($reg->anticipo),1,"","L",true);
            $ingreso=$ingreso+$reg->ingreso_semana;
            $salida=$salida+$reg->salida_semana;
            $anticipo=$anticipo+$reg->anticipo;
            $pdf::Ln(); 
         }
         $pdf::cell(45,8,utf8_decode("TOTALES"),1,"","C",true);
         $pdf::cell(45,8,utf8_decode("Ingresos = ".$ingreso),1,"","C",true);
         $pdf::cell(45,8,utf8_decode("Salidas = ".$salida),1,"","C",true);
         $pdf::cell(40,8,utf8_decode("Anticipos = ".$anticipo),1,"","C",true);

         $pdf::Output();
         exit;
    }
    public function report(Request $request,$searchText){
         //Obtenemos los registros
         $registros=DB::table('resumen as r')
            ->select('r.idresumen','r.zona','r.ingreso_semana','r.salida_semana','r.anticipo','r.estado','r.created_at')
            ->where('r.zona','LIKE','%'.$searchText.'%')
            ->orwhere('r.idresumen','LIKE','%'.$searchText.'%')
            ->orderBy('idresumen','desc')
            ->get();

        $pdf = new Fpdf();
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Resumenes"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190

         $pdf::cell(25,8,utf8_decode("Fecha"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Zona"),1,"","L",true);
         $pdf::cell(45,8,utf8_decode("Ingreso Semanal"),1,"","L",true);
         $pdf::cell(45,8,utf8_decode("Salida Semanal"),1,"","L",true);
         $pdf::cell(40,8,utf8_decode("Anticipo"),1,"","L",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         $ingreso=0;
         $salida=0;
         $anticipo=0;
         
         foreach ($registros as $reg)
         {
            $pdf::cell(25,6,substr($reg->created_at,0,10),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->zona),1,"","L",true);
            $pdf::cell(45,6,utf8_decode($reg->ingreso_semana),1,"","L",true);
            $pdf::cell(45,6,utf8_decode($reg->salida_semana),1,"","L",true);
            $pdf::cell(40,6,utf8_decode($reg->anticipo),1,"","L",true);
            $ingreso=$ingreso+$reg->ingreso_semana;
            $salida=$salida+$reg->salida_semana;
            $anticipo=$anticipo+$reg->anticipo;
            $pdf::Ln(); 
         }
         $pdf::cell(45,8,utf8_decode("TOTALES"),1,"","C",true);
         $pdf::cell(45,8,utf8_decode("Ingresos = ".$ingreso),1,"","C",true);
         $pdf::cell(45,8,utf8_decode("Salidas = ".$salida),1,"","C",true);
         $pdf::cell(40,8,utf8_decode("Anticipos = ".$anticipo),1,"","C",true);
         $pdf::Output();
         exit;
}
}
