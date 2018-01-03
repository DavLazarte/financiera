@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Liquidaciones<a href="liquidacion/create"><button class="btn btn-success">Nuevo</button></a> <a href="{{URL::action('LiquidacionController@reporte',$searchText)}}" target="_blank"><button class="btn btn-info">Reporte</button></a></h3>
		@include('administracion.liquidacion.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Codigo</th>
					<th>Empleado</th>
					<th>Periodo</th>
					<th>Recaudacion</th>
					<th>Comision</th>
					<th>Total</th>
					<th>Opciones</th>
				</thead>
               @foreach ($liquidaciones as $liq)
				<tr>
					<td>{{ $liq->idliquidacion}}</td>
					<td>{{ $liq->empleado}}</td>
					<td>{{ $liq->periodo}}</td>
					<td>{{ $liq->totalrec}}</td>
					<td>{{ $liq->total_comision}}</td>
					<td>{{ $liq->total}}</td>
					<td>
						<a href="{{URL::action('LiquidacionController@show',$liq->idliquidacion)}}"><button class="btn btn-primary">Detalles</button></a>
						<a target="_blank" href="{{URL::action('LiquidacionController@reportec',$liq->idliquidacion)}}"><button class="btn btn-info">Reporte</button></a>
					</td>
				</tr>
				@include('administracion.liquidacion.modal')
				@endforeach
			</table>
		</div>
		{{$liquidaciones->render()}}
	</div>
</div>
@push ('scripts')
<script>
$('#liVentas').addClass("treeview active");
$('#liVentass').addClass("active");
</script>
@endpush

@endsection