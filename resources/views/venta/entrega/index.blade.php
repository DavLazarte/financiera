@extends ('layouts.admin')
@section ('contenido')
<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
    <h3>Listado de Entregas <a href="{{url('venta/entrega/create')}}"><button class="btn btn-success" title="Agregar Entrega"><i class="fa fa-plus-square" aria-hidden="true"></i></button></a> <a href="{{url('reporteentregas')}}" target="_blank"><button title="Reporte" class="btn btn-warning"><i class="fa fa-print" aria-hidden="true"></i></button></a></h3>
</div>
</div>
@if (session('status'))
    <div class="alert alert-success fade in">
        <button class="close" data-dismiss="alert"><span>&times;</span></button>
        {{ session('status') }}
    </div>
@endif

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_entrega">
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
                    <th >Estado</th>
                    <th>Opciones</th>
                </thead>
            </table>
        </div>
    </div>
</div>
@push ('scripts')
<script>
function activar_tabla_entregas() {
$(document).ready(function(){
    $('#tabla_entrega').DataTable({
        order: [[ 0, "desc" ]],
        select:  true,
        processing: true,
        serverSide: true,
        language: {
                 "url": '{!! asset('plugins/datatables/latino.json')  !!}'
                   } ,
        ajax: '{!! url('listado_entregas_data') !!}',
        columns: [
            { data: 'idventa', name: 'venta.idventa' },
            { data: 'fecha_hora', name:'venta.fecha_hora' },
            { data: 'zona', name:'venta.zona' },
            { data: 'nombre_apellido', name: 'persona.nombre_apellido' },
            { data: 'monto', name: 'venta.monto' },
            { data: 'plan', name: 'venta.plan' },
            { data: 'fecha_cancela', name: 'venta.fecha_cancela' },
            { data: 'concepto', name: 'venta.concepto' },
            { data: 'empleado', name: 'venta.empleado' },
            { data: 'estado', name:'venta.estado' },
            { data: null, render: function ( data, type, row ) {
                return "<a href='{{ url('editar_entrega/') }}/"+ data.idventa +"' <button title='Editar' class='btn btn-info btn-sm'><i class='fa fa-pencil-square-o'></i></button></a> <a href='{{ url('activar_entrega/') }}/"+ data.idventa +"' <button title='Activar' class='btn btn-success btn-sm'><i class='fa fa-power-off' aria-hidden='true'></i></button></a>	<a href='{{ url('eliminar_entrega/') }}/"+ data.idventa +"' <button title='Eliminar' class='btn btn-danger btn-sm'><i class='fa fa-trash-o' aria-hidden='true'></i></button></a> <a href='{{ url('reporte_entrega/') }}/"+ data.idventa +"' <button title='imprimir' class='btn btn-warning btn-sm' target='_blank'><i class='fa fa-print' aria-hidden='true'></i></button></a>" 
                }
            }
        ]
    });
  });		 
}

activar_tabla_entregas();

</script>
@endpush
@endsection