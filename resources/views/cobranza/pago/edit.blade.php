@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Pago:</h3>
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
			{!!Form::model($cobranza,['method'=>'PATCH','route'=>['cobranza.pago.update',$cobranza->idcobranza]])!!}
            {{Form::token()}}
    <div class="row">
       <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="credito">Credito</label>
                <select name="credito" id="credito" class="form-control selectpicker" data-live-search="true">
                    @foreach($creditos as $cred)
                     <option value="{{$cred->idcredito}}">{{$cred->idcredito.'-'. $cred->nombre_apellido}}</option>
                     @endforeach

                </select>
            </div>
        </div>
        <div class="col-lg-1 col-sm-1 col-md-1 col-xs-12">
            <div class="form-group">
                <label for="zona">Zona</label>
                <select name="zona" class="form-control">
                    @if ($cobranza->zona=='Z0')
                       <option value="Z0" selected>Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                       <option value="Z7">Z7</option>
                    @elseif ($cobranza->zona=='Z1')          
                       <option value="Z0">Z0</option>
                       <option value="Z1" selected>Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                       <option value="Z7">Z7</option>                       
                    @elseif ($cobranza->zona=='Z2')
                       <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2" selected>Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                       <option value="Z7">Z7</option>
                    @elseif ($cobranza->zona=='Z3')
                       <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3" selected>Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                       <option value="Z7">Z7</option>
                    @elseif ($cobranza->zona=='Z4')
                       <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4" selected>Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                       <option value="Z7">Z7</option>
                    @elseif ($cobranza->zona=='Z5')
                       <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5" selected>Z5</option>
                       <option value="Z6">Z6</option>
                    @elseif ($cobranza->zona=='Z6')
                       <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6" selected >Z6</option>
                    @else 
                       <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                       <option value="Z7" selected >Z7</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="monto">Monto</label>
                <input type="text" name="monto" value="{{$cobranza->monto}}" class="form-control">
            </div>
        </div>
         <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" name="fecha_hora" value="{{$cobranza->fecha_hora}}" class="form-control">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
        </div>
    </div>   

{!!Form::close()!!}		         
@push ('scripts')
<script>
$('#licobranzas').addClass("treeview active");
$('#liClientes').addClass("active");
</script>
@endpush
@endsection