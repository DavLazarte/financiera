@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Nueva Salida</h3>
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
            {!!Form::open(array('url'=>'administracion/salida','method'=>'POST','autocomplete'=>'off','files'=>'true'))!!}
            {{Form::token()}}
    <div class="row">
        <div class="col-lg-1 col-sm-1 col-md-1 col-xs-12">
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
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="monto">Monto</label>
                <input type="text" name="monto" required value="{{old('monto')}}" class="form-control" placeholder="Monto de la Salida...">
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="concepto">Concepto</label>
                <input type="text" name="concepto" required value="{{old('concepto')}}" class="form-control" placeholder="Concepto de la Salida...">
            </div>
        </div>
        <div class="col-lg-9 col-sm-9 col-md-9 col-xs-12">
            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea name="observaciones" value="{{old('observaciones')}}" class="form-control" placeholder="Observaciones de la Salida..."></textarea>  
            </div>
        </div>
        <br>

        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
        </div>
    </div>
            
            
            

{!!Form::close()!!}
@push ('scripts')
<script>
$('#liAlmacen').addClass("treeview active");
$('#liArticulos').addClass("active");
</script>
@endpush

@endsection