<?php

namespace ConfiSis\Http\Controllers;

use Illuminate\Http\Request;

use ConfiSis\Http\Requests;

use ConfiSis\User;
use Illuminate\Support\Facades\Redirect;
use ConfiSis\Http\Requests\UsuarioFormRequest;
use DB;

use Fpdf;

class UsuarioController extends Controller
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
            $usuarios=DB::table('users')->where('name','LIKE','%'.$query.'%')
            ->orderBy('id','desc')
            ->paginate(7);
            return view('herramienta.usuario.index',["usuarios"=>$usuarios,"searchText"=>$query]);
        }
    }

    public function create()
    {
        return view("herramienta.usuario.create");
    }
    public function store (UsuarioFormRequest $request)
    {
        $usuario=new User;
        $usuario->name=$request->get('name');
        $usuario->email=$request->get('email');
        $usuario->password=bcrypt($request->get('password'));
        $usuario->save();
        return Redirect::to('herramienta/usuario');
    }
    public function edit($id)
    {
        return view("herramienta.usuario.edit",["usuario"=>User::findOrFail($id)]);
    }    
    public function update(UsuarioFormRequest $request,$id)
    {
        $usuario=User::findOrFail($id);
        $usuario->name=$request->get('name');
        $usuario->email=$request->get('email');
        $usuario->password=bcrypt($request->get('password'));
        $usuario->update();
        return Redirect::to('herramienta/usuario');
    }
    public function destroy($id)
    {
        $usuario = DB::table('users')->where('id', '=', $id)->delete();
        return Redirect::to('herramienta/usuario');
    }
}
