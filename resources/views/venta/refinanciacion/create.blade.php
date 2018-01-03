<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-create-{{$act->idcredito}}">

    {!!Form::open(array('url'=>'venta/refinanciacion','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" 
                aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Refinanciar Credito</h4>
            </div>
            <div class="modal-body">
                <p>Confirme si desea refinanciar el credito n° </p>
                <input type="text" name="credito" id="credito" value="{{$act->idcredito}}">
                <input type="hidden" name="cliente" id="cliente" value="{{$act->cliente}} ">
                <input type="hidden" name="saldo" id="saldo" value="{{$act->saldo}}">
                <input type="hidden" name="plan" id="plan" value="0">
                
                <input type="hidden" name="vencimiento" id="vencimiento" value="0">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Confirmar</button>
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