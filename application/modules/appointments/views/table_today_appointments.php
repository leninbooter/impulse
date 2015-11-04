<!-- <section class="content-header">
  <h1>Citas</h1>
</section> -->
<section class="content">
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
                <div id="calendar" style=""></div>
            </div><!-- /.box-body -->
        </div><!-- /. box -->
        <!--<table class="table table-condensed table-hover" style="width:100%">
            <thead>
                <tr>
                    <th style="width:10%; text-align:left">Hora</th>
                    <th style="width:20%; text-align:center">Cliente</th>
                    <th style="width:20%; text-align:center">Servicio</th>
                    <th style="width:10%; text-align:center">Créditos</th>
                    <th style="text-align:center"></th>
                </tr>
            </thead>
            <tbody>
                <?php if ( !empty($appointments)): ?>
                    <?php foreach( $appointments as $k=>$a): ?>
                    <tr>
                        <td><?=DateTime::createFromFormat('Y-m-j H:i:s', $a->datetime_dtm)->format('Y-m-j H:i')?></td>
                        <td style="text-align:center"><a href="<?=base_url('index.php/suscriptions/actives')?>"><?=$a->customer->name . " " . $a->customer->lastname?></a></td>
                        <td style="text-align:center"><?=$a->service->description_ln?></td>
                        <td style="text-align:center"><?=$a->credits_int?></td>
                        <td style="text-align:center">
                            <form method="POST" action="<?=base_url('index.php/appointments/checkin')?>" style="display:inline"><input type="hidden" name="apptId" value="<?=$a->pk_id?>"><button type="submit" class="btn btn-default btn-sm" ><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Check in</button></form>
                            <form method="POST" action="<?=base_url('index.php/appointments/cancel')?>" style="display:inline"><input type="hidden" name="apptId" value="<?=$a->pk_id?>"><button type="submit" class="btn btn-default btn-sm" ><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancelar</button></form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>-->
    </div>
</div>
</section>

