@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Salida: {{ $salida->created_at->format('d-m-Y')}}</h3>
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
			{!!Form::model($salida,['method'=>'PATCH','route'=>['administracion.salida.update',$salida->idsalida]])!!}
            {{Form::token()}}
    <div class="row">
         <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="zona">Zona</label>
                <select name="zona" class="form-control">
                    @if ($salida->zona=='Z0')
                       <option value="Z0" selected>Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                    @elseif ($salida->zona=='Z1')          
                       <option value="Z0">Z0</option>
                       <option value="Z1" selected>Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                    @elseif ($salida->zona=='Z2')
                       <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2" selected>Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                    @elseif ($salida->zona=='Z3')
                       <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3" selected>Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                    @elseif ($salida->zona=='Z4')
                       <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4" selected>Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                    @elseif ($salida->zona=='Z5')
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
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="monto">Monto</label>
                <input type="text" name="monto" required value="{{$salida->monto}}" class="form-control" placeholder="Monto de la Salida...">
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="concepto">Concepto</label>
                <select name="concepto" class="form-control">
                        @if($salida->concepto=='Anticipo')
                            <option value="Anticipo" selected>Anticipo</option>
                            <option value="Entrega">Entrega</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Caja">Caja</option>
                            <option value="Otro">Otro</option>
                        @elseif($salida->concepto=='Entrega')
                            <option value="Anticipo">Anticipo</option>
                            <option value="Entrega" selected>Entrega</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Caja">Caja</option>
                            <option value="Otro">Otro</option>
                        @elseif($salida->concepto=='Pendiente')
                            <option value="Anticipo">Anticipo</option>
                            <option value="Entrega">Entrega</option>
                            <option value="Pendiente" selected>Pendiente</option>
                            <option value="Caja">Caja</option>
                            <option value="Otro">Otro</option>
                        @elseif($salida->concepto='Caja')
                            <option value="Anticipo">Anticipo</option>
                            <option value="Entrega">Entrega</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Caja" selected>Caja</option>
                            <option value="Otro">Otro</option>
                        @else
                            <option value="Anticipo">Anticipo</option>
                            <option value="Entrega">Entrega</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Caja">Caja</option>
                            <option value="Otro" selected>Otro</option>
                        @endif                            
                </select>
            </div>
        </div>
        <div class="col-lg-9 col-sm-9 col-md-9 col-xs-12">
            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea name="observaciones" value="{{$salida->observaciones}}" class="form-control" placeholder="Observaciones de la Salida...">{{$salida->observaciones}}</textarea>  
            </div>
        </div>
        <br>

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