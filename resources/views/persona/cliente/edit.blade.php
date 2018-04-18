@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Cliente: {{ $persona->nombre_apellido}}</h3>
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
	{!!Form::model($persona,['method'=>'PATCH','route'=>['persona.cliente.update',$persona->idpersona]])!!}
    {{Form::token()}}
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="nombre_apellido">Nombre</label>
                <input type="text" name="nombre_apellido" required value="{{$persona->nombre_apellido}}" class="form-control" >
            </div>
            <div class="form-group">
                <label for="domicilio">Domicilio</label>
                <input type="text" name="domicilio" value="{{$persona->domicilio}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="dni">Número documento</label>
                <input type="text" name="dni" value="{{$persona->dni}}" class="form-control" >
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" value="{{$persona->telefono}}" class="form-control" placeholder="Teléfono...">
            </div>
        </div>
        <div class="col-lg-7 col-sm-7 col-md-7 col-xs-12">
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