
<div class="row">
    <div class="col-md-12">
        
        <div class="box">
            <div class="box-body table-responsive">
              <table class="table table-condensed table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th style="width:30%; text-align:left">Servicios</th>
                        <th style="width:20%; text-align:center">Afiliado desde</th>
                        <th style="width: 2%; text-align:center">Precio/ Crédito</th>
                        <th style="width:10%; text-align:center">Creditos</th>
                        <th style="width:10%; text-align:center">Usados</th>
                        <th style="width:10%; text-align:center">Bloqueados</th>
                        <th style="width:10%; text-align:center">Disponibles</th>
                        <th style="text-align:center"><button type="button" class="btn btn-default btn-sm" onclick="$('#addServiceModal').modal('show')"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar</button></th>
                    </tr>
                </thead>
                <tbody>        
                    <?php if ( !empty($suscriptions)): ?>
                        <?php foreach( $suscriptions as $k=>$s): ?>
                        <tr>
                            <td><?=$s->service->description_ln?></td>
                            <td style="text-align:center"><?=$s->created_at?></td>
                            <td style="text-align:center"><?=number_format($s->price_amt,2,',','.')?></td>
                            <td style="text-align:center"><?=$s->credits_int?></td>
                            <td style="text-align:center"><a href="<?=base_url('index.php/suscriptions/usedCreditsFrom?s='.$s->pk_id)?>"><?=$s->credits_used_int?></a></td>
                            <td style="text-align:center"><a href="<?=base_url('index.php/suscriptions/heldCreditsFrom?s='.$s->pk_id)?>"><?=$s->credits_lock_int?></a></td>
                            <td style="text-align:center"><?=$s->credits_int - $s->credits_lock_int - $s->credits_used_int?></td>
                            <td style="text-align:center"></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            </div><!-- /.box-body -->
          </div>                        
    </div>
</div>

<div class="modal fade" id="addServiceModal">
  <div class="modal-dialog">
    <div id="addServiceModalContent" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Agregar Servicio</h4>
      </div>
      <div class="modal-body container-fluid">
        <?=$formAddSuscription?>
        <div id="servicePrices">
        </div>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class="modal fade" id="addAppointmentModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Nueva cita para <span id="serviceNameHolder"></span></h4>
      </div>
      <div class="modal-body container-fluid">
        <?=$formAddAppointment?>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="checkoutModal">
  <div class="modal-dialog">
    <div id="checkoutModalContent"class="modal-content">
            
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<script>   
    $('#addAppointmentModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var serviceName = button.data('servicename'); // Extract info from data-* attributes
      var suscriptionId = button.data('suscriptionid'); // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this);
      modal.find('#serviceNameHolder').html(serviceName);
      modal.find('[name="suscription[id]"]').val(suscriptionId);
      console.log(button.data('servicename'));
      console.log(button);
    });
    
    $('#suscription_serviceid').change(function() {
        $('#servicePrices').load('<?=base_url('index.php/services/getPricesTable?servId=')?>'+$('option:selected', $(this)).val());               
    });
</script>