@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Entregas <a href="entrega/create"><button class="btn btn-success">Nuevo</button></a> <a href="{{URL::action('VentaController@report',$searchText)}}" target="_blank"><button class="btn btn-info">Reporte</button></a></h3>
		@include('venta.entrega.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
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
               @foreach ($ventas as $ven)
				<tr>
					<td>{{ $ven->idventa}}</td>
					<td>{{ Carbon\Carbon::parse($ven->fecha_hora)->format('d-m-Y')}}</td>
					<td>{{ $ven->zona}}</td>
					<td>{{ $ven->nombre_apellido}}</td>
					<td>{{ $ven->monto}}</td>
					<td>{{ $ven->plan}}</td>
					<td>{{ Carbon\Carbon::parse($ven->fecha_cancela)->format('d-m-Y')}}</td>
					<td>{{ $ven->concepto}}</td>
					<td>{{ $ven->empleado}}</td>
					<td>{{ $ven->estado}}</td>
					<td>
						<a href="{{URL::action('VentaController@edit',$ven->idventa)}}"><button class="btn btn-info">Editar</button></a>
						<a id="activar" href="" data-target="#modal-create-{{$ven->idventa}}" data-toggle="modal"><button class="btn btn-success" >Activar</button></a>
					</td>
				</tr>
				@include('venta.entrega.modal')
				@include('venta.activo.create')
				@endforeach
			</table>
		</div>
		{{$ventas->render()}}
	</div>
</div>
@push ('scripts')
<script>
$('#liVentas').addClass("treeview active");
$('#liClientes').addClass("active");
</script>
@endpush
@endsection