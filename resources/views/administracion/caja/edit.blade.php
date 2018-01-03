@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Actualizar</h3>
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
           {!!Form::model($caja,['method'=>'PATCH','route'=>['administracion.caja.update',$caja->idcaja]])!!}
            {{Form::token()}}
    
                
                   
                
            
            
                
                <button type="button"  id="calcular" class="btn btn-default" >Actualizar saldo</button>
                <button type="submit" id="save" class="btn btn-primary">Guardar</button>
   

{{Form::Close()}}
@push ('scripts')
<script>
$(document).ready(function(){
    $('#calcular').click(function(){
      suma();
    });
});

var resultado=0;
var suma = function(){
            var numero1 = parseInt(document.getElementById("sena").value);
            var numero2 = parseInt(document.getElementById("cuota").value);

            var resultado = numero1 + numero2;
            $("#sena").val(resultado.toFixed(2));
            
            //$("#nuevasena").val(0);

            var numero3 = parseInt(document.getElementById("total_venta").value);
            var numero4 = parseInt(document.getElementById("sena").value);

            var resultado2 = numero3 - numero4;

            $("#saldo").val(resultado2.toFixed(2));
            if (resultado2 === 0.00) 
            {
                $("#estado").val("cancelado");
            }
            else
            {
                $("#estado").val("debe");
            }
        }


$('#liVentas').addClass("treeview active");
$('#liVentass').addClass("active");
  
</script>


@endpush
@endsection