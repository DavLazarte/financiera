<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-cliente">
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Nuevo Cliente</h4>
		</div>
		<div id="msj-success" class="alert alert-success" role="alert" style="display:none">
                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                Cliente Cargado
        </div>
		<div class="modal-body">
		   <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
			<div class="row">
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					<div class="form-group">
						<label for="nombre_apellido">Nombre</label>
						<input type="text" name="nombre_apellido" required value="{{old('nombre_apellido')}}" class="form-control" placeholder="Nombre y Apellido" id="nombre_apellido">
					</div>
					<div class="form-group">
						<label for="domicilio">Domicilio</label>
						<input type="text" name="domicilio" value="{{old('domicilio')}}" class="form-control" placeholder="Domicilio" id="domicilio">
					</div>
					<div class="form-group">
						<label for="dni">Número documento</label>
						<input type="text" name="dni" value="{{old('dni')}}" class="form-control" placeholder="Número de Documento" id="dni">
					</div>
					<div class="form-group">
						<label for="telefono">Teléfono</label>
						<input type="text" name="telefono" value="{{old('telefono')}}" class="form-control" placeholder="Teléfono..." id="telefono">
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
				<input type="hidden" name="tipo" value="Cliente" id="tipo">
				<input type="hidden" name="estado" value="Activo" id="estado">
			<div class="row">
				<div class="col-lg-7 col-sm-7 col-md-7 col-xs-12">
					<div class="form-group">
						<button class="btn btn-primary" type="submit" id="guardar">Guardar</button>
						<button  type="button" class="btn btn-default" data-dismiss="modal" onClick="window.location.reload()">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>  
@push ('scripts')
<script>
     $("#guardar").click(function(){
		 var nombre    = $("#nombre_apellido").val();
		 var domicilio = $("#domicilio").val();
		 var dni       = $("#dni").val();
		 var telefono  = $("#telefono").val();
		 var tipo      = $("#tipo").val();
		 var estado    = $("#estado").val();
		 var route     = "{{url('persona/cliente')}}";
		 var token     = $("#token").val();

		 $.ajax({
			url: route,
			headers:{'X-CSRF-TOKEN': token},
			type: 'POST',
			dataType: 'json',
			data:{ nombre_apellido: nombre,
				   dni: dni,
			       domicilio: domicilio,
				   telefono: telefono,
				   tipo: tipo,
				   estado: estado,
				 },
		    success:function(){
				$("#msj-success").fadeIn();
			},
			error:function(msj){
                $("#msj").html(msj.responseJSON.idpersona);
                $("#msj-error").fadeIn();
            }
		 });
	 });
</script>
@endpush
</div>