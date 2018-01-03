@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
    	<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
    		<div class="form-group">
            	<label for="caja">Numero de Caja</label>
            	<p>{{$caja->idcaja}}</p>
            </div>
    	</div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label>Fecha</label>
                <p>{{ Carbon\Carbon::parse($caja->created_at)->format('d-m-Y')}}</p>
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
                            <th>Zona Ing</th>
                            <th>Ingreso</th>
                            <th>Monto Ing</th>
                            <th>Zona Sal</th>
                            <th>Salida</th>
                            <th>Monto Sal</th>
                            <th>Concepto</th>
                        </thead>
                        <tfoot>
                            <tr>
                                <th  colspan="8"><p align="right">TOTAL INGRESO:</p></th>
                                <th><p align="right">$/. {{$caja->totalingreso}}</p></th>
                            </tr>
                            <tr>
                                <th colspan="8"><p align="right">TOTAL SALIDA:</p></th>
                                <th><p align="right">$/. {{$caja->totalsalida}}</p></th>
                            </tr>
                            <tr>
                                <th  colspan="8"><p align="right">TOTAL CAJA:</p></th>
                                <th><p align="right">$/. {{$caja->totalsuma}}</p></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($detalles as $det)
                            <tr>
                                <td>{{$det->iddetalle_caja}}</td>
                                <td>{{$det->zonaingreso}}</td>
                                <td>{{$det->ingreso}}</td>
                                <td>{{$det->montoingreso}}</td>
                                <td>{{$det->zonasalida}}</td>
                                <td>{{$det->salida}}</td>
                                <td>{{$det->montosalida}}</td>
                                <td>{{$det->concepto}}</td>
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