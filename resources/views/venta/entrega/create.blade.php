@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nueva Entrega</h3>
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
			{!!Form::open(array('url'=>'venta/entrega','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
    <div class="row">
    	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="zona">Zona</label>
                <select name="zona" class="form-control">
                       <option value="Z00">Z0I</option>
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
        <div class="col-lg-9 col-sm-9 col-md-9 col-xs-12">
            <div class="form-group">
                <label for="cliente">Cliente</label>
                <select name="cliente" id="cliente" class="form-control selectpicker" data-live-search="true">
                    @foreach($clientes as $cliente)
                     <option value="{{$cliente->idpersona}}">{{$cliente->nombre_apellido}}</option>
                     @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="empleado">Entrega</label>
                <select name="empleado" class="form-control">
                       <option value="dani">Dani Miranda</option>
                       <option value="karina">Karina Fenoglio</option>
                       <option value="leo">Leo Escobar</option>
                       <option value="david">David Lazarte</option>
                       <option value="veronica">Veronica Huerta</option>
                       <option value="dante">Dante Miranda</option>
                       <option value="dario">Dario Ogas</option>
                       <option value="alvaro">Alvaro Nieva</option>
                       <option value="santiago">Santiago Ruiz</option>
                </select>
            </div>
        </div>
       
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="monto">Monto</label>
                <input type="text" name="monto" value="{{old('monto')}}" class="form-control" placeholder="Monto entregado">
            </div>
        </div>
    	<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="plan">Plan</label>
               <select name="plan" id="plan" class="form-control">
                   <option value="1">26 dias</option>
                   <option value="2">35 dias</option>
                   <option value="3">4 semanas</option>
                   <option value="4">5 semanas</option>
                   <option value="5">6 semanas</option>
                   <option value="6">Especial</option>
               </select>
            </div>
        </div>
         <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="fecha_hora">Inicio</label>
                <input type="date"   name="fecha_hora" value="{{old('fecha_hora')}}" class="form-control" >
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="fecha_cancela">Cancelación</label>
                <input type="date"   name="fecha_cancela" value="{{old('fecha_cancela')}}" class="form-control" placeholder="Fecha de Cancelación">
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="concepto">Concepto</label>
                <select name="concepto" class="form-control">
                       <option value="nuevo">Nuevo</option>
                       <option value="recuperacion">Recuperación</option>
                       <option value="renovacion">Renovación</option>
                       <option value="paralela">Paralela</option>
                       <option value="especial">Especial</option>
                </select>
            </div>
        </div>
        <div class="col-lg-11 col-sm-11 col-md-11 col-xs-11">
        </div>
    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    		<div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
    	</div>
    </div>   
{!!Form::close()!!}		
@push ('scripts')
<script>
$('#liVentas').addClass("treeview active");
$('#liClientes').addClass("active");
</script>
@endpush
@endsection