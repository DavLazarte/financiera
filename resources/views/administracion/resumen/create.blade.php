@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Resumen</h3>
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
	{!!Form::open(array('url'=>'administracion/resumen','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}
<?php 
foreach ($totales as $total)
{
?>
    <div class="row">
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="zona">Zona</label>
                <select name="zona" class="form-control" id="pzona">
                       <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                       <option value="Z7">Z7</option>
                </select>
            </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="ingreso_semana">Ingreso Semanal</label>
                <input type="text" name="ingreso_semana" id="pingreso" value="" class="form-control">
                <input type="hidden" id="iz0" value="<?php echo $total->ingresoz0;?>">
                <input type="hidden" id="iz1" value="<?php echo $total->ingresoz1;?>">
                <input type="hidden" id="iz2" value="<?php echo $total->ingresoz2;?>">
                <input type="hidden" id="iz3" value="<?php echo $total->ingresoz3;?>">
                <input type="hidden" id="iz4" value="<?php echo $total->ingresoz4;?>">
                <input type="hidden" id="iz5" value="<?php echo $total->ingresoz5;?>">
                <input type="hidden" id="iz6" value="<?php echo $total->ingresoz6;?>">
                <input type="hidden" id="iz7" value="<?php echo $total->ingresoz7;?>">
            </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="salida_semana">Salida Semanal</label>
                <input type="text" name="salida_semana" id="psalida" value="" class="form-control">
                <input type="hidden" id="sz0" value="<?php echo $total->salidaz0;?>">
                <input type="hidden" id="sz1" value="<?php echo $total->salidaz1;?>">
                <input type="hidden" id="sz2" value="<?php echo $total->salidaz2;?>">
                <input type="hidden" id="sz3" value="<?php echo $total->salidaz3;?>">
                <input type="hidden" id="sz4" value="<?php echo $total->salidaz4;?>">
                <input type="hidden" id="sz5" value="<?php echo $total->salidaz5;?>">
                <input type="hidden" id="sz6" value="<?php echo $total->salidaz6;?>">
                <input type="hidden" id="sz7" value="<?php echo $total->salidaz7;?>">
            </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="anticipo">Anticipo</label>
                <input type="text" name="anticipo" id="panticipo" value="" class="form-control">
                <input type="hidden" id="az0" value="<?php echo $total->anticipoz0;?>">
                <input type="hidden" id="az1" value="<?php echo $total->anticipoz1;?>">
                <input type="hidden" id="az2" value="<?php echo $total->anticipoz2;?>">
                <input type="hidden" id="az3" value="<?php echo $total->anticipoz3;?>">
                <input type="hidden" id="az4" value="<?php echo $total->anticipoz4;?>">
                <input type="hidden" id="az5" value="<?php echo $total->anticipoz5;?>">
                <input type="hidden" id="az6" value="<?php echo $total->anticipoz6;?>">
                <input type="hidden" id="az7" value="<?php echo $total->anticipoz7;?>">
            </div>
        </div>
                
    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" id="botones">
    		<div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
    	</div>
        <button class="btn btn-primary" type="button" id="cargar">Cargar</button>

    </div>   
<?php }?>
{!!Form::close()!!}		
@push ('scripts')
<script>
 $(document).ready(function(){
    $('#cargar').click(function(){
      cargar();
    });
  });
$("#botones").hide();
var cargar = function(){
    var zona=document.getElementById('pzona').value;
    if (zona == "Z0") {
            var ingreso=document.getElementById('iz0').value;
            var salida=document.getElementById('sz0').value;
            var anticipo=document.getElementById('az0').value;
            $("#pingreso").val(ingreso);
            $("#psalida").val(salida);
            $("#panticipo").val(anticipo);
            $("#botones").show();
        }
    if (zona=="Z1") {
            var ingreso=document.getElementById('iz1').value;
            var salida=document.getElementById('sz1').value;
            var anticipo=document.getElementById('az1').value;
            $("#pingreso").val(ingreso);
            $("#psalida").val(salida);
            $("#panticipo").val(anticipo);
            $("#botones").show();
    }
    if (zona=="Z2") {
            var ingreso=document.getElementById('iz2').value;
            var salida=document.getElementById('sz2').value;
            var anticipo=document.getElementById('az2').value;
            $("#pingreso").val(ingreso);
            $("#psalida").val(salida);
            $("#panticipo").val(anticipo);
            $("#botones").show();
    }
    if (zona=="Z3") {
            var ingreso=document.getElementById('iz3').value;
            var salida=document.getElementById('sz3').value;
            var anticipo=document.getElementById('az3').value;
            $("#pingreso").val(ingreso);
            $("#psalida").val(salida);
            $("#panticipo").val(anticipo);
            $("#botones").show();
    }
    if (zona=="Z4") {
            var ingreso=document.getElementById('iz4').value;
            var salida=document.getElementById('sz4').value;
            var anticipo=document.getElementById('az4').value;
            $("#pingreso").val(ingreso);
            $("#psalida").val(salida);
            $("#panticipo").val(anticipo);
            $("#botones").show();
    if (zona=="Z5") {
            var ingreso=document.getElementById('iz5').value;
            var salida=document.getElementById('sz5').value;
            var anticipo=document.getElementById('az5').value;
            $("#pingreso").val(ingreso);
            $("#psalida").val(salida);
            $("#panticipo").val(anticipo);
            $("#botones").show();
    }
    if (zona=="Z6") {
            var ingreso=document.getElementById('iz6').value;
            var salida=document.getElementById('sz6').value;
            var anticipo=document.getElementById('az6').value;
            $("#pingreso").val(ingreso);
            $("#psalida").val(salida);
            $("#panticipo").val(anticipo);
            $("#botones").show();
    }
    if (zona=="Z7") {
            var ingreso=document.getElementById('iz7').value;
            var salida=document.getElementById('sz7').value;
            var anticipo=document.getElementById('az7').value;
            $("#pingreso").val(ingreso);
            $("#psalida").val(salida);
            $("#panticipo").val(anticipo);
            $("#botones").show();
    }

}

}

$('#liVentas').addClass("treeview active");
$('#liClientes').addClass("active");
</script>
@endpush
@endsection