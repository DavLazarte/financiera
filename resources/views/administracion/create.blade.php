@extends ('layouts.admin')
@section ('contenido')
   
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Caja Diaria</h3>
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
			{!!Form::open(array('url'=>'administracion/caja','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
    <div class="row">
    	
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                    <div class="form-group">
                        <label>Ingreso</label>
                        <select name="idingreso" class="form-control selectpicker" id="pidingreso" data-live-search="true">
                            @foreach($ingresos as $ingreso)
                            <option value="{{$ingreso->idingreso}}_{{$ingreso->zona}}_{{$ingreso->monto}}">{{$ingreso->idingreso}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="zona">Zona</label>
                        <input type="text"  disabled name="zona" id="pzona" class="form-control">
                    </div>
                </div>
            
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="monto">Monto</label>
                        <input type="number" disabled name="monto" id="pmonto" class="form-control">
                    </div>
                </div>
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                       <button type="button" id="bt_addi" class="btn btn-primary">Agregar Ingreso</button>
                    </div>
                </div>

                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <table id="idetalles" class="table table-striped table-bordered table-condensed table-hover">
                        <thead style="background-color:#A9D0F5">
                            <th>Opciones</th>
                            <th>Ingreso</th>
                            <th>Zona</th>
                            <th>Monto</th>
                        </thead>
                        <tfoot>
                            <tr>
                                <th  colspan="5"><p align="right">TOTAL ENTRADA:</p></th>
                                <th><p align="right"><input type="number" name="totalingreso" id="totalingreso" value="0.00"></p></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            
                        </tbody>
                    </table>
                 </div>
            </div>
        <div class="panel-body">
                <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                    <div class="form-group">
                        <label>Salida</label>
                        <select name="idsalida" class="form-control selectpicker" id="pidsalida" data-live-search="true">
                            @foreach($salidas as $salida)
                            <option value="{{$salida->idsalida}}_{{$salida->destino}}_{{$salida->monto}}">{{$salida->idsalida}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="destino">Destino</label>
                        <input type="text" disabled name="destino" id="pdestino" class="form-control">
                    </div>
                </div>
            
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="monto">Monto</label>
                        <input type="number" disabled name="smonto" id="smonto" class="form-control">
                    </div>
                </div>
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                       <button type="button" id="bt_adds" class="btn btn-primary">Agregar Salida</button>
                    </div>
                </div>

                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <table id="sdetalles" class="table table-striped table-bordered table-condensed table-hover">
                        <thead style="background-color:#A9D0F5">
                            <th>Opciones</th>
                            <th>Salida</th>
                            <th>Destino</th>
                            <th>Monto</th>
                        </thead>
                        <tfoot>
                            <tr>
                                <th  colspan="5"><p align="right">TOTAL SALIDA:</p></th>
                                <th><p align="right"><input type="number" name="totalsalida" id="totalsalida" value="0.00"></th>
                            </tr>
                            <tr>
                                <th  colspan="5"><p align="right">CIERRE ANTERIOR:</p></th>
                                <th><p align="right"><input type="number" name="cierreold" id="cierreold" value="1000.00"></th>
                            </tr>

                        </tfoot>
                        <tbody>
                            
                        </tbody>
                    </table>
                 </div>
            </div>
        </div>
      <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" id="nuevototal">
      <div class="form-group" >
            <label for="nuevoCierre">Nuevo Cierre</label>
            <input type="number" name="totalsuma" id="cierrenew" value="0.00">
            <button type="button" id="bt_total" class="btn btn-success" >Nuevo Total</button>
    </div>
     </div>
    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" id="guardar">
    		<div class="form-group">
            	<input name"_token" value="{{ csrf_token() }}" type="hidden"></input>
              <button class="btn btn-primary" type="submit">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
    	</div>
    </div>   
{!!Form::close()!!}		

@push ('scripts')
<script>
  $(document).ready(function(){
    $('#bt_addi').click(function(){
      agregarIngreso();
    });
  });

   $(document).ready(function(){
    $('#bt_adds').click(function(){
      agregarSalida();
    });
  });
   $(document).ready(function(){
    $('#bt_total').click(function(){
      nuevoTotal();
    });
  });
   
  var cont=0;
  $("#nuevototal").hide();
  $("#guardar").hide();
  $("#pidingreso").change(mostrarIngreso);
  $("#pidsalida").change(mostrarSalida);
  

  function mostrarIngreso()
  {
    datosIngreso=document.getElementById('pidingreso').value.split('_')
    $("#pmonto").val(datosIngreso[2]);
    $("#pzona").val(datosIngreso[1]);    
  }
  function mostrarSalida()
  {
    datosSalida=document.getElementById('pidsalida').value.split('_')
    $("#smonto").val(datosSalida[2]);
    $("#pdestino").val(datosSalida[1]);    
  }

  function agregarIngreso()
  {

    datosIngreso=document.getElementById('pidingreso').value.split('_');

    idingreso=datosIngreso[0];
    ingreso=$("#pidingreso option:selected").text();
    zona=$("#pzona").val();
    monto=$("#pmonto").val();

    if (idingreso!="" && ingreso!=""  && zona!="" && monto!="")
    {

        var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="ingreso[]" value="'+idingreso+'">'+ingreso+'</td><td><input type="text" name="zona[]" value="'+zona+'"></td><td><input type="number" name="monto[]" value="'+parseFloat(monto).toFixed(2)+'"></td></tr>';
        cont++;
        totalingreso();
        evaluar();
        $('#idetalles').append(fila);  
    }
    else
    {
        alert("Error al ingresar el detalle de la Caja, revise los datos");
    }
    
  }

  function agregarSalida()
  {

    datosSalida=document.getElementById('pidsalida').value.split('_');

    idsalida=datosSalida[0];
    salida=$("#pidsalida option:selected").text();
    destino=$("#pdestino").val();
    monto=$("#smonto").val();

    if (idsalida!="" && salida!=""  && destino!="" && monto!="")
    {

        var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="salida[]" value="'+idsalida+'">'+salida+'</td><td><input type="text" name="destino[]" value="'+destino+'"></td><td><input type="number" name="smonto[]" value="'+parseFloat(monto).toFixed(2)+'"></td></tr>';
        cont++;
        totalsalida();
        evaluar();
        $('#sdetalles').append(fila);   
    }
    else
    {
        alert("Error al ingresar el detalle de la Caja, revise los datos");
    }
    
  }

  function limpiar(){
    $("#pzona").val("");
    $("#pmonto").val("");
  }
  function totalingreso()
  {
        var total = parseInt(document.getElementById("totalingreso").value);
        var monto = parseInt(document.getElementById("pmonto").value);
        var totali = total + monto;
        $("#totalingreso").val(totali.toFixed(2));
  }
  function totalsalida()
  {
        var total = parseInt(document.getElementById("totalsalida").value);
        var monto = parseInt(document.getElementById("smonto").value);
        var totals = total + monto;
        $("#totalsalida").val(totals.toFixed(2));
  }

  function nuevoTotal()
  {
      var ingreso = parseInt(document.getElementById("totalingreso").value);
      var salida = parseInt(document.getElementById("totalsalida").value);
      var cierreold = parseInt(document.getElementById("cierreold").value);
      var cierrenew = cierreold + ingreso - salida;
      $("#cierrenew").val(cierrenew.toFixed(2));
      evaluarg();

  }
  function evaluarg()
  {
    var cierren = parseInt(document.getElementById("cierrenew").value);
    if (cierren!=0) {
      $("#guardar").show();
    }
    else{
      $("#guardar").hide();
    }
  }

  function evaluar()
  {
    var ingreso = parseInt(document.getElementById("totalingreso").value);
    var salida = parseInt(document.getElementById("totalsalida").value);
    if (ingreso>0 && salida>0)
    {
      $("#nuevototal").show();
    }
    else
    {
      $("#nuevototal").hide(); 
    }
   }

   function eliminar(index){  
    $("#fila" + index).remove();


  }

$('#liVentas').addClass("treeview active");
$('#liVentass').addClass("active");
  
</script>
@endpush
@endsection