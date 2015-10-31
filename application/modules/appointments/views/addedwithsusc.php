<div class="row">
    <div class="col-md-offset-1 col-md-10 text-center">
        <h2 class="text-center"><i class="fa fa-calendar"></i></h2>
        <h2>¡Se registró la cita satisfactoriamente!</h2>
        <a href="<?=base_url('index.php')?>" class="btn btn-default">Ir al inicio</a> <a href="<?=base_url("index.php/appointments/view/{$this->uri->segment(3)}")?>" class="btn btn-default">Ir a la cita</a>
    </div>
</div>