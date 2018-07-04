@extends('layouts.admin')
@section('contenido')
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h3>Generar Reportes de Entrega</h3>
            @if (count($errors)>0)
            <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
                </ul>
            </div>
            @endif
    </div>
</div>
{!! Form::open(array('url'=>'rep_entrega','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="row">

    {{-- <input type="text" class="form-control" name="zona" placeholder="Ingresar la Zona" value="{{$zona}}"> --}}
    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12"> 
        <div class="form-group">
            <label for="zona">Zona</label>
            <select name="zona" class="form-control" value="{{$zona}}">
                    <option value="Z0">Z0</option>
                    <option value="Z1">Z1</option>
                    <option value="Z2">Z2</option>
                    <option value="Z3">Z3</option>
                    <option value="Z4">Z4</option>
                    <option value="Z5">Z5</option>
                    <option value="Z6">Z6</option>
                    <option value="Z7">Z7</option>
            </select>
        </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
           <div class="form-group">
            <label for="fecha">Fecha</label> 
            <input type="date" class="form-control" name="fecha"  value="{{$fecha}}">
           </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary form-control">Buscar</button>
                </span>
            </div>
        </div>
        
    </div>


<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th>Id</th>
					<th>Inicio</th>
					<th>Zona</th>
					<th>Cliente</th>
					<th>Monto</th>
					<th>Plan</th>
					<th>Vence</th>
					<th>Concepto</th>
					<th>Entrega</th>
					<th>Estado</th>
				</thead>
                @foreach ($ventas as $ven)
				<tr>
                    <td>{{ $ven->idventa}}</td>
					<td>{{ Carbon\Carbon::parse($ven->fecha_hora)->format('d-m-Y')}}</td>
					<td>{{ $ven->zona}}</td>
					<td>{{ $ven->nombre_apellido}}</td>
					<td>{{ $ven->monto}}</td>
					<td>{{ $ven->plan}}</td>
					<td>{{ Carbon\Carbon::parse($ven->fecha_cancela)->format('d-m-Y')}}</td>
					<td>{{ $ven->concepto}}</td>
					<td>{{ $ven->empleado}}</td>
					<td>{{ $ven->estado}}</td>
				</tr>
				@endforeach
			</table>
		</div>
    </div>
</div>
{{Form::close()}}
<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
    <div class="form-group">
      <a href="{{URL::action('VentaController@report',[$zona,$fecha])}}" target="_blank"><button title="Reporte" class="btn btn-warning"><i class="fa fa-print" aria-hidden="true"></i></button></a>
    </div>
</div>
@endsection