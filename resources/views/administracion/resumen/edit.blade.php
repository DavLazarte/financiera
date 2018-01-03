@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Resumen:</h3>
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
			{!!Form::model($resumen,['method'=>'PATCH','route'=>['administracion.resumen.update',$resumen->idresumen]])!!}
      {{Form::token()}}
    <div class="row">
        <div class="col-lg-1 col-sm-1 col-md-1 col-xs-12">
            <div class="form-group">
                <label for="zona">Zona</label>
                <select name="zona" class="form-control">
                    @if ($resumen->zona=='Z0')
                       <option value="Z0" selected>Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                    @elseif ($resumen->zona=='Z1')          
                        <option value="Z0">Z0</option>
                       <option value="Z1" selected>Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                    @elseif ($resumen->zona=='Z2')
                        <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2" selected>Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                    @elseif ($resumen->zona=='Z3')
                        <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3" selected>Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                    @elseif ($resumen->zona=='Z4')
                    <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4" selected>Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                    @elseif ($resumen->zona=='Z5')
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
           <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="ingreso_semana">Ingreso Semanal</label>
                <input type="text" name="ingreso_semana" value="{{$resumen->ingreso_semana}}" class="form-control">
            </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="salida_semana">Salida Semanal</label>
                <input type="text" name="salida_semana" value="{{$resumen->salida_semana}}" class="form-control">
            </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="anticipo">Anticipo</label>
                <input type="text" name="anticipo" value="{{$resumen->anticipo}}" class="form-control">
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
$('#liresumens').addClass("treeview active");
$('#liClientes').addClass("active");
</script>
@endpush
@endsection