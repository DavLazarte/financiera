@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Ingresos <a href="ingreso/create"><button class="btn btn-success">Nuevo</button></a> <a href="{{URL::action('IngresoController@report',$searchText)}}" target="_blank"><button class="btn btn-info">Reporte</button></a></h3>
		@include('administracion.ingreso.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Fecha</th>
					<th>Zona</th>
					<th>Monto</th>
					<th>Concepto</th>
					<th>Empleado</th>
					<th>Estado</th>
					<th>Opciones</th>
				</thead>
               @foreach ($ingresos as $ing)
				<tr>
					<td>{{ Carbon\Carbon::parse($ing->created_at)->format('d-m-Y')}}</td>
					<td>{{ $ing->zona}}</td>
					<td>{{ $ing->monto}}</td>
					<td>{{ $ing->concepto}}</td>
					<td>{{ $ing->empleado.'-'.$ing->nombre_apellido}}</td>
					<td>{{ $ing->estado}}</td>
					<td>
						<a href="{{URL::action('IngresoController@edit',$ing->idingreso)}}"><button class="btn btn-primary">Editar</button></a>
                         <a href="" data-target="#modal-delete-{{$ing->idingreso}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a>
					</td>
				</tr>
				@include('administracion.ingreso.modal')
				@endforeach
			</table>
		</div>
		{{$ingresos->render()}}
	</div>
</div>
@push ('scripts')
<script>
$('#liotrpras').addClass("treeview active");
$('#liIngresos').addClass("active");
</script>
@endpush
@endsection