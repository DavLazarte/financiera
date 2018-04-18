@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Cargar Nueva Entrega</h3>
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
            Entrega Cargada Correctamente
    </div>
    <div class="row">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
    <div class="col-lg-9 col-sm-9 col-md-9 col-xs-12">
        <div class="form-group">
            <label for="fecha_hora">Inicio</label>
            <input type="date"  id="inicio" name="fecha_hora" value="{{old('fecha_hora')}}" class="form-control" >
        </div>
        <div class="form-group">
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
        </div>
        <div class="form-group">
            <label for="cliente">Cliente</label>
            <select name="cliente" id="cliente" class="form-control selectpicker" data-live-search="true">
                @foreach($clientes as $cliente)
                  <option value="{{$cliente->idpersona}}">{{$cliente->nombre_apellido}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="monto">Monto</label>
            <input type="text" id="monto" name="monto" value="{{old('monto')}}" class="form-control" placeholder="Monto entregado">
        </div>
        <div class="form-group">
            <label for="plan">Plan</label>
           <select name="plan" id="plan" class="form-control">
               <option value="1">26 dias</option>
               <option value="2">35 dias</option>
               <option value="3">4 semanas</option>
               <option value="4">5 semanas</option>
               <option value="5">6 semanas</option>
               <option value="6">Especial</option>
           </select>
        </div>
        <div class="form-group">
            <label for="fecha_cancela">Cancelación</label>
            <input type="date"  id="cancelacion" name="fecha_cancela" value="{{old('fecha_cancela')}}" class="form-control" placeholder="Fecha de Cancelación">
        </div>
        <div class="form-group">
            <label for="concepto">Concepto</label>
            <select name="concepto" class="form-control" id="concepto">
                   <option value="nuevo">Nuevo</option>
                   <option value="recuperacion">Recuperación</option>
                   <option value="renovacion">Renovación</option>
                   <option value="paralela">Paralela</option>
                   <option value="especial">Especial</option>
            </select>
        </div>
        <div class="form-group">
            <label for="empleado">Entrega</label>
            <select name="empleado" class="form-control" id="entrega">
                    <option value="dani">Dani Miranda</option>
                    <option value="karina">Karina Fenoglio</option>
                    <option value="leo">Leo Escobar</option>
                    <option value="david">David Lazarte</option>
                    <option value="veronica">Veronica Huerta</option>
                    <option value="dante">Dante Miranda</option>
                    <option value="dario">Dario Ogas</option>
                    <option value="alvaro">Alvaro Nieva</option>
                    <option value="santiago">Santiago Ruiz</option>
            </select>
        </div>
    </div>
    <input type="hidden" name="estado" value="PENDIENTE" id="estado">
    	<div class="col-lg-7 col-sm-7 col-md-7 col-xs-12">
    		<div class="form-group">
            	<button class="btn btn-primary" type="submit" id="guardar">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
    	</div>
    </div>   
	
@push ('scripts')
<script>
$('#liVentas').addClass("treeview active");
$('#liClientes').addClass("active");
</script>
<script>
    $("#guardar").click(function(){
    var zona         = $("#zona").val();
    var cliente      = $("#cliente").val();
    var entrega      = $("#entrega").val();
    var monto        = $("#monto").val();
    var plan         = $("#plan").val();
    var inicio       = $("#inicio").val();
    var cancelacion  = $("#cancelacion").val();
    var concepto     = $("#concepto").val();
    var estado       = $("#estado").val();
    var route        = "{{url('venta/entrega')}}";
    var token        = $("#token").val();

    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data:{fecha_hora: inicio,
              zona: zona,
              idpersona: cliente,
              monto: monto,
              plan: plan,
              fecha_cancela: cancelacion,
              concepto: concepto,
              empleado: entrega,
              estado: estado,
            },

        success:function(){
            $("#msj-success").fadeIn();
        },
        error:function(msj){
            $("#msj").html(msj.responseJSON.entrega);
            $("#msj-error").fadeIn();
        }
    });
});
</script>
@endpush
@endsection