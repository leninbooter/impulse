<section class="content-header">
    <div class="row">
        <div class="col-xs-offset-2 col-xs-1 text-right">  
            <h2><i class="fa fa-reply btn" onclick="window.history.back()"></i> </h2>
        </div>
        <div class=" col-xs-9" style="padding-left:0">  
            <h2>Cita</h2>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-xs-offset-3 col-xs-6">        
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
                                        <?php if($appt->fk_suscription_id == null): ?>
                                        <h3><i class="fa fa-warning text-danger"></i> El cliente no tiene suscripción. La atención debe ser cobrada al paciente el día de la cita.</h3>
                                        <?php endif; ?>
                                        <div class="form-group">
                                            <label for="employees" class="col-xs-3 control-label text-left" style="text-align: left"><i class="fa fa-user"></i> Tratante</label>
                                            <div class="col-xs-8">
                                                <select id="employees" name="employees" class="form-control">
                                                    <option></option>
                                                    <?php foreach($employees as $e):?>
                                                        <option value="<?=$e->pk_id?>" <?=isset($appt) && $appt->fk_attending_employment_id == $e->pk_id ? 'selected':''?>><?="{$e->name} {$e->lastname}"?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
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
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Facturación</h4>
        </div>
        <form method="POST" action="<?=base_url('index.php/invoices/generate')?>">
            <div id="invoicebody" class="modal-body container-fluid">                
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Guardar">
            </div>            
        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    var askedAction = 0;
    
    
    
    function confirmaction() {
        
        confirmstr = "";
        
        switch( askedAction ) {
            
            case 1: confirmstr = "¿Esta seguro de que desea confirmar esta cita?"; break;
            case 2: confirmstr = "Por favor, confirme la llegada del paciente"; break;
            case 3: confirmstr = "Confirme que desea marcar la cita como atendida" ;break;
            case 4: confirmstr = "¿Esta seguro de que desea cancelar esta cita?"; break;
        }
        
        if( confirm(confirmstr) ){
            
            switch(askedAction) {
                
                case 1: return true; break;
                case 2: break;
                case 3: setAsAttend(); return false; break;
                case 4: 
                    $('#cancellationModal').modal({show: true, backdrop: 'static', keyboard: 'false'}); 
                    $('#cancellationnote', '#cancellationModal').focus();
                    return false; 
                    break;
                
                default: return false; break;
            }
            
        }else {
            return false;
        }
    }
    
    function setAsAttend() {
        
        $.post(
            '<?=base_url("index.php/appointments/save")?>',
            {
                apptid:     $('#apptid').val(),
                attended:   true
            },
            function(result) {
                
                if ( result.result == 'OK' ) {
                    
                    if ( result.invoice == 'yes' ) {
                        
                        $('#invoicebody').load(
                                            '<?=base_url("index.php/invoices/invoice/{$appt->pk_id}")?>',
                                            {},
                                            function() {
                                                $('#checkoutModal').modal({
                                                    show: true,
                                                    backdrop: 'static',
                                                    keyboard: false
                                                });
                                            }
                                        );
                        
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
            appt: <?=$appt->pk_id?>,
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
    
</script>