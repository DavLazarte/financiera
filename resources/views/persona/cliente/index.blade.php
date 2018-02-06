@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Clientes <a href="cliente/create"><button class="btn btn-success">Nuevo</button></a> <a href="{{url('reporteclientes')}}" target="_blank"><button class="btn btn-info">Reporte</button></a></h3>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover" id="tabla_clientes">
				<thead>
					<th>Id</th>
					<th>Nombre</th>
					<th>DNI</th>
					<th>Teléfono</th>
					<th>Domicilio</th>
					<th>Tipo</th>
					<th>Estado</th>
					<th>Opciones</th>
				</thead>
               @foreach ($personas as $per)
				<tr>
					<td>{{ $per->idpersona}}</td>
					<td>{{ $per->nombre_apellido}}</td>
					<td>{{ $per->dni}}</td>
					<td>{{ $per->telefono}}</td>
					<td>{{ $per->domicilio}}</td>
					<td>{{ $per->estado}}</td>
					<td>
						<a href="{{URL::action('ClienteController@edit',$per->idpersona)}}"><button class="btn btn-info btn-sm">Editar</button></a>
                         <a href="" data-target="#modal-delete-{{$per->idpersona}}" data-toggle="modal"><button class="btn btn-danger btn-sm">X</button></a>
					</td>
				</tr>
				@include('persona.cliente.modal')
				@endforeach
			</table>
		</div>
		
	</div>
</div>
@push ('scripts')
<script>
$(document).ready(function(){
    $('#tabla_clientes').DataTable({
		"processing": true,
        "serverSide": true,
        "ajax": "api/cliente",
		"columns":[
			{data: 'idpersona'},
			{data: 'nombre_apellido'},
			{data: 'dni'},
			{data: 'domicilio'},
			{data: 'telefono'},
			{data: 'tipo'},
			{data: 'estado'},												
		]
    });
});
</script>
<script>
$('#liVentas').addClass("treeview active");
$('#liClientes').addClass("active");
</script>
@endpush
@endsection