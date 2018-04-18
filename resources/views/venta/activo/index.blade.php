@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Gestion de Creditos<a href="{{URL::action('ActivoController@report',$searchText)}}" target="_blank"><button class="btn btn-info">Reporte</button></a> <a href="{{URL::action('ActivoController@planilla',$searchText)}}" target="_blank"><button class="btn btn-primary">Nueva Planilla</button></a></h3>
		@include('venta.activo.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
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
               @foreach ($activos as $act)
				<tr>
					<td>{{ $act->idcredito}}</td>
					<td>{{ $act->zona}}</td>
					<td>{{ $act->cliente}}</td>
					<td>{{ $act->saldo}}</td>
					<td>{{ $act->proyeccion}}</td>
					<td>{{ Carbon\Carbon::parse($act->vencimiento)->format('d-m-Y')}}</td>
					<td>{{ $act->estado}}</td>
					<td>
						<a href="{{URL::action('ActivoController@edit',$act->idcredito)}}"><button class="btn btn-info">Actualizar Saldo</button></a>
						<a href="" data-target="#modal-create-{{$act->idcredito}}" data-toggle="modal"><button class="btn btn-primary">Refinanciar</button></a>
                         <a href="" data-target="#modal-delete-{{$act->idcredito}}" data-toggle="modal"><button class="btn btn-danger">Estados</button></a>
					</td>
				</tr>
				@include('venta.refinanciacion.create')
				@include('venta.activo.modal')
				@endforeach
			</table>
		</div>
		{{$activos->render()}}
	</div>
</div>
@push ('scripts')
<script>
$('#liVentas').addClass("treeview active");
$('#liClientes').addClass("active");
</script>
@endpush
@endsection