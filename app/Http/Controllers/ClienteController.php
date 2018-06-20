<?php

namespace ConfiSis\Http\Controllers;

use Illuminate\Http\Request;

use ConfiSis\Http\Requests;
use ConfiSis\Persona;
use Illuminate\Support\Facades\Redirect;
use ConfiSis\Http\Requests\PersonaFormRequest;
use DB;
use Datatables;
use Fpdf;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //Cargar las datatables
    public function listar_cliente(){
        return view('persona.cliente.index');

    }
    //pasar datos a las datatables
    public function data_cliente(){
        $persona = Persona::where([
            ['tipo','=','Cliente'],
            ['estado','=', 'Activo']
            ])->get();
        return Datatables::of($persona)->make(true);
    }
    public function create()
    {
        return view("persona.cliente.create");
    }
    public function store (PersonaFormRequest $request)
    {
        //corregir el response
        if($request->ajax()){
            Persona::create($request->all());
            return response()->json([
                "mensaje" => "creado"
                ]);
            }
        /* 
        codigo sin ajax 
        $persona=new Persona;
        $persona->nombre_apellido=$request->get('nombre_apellido');
        $persona->dni=$request->get('dni');
        $persona->domicilio=$request->get('domicilio');
        $persona->telefono=$request->get('telefono');
        $persona->tipo='Cliente';
        $persona->estado='Activo';       
        $persona->save();
        return Redirect::to('persona/cliente');
        */
    }
    public function edit($id)
    {
        return view("persona.cliente.edit",["persona"=>Persona::findOrFail($id)]);
    }
    public function update(PersonaFormRequest $request,$id)
    {
        $persona                  = Persona::findOrFail($id);
        $persona->nombre_apellido = $request->get('nombre_apellido');
        $persona->dni             = $request->get('dni');
        $persona->domicilio       = $request->get('domicilio');
        $persona->telefono        = $request->get('telefono');
        $persona->update();
        return Redirect::to('persona/cliente');
    }

    public function destroy($id)
    {
        $persona          = Persona::findOrFail($id);
        $persona->estado  = 'Inactivo';
        $persona->update();
        return Redirect::to('persona/cliente');
    }
    
    public function reporte(){
         //Obtenemos los registros
         $registros = DB::table('persona')
            ->where ('tipo','=','Cliente')
            ->orderBy('idpersona','asc')
            ->get();
         $pdf = new Fpdf();
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado Clientes"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190   
         $pdf::cell(10,8,utf8_decode("Cod"),1,"","L",true);     
         $pdf::cell(60,8,utf8_decode("Nombre"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Doc"),1,"","L",true);
         $pdf::cell(80,8,utf8_decode("Domicilio"),1,"","L",true);
         $pdf::cell(20,8,utf8_decode("Teléfono"),1,"","L",true);
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         foreach ($registros as $reg)
         {
            $pdf::cell(10,6,utf8_decode($reg->idpersona),1,"","L",true);
            $pdf::cell(60,6,utf8_decode($reg->nombre_apellido),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->dni),1,"","L",true);
            $pdf::cell(80,6,utf8_decode($reg->domicilio),1,"","L",true);
            $pdf::cell(20,6,utf8_decode($reg->telefono),1,"","L",true);
            $pdf::Ln(); 
         }
         $pdf::Output();
         exit;
    }
}
