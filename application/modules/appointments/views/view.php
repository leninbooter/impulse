<section class="content-header">
    <div class="row">
        <div class="col-xs-1 text-right">  
            <h2><i class="fa fa-reply btn" onclick="window.history.back()"></i> </h2>
        </div>
        <div class=" col-xs-9" style="padding-left:0">  
            <h2>Cita</h2>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-xs-offset-1 col-xs-6">        
        <div class="row">
            <div class="col-xs-12" style="">                                                
                <div id="tabscontainer" class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#view">Ver</a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#edit">Editar</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="view" class="tab-pane active container-fluid">
                            <form class="form-horizontal" method="post" action="<?=base_url("index.php/appointments/save")?>" onsubmit="return confirmaction();">
                                <input type="hidden" id="apptid" name="apptid" value="<?="{$appt->pk_id}"?>">
                                <div class="row">
                                    <div class="col-xs-8">
                                        <h3><?="{$appt->name} {$appt->lastname}"?></h3>
                                        <h4><?="{$appt->description_ln}"?></h4>
                                        <h4><i class="fa fa-calendar-o"></i> <?="{$datetimearr[0]}"?>&nbsp;&nbsp;&nbsp;<i class="fa fa-clock-o"></i> <?="{$datetimearr[1]}"?></h4>
                                        <br/>
                                        <h4><i class="fa fa-sticky-note"></i> <?="{$appt->notes_txt}"?></h4>
                                        <?php if($appt->fk_appointment_status_id == "3"): ?>
                                        <h4><i class="fa fa-sticky-note text-danger"></i> Motivo de la cancelación: <small><?="{$appt->cancellation_notes_txt}"?></small></h4>
                                        <?php endif; ?>                                                                                
                                        <?php if($appt->fk_attending_employment_id != null): ?>
                                        <h4><i class="fa fa-user"></i> <b>Tratante:</b> <?="{$appt->attending_employ}"?></h4>
                                        <?php endif; ?>
                                        <?php if($appt->fk_equipment_id != null): ?>
                                        <h4><i class="fa fa-bolt"></i> <b>Equipo:</b>   <?="{$appt->equip_name}"?></h4>
                                        <?php endif; ?>
                                        <?php if($appt->include_accesories_bit == 1): ?>
                                        <h4><i class="fa fa-check-square-o"></i> Incluir material</h4>
                                        <?php endif; ?>
                                        <?php if($appt->fk_suscription_id == null): ?>
                                        <h3><i class="fa fa-warning text-danger"></i> El cliente no tiene suscripción. La atención debe ser cobrada al paciente el día de la cita.</h3>
                                        <?php endif; ?>
                                        <h4><small>Fecha creación: <?="{$appt->created_at}"?></small></h4>                                        
                                    </div>
                                    <div class="col-xs-4 text-right">
                                        <h3><span 
                                                class="label label-<?php 
                                                switch($appt->fk_appointment_status_id) {
                                                    case 1: echo 'primary'; break;
                                                    case 2: echo 'info';break;
                                                    case 3: echo 'danger';break;
                                                    case 4: echo 'primary';break;
                                                    case 5: echo 'success';break;
                                                    case 6: echo 'default';break;
                                                    case 7: echo 'success';break;
                                                }
                                                ?>"><?=$appt->status_description?></span></h3>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 10px">
                                    <div class="col-xs-12">
                                        <div class="btn-group" role="group" aria-label="">
                                            <?php if($appt->fk_appointment_status_id != "3"
                                                        && $appt->fk_appointment_status_id != "5" ): ?>
                                            <input type="submit" class="btn btn-info"       value="Confirmar" name="confirm" onclick="askedAction=1">
                                            <input type="submit" class="btn btn-primary"    value="Check in" name="checkin" onclick="askedAction=2">
                                            <input type="submit" class="btn btn-primary"    value="Atendida" name="attended" onclick="askedAction=3">
                                            <input type="submit" class="btn btn-default"    value="Cancelar" name="cancel" onclick="askedAction=4">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="edit" class="tab-pane">
                            <form id="apptform" class="form-horizontal" method="post" action="<?=base_url("index.php/appointments/save/{$appt->pk_id}")?>">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-4">
        <div class="row">
            <div class="col-xs-12"  style="background: #652016; color: #fff; padding: 15px 15px 0px">
                <div class="row">
                    <div class="col-xs-12">
                        <h4 style="color: #ffffff">Detalles del Servicio</h4>
                    </div>
                </div>
        
                <div class="row">
                    <div class="col-xs-12 container-fluid">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Cant.</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>                       
                                    <?php if( isset($services) && !empty($services)):?>
                                    <?php foreach($services as $v):?>
                                    <tr>
                                        <td>1<input type="hidden" name="itemqty[]" value="1"></td>
                                        <td><?=$v->description_ln?><input type="hidden" name="itemid[]" value="<?=$v->fk_item_id?>"><input type="hidden" name="itmdesc[]" value="<?=$v->description_ln?>"></td>
                                        <td style="text-align: right"><?=$v->unit_price_amt?><input type="hidden" name="itemprice[]" value="<?=$v->unit_price_amt?>"></td>
                                        <?php $subtotal += $v->unit_price_amt; $total += $v->unit_price_amt; ?>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                    
                                    
                                    <?php if( isset($products) && !empty($products)):?>
                                    <?php foreach($products as $v):?>
                                        <tr>
                                            <td>1<input type="hidden" name="productqty[]" value="1"></td>
                                            <td><?=$v->description_ln?><input type="hidden" name="productid[]" value="<?=$v->pk_id?>"><input type="hidden" name="productdesc[]" value="<?=$v->description_ln?>"></td>
                                            <td style="text-align: right"><?=$v->unit_price_amt?><input type="hidden" name="productprice[]" value="<?=$v->unit_price_amt?>"></td>
                                            <?php $subtotal += $v->unit_price_amt; $total += $v->unit_price_amt; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                               
                            </tbody>
                        </table>
                        <table class="table" style="border:none">                   
                            <tbody>                       
                                <tr>
                                    <td style="width: 80%; text-align: right; border:none"><h4 style="margin:0"><b>Subtotal:</b></h4></td><td style="text-align: right; border:none"><h3 style="margin:0"><?=number_format($subtotal, 2, ',', '.')?></h4><input type="hidden" name="subtotal" value="<?=$subtotal?>"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right; border:none"><h4 style="margin:0"><b>Total:</b></h4></td><td style="text-align: right; border:none"><h3 style="margin:0"><?=number_format($total, 2, ',', '.')?></h4><input type="hidden" name="total" value="<?=$total?>"></td>
                                </tr>                       
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12" style="padding: 10px 0px">
                <ul class="nav nav-tabs" role="tablist" style="border-bottom: 4px solid #652016">
                    <li role="presentation" class="active"><a href="#payments" aria-controls="home" role="tab" data-toggle="tab"
                        style="
                            background: transparent none repeat scroll 0% 0%;
                            color: rgb(101, 32, 22);
                            border-radius: 0px;
                            border: medium none;
                            font-size: 20px;"
                    >Pagos</a></li>
                </ul>
                
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active container-fluid" id="payments">                        
                        <div class="row">
                            <div class="col-xs-12" style="padding: 0">
                                <form id="newpaymentform" onsubmit="return false;">
                                    <input type="hidden" name="saleid" value="<?=$saleid?>">
                                     <div class="row">
                                        <div class="col-xs-12">
                                            <h4 style=""><small>Nuevo Pago</small></h4>
                                            <div class="radio">
                                              <label>
                                                <input type="radio" name="paymentmeth" id="cash" value="1" checked>
                                                Efectivo
                                              </label>
                                              <label>
                                                <input type="radio" name="paymentmeth" id="card" value="2" >
                                                Débito/Crédito
                                              </label>                                  
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <input type="type"  name="payment_ammount"  class="form-control input-sm" placeholder="0.00">
                                        </div>
                                        <div class="col-xs-6">
                                            <input type="type"  name="payment_description" class="form-control input-sm" placeholder="Detalles del pago">
                                        </div>
                                        <div class="col-xs-3">
                                            <button type="submit" class="btn btn-primary btn-sm btn-block">Guardar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-12" style="padding:0">
                                <table class="table table-condensed table-striped table-responsive table-bordered" style="width: 100%">
                                    <caption>Pagos realizados</caption>
                                    <thead>
                                        <tr style="background: #E6E6E6">
                                            <th>Fecha</th>
                                            <th>Tipo</th>
                                            <th>Monto</th>
                                            <th>Detalles</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($payments as $v): ?>
                                            <tr>
                                                <td><?=date('d-m-Y', strtotime($v->created_at))?></td>
                                                <td><?=$v->method->name_ln?></td>
                                                <td><?=$v->ammount_amt?></td>
                                                <td><?=$v->note_txt?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if( empty($payments) ): ?>
                                            <tr><td colspan="4">No hay registros</td></tr>
                                        <?php endif; ?>                                            
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-offset-7 col-xs-4">
        
    </div>
