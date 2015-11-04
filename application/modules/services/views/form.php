                            <input type="hidden" name="serviceid" value="<?=isset($service) ? $service->pk_id:''?>">
                            <input type="hidden" name="returnto" value="<?=isset($returnto) ? $returnto:''?>">
                            <div class="form-group">
                                <label for="service" class="col-xs-2 control-label">Nombre</label>
                                <div class="col-xs-7">
                                   <input type="text" name="name" class="form-control" value="<?=isset($service) ? $service->description_ln:''?>">
                                </div>
                            </div>                            
                            <div class="row">
                                <label for="service" class="col-xs-2 control-label">Créditos</label>
                                <div class="col-xs-offset-0 col-xs-8">
                                <table id="credits" class="table  table-condensed table-responsive " style="margin-bottom: 0">
                                    <thead>
                                        <tr>
                                            <th style="width:20%">Desde</th>
                                            <th style="width:20%">Hasta</th>
                                            <th style="width:25%">Precio</th>
                                            <th style="width:15%"></th>
                                            <th style="width:"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                         <?php if( !isset($credits) || empty($credits) ): 
                                                    $credits = array(1);
                                                endif;
                                        ?>   
                                        
                                         <?php foreach($credits as $c): ?>
                                        <tr>
                                            <td>
                                             <?php if ( isset($c->pk_id) ) :?>
                                                <input type="hidden" name="credid[]" value="<?=isset($c->pk_id) ? $c->pk_id:''?>">
                                            <?php endif; ?><input type="text" name="creditsfrom[]" class="form-control input-sm" value="<?=isset($c->pk_id) ? $c->credits_min_int:''?>"></td>
                                            <td><input type="text" name="creditsto[]" class="form-control input-sm" value="<?=isset($c->pk_id) ? $c->credits_max_int:''?>"></td>
                                            <td><input type="text" name="creditsprice[]" class="form-control input-sm" style="text-align:right" value="<?=isset($c->pk_id) ? $c->price_amt:''?>"></td>
                                            <td style="text-align: right" class="discount"></td>
                                            <td><button type="button" class="btn btn-default btn-block btn-sm" onclick="if ( $('#credits tr').length == 3) return; $(this).closest('tr').remove();"><span class="glyphicon glyphicon-remove" arei-hidden="true"></span></button></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><button type="button" class="btn btn-default btn-block btn-sm" onclick="newCredits(this)" ><span class="glyphicon glyphicon-plus" arei-hidden="true"></span></button></td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            
                            <div class="row">
                                <label for="service" class="col-xs-2 control-label">Paquetes por Tiempo</label>
                                <div class="col-xs-offset-0 col-xs-8">
                                <table id="times" class="table  table-condensed table-responsive ">
                                    <thead>
                                        <tr>
                                            <th style="width:20%">Meses</th>
                                            <th style="width:20%">Citas Mensuales</th>
                                            <th style="width:25%">Precio</th>
                                            <th style="width:15%"></th>
                                            <th style="width:"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                         <?php if( !isset($timebundles) || empty($timebundles) ): 
                                                    $timebundles = array(1);
                                                endif;
                                        ?>   
                                        
                                         <?php foreach($timebundles as $c): ?>
                                        <tr>
                                            <td>
                                             <?php if ( isset($c->pk_id) ) :?>
                                                <input type="hidden" name="timeid[]" value="<?=isset($c->pk_id) ? $c->pk_id:''?>">
                                            <?php endif; ?><input type="text" name="time[]" class="form-control input-sm" value="<?=isset($c->pk_id) ? $c->time_bundle_int:''?>"></td>
                                            <td><input type="text" name="timebundleappts[]" class="form-control input-sm" style="text-align:right" value="<?=isset($c->pk_id) ? $c->month_appts_int:''?>"></td>
                                            <td><input type="text" name="timebundleprice[]" class="form-control input-sm" style="text-align:right" value="<?=isset($c->pk_id) ? $c->price_amt:''?>"></td>
                                            <td style="text-align: right" class="discount"></td>
                                            <td><button type="button" class="btn btn-default btn-block btn-sm" onclick="if ( $('#times tr').length == 3) return; $(this).closest('tr').remove();"><span class="glyphicon glyphicon-remove" arei-hidden="true"></span></button></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><button type="button" class="btn btn-default btn-block btn-sm" onclick="newCredits(this)" ><span class="glyphicon glyphicon-plus" arei-hidden="true"></span></button></td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <!--<label class="col-sm-2 control-label">Servicio</label>-->
                                    <label for="date" class="col-xs-2 control-label">Observaciones</label>
                                    <div class="col-xs-7">
                                        <textarea name="observations" class="form-control"><?=isset($service) ? $service->observations_txt:''?></textarea>
                                    </div>                                   
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-2">
                                </div>
                                <div class="col-xs-10">
                                    <div class="btn-group" role="group" aria-label="...">
                                    <input type="submit" class="btn btn-primary" value="Guardar" name="save"><?php if(isset($service)):?><input type="submit" class="btn btn-danger" value="Eliminar" name="remove"><?php endif; ?>
                                    </div>
                                    
                                </div>
                                
                            </div>    
                    </form>





<script>

    function newCredits(caller) {
                
        parent = $(caller).closest('table');
        
        parent.find('tr:eq(1)').clone(true).insertBefore(parent.find('tr:last'));
        parent.find('tr:last').prev().find('input:text').val('')
        parent.find('tr:last').prev().find("[name='credid[]']").remove();
        parent.find('tr:last').prev().find("[name='timeid[]']").remove();
        
        // $('#credits tr:eq(1)').clone(true).insertBefore('#credits tr:last');
        // $('#credits tr:last').prev().find('input:text').val('')
        // $('#credits tr:last').prev().find("[name='credid[]']").remove();  
    }
    
    function recalcDisc() {
        
        base    = $('#credits tbody tr').eq(0).find('[name="creditsprice[]"]').val();
        l       = $('#credits tbody tr').length-1;
        
        $('#credits tbody tr').each(function(idx) {
            
            if ( l != idx ) {
             
                pric = $(this).find('[name="creditsprice[]"]').val();
                perc = 100 - ((pric / base)*100);
                $(this).find('.discount').html(perc.toFixed(2) + '%');
            console.log(idx);    
            }
                        
        });
               
    }
    
    $('#credits').find('[name="creditsprice[]"]').keyup(function(e) {
        
        recalcDisc();
    });$
    
    ('#times').find('[name="timebundleprice[]"]').keyup(function(e) {
        
        recalcDisc();
    });
    
      $(function() {
        $( '#datepicker' ).datepicker({
            altField: '[name="fecha"]',
            altFormat: "m/d/yy"
        });
        
        $("[name='service']").select2({
            
            placeholder: "Seleccione un servicio"
        });
        
        $("[name='customer']").select2({
            
            placeholder: "Seleccione un cliente"
        });
        
        recalcDisc();
      });
</script>