@extends ('layouts.admin')
@section ('contenido')
@include('alerts.errors')
<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3>Resumen General</h3>
    </div>
</div>

<?php 
foreach ($totales as $total)
{
?>
<div class="row">
             <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h4 style="font-size:17px;"><strong><?php echo $total->totalpagodia;?></strong></h4>
                  <p>Cobranzas del dia</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="{{url('cobranza/pago')}}" class="small-box-footer">Pagos<i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h4 style="font-size:17px;"><strong><?php echo $total->totalpagowek;?></strong></h4>
                  <p>Cobranzas Semanal</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="{{url('cobranza/pago')}}" class="small-box-footer">Pagos<i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h4 style="font-size:17px;"><strong><?php echo $total->totalpagomes;?></strong></h4>
                  <p>Cobranzas del Mes</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="{{url('cobranza/pago')}}" class="small-box-footer">Pagos<i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h4 style="font-size:17px;"><strong><?php echo $total->totalpagoaño;?></strong></h4>
                  <p>Cobranzas Anual</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="{{url('cobranza/pago')}}" class="small-box-footer">Pagos<i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-blue">
                <div class="inner">
                  <h4 style="font-size:17px;"><strong><?php echo $total->totalventadia;?></strong></h4>
                  <p>Ventas del dia</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="{{url('ventas/entregas')}}" class="small-box-footer">Entregas<i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
             <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-blue">
                <div class="inner">
                  <h4 style="font-size:17px;"><strong><?php echo $total->totalventawek;?></strong></h4>
                  <p>Ventas Semanal</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="{{url('ventas/entregas')}}" class="small-box-footer">Entregas<i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
             <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-blue">
                <div class="inner">
                  <h4 style="font-size:17px;"><strong><?php echo $total->totalventames;?></strong></h4>
                  <p>Ventas del mes</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="{{url('ventas/entregas')}}" class="small-box-footer">Entregas<i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
             <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-blue">
                <div class="inner">
                  <h4 style="font-size:17px;"><strong><?php echo $total->totalventaño;?></strong></h4>
                  <p>Ventas del año</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="{{url('ventas/entregas')}}" class="small-box-footer">Entregas<i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            
        </div>

<?php }?>

@push ('scripts')
<script src="{{asset('js/Chart.js')}}"></script>

    <script>
      $('#liEstadistica').addClass("treeview active");
      $('#liEscritorio').addClass("active");
    </script>
@endpush
@endsection