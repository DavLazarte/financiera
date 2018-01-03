@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Creditos Refinanciados <a href="{{URL::action('RefinanciacionController@report',$searchText)}}" target="_blank"><button class="btn btn-info">Reporte</button></a></h3>
		@include('venta.refinanciacion.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Credito</th>
					<th>Inicio</th>
					<th>Zona</th>
					<th>Cliente</th>
					<th>Saldo</th>
					<th>Plan</th>
					<th>Vencimiento</th>
					<th>Estado</th>
					<th>Opciones</th>
				</thead>
               @foreach ($refinanciaciones as $ref)
				<tr>
					<td>{{ $ref->credito}}</td>
					<td>{{ Carbon\Carbon::parse($ref->created_at)->format('d-m-Y')}}</td>
					<td>{{ $ref->zona}}</td>
					<td>{{ $ref->nombre_apellido}}</td>
					<td>{{ $ref->saldo}}</td>
					<td>{{ $ref->plan}}</td>
					<td>{{ Carbon\Carbon::parse($ref->vencimiento)->format('d-m-Y')}}</td>
					<td>{{ $ref->estado}}</td>
					<td>
						<a href="{{URL::action('RefinanciacionController@edit',$ref->idrefinanciacion)}}"><button class="btn btn-info">Editar</button></a>
                         <a href="" data-target="#modal-delete-{{$ref->idrefinanciacion}}" data-toggle="modal"><button class="btn btn-danger">Estados</button></a>
					</td>
				</tr>
				@include('venta.refinanciacion.modal')
				@endforeach
			</table>
		</div>
		{{$refinanciaciones->render()}}
	</div>
</div>
@push ('scripts')
<script>
$('#liVentas').addClass("treeview active");
$('#liClientes').addClass("active");
</script>
@endpush
@endsection