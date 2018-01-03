@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3>Refinanciar Credito</h3>
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
{!!Form::model($refinanciacion,['method'=>'PATCH','route'=>['venta.refinanciacion.update',$refinanciacion->idrefinanciacion]])!!}
{{Form::token()}}
<div class="row">
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="cliente">Cliente</label>
                <input type="text" name="cliente" id="cliente" value="{{$refinanciacion->cliente}}" class="form-control">
            </div>
        </div>

        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="plan">Plan</label>
               <select name="plan" id="plan" class="form-control">
                   <option value="o">Plan</option>
                   <option value="1">26 dias</option>
                   <option value="2">35 dias</option>
                   <option value="3">4 semanas</option>
                   <option value="4">5 semanas</option>
                   <option value="5">6 semanas</option>
                   <option value="6">Especial</option>
               </select>
            </div>
        </div>

        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="saldo">Saldo</label>
                <input type="text" name="saldo" id="saldo" value="{{$refinanciacion->saldo}}" class="form-control" >
            </div>
        </div>
        
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="vencimiento">Cancelación</label>
                <input type="date"   name="vencimiento" value="{{$refinanciacion->vencimiento}}" class="form-control">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group" id="botones">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
        <button type="button"  id="actualizar" class="btn btn-default" >Actualizar saldo</button>
        </div>
    </div>  
{{Form::Close()}} 
@push ('scripts')
<script>
$(document).ready(function(){
    $('#actualizar').click(function(){
      calculo();
    });
});

$("#botones").hide();
var calculo = function(){

                
                var plan = parseInt(document.getElementById("plan").value);
                
                switch(plan){
                    case 1:
                        var saldo = parseInt(document.getElementById("saldo").value);
                        var interes = 30;
                        var calculo = saldo * interes/100;
                        var total = saldo + calculo;
                        $("#saldo").val(total.toFixed(2));
                        break;
                    case 2:
                        var saldo = parseInt(document.getElementById("saldo").value);
                        var interes = 40;
                        var calculo = saldo * interes/100;
                        var total = saldo + calculo;
                        $("#saldo").val(total.toFixed(2));
                        break;
                    case 3:
                        var saldo = parseInt(document.getElementById("saldo").value);
                        var interes = 24;
                        var calculo = saldo * interes/100;
                        var total = saldo + calculo;
                        $("#saldo").val(total.toFixed(2));
                        break;
                    case 4:
                        var saldo = parseInt(document.getElementById("saldo").value);
                        var interes = 30;
                        var calculo = saldo * interes/100;
                        var total = saldo + calculo;
                        $("#saldo").val(total.toFixed(2));
                        break;
                    
                    case 5:
                        var saldo = parseInt(document.getElementById("saldo").value);
                        var interes = 36;
                        var calculo = saldo * interes/100;
                        var total = saldo + calculo;
                        $("#saldo").val(total.toFixed(2));
                        break;
                    case 6:
                        alert('Ingrese el saldo');
                        $("#botones").show();
                        break;
                }
                
                

                $("#botones").show();
        }


$('#lirefinanciacions').addClass("treeview active");
$('#lirefinanciaciones').addClass("active");
  
</script>

@endpush    
@endsection