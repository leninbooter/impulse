                                           
                        
                            <input type="hidden" name="returnto" value="<?=isset($returnto) ? $returnto:''?>">
                            <div class="form-group">
                                <label for="service" class="col-md-2 control-label">Servicio</label>
                                <div class="col-md-6">
                                    <select name="service" class="form-control">
                                        <option></option>
                                        <?php foreach($services as $s):?>
                                            <option value="<?=$s->pk_id?>" <?=isset($appt) && $appt->se_id == $s->pk_id ? 'selected':''?>><?=$s->description_ln?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="customer" class="col-md-2 control-label">Cliente</label>
                                <div class="col-md-6">
                                    <select name="customer" class="form-control">
                                        <option></option>
                                        <?php foreach($customers as $c):?>
                                            <option value="<?=$c->pk_id?>" <?=isset($appt) && $appt->cust_id == $c->pk_id ? 'selected':''?>><?="{$c->name} {$c->lastname}"?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <!--<label class="col-sm-2 control-label">Servicio</label>-->
                                    <label for="date" class="col-md-2 control-label">Fecha</label>
                                    <div class="col-md-3">
                                        <input type="text" name="date" id="datepicker" class="form-control" value="<?=$pickedDay?>">
                                        <input type="hidden" name="fecha" class="form-control">
                                      
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="time" id="" class="form-control" value="<?=$pickedTime?>">
                                    </div>
                                    <input type="hidden" name="fecha" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <!--<label class="col-sm-2 control-label">Servicio</label>-->
                                    <label for="date" class="col-md-2 control-label">Observaciones</label>
                                    <div class="col-md-6">
                                        <textarea name="observations" class="form-control"><?=isset($appt) ? $appt->notes_txt:''?></textarea>
                                    </div>                                   
                            </div>
                            
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-10">
                                    <div class="btn-group" role="group" aria-label="...">
                                    <input type="submit" class="btn btn-primary" value="Guardar" name="save">
                                    </div>
                                    
                                </div>
                                
                            </div>    
                    </form>





<script>
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
        
      });
</script>