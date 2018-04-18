@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Cargar Pago Nuevo</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif
		</div>
	</div>
    <div id="msj-success" class="alert alert-success" role="alert" style="display:none">
    <button class="close" data-dismiss="alert"><span>&times;</span></button>
        Pago Cargado Correctamente
    </div>
    <div class="row">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="idventa"> Elegir Credito</label>
                <select name="idventa" id="pcredito" class="form-control selectpicker" data-live-search="true">
                    @foreach($creditos as $cred)
                     <option value="{{$cred->idcredito}}_{{$cred->zona}}_{{$cred->cliente}}_{{$cred->saldo}}_{{$cred->proyeccion}}_{{$cred->vencimiento}}_{{$cred->estado}}">{{$cred->idcredito.'-'. $cred->nombre_apellido}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" name="fecha_hora" id="fecha" class="form-control">
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">        
            <div class="form-group">
              <label for="monto">Monto</label>
              <input type="text" name="monto" id="monto" value="{{old('monto')}}" class="form-control" placeholder="Monto Abonada">
            </div>
        </div>
            <!--<div class="form-group">
                <label for="zona">Zona</label>
                <select name="zona" class="form-control" id="zona">
                       <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                       <option value="Z7">Z7</option>
                </select>
            </div>-->
        </div>
        <div class="row" id="datoscredito">
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
              <h3>Datos del Credito</h3>
            </div>
                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                    <div class="form-group">
                        <label for="id">N° Credito</label>
                        <input type="text" class="form-control"  readonly id="id">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                    <div class="form-group">
                        <label for="zona">Zona</label>                              
                        <input type="text" class="form-control"  readonly id="pzona">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                    <div class="form-group">
                        <label for="cliente">Cliente</label>
                        <input type="text" class="form-control"  readonly id="pcliente">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">        
                    <div class="form-group">
                      <label for="saldo">Saldo</label>
                      <input type="text" class="form-control"  readonly id="saldo">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">        
                    <div class="form-group">
                        <label for="proyeccion">Proyeccion</label>
                        <input type="text" class="form-control"  readonly id="proyeccion">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">        
                    <div class="form-group">
                        <label for="vencimiento">Vencimiento</label>
                        <input type="text" class="form-control"  readonly id="vencimiento">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">        
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <input type="text" class="form-control"  readonly id="estado">
                    </div>
                </div>               
        <input type="hidden" class="form-control" name="estado" value="Activo" id="estado">                
        </div>
    	<div class="col-lg-9 col-sm-9 col-md-9 col-xs-12">
    		<div class="form-group">
            	<button class="btn btn-primary" type="submit" id="guardar">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
    	</div>

@push ('scripts')
<script>
$('#liVentas').addClass("treeview active");
$('#liClientes').addClass("active");
</script>
<script>
    $("#datoscredito").hide();
    $("#pcredito").change(mostrarCredito);

    $("#guardar").click(function(){
    var credito    = $("#id").val();
    var fecha      = $("#fecha").val();
    var zona       = $("#pzona").val();
    var monto      = $("#monto").val();
    var estado     = $("#estado").val();
    var route      = "{{url('cobranza/pago')}}";
    var token      = $("#token").val();

    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:{idventa: credito,
              fecha_hora: fecha,
              zona: zona,
              monto: monto,
              estado: estado,
            },

        success:function(){
            $("#msj-success").fadeIn();
        },
        error:function(msj){
            $("#msj").html(msj.responseJSON.idventa);
            $("#msj-error").fadeIn();
        }
    });
});

function mostrarCredito(){
    datosCreditos=document.getElementById('pcredito').value.split('_')
    $("#id").val(datosCreditos[0]);
    $("#pzona").val(datosCreditos[1]);
    $("#pcliente").val(datosCreditos[2]);
    $("#saldo").val(datosCreditos[3]);
    $("#proyeccion").val(datosCreditos[4]);
    $("#vencimiento").val(datosCreditos[5]);
    $("#estado").val(datosCreditos[6]);
    $("#datoscredito").show();    

}
</script>
@endpush
@endsection