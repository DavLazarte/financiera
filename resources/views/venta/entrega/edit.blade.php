@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Venta: {{ $venta->nombre_apellido}}</h3>
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
{!!Form::model($venta,['method'=>'PATCH','route'=>['venta.entrega.update',$venta->idventa]])!!}
{{Form::token()}}
    <div class="row">
        <div class="col-lg-9 col-sm-9 col-md-9 col-xs-12">
            <div class="form-group">
                <label for="fecha_hora">Inicio</label>
                <input type="text"   name="fecha_hora" value="{{$venta->fecha_hora}}" class="form-control" >
            </div>
            <div class="form-group">
                <label for="zona">Zona</label>
                <select name="zona" class="form-control">
                    @if ($venta->zona=='Z0')
                       <option value="Z0" selected>Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                    @elseif ($venta->zona=='Z1')          
                        <option value="Z0">Z0</option>
                       <option value="Z1" selected>Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                    @elseif ($venta->zona=='Z2')
                        <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2" selected>Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                    @elseif ($venta->zona=='Z3')
                        <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3" selected>Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                    @elseif ($venta->zona=='Z4')
                    <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4" selected>Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                    @elseif ($venta->zona=='Z5')
                        <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5" selected>Z5</option>
                       <option value="Z6">Z6</option>
                    @else
                        <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6" selected="">Z6</option>
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="cliente">Cliente</label>
                <select name="cliente" id="cliente" class="form-control selectpicker" data-live-search="true">
                    @foreach($clientes as $cliente)
                     <option value="{{$cliente->idpersona}}">{{$cliente->nombre_apellido}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="monto">Monto</label>
                <input type="text" name="monto" value="{{$venta->monto}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="plan">Plan</label>
                   <select name="plan" id="plan" class="form-control">
                        @if ($venta->plan == 1)
                       <option value="1" selected>26 dias</option>
                       <option value="2">35 dias</option>
                       <option value="3">4 semanas</option>
                       <option value="4">5 semanas</option>
                       <option value="5">6 semanas</option>
                       <option value="6">Especial</option>
                       @elseif ($venta->plan == 2 )
                       <option value="1">26 dias</option>
                       <option value="2" selected>35 dias</option>
                       <option value="3">4 semanas</option>
                       <option value="4">5 semanas</option>
                       <option value="5">6 semanas</option>
                       <option value="6">Especial</option>
                       @elseif ($venta->plan == 3 )
                       <option value="1">26 dias</option>
                       <option value="2">35 dias</option>
                       <option value="3" selected>4 semanas</option>
                       <option value="4">5 semanas</option>
                       <option value="5">6 semanas</option>
                       <option value="6">Especial</option>
                       @elseif ($venta->plan == 4 )
                       <option value="1">26 dias</option>
                       <option value="2">35 dias</option>
                       <option value="3">4 semanas</option>
                       <option value="4" selected>5 semanas</option>
                       <option value="5">6 semanas</option>
                       <option value="6">Especial</option>
                       @elseif ($venta->plan == 5 )
                       <option value="1">26 dias</option>
                       <option value="2">35 dias</option>
                       <option value="3">4 semanas</option>
                       <option value="4">5 semanas</option>
                       <option value="5" selected>6 semanas</option>
                       <option value="6">Especial</option>
                       @else
                       <option value="1">26 dias</option>
                       <option value="2">35 dias</option>
                       <option value="3">4 semanas</option>
                       <option value="4">5 semanas</option>
                       <option value="5">6 semanas</option>
                       <option value="6" selected>Especial</option>
                       @endif
                   </select>
                </div>
                <div class="form-group">
                    <label for="fecha_cancela">Cancelación</label>
                    <input type="text"   name="fecha_cancela" value="{{$venta->fecha_cancela}}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="concepto">Concepto</label>
                    <select name="concepto" class="form-control">
                        @if ($venta->concepto=='nuevo')
                           <option value="nuevo" selected>Nuevo</option>
                           <option value="recuperacion">Recuperación</option>
                           <option value="renovacion">Renovación</option>
                           <option value="paralela">Paralela</option>
                           <option value="especial">Especial</option>
                        @elseif ($venta->concepto=='recuperacion')
                            <option value="nuevo" >Nuevo</option>
                           <option value="recuperacion" selected>Recuperación</option>
                           <option value="renovacion">Renovación</option>
                           <option value="paralela">Paralela</option>
                           <option value="especial">Especial</option>
                        @elseif ($venta->concepto=='renovacion')
                            <option value="nuevo">Nuevo</option>
                           <option value="recuperacion">Recuperación</option>
                           <option value="renovacion" selected>Renovación</option>
                           <option value="paralela">Paralela</option>
                           <option value="especial">Especial</option>
                        @elseif ($venta->concepto=='paralela')
                            <option value="nuevo">Nuevo</option>
                           <option value="recuperacion">Recuperación</option>
                           <option value="renovacion">Renovación</option>
                           <option value="paralela" selected>Paralela</option>
                           <option value="especial">Especial</option>
                        @else
                            <option value="nuevo">Nuevo</option>
                           <option value="recuperacion">Recuperación</option>
                           <option value="renovacion">Renovación</option>
                           <option value="paralela">Paralela</option>
                           <option value="especial" selected>Especial</option>
                        @endif
                    </select>
                </div>
            <div class="form-group">
                <label for="empleado">Entrega</label>
                <select name="empleado" class="form-control">
                    @if ($venta->empleado =='dani')
                        <option value="dani" selected>Dani Miranda</option>
                        <option value="karina">Karina Fenoglio</option>
                        <option value="leo">Leo Escobar</option>
                        <option value="david">David Lazarte</option>
                        <option value="veronica">Veronica Huerta</option>
                        <option value="dante">Dante Miranda</option>
                        <option value="dario">Dario Ogas</option>
                        <option value="alvaro">Alvaro Nieva</option>
                        <option value="santiago">Santiago Ruiz</option>
                    @elseif ($venta->empleado =='karina')
                        <option value="dani">Dani Miranda</option>
                        <option value="karina" selected>Karina Fenoglio</option>
                        <option value="leo">Leo Escobar</option>
                        <option value="david">David Lazarte</option>
                        <option value="veronica">Veronica Huerta</option>
                        <option value="dante">Dante Miranda</option>
                        <option value="dario">Dario Ogas</option>
                        <option value="alvaro">Alvaro Nieva</option>
                        <option value="santiago">Santiago Ruiz</option>
                    @elseif ($venta->empleado =='leo')
                        <option value="dani">Dani Miranda</option>
                        <option value="karina">Karina Fenoglio</option>
                        <option value="leo" selected>Leo Escobar</option>
                        <option value="david">David Lazarte</option>
                        <option value="veronica">Veronica Huerta</option>
                        <option value="dante">Dante Miranda</option>
                        <option value="dario">Dario Ogas</option>
                        <option value="alvaro">Alvaro Nieva</option>
                        <option value="santiago">Santiago Ruiz</option>
                    @elseif ($venta->empleado =='david')
                        <option value="dani">Dani Miranda</option>
                        <option value="karina">Karina Fenoglio</option>
                        <option value="leo">Leo Escobar</option>
                        <option value="david" selected>David Lazarte</option>
                        <option value="veronica">Veronica Huerta</option>
                        <option value="dante">Dante Miranda</option>
                        <option value="dario">Dario Ogas</option>
                        <option value="alvaro">Alvaro Nieva</option>
                        <option value="santiago">Santiago Ruiz</option>
                    @elseif ($venta->empleado =='veronica')
                        <option value="dani">Dani Miranda</option>
                        <option value="karina">Karina Fenoglio</option>
                        <option value="leo">Leo Escobar</option>
                        <option value="david">David Lazarte</option>
                        <option value="veronica" selected>Veronica Huerta</option>
                        <option value="dante">Dante Miranda</option>
                        <option value="dario">Dario Ogas</option>
                        <option value="alvaro">Alvaro Nieva</option>
                        <option value="santiago">Santiago Ruiz</option>
                    @elseif ($venta->empleado =='dante')
                        <option value="dani">Dani Miranda</option>
                        <option value="karina">Karina Fenoglio</option>
                        <option value="leo">Leo Escobar</option>
                        <option value="david">David Lazarte</option>
                        <option value="veronica">Veronica Huerta</option>
                        <option value="dante" selected>Dante Miranda</option>
                        <option value="dario">Dario Ogas</option>
                        <option value="alvaro">Alvaro Nieva</option>
                        <option value="santiago">Santiago Ruiz</option>
                    @elseif ($venta->empleado =='dario')
                        <option value="dani">Dani Miranda</option>
                        <option value="karina">Karina Fenoglio</option>
                        <option value="leo">Leo Escobar</option>
                        <option value="david">David Lazarte</option>
                        <option value="veronica">Veronica Huerta</option>
                        <option value="dante">Dante Miranda</option>
                        <option value="dario" selected>Dario Ogas</option>
                        <option value="alvaro">Alvaro Nieva</option>
                        <option value="santiago">Santiago Ruiz</option>
                    @elseif ($venta->empleado =='alvaro')
                        <option value="dani">Dani Miranda</option>
                        <option value="karina">Karina Fenoglio</option>
                        <option value="leo">Leo Escobar</option>
                        <option value="david">David Lazarte</option>
                        <option value="veronica">Veronica Huerta</option>
                        <option value="dante">Dante Miranda</option>
                        <option value="dario">Dario Ogas</option>
                        <option value="alvaro" selected>Alvaro Nieva</option>
                        <option value="santiago">Santiago Ruiz</option>
                    @else 
                       <option value="dani">Dani Miranda</option>
                       <option value="karina">Karina Fenoglio</option>
                       <option value="leo">Leo Escobar</option>
                       <option value="david">David Lazarte</option>
                       <option value="veronica">Veronica Huerta</option>
                       <option value="dante">Dante Miranda</option>
                       <option value="dario">Dario Ogas</option>
                       <option value="alvaro">Alvaro Nieva</option>
                       <option value="santiago" selected>Santiago Ruiz</option>
                    @endif 
                </select>
            </div>
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