<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-create-{{$ven->idventa}}">
    {!!Form::open(array('url'=>'venta/activo','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" 
                aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Cargar Credito</h4>
            </div>
            <div class="modal-body">
                <label>ESTE CREDITO SE ENCUENTRA:{{$ven->estado}}</label><br>
                <label>Credito n°</label>
                <input type="text"   name="idcredito" id="idcredito" value="{{$ven->idventa}}">
                <input type="hidden" name="zona" id="zona" value="{{$ven->zona}} ">
                <input type="hidden" name="cliente" id="cliente" value="{{$ven->nombre_apellido}} ">
                <input type="hidden" name="saldo" id="saldo" value="{{$ven->monto}}">
                <input type="hidden" name="proyeccion" id="proyeccion" value="{{$ven->plan}}">
                <input type="hidden" name="vencimiento" id="vencimiento" value="0">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="confirmar">Confirmar</button>
            </div>
        </div>
    </div>
    {!!Form::Close()!!}
    @push ('scripts')
<script>


$('#liVentas').addClass("treeview active");
$('#liVentass').addClass("active");
  
</script>


@endpush    
</div>