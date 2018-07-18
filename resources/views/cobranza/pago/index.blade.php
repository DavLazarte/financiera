@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Pagos <a href="{{url('cobranza/pago/create')}}"><button class="btn btn-success">Nuevo</button></a> </h3>
	</div>
</div>
@if (session('info'))
    <div class="alert alert-success fade in">
        <button class="close" data-dismiss="alert"><span>&times;</span></button>
        {{ session('info') }}
    </div>
@endif
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover" id="tabla_pago">
				<thead>
					<th>Nº de pago</th>
					<th>Nº de Credito</th>
					<th>Fecha pago</th>
					<th>Zona</th>
					<th>Cliente</th>
					<th>Monto</th>
					<th>Opciones</th>
				</thead>
			</table>
		</div>
	</div>
</div>
@push ('scripts')
<script>
function activar_tabla_pagos() {
$(document).ready(function(){
    $('#tabla_pago').DataTable({
        order: [[ 0, "desc" ]],
        select:  true,
        processing: true,
        serverSide: true,
        language: {
                 "url": '{!! asset('plugins/datatables/latino.json')  !!}'
                   } ,
        ajax: '{!! url('listado_pagos_data') !!}',
        columns: [
            { data: 'idcobranza', name: 'c.idcobranza' },
            { data: 'idventa', name: 'c.idventa' },
            { data: 'fecha_hora', name:'c.fecha_hora' },
            { data: 'zona', name:'c.zona' },
            { data: 'nombre_apellido', name: 'p.nombre_apellido' },
            { data: 'monto', name: 'c.monto' },
            { data: 'action', name:'c.action', orderable: false, searchable:false }
        ]
    });
  });		 
}

activar_tabla_pagos();

</script>
@endpush
@endsection