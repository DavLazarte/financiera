@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Resumen de Zonas <a href="resumen/create"><button class="btn btn-success">Nuevo</button></a> <a href="{{URL::action('ResumenController@report',$searchText)}}" target="_blank"><button class="btn btn-info">Reporte</button></a></h3>
		@include('administracion.resumen.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Fecha</th>
					<th>Zona</th>
					<th>Ingreso Semanal</th>
					<th>Salida Semanal</th>
					<th>Anticipo</th>
					<th>Opciones</th>
				</thead>
               @foreach ($resumenes as $res)
				<tr>
					<td>{{ Carbon\Carbon::parse($res->created_at)->format('d-m-Y')}}</td>
					<td>{{ $res->zona}}</td>
					<td>{{ $res->ingreso_semana}}</td>
					<td>{{ $res->salida_semana}}</td>
					<td>{{ $res->anticipo}}</td>
					<td>
						<a href="{{URL::action('ResumenController@edit',$res->idresumen)}}"><button class="btn btn-info">Editar</button></a>
					</td>
				</tr>
				@endforeach
			</table>
		</div>
		{{$resumenes->render()}}
	</div>
</div>
@push ('scripts')
<script>
$('#liVentas').addClass("treeview active");
$('#liClientes').addClass("active");
</script>
@endpush
@endsection