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
    public function index()
    {

        $personas = Persona::all();
        return view('persona.cliente.index',["personas"=>$personas]);
    
    }
    public function create()
    {
        return view("persona.cliente.create");
    }
    public function store (PersonaFormRequest $request)
    {
        $persona=new Persona;
        $persona->nombre_apellido=$request->get('nombre_apellido');
        $persona->dni=$request->get('dni');
        $persona->domicilio=$request->get('domicilio');
        $persona->telefono=$request->get('telefono');
        $persona->tipo='Cliente';
        $persona->estado='Activo';       
        $persona->save();
        return Redirect::to('persona/cliente');

    }
    public function show($id)
    {
        return view("persona.cliente.show",["persona"=>Persona::findOrFail($id)]);
    }
    public function edit($id)
    {
        return view("persona.cliente.edit",["persona"=>Persona::findOrFail($id)]);
    }
    public function update(PersonaFormRequest $request,$id)
    {
        $persona=Persona::findOrFail($id);

        $persona->nombre_apellido=$request->get('nombre_apellido');
        $persona->dni=$request->get('dni');
        $persona->domicilio=$request->get('domicilio');
        $persona->telefono=$request->get('telefono');
        $persona->update();
        return Redirect::to('persona/cliente');
    }

    public function destroy($id)
    {
        $persona=Persona::findOrFail($id);
        $persona->estado='Inactivo';
        $persona->update();
        return Redirect::to('persona/cliente');
    }
    public function listar_cliente(){
        return view('persona.cliente.index');

    }
    public function data_cliente(){
        $persona=Persona::where([
            ['tipo','=','Cliente'],
            ['estado','=', 'Activo']
            ])->get();
        return Datatables::of($persona)->make(true);
    }
    public function reporte(){
         //Obtenemos los registros
         $registros=DB::table('persona')
            ->where ('tipo','=','Cliente')
            ->orderBy('idpersona','desc')
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
         $pdf::cell(20,8,utf8_decode("Codigo"),1,"","L",true);     
         $pdf::cell(60,8,utf8_decode("Nombre"),1,"","L",true);
         $pdf::cell(35,8,utf8_decode("Documento"),1,"","L",true);
         $pdf::cell(50,8,utf8_decode("Domicilio"),1,"","L",true);
         $pdf::cell(25,8,utf8_decode("Teléfono"),1,"","L",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         
         foreach ($registros as $reg)
         {
            $pdf::cell(20,6,utf8_decode($reg->idpersona),1,"","L",true);
            $pdf::cell(60,6,utf8_decode($reg->nombre_apellido),1,"","L",true);
            $pdf::cell(35,6,utf8_decode($reg->dni),1,"","L",true);
            $pdf::cell(50,6,utf8_decode($reg->domicilio),1,"","L",true);
            $pdf::cell(25,6,utf8_decode($reg->telefono),1,"","L",true);
            $pdf::Ln(); 
         }

         $pdf::Output();
         exit;
    }
}
