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
                <div class="col-lg-1 col-sm-1 col-md-1 col-xs-12">
                    <div class="form-group">
                        <label>Zona I</label>
                        <select name="zonaingreso" class="form-control selectpicker" id="pzonaingreso" data-live-search="true">
                            @foreach($ingresos as $ing)
                            <option value="{{$ing->zona}}_{{$ing->idingreso}}_{{$ing->monto}}">{{$ing->zona}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="ingreso">Ingreso</label>
                        <input type="text"  disabled name="idingreso" id="pidingreso" class="form-control">
                    </div>
                </div>
            
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="montoingreso">Monto ingreso</label>
                        <input type="number" disabled name="montoingreso" id="pmontoingreso" class="form-control">
                    </div>
                </div>
                 <div class="col-lg-1 col-sm-1 col-md-1 col-xs-12">
                    <div class="form-group">
                        <label>Zona S</label>
                        <select name="zonasalida" class="form-control selectpicker" id="pzonasalida" data-live-search="true">
                            @foreach($salidas as $sal)
                            <option value="{{$sal->zona}}_{{$sal->idsalida}}_{{$sal->monto}}_{{$sal->concepto}}">{{$sal->zona}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="salida">Salida</label>
                        <input type="text"  disabled name="idsalida" id="pidsalida" class="form-control">
                    </div>
                </div>
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="montosalida">Monto salida</label>
                        <input type="number" disabled name="montosalida" id="pmontosalida" class="form-control">
                    </div>
                </div>
              
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="concepto">Concepto</label>
                        <input type="text" disabled name="concepto" id="pconcepto" class="form-control">
                    </div>
                </div>
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                       <button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
                    </div>
                </div>

                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                        <thead style="background-color:#A9D0F5">
                            <th>Opciones</th>
                            <th>Zona entrada</th>
                            <th>Ingreso</th>
                            <th>Monto ent</th>
                            <th>Zona salida</th>
                            <th>Salida</th>
                            <th>Monto Sal</th>
                            <th>Concepto</th>
                        </thead>
                        <tfoot>
                            <tr>
                                <th  colspan="7"><p align="right">SUBTOTAL ENTRADAS:</p></th>
                                <th><p align="right"><input type="number" name="totalingreso" id="totalingreso" value="0.00"></p></th>
                            </tr>
                            <tr>
                                <th  colspan="7"><p align="right">SUBTOTAL SALIDAS:</p></th>
                                <th><p align="right"><input type="number" name="totalsalida" id="totalsalida" value="0.00"></p></th>
                            </tr>
                            <tr>
                                <th  colspan="7"><p align="right">ULTIMO CIERRE:</p></th>
                                <th><p align="right">
                                  <input type="number" name="cierreold" id="cierreold" value="{{$cajas->totalsuma}}">
                                </p></th>
                            </tr>
                            <tr>
                                <th  colspan="7"><p align="right">TOTAL CAJA:</p></th>
                                <th><p align="right"><input type="number" name="totalsuma" id="cierrenew" value="0.00"></p></th>
                            </tr>

                        </tfoot>
                        <tbody>
                            
                        </tbody>
                    </table>
                 </div>
            </div>
       
            </div>
        </div>
      <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" id="nuevototal">
      <div class="form-group" >
            <button type="button" id="bt_total" class="btn btn-success" >Cerrar Caja</button>
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
    $('#bt_add').click(function(){
      agregar();
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
  $("#pzonaingreso").change(mostrarIngreso);
  $("#pzonasalida").change(mostrarSalida);
  

  function mostrarIngreso()
  {
    datosIngreso=document.getElementById('pzonaingreso').value.split('_')
    $("#pmontoingreso").val(datosIngreso[2]);
    $("#pidingreso").val(datosIngreso[1]);    
  }
  function mostrarSalida()
  {
    datosSalida=document.getElementById('pzonasalida').value.split('_')
    $("#pconcepto").val(datosSalida[3]);
    $("#pmontosalida").val(datosSalida[2]);
    $("#pidsalida").val(datosSalida[1]);    
  }

  function agregar()
  {

    datosIngreso=document.getElementById('pzonaingreso').value.split('_');
    datosSalida=document.getElementById('pzonasalida').value.split('_')

    zonaingreso=datosIngreso[0];
    ingreso=$("#pidingreso").val();
    montoingreso=$("#pmontoingreso").val();
    zonasalida=datosSalida[0];
    salida=$("#pidsalida").val();
    montosalida=$("#pmontosalida").val();
    concepto=$("#pconcepto").val();

    if (zonaingreso!="" && ingreso!=""  && montoingreso!="")
    {

        var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="zonaingreso[]" value="'+zonaingreso+'">'+zonaingreso+'</td><td><input type="text" name="ingreso[]" value="'+ingreso+'"></td><td><input type="number" name="montoingreso[]" value="'+parseFloat(montoingreso).toFixed(2)+'"></td><td><input type="hidden" name="zonasalida[]" value="'+zonasalida+'">'+zonasalida+'</td><td><input type="text" name="salida[]" value="'+salida+'"></td><td><input type="number" name="montosalida[]" value="'+parseFloat(montosalida).toFixed(2)+'"></td><td><input type="text" name="concepto[]" value="'+concepto+'"></td></tr>';
        cont++;
        $('#detalles').append(fila);  
        totalingreso();
        totalsalida();
        evaluar();
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
        var totalingreso = parseInt(document.getElementById("totalingreso").value);
        var montoingreso = parseInt(document.getElementById("pmontoingreso").value);
        var totali = totalingreso + montoingreso;
        $("#totalingreso").val(totali.toFixed(2));
  }
  function totalsalida()
  {
        var totalsalida = parseInt(document.getElementById("totalsalida").value);
        var montosalida = parseInt(document.getElementById("pmontosalida").value);
        var totals = totalsalida + montosalida;
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
    if (ingreso>0 || salida>0)
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