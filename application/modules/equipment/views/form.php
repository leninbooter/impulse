                            <div class="form-group">
                                <label for="name" class="col-xs-2 control-label">Nombre</label>
                                <div class="col-xs-7">
                                   <input type="text" name="name" class="form-control" value="<?=isset($eq) ? $eq->name_sn:''?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="serial" class="col-xs-2 control-label">Serial</label>
                                <div class="col-xs-7">
                                   <input type="text" name="serial" class="form-control" value="<?=isset($eq) ? $eq->serial_ln:''?>">
                                </div>
                            </div>                                                      
                            
                            <div class="form-group">
                                    <label for="date" class="col-xs-2 control-label">Descripción</label>
                                    <div class="col-xs-7">
                                        <textarea name="description" class="form-control"><?=isset($eq) ? $eq->description_txt:''?></textarea>
                                    </div>                                   
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-2">
                                </div>
                                <div class="col-xs-10">
                                    <div class="btn-group" role="group" aria-label="...">
                                    <input type="submit" class="btn btn-primary" value="Guardar" name="save"><?php if(isset($eq)):?><input type="submit" class="btn btn-danger" value="Eliminar" name="remove"><?php endif; ?>
                                    </div>
                                    
                                </div>
                                
                            </div>





<script>

    
</script>