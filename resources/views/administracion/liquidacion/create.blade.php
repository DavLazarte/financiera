@extends ('layouts.admin')
@section ('contenido')
   
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Liquidacion de Sueldo</h3>
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
			{!!Form::open(array('url'=>'administracion/liquidacion','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
    <div class="row">
    	
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-body">
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="empleado">Empleado</label>
                <select name="empleado" id="empleado" class="form-control selectpicker" data-live-search="true">
                    @foreach($empleados as $empleado)
                     <option value="{{$empleado->idpersona}}">{{$empleado->nombre_apellido}}</option>
                     @endforeach
                </select>
            </div>
        </div>
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="periodo">Periodo</label>
                        <input type="text" name="periodo" id="pperiodo" class="form-control">
                    </div>
                </div>
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="fecha_inicio">Inicio</label>
                        <input type="date"  name="fecha_inicio" id="pinicio" class="form-control">
                    </div>
                </div>
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="fecha_fin">Fin</label>
                        <input type="date"  name="fecha_fin" id="pfin" class="form-control">
                    </div>
                </div>
                 <div class="col-lg-1 col-sm-1 col-md-1 col-xs-12">
                    <div class="form-group">
                        <label>Zona</label>
                        <select name="zona" class="form-control selectpicker" id="pzona" data-live-search="true">
                            @foreach($resumenes as $res)
                            <option value="{{$res->zona}}_{{$res->ingreso_semana}}_{{$res->anticipo}}">{{$res->zona}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="cobranza">Ingreso</label>
                        <input type="number"  disabled name="cobranza" id="pcobranza" class="form-control">
                    </div>
                </div>
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="anticipo">Anticipo</label>
                        <input type="number"  disabled name="anticipo" id="panticipo" class="form-control">
                    </div>
                </div>
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="premio">Premio</label>
                        <input type="number"  name="premio" id="ppremio" class="form-control">
                    </div>
                </div>
                 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="comision">% Comision</label>
                        <input type="number"   name="pcomision" id="pcomision" class="form-control">
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
                                <th  colspan="7"><p align="right">RECAUDACION:</p></th>
                                <th><p align="right"><input type="number" step="any" name="totalrec" id="totalrec" value="0.00"></p></th>
                            </tr>
                            <tr>
                                <th  colspan="7"><p align="right">COMISION Y PREMIO:</p></th>
                                <th><p align="right"><input type="number" step="any" name="total_comision" id="comision" value="0.00"></p></th>
                            </tr>
                            <tr>
                                <th  colspan="7"><p align="right">ANTICIPO:</p></th>
                                <th><p align="right">
                                  <input type="number" step="any" name="totalanti" id="anticipo" value="0.00">
                                </p></th>
                            </tr>
                            <tr>
                                <th  colspan="7"><p align="right">TOTAL:</p></th>
                                <th><p align="right"><input type="number" step="any" name="total" id="total" value="0.00"></p></th>
                            </tr>

                        </tfoot>
                        <tbody>
                            
                        </tbody>
                    </table>
                 </div>
            </div>
       
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
   
  var cont=0;
  total=0;
  totalrec=0;
  totalcom=0;
  totalanti=0;
  subpremio=[];
  subanti=[];
  subrec=[];
  subcom=[];
  $("#guardar").hide();
  $("#pzona").change(mostrarValores);

  function mostrarValores()
  {
    datos=document.getElementById('pzona').value.split('_')
    $("#pcobranza").val(datos[1]);
    $("#panticipo" ).val(datos[2]);    
  }

  function agregar()
  {

    datos=document.getElementById('pzona').value.split('_');
   
    zona=datos[0];
    fecha_inicio=$("#pinicio").val();
    fecha_fin=$("#pfin").val();
    cobranza=$("#pcobranza").val();
    porcentaje=$("#pcomision").val();
    comision=cobranza*porcentaje / 100;
    anticipo=$("#panticipo").val();;
    premio=$("#ppremio").val();

    if (zona!="" && fecha_inicio!="" && fecha_fin!=""  && cobranza!="" && comision!="" && anticipo!="" && premio!="")
    {
       
        subrec[cont]=parseFloat(cobranza);
        totalrec=totalrec+subrec[cont];
        subcom[cont]=parseFloat(comision);
        subpremio[cont]=parseFloat(premio);
        totalcom=totalcom+subcom[cont]+subpremio[cont];
        subanti[cont]=parseFloat(anticipo);
        totalanti=totalanti+subanti[cont];
        total=totalcom-totalanti;
        
        
        var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="zona[]" value="'+zona+'">'+zona+'</td><td><input type="date" name="fecha_inicio[]" value="'+fecha_inicio+'"></td><td><input type="date" name="fecha_fin[]" value="'+fecha_fin+'"></td><td><input type="number"  name="cobranza[]" value="'+parseFloat(cobranza).toFixed(2)+'"></td><td><input type="number"  name="comision[]" value="'+parseFloat(comision).toFixed(2)+'"></td><td><input type="number" name="anticipo[]" value="'+parseFloat(anticipo).toFixed(2)+'"></td><td><input type="number" name="premio[]" value="'+parseFloat(premio).toFixed(2)+'"></td></tr>';
        cont++;
        totales();
        limpiar();
        evaluar();
        $('#detalles').append(fila);
    }
    else
    {
        alert("Error al ingresar el detalle de la Caja, revise los datos");
    }
    
  }

  
  function limpiar(){
    $("#pinicio").val("");
    $("#pfin").val("");
    $("#pcomision").val("");
    $("#ppremio").val("");
  }
  
  function totales()
  {
    $("#totalrec").val(totalrec.toFixed(2));
    $("#comision").val(totalcom.toFixed(2));
    $("#anticipo").val(totalanti.toFixed(2));
    $("#total").val(total.toFixed(2));
  }
  function evaluar()
  {
    var liquida = parseInt(document.getElementById("total").value);
    if (liquida!=0) {
      $("#guardar").show();
    }
    else{
      $("#guardar").hide();
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