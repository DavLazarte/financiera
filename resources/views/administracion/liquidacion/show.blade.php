@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
    	<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
    		<div class="form-group">
            	<label for="liquidacion">Numero de liquidacion</label>
            	<p>{{$liquidacion->idliquidacion}}</p>
            </div>
    	</div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label>Fecha</label>
                <p>{{ Carbon\Carbon::parse($liquidacion->created_at)->format('d-m-Y')}}</p>
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label>Empleado</label>
                <p>{{$liquidacion->empleado}}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-body">            

                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                        <thead style="background-color:#A9D0F5">
                            <th>Codigo</th>
                            <th>Zona</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Cobranza</th>
                            <th>Comision</th>
                            <th>Anticipo</th>
                            <th>Premio</th>
                        </thead>
                        <tfoot>
                            <tr>
                                <th  colspan="8"><p align="right">RECAUDACION:</p></th>
                                <th><p align="right">$/. {{$liquidacion->totalrec}}</p></th>
                            </tr>
                            <tr>
                                <th colspan="8"><p align="right">COMISION:</p></th>
                                <th><p align="right">$/. {{$liquidacion->total_comision}}</p></th>
                            </tr>
                            <tr>
                                <th  colspan="8"><p align="right">TOTAL:</p></th>
                                <th><p align="right">$/. {{$liquidacion->total}}</p></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($detalles as $det)
                            <tr>
                                <td>{{$det->iddetalle_liquidacion}}</td>
                                <td>{{$det->zona}}</td>
                                <td>{{Carbon\Carbon::parse($det->fecha_inicio)->format('d-m-Y')}}</td>
                                <td>{{Carbon\Carbon::parse($det->fecha_fin)->format('d-m-Y')}}</td>
                                <td>{{$det->cobranza}}</td>
                                <td>{{$det->comision}}</td>
                                <td>{{$det->anticipo}}</td>
                                <td>{{$det->premio}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                 </div>
            </div>
        </div>
    	
    </div>   
@push ('scripts')
<script>
$('#liVentas').addClass("treeview active");
$('#liVentass').addClass("active");
</script>
@endpush
@endsection