</div>

<div class="modal" id="cancellationModal">
  <div class="modal-dialog modal-md ">
    <div class="modal-content">
    <form method="POST" action="<?=base_url('index.php/appointments/save')?>">
        <div class="modal-body container-fluid">
            <input type="hidden" name="apptid" value="<?=$appt->pk_id?>">
            <div class="row">
                <div class="col-xs-12">                    
                     <div class="form-group">
                        <label for="cancellationnote" class="control-label">Indique el motivo de la cancelación:</label>
                        <textarea type="text" class="form-control" id="cancellationnote" name="cancellationnote"></textarea>
                      </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <input type="submit" class="btn btn-primary" value="Aceptar" name="cancel">
                </div>
            </div>
        </div>        
    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" id="checkoutModal">
  <div class="modal-dialog modal-md ">
    <div id="checkoutModalContent" class="modal-content">
       
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" id="pickMachineModal">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
    <form method="POST" action="<?=base_url('index.php/appointments/save')?>">
        <div class="modal-body container-fluid form-horizontal">
            <input type="hidden" name="apptid" value="<?=$appt->pk_id?>">                              
                <div class="form-group">
                    <h4 class="col-xs-3 control-label text-left" style="text-align: left; margin-top:0" ><i class="fa fa-user"></i> Tratante:</h4>
                    <div class="col-xs-7" style="padding-left:0">
                        <select id="employees" name="employees" class="form-control" style="width: 100%">
                            <option></option>
                            <?php foreach($employees as $e):?>
                                <option value="<?=$e->pk_id?>" <?=isset($appt) && $appt->fk_attending_employment_id == $e->pk_id ? 'selected':''?>><?="{$e->name} {$e->lastname}"?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <h4 class="col-xs-3 control-label text-left" style="text-align: left; margin-top:0" ><i class="fa fa-bolt"></i> Equipo:</h4>
                    <div class="col-xs-7" style="padding-left:0">
                        <select id="machines" name="machines" class="form-control input-sm " style="width: 100%">
                            <option></option>
                            <?php foreach($machines as $v):?>
                                <option value="<?=$v->pk_id?>" <?=isset($appt) && $appt->fk_equipment_id == $v->pk_id ? 'selected':''?>><?="{$v->name_sn}"?></option>
                            <?php endforeach; ?>
                        </select>    
                    </div>                     
                </div>
                <div class="form-group">
                     <div class="col-xs-offset-3 col-xs-8" style="padding-left: 0">
                     <label><h4 class=" control-label text-left" style="text-align: left; margin-top:0" ><input type="checkbox" name="accesories" class="" checked> Incluir material</h4></label>
                     </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-offset-3 col-xs-3" style="padding-left: 0"> 
                        <input type="submit" class="btn btn-primary btn-sm btn-block" name="checkin" value="Continuar">
                     </div>
                     <div class="col-xs-offset-0 col-xs-3" style="padding-left: 0"> 
                        <input type="button" class="btn btn-default btn-sm btn-block" value="Cancelar"  data-dismiss="modal">
                     </div>
                </div>
        </div>        
    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script type="text/javascript">
    var askedAction = 0;
    
    function invoice(saleid) {
        
        $('#checkoutModalContent').addClass('magictime loading');
        $('#checkoutModalContent').load(
            '<?=base_url('index.php/invoices/invoice')?>' + '/' + saleid + '/true',
            {},
            function() {
                $('#checkoutModalContent').removeClass('magictime loading');
                $('#checkoutModal').modal({
                    show: true,
                    backdrop: 'static',
                    keyboard: false
                });
            }
        );
    }
    
    
    function checkout() {
        
        $('#checkoutModalContent').load(
            '<?=base_url("index.php/appointments/checkout/{$appt->pk_id}")?>',
            {},
            function() {
                
                $('#btn_checkout').click(function(event) {
                    submitCheckout();
                });
                
                $('#checkoutModal').modal({
                    show: true,
                    backdrop: 'static',
                    keyboard: false
                });
            }
        );
    }
    
    function confirmaction() {
        
        confirmstr = "";
        
        switch( askedAction ) {
            
            case 1: confirmstr = "¿Esta seguro de que desea confirmar esta cita?"; break;
            case 2: confirmstr = "Por favor, confirme la llegada del paciente"; break;
            case 3: confirmstr = "Confirme que desea marcar la cita como atendida" ;break;
            case 4: confirmstr = "¿Esta seguro de que desea cancelar esta cita?"; break;
        }
        
        
        if( askedAction != 3 && !confirm(confirmstr) ){                        
            
            return false;
        }
        
        
        switch(askedAction) {
                
            case 1: return true; break;
            case 2: $('#pickMachineModal').modal(); return false; break;
            case 3: checkout(); return false; break;
            case 4: 
                $('#cancellationModal').modal({show: true, backdrop: 'static', keyboard: 'false'}); 
                $('#cancellationnote', '#cancellationModal').focus();
                return false; 
                break;
            
            default: return false; break;
        }
    }
    
    function receipt(saleid) {
        
        $('#checkoutModalContent').addClass('magictime loading');
        $('#checkoutModalContent').load(
            '<?=base_url('index.php/receipts/receipt')?>' + '/' + saleid + '/true',
            {},
            function() {
                
                $('#checkoutModalContent').removeClass('magictime loading');
                $('#checkoutModal').modal({
                    show: true,
                    backdrop: 'static',
                    keyboard: false
                });
            }
        );
    }
    
    function submitCheckout() {
        
        $('#checkoutModalContent').addClass('magictime loading');
        $.post(
            '<?=base_url("index.php/appointments/save")?>',
            {
                apptid:     $('#apptid').val(),
                duration:   $('#duration').val(),
                processas:  $("[name='processas']").val(),
                attended:   true
            },
            function(result) {
                $('#checkoutModalContent').removeClass('magictime loading');
                if ( result.result == 'OK' ) {
                    
                    if ( result.invoice == 'yes' ) {
                        
                        switch( $("[name='processas']:checked").val() ) {
                            case 'invoice': invoice(result.saleid); break;
                            case 'receipt': receipt(result.saleid); break;
                        }                                                
                        
                    }else {
                        location.href = '<?=base_url('index.php')?>';
                    }
                }
            },
            'json'
        );
    }
    
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
        
        if ( $(e.target).attr('href') == '#edit') {
            $('#tabscontainer').addClass('magictime loading');
            $('#apptform')
                .load(  '<?=base_url("index.php/appointments/edit/{$appt->pk_id}")?>',
                        {},
                        function() {
                            $('#tabscontainer').removeClass('magictime loading');
                        });
            
        }
    });
         
     
     $('#employees').change(function(event) {
        
        $(this).addClass('magictime loading');
                
        $.post('<?=base_url('index.php/appointments/setwhoattend')?>',
        {
            appt:       <?=$appt->pk_id?>,
            employees:  $(this).val()
        },
        function(result) {
            $(this).removeClass('magictime loading');
            
            if( result.result != 'OK' ) {
                
                alert('Technical error!');
            }
        },
        'json');
        
     });
    
    $('#employees').select2({
        placeholder: 'Seleccione quien atenderá esta cita'
    });
    
    $('#machines').select2({
        placeholder: ''
    });
    
    
    $('#newpaymentform').submit( function() {

        $.post('<?=base_url('index.php/payments/add')?>', 
            $(this).serialize(),
            function(result) {
                
                if ( result.result == 'OK') {
                    
                     location.reload();
                }
            },
            'json'
            );
    });
    
</script>