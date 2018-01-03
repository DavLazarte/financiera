@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3>Editar Credito</h3>
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
{!!Form::model($activo,['method'=>'PATCH','route'=>['venta.activo.update',$activo->idcredito]])!!}
{{Form::token()}}
<div class="row">

        <div class="col-lg-1 col-sm-1 col-md-1 col-xs-12">
            <div class="form-group">
                <label for="zona">Zona</label>
                <input type="text" name="zona" id="zona" value="{{$activo->zona}}" class="form-control">
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="cliente">Cliente</label>
                <input type="text" name="cliente" id="cliente" value="{{$activo->cliente}}" class="form-control">
            </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="saldo">Saldo</label>
                <input type="text" name="saldo" id="saldo" value="{{$activo->saldo}}" class="form-control" >
            </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="proyeccion">Proyección</label>
                <input type="text" name="proyeccion" id="proyeccion" value="{{$activo->proyeccion}}" class="form-control">
            </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="vencimiento">Cancelación</label>
                <input type="date"   name="vencimiento" value="{{$activo->vencimiento}}" class="form-control">
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

                
        var proyeccion = parseInt(document.getElementById("proyeccion").value);
                
          switch(proyeccion){
                    case 1:
                        var saldo = parseInt(document.getElementById("saldo").value);
                        var interes = 30;
                        var calculo = saldo * interes/100;
                        var total = saldo + calculo;
                        var pro1 = total / 26;
                        var pro2 = pro1 * 6;
                        $("#proyeccion").val(pro2);
                        $("#saldo").val(total.toFixed(2));
                        break;
                    case 2:
                        var saldo = parseInt(document.getElementById("saldo").value);
                        var interes = 40;
                        var calculo = saldo * interes/100;
                        var total = saldo + calculo;
                        var pro1 = total / 35;
                        var pro2 = pro1 * 6;
                        $("#proyeccion").val(pro2);
                        $("#saldo").val(total.toFixed(2));
                        break;
                    case 3:
                        var saldo = parseInt(document.getElementById("saldo").value);
                        var interes = 24;
                        var calculo = saldo * interes/100;
                        var total = saldo + calculo;
                        var pro = total / 4;
                        $("#proyeccion").val(pro);
                        $("#saldo").val(total.toFixed(2));
                        break;
                    case 4:
                        var saldo = parseInt(document.getElementById("saldo").value);
                        var interes = 30;
                        var calculo = saldo * interes/100;
                        var total = saldo + calculo;
                        var pro = total / 5;
                        $("#proyeccion").val(pro);
                        $("#saldo").val(total.toFixed(2));
                        break;
                    
                    case 5:
                        var saldo = parseInt(document.getElementById("saldo").value);
                        var interes = 36;
                        var calculo = saldo * interes/100;
                        var total = saldo + calculo;
                        var pro = total / 6;
                        $("#proyeccion").val(pro);
                        $("#saldo").val(total.toFixed(2));
                        break;
                    case 6:
                        alert('Ingrese el saldo y la Proyeccion Manualmente');
                        $("#botones").show();
                        break;
                }
                
                

                $("#botones").show();
        }


$('#liactivos').addClass("treeview active");
$('#liactivoes').addClass("active");
  
</script>

@endpush    
@endsection