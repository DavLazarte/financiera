@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Clientes  <a href="" data-target="#modal-cliente" data-toggle="modal"><button class="btn btn-success">Nuevo</button></a> <a href="{{url('reporteclientes')}}" target="_blank"><button class="btn btn-info">Reporte</button></a></h3>
	   @include('persona.cliente.create')
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
				  <th>Estado</th>
				  <th>Opciones</th>
				</thead>	
			</table>
		</div>
	</div>
</div>
@push ('scripts')
<script>
function activar_tabla_clientes() {
$(document).ready(function(){
	$('#tabla_clientes').DataTable({
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		language: {
			     "url": '{!! asset('plugins/datatables/latino.json')  !!}'
			       } ,
		ajax: '{!! url('listado_clientes_data') !!}',
		columns: [
			{ data: 'idpersona', name: 'idpersona' },
			{ data: 'nombre_apellido', name:'nombre_apellido' },
			{ data: 'dni', name:'dni' },
			{ data: 'telefono', name: 'telefono' },
			{ data: 'domicilio', name: 'domicilio' },
			{ data: 'estado', name:'estado' },
			{ data: null, render: function ( data, type, row ) {
				return "<a href='{{ url('editar_cliente/') }}/"+ data.idpersona +"' <button class='btn btn-info btn-sm'>Editar</button></a> <a href='{{ url('eliminar_cliente/') }}/"+ data.idpersona +"' <button class='btn btn-danger btn-sm'>Eliminar</button></a>" 
				}
			}
		]
	});
  });		 
}

activar_tabla_clientes();

</script>
@endpush
@endsection