<div class="modal fade" id="apptModal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title"><i class="fa fa-calendar"></i> <span id="apptModal-customerNameh"></span></h3>
        <h4 id="apptModal-eventDatetimeh"></h4>
        <h4 id="apptModal-serviceNameh"></h4>
      </div>
      <div class="modal-body container-fluid">
        <div class="row">
            <div class="col-md-12">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 text-right">
                <form method="POST" action="<?=base_url('index.php/appointments/checkin')?>" style="display:inline"><input type="hidden" name="apptId" value="<?=$a->pk_id?>"><button type="submit" class="btn btn-success btn-flat" ><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Check in</button></form>
            </div>
            <div class="col-md-6 text-left">
                <form method="POST" action="<?=base_url('index.php/appointments/cancel')?>" style="display:inline"><input type="hidden" name="apptId" value="<?=$a->pk_id?>"><button type="submit" class="btn btn-danger btn-flat" ><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancelar cita</button></form>
            </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal menuanimation" id="confirmNewApt">
  <div class="modal-dialog modal-lg ">
    <div class="modal-content">
    <form id="newapptontheflyform" method="POST" onsubmit="return false;">
        <div class="modal-body container-fluid">
            <input type="hidden" name="apptdate" value="">
            <div class="row">
                <div class="col-xs-12 text-center">                    
                    <h1>Nueva Cita</h1>
                    <h2><span id="day"></span> a las <span id="time"></span></h2>
                    <!--<h4>Confirma que deseas crear una cita en la fecha seleccionada</h4>-->
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-offset-3 col-xs-6 text-center" style="padding-left: 0; padding-right:0">
                    <select id="customers" name="customer" class="form-control" style="width: 100%">
                        <option></option>
                        <?php foreach($customers as $c):?>
                            <option value="<?=$c->pk_id?>" <?=isset($appt) && $appt->cust_id == $c->pk_id ? 'selected':''?>><?="{$c->name} {$c->lastname}"?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" id="custsearchcriteria">
                </div>
                <div id="rownewcustbtn" class=" col-xs-2 text-center" style="padding-left: 0; padding-right:0; padding-top: 0px; opacity:0; display:none">                    
                    <button id="btn_newcustonthefly" class="btn btn-primary btn-sm" type="button" onclick="showNewCustForm()"><i class="fa fa-user-plus"></i> Cliente nuevo</button>
                </div>
            </div>
            
            <div id="newcustrow" class="row" style="display:none">
                <div class="col-xs-offset-3 col-xs-6 text-left" style="padding: 10px 20px; margin-top: 20px; color: #fff; background-color: #B61B1B">                    
                    <h4><i class="fa fa-user-plus"></i> Nuevo Cliente</h4>
                    <div class="form-horizontal">                        
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Nombre</label>
                            <div class="col-sm-4">
                                <input type="name" class="form-control input-sm" id="name" name="name" placeholder="" style="height: 25px">
                            </div>
                            
                            <label for="inputEmail3" class="col-sm-2 control-label">Apellido</label>
                            <div class="col-sm-4">
                                <input type="lastname" class="form-control input-sm" id="lastname" name="lastname" placeholder="" style="height: 25px">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Teléfono</label>
                            <div class="col-sm-4">
                                <input type="telephone" class="form-control input-sm" id="telephone" name="telephone" placeholder="" style="height: 25px">
                            </div>
                        </div>                      
                      
                      <div class="row">
                        <div class="col-xs-offset-2 col-xs-2">
                            <button id="btn_cancelnewcustform"  class="btn btn-default" type="button">Cancelar</button>
                        </div>
                      </div>
                      
                    </div>
                </div>
            </div>
            
           <div class="row">
                <div class="col-xs-offset-3 col-xs-6 text-center" style="padding-left: 0; padding-top:10px; padding-right:0">
                    <select id="service" name="service" class="form-control" style="width: 100%">
                        <option></option>
                        <?php foreach($services as $s):?>
                            <option value="<?=$s->pk_id?>" <?=isset($appt) && $appt->se_id == $s->pk_id ? 'selected':''?>><?=$s->description_ln?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
             <div class="row">
                <!--<label class="col-sm-2 control-label">Servicio</label>-->
                    <div class="col-xs-offset-3  col-xs-6" style="padding-left: 0;padding-right: 0; padding-top: 10px">
                        <textarea name="observations" class="form-control" style="width: 100%" placeholder="Observaciones"></textarea>
                    </div>                                   
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
     $('#calendar').fullCalendar({
                                    header: {
                                        left: 'prev,next today',
                                        center: 'title',
                                        right: 'month,agendaWeek,agendaDay'
                                    },
                                    defaultView: 'agendaDay',
                                    events: '<?=base_url('index.php/appointments/getApptsFromTo')?>',
                                    defaultTimedEventDuration: '01:00:00',
                                    minTime: '06:00:00',
                                    maxTime: '21:00:00',
                                    allDaySlot: false,
                                    eventClick: function(calEvent, jsEvent, view) {

                                        location.href = "<?=base_url("index.php/appointments/view")?>/"+calEvent.citaID;
                                        /*$('#apptModal').find('#apptModal-customerNameh').html(calEvent.name);
                                        $('#apptModal').find('#apptModal-eventDatetimeh').html(calEvent.startFormatted);
                                        $('#apptModal').find('#apptModal-serviceNameh').html(calEvent.serviceName);
                                        $('#apptModal').modal('show');*/

                                    },
                                    dayClick: function(date, jsEvent, view) {
                                        var pickedDate  = new Date(date.format());                                                                                
                                        var meses       = new Array ("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
                                        var diasSemana  = new Array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
                                        
                                        var dateStr = diasSemana[pickedDate.getDay()] + " " + pickedDate.getDate() + " de " + meses[pickedDate.getMonth()] + " de " + pickedDate.getFullYear();
                                        var timeStr = pickedDate.getHours() + ":" + (pickedDate.getMinutes() < 10 ? '0' + pickedDate.getMinutes():pickedDate.getMinutes());
                                        
                                        $('#confirmNewApt').find("#day").html(dateStr);
                                        $('#confirmNewApt').find("#time").html(timeStr);
                                        
                                        $('#confirmNewApt').find("[name='apptdate']").val(date.format());
                                        $('#confirmNewApt').modal('show');                                                                                

                                    },
                                    height:500
                                });
    
    var custs2picker = $('#customers').select2({
    
        placeholder: 'Seleccione un cliente'
        
    });
   
    var servs2picker = $('#service').select2({
        
        placeholder: 'Seleccione un servicio'
        
    });
   
    $('#confirmNewApt').on('hide.bs.modal', function() {
        
        $('#newcustrow').hide();
        $('#rownewcustbtn').hide();
        custs2picker.val(null).trigger("change");
        servs2picker.val(null).trigger("change");
    });
    
    $('#btn_cancelnewcustform').click(function() {
        $('#newcustrow').hide();
    });
    
    $('#newapptontheflyform').submit(function() {
       
        $.post('<?=base_url('index.php/appointments/add/true')?>', 
            $(this).serialize(),
            function(result) {
                if( result.result == 'OK' ) {
                    
                    location.reload(true);
                }
            },
            'json'
        );
    });
    
    function showNewCustForm() {
        
        $('#rownewcustbtn').hide();
        
        custs2picker.select2("close");
        custs2picker.val(null).trigger("change");
        
        var name = $('#custsearchcriteria').val().split(" ");
        
        $('#newcustrow').show();
        $('#name').val(name[0].charAt(0).toUpperCase() + name[0].slice(1)).focus();
        $('#lastname').val(name[1].charAt(0).toUpperCase() + name[1].slice(1));
        
    }
    
    function showNewCustBtn() {
        
        searchcrit = $('.select2-search__field').val();
        
        $('#custsearchcriteria').val(searchcrit);
        $('#rownewcustbtn').css('display', 'inline-block');                
        $('#rownewcustbtn').addClass('magictime tinRightIn');                
                
    }            
    
</script>