@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Cierres de Caja<a href="caja/create"><button class="btn btn-success">Nuevo</button></a> <a href="{{URL::action('CajaController@reporte',$searchText)}}" target="_blank"><button class="btn btn-info">Reporte</button></a></h3>
		@include('administracion.caja.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Numero</th>
					<th>Fecha</th>
					<th>Total Ingreso</th>
					<th>Total Salida</th>
					<th>Total Suma</th>
					<th>Opciones</th>
				</thead>
               @foreach ($cajas as $caj)
				<tr>
					<td>{{ $caj->idcaja}}</td>
					<td>{{ Carbon\Carbon::parse($caj->created_at)->format('d-m-Y')}}</td>
					<td>{{ $caj->totalingreso}}</td>
					<td>{{ $caj->totalsalida}}</td>
					<td>{{ $caj->totalsuma}}</td>
					<td>
						<a href="{{URL::action('CajaController@show',$caj->idcaja)}}"><button class="btn btn-primary">Detalles</button></a>
						<a target="_blank" href="{{URL::action('CajaController@reportec',$caj->idcaja)}}"><button class="btn btn-info">Reporte</button></a>
					</td>
				</tr>
				@include('administracion.caja.modal')
				@endforeach
			</table>
		</div>
		{{$cajas->render()}}
	</div>
</div>
@push ('scripts')
<script>
$('#liVentas').addClass("treeview active");
$('#liVentass').addClass("active");
</script>
@endpush

@endsection