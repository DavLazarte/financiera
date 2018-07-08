@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Gestion de Creditos</h3>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover" id="tabla_activo">
				<thead>
					<th>Credito</th>
					<th>Zona</th>
					<th>Cliente</th>
					<th>Saldo</th>
					<th>Proyeccion</th>
					<th>Vencimiento</th>
					<th>Estado</th>
					<th>Opciones</th>
				</thead>
			</table>
		</div>
	</div>
</div>
@push ('scripts')
<script>
function activar_tabla_activos() {
$(document).ready(function(){
    $('#tabla_activo').DataTable({
        order: [[ 0, "desc" ]],
        select:  true,
        processing: true,
        serverSide: true,
        language: {
                 "url": '{!! asset('plugins/datatables/latino.json')  !!}'
                   } ,
        ajax: '{!! url('listado_activos_data') !!}',
        columns: [
            { data: 'idcredito', name: 'activo.idcredito' },
            { data: 'zona', name:'activo.zona' },
            { data: 'cliente', name: 'activo.cliente' },
            { data: 'saldo', name: 'activo.saldo' },
            { data: 'proyeccion', name: 'activo.proyeccion' },
            { data: 'vencimiento', name: 'activo.vencimiento' },
            { data: 'estado', name:'activo.estado' },
			{ data: 'action', name:'activo.action', orderable: false, searchable:false }
        ]
    });
  });		 
}

activar_tabla_activos();
</script>
@endpush
@endsection