@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Ingreso: {{ $ingreso->created_at->format('d-m-Y')}}</h3>
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
			{!!Form::model($ingreso,['method'=>'PATCH','route'=>['administracion.ingreso.update',$ingreso->idingreso]])!!}
            {{Form::token()}}
    <div class="row">
       <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="zona">Zona</label>
                <select name="zona" class="form-control">
                    @if ($ingreso->zona=='Z0')
                       <option value="Z0" selected>Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                       <option value="Z7">Z7</option>
                    @elseif ($ingreso->zona=='Z1')          
                       <option value="Z0">Z0</option>
                       <option value="Z1" selected>Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                       <option value="Z7">Z7</option>
                    @elseif ($ingreso->zona=='Z2')
                       <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2" selected>Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                       <option value="Z7">Z7</option>
                    @elseif ($ingreso->zona=='Z3')
                       <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3" selected>Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                       <option value="Z7">Z7</option>
                    @elseif ($ingreso->zona=='Z4')
                       <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4" selected>Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                       <option value="Z7">Z7</option>
                    @elseif ($ingreso->zona=='Z5')
                       <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5" selected>Z5</option>
                       <option value="Z6">Z6</option>
                       <option value="Z7">Z7</option>
                    @elseif ($ingreso->zona=='Z6')                    
                       <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6" selected="">Z6</option>
                       <option value="Z7">Z7</option>
                    @else
                       <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                       <option value="Z7" selected>Z7</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="empleado">Empleado</label>
                <select name="empleado" id="empleado" class="form-control selectpicker" data-live-search="true">
                    @foreach($empleados as $empleado)
                     <option value="{{$empleado->idpersona}}">{{$empleado->nombre_apellido}}</option>
                     @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="monto">Monto</label>
                <input type="text" name="monto" required value="{{$ingreso->monto}}" class="form-control" placeholder="Monto de Ingreso...">
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="concepto">Concepto</label>
                <select name="concepto" class="form-control">
                @if ($ingreso->concepto=='Cobranza')
                    <option value="Cobranza" selected>Cobranza</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Caja">Caja</option>
                    <option value="Otro">Otro</option>
                @elseif($ingreso->concepto=='Pendiente')
                    <option value="Cobranza" >Cobranza</option>
                    <option value="Pendiente" selected>Pendiente</option>
                    <option value="Caja">Caja</option>
                    <option value="Otro">Otro</option>
                @elseif($ingreso->concepto=='Caja')
                    <option value="Cobranza" >Cobranza</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Caja" selected>Caja</option>
                    <option value="Otro">Otro</option>
                @else
                    <option value="Cobranza" >Cobranza</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Caja">Caja</option>
                    <option value="Otro" selected>Otro</option>
                @endif                    
                </select>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
        </div>
    </div>
{!!Form::close()!!}		    
@push ('scripts')
<script>
$('#liAlmacen').addClass("treeview active");
$('#liArticulos').addClass("active");
</script>
@endpush
@endsection