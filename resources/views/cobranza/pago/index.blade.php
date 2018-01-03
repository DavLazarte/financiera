@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Pagos <a href="pago/create"><button class="btn btn-success">Nuevo</button></a> <a href="{{URL::action('CobranzaController@report',$searchText)}}" target="_blank"><button class="btn btn-info">Reporte</button></a></h3>
		@include('cobranza.pago.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Credito</th>
					<th>Fecha pago</th>
					<th>Zona</th>
					<th>Cliente</th>
					<th>Monto</th>
					<th>Opciones</th>
				</thead>
               @foreach ($pagos as $pag)
				<tr>
					<td>{{ $pag->idventa}}</td>
					<td>{{ Carbon\Carbon::parse($pag->fecha_hora)->format('d-m-Y')}}</td>
					<td>{{ $pag->zona}}</td>
					<td>{{ $pag->nombre_apellido}}</td>
					<td>{{ $pag->monto}}</td>
					<td>
						<a href="{{URL::action('CobranzaController@edit',$pag->idcobranza)}}"><button class="btn btn-info">Editar</button></a>
					</td>
				</tr>
				@endforeach
			</table>
		</div>
		{{$pagos->render()}}
	</div>
</div>
@push ('scripts')
<script>
$('#liVentas').addClass("treeview active");
$('#liClientes').addClass("active");
</script>
@endpush
@endsection