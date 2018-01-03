<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-delete-{{$act->idcredito}}">
	{{Form::Open(array('action'=>array('ActivoController@destroy',$act->idcredito),'method'=>'delete'))}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Cambiar estado</h4>
			</div>
			<div class="modal-body">
				<div class="modal-body">
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            	<div class="form-group">
                <label for="estado">Elegir Estado</label>
                <select name="estado" class="form-control">
                       <option value="Cancelado">Cancelado</option>
                       <option value="Activo">Activo</option>
                       <option value="Refinanciado">Refinanciado</option>
                       <option value="Unificado">Unificado</option>
                       <option value="Vencida">Vencida</option>
                </select>
            </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>