@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
	<h3>Listado de Entregas <a href="{{url('venta/entrega/create')}}"><button class="btn btn-success">Nuevo</button></a> <a href="{{url('reporteentregas')}}" target="_blank"><button class="btn btn-info">Reporte</button></a></h3>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover" id="tabla_entrega">
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
					<th>Opciones</th>
				</thead>
			</table>
		</div>
	</div>
</div>
@push ('scripts')
<script>
function activar_tabla_entregas() {
$(document).ready(function(){
	$('#tabla_entrega').DataTable({
		order: [[ 0, "desc" ]],
		processing: true,
		serverSide: true,
		language: {
			     "url": '{!! asset('plugins/datatables/latino.json')  !!}'
			       } ,
		ajax: '{!! url('listado_entregas_data') !!}',
		columns: [
			{ data: 'idventa', name: 'venta.idventa' },
			{ data: 'fecha_hora', name:'venta.fecha_hora' },
			{ data: 'zona', name:'venta.zona' },
			{ data: 'nombre_apellido', name: 'persona.nombre_apellido' },
			{ data: 'monto', name: 'venta.monto' },
			{ data: 'plan', name: 'venta.plan' },
			{ data: 'fecha_cancela', name: 'venta.fecha_cancela' },
			{ data: 'concepto', name: 'venta.concepto' },
			{ data: 'empleado', name: 'venta.empleado' },
			{ data: 'estado', name:'venta.estado' },
			{ data: null, render: function ( data, type, row ) {
				return "<a href='{{ url('editar_entrega/') }}/"+ data.idventa +"' <button class='btn btn-info btn-sm'>Editar</button></a> <a href='{{ url('activar_entrega/') }}/"+ data.idventa +"' <button class='btn btn-success btn-sm'>Activar</button></a>	<a href='{{ url('eliminar_entrega/') }}/"+ data.idventa +"' <button class='btn btn-danger btn-sm'>Eliminar</button></a>" 
				}
			}
		]
	});
  });		 
}

activar_tabla_entregas();

</script>
@endpush
@endsection