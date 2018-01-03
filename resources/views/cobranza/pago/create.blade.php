@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Pago</h3>
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
			{!!Form::open(array('url'=>'cobranza/pago','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
    <div class="row">
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="idventa">Credito</label>
                <select name="idventa" id="idventa" class="form-control selectpicker" data-live-search="true">
                    @foreach($creditos as $cred)
                     <option value="{{$cred->idcredito}}">{{$cred->idcredito.'-'. $cred->nombre_apellido}}</option>
                     @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" name="fecha_hora" class="form-control">
            </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="zona">Zona</label>
                <select name="zona" class="form-control">
                       <option value="Z0">Z0</option>
                       <option value="Z1">Z1</option>
                       <option value="Z2">Z2</option>
                       <option value="Z3">Z3</option>
                       <option value="Z4">Z4</option>
                       <option value="Z5">Z5</option>
                       <option value="Z6">Z6</option>
                </select>
            </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="monto">Monto</label>
                <input type="text" name="monto" value="{{old('monto')}}" class="form-control" placeholder="Monto Abonada">
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
$('#liVentas').addClass("treeview active");
$('#liClientes').addClass("active");
</script>
@endpush
@endsection