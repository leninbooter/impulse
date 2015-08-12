<?php 

    if ( isset($userData) ){
        
        $customerId = $userData->pk_id;
        
    }else {
        
        $customerId = '';
    }

?>   
   <div class="row">
        <div class="col-md-12">
            <form method="post" action="<?=base_url('index.php/customers/form/'. $customerId )?>">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">                
                            <label class="control-label">Tipo de Cliente</label>
                            <select name="customer[type]" class="form-control input-sm">
                                <?php foreach( $customerTypes as $k=>$v): ?>
                                    <option value="<?=$v->pk_id?>" <?=isset($userData) && $userData->fk_customer_type == $v->pk_id ? 'selected':''?>  ><?=$v->name?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Nombre</label>
                            <input  type="text" 
                                    class="form-control input-sm" 
                                    id ="name" 
                                    name="customer[name]"
                                    value="<?=isset($userData) ? $userData->name:''?>">
                        </div>
                    </div>        
                    <div class="col-md-2">
                        <div class="form-group">
                            <label name="customer[lastname]" class="control-label">Apellido</label>
                            <input type="text" class="form-control input-sm" id="lastname" name="customer[lastname]" value="<?=isset($userData) ? $userData->lastname:''?>">
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label class="control-label">Documento</label>            
                            <select name="customer[documentType]"  class="form-control input-sm">
                                <?php foreach( $documentTypes as $k=>$v): ?>
                                    <option value="<?=$k?>" <?=isset($userData) && $userData->fk_document_type == $k ? 'selected':''?>  ><?=$v?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>        
                    <div class="col-md-1">
                        <div class="form-group">
                            <label class="control-label">&nbsp;</label>
                            <input type="text" class="form-control input-sm" id="NIF" name="customer[document]" value="<?=isset($userData) ? $userData->NIF:''?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Teléfono</label>
                            <input type="text" class="form-control input-sm" id="telephone" name="customer[phone]" value="<?=isset($userData) ? $userData->telephone:''?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Móvil</label>
                            <input  type="text" 
                                    class="form-control input-sm" 
                                    id ="mobile" 
                                    name="customer[mobile]"
                                    value="<?=isset($userData) ? $userData->mobile:''?>">
                        </div>
                    </div>
                </div>
                <div class="row">                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">E-mail</label>
                            <input type="text" class="form-control input-sm" id="email" name="customer[email]" value="<?=isset($userData) ? $userData->email:''?>">
                        </div>
                    </div>
                </div>    
                
                <fieldset id="directionsFieldset">
                    <div class="row">
                        <div class="col-md-6">
                            <legend>Direcciones</legend>
                        </div>
                    </div>
                    <?php if( !isset($userData->addresses) ): 
                                $userData = new StdClass();
                                $userData->addresses = array(1);
                            endif;
                    ?>                                 
                                <?php foreach($userData->addresses as $addr): ?>                                                                    
                                    <div  class="row">
                                        <?php if ( isset($addr->pk_id) ) :?>
                                            <input type="hidden" name="dirid[]" value="<?=$addr->pk_id?>">
                                        <?php endif; ?>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Descripción</label>
                                                <input type="text" class="form-control input-sm" id="description" name="dirdesc[]" value="<?=isset($addr->description) ? $addr->description:''?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label class="control-label">&nbsp;</label>
                                                <select  class="form-control input-sm" name="dirviatype[]">
                                                    <option value="1" <?=isset($addr->via_type) && $addr->via_type == 1 ? 'selected':''?>>Avenida</option>
                                                    <option value="2" <?=isset($addr->via_type) && $addr->via_type == 2 ? 'selected':''?>>Calle</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label class="control-label">Vía</label>
                                                <input type="text" class="form-control input-sm" id="via" name="dirvia[]" value="<?=isset($addr->via) ? $addr->via:''?>">
                                            </div>
                                        </div>                        
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label class="control-label">Portal</label>
                                                <input type="text" class="form-control input-sm" id="portal" name="dirportal[]" value="<?=isset($addr->portal) ? $addr->portal:''?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label class="control-label">Piso</label>
                                                <input type="text" class="form-control input-sm" id="floor" name="dirfloor[]" value="<?=isset($addr->floor) ? $addr->floor:''?>">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label class="control-label">Localidad</label>
                                                <input type="text" class="form-control input-sm" id="locality" name="dirlocality[]" value="<?=isset($addr->locality) ? $addr->locality:''?>">
                                            </div>
                                        </div>                        
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label class="control-label">CP</label>
                                                <input type="text" class="form-control input-sm" id="CP" name="dircp[]" value="<?=isset($addr->CP) ? $addr->CP:''?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label class="control-label">Provincia</label>
                                                <input type="text" class="form-control input-sm" id="province" name="dirprovince[]" value="<?=isset($addr->province) ? $addr->province:''?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">País</label>
                                                <select name="dircountry[]" class="form-control input-sm">
                                                    <?php foreach( $countries as $k=>$v): ?>
                                                        <option value="<?=$k?>"  <?= isset($addr->fk_country_id) && $addr->fk_country_id == $k ? 'selected':''?>><?=$v?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1 text-right">
                                            <div class="form-group">
                                                <label class="control-label">&nbsp;</label>
                                                <button type="button" class="btn btn-default btn-block btn-sm" onclick="if ( $('#directionsFieldset .row').length == 3) return;  $(this).closest('.row').remove();"><span class="glyphicon glyphicon-remove" arei-hidden="true"></span></button>
                                            </div>
                                        </div>
                                    </div>
                    <?php endforeach;?>                   
                    <div class="row">
                    <div class="col-md-1 text-left">
                        <button type="button" class="btn btn-default btn-block btn-sm" onclick="newDir(this)" ><span class="glyphicon glyphicon-plus" arei-hidden="true"></span></button>
                    </div>                                        
                </div>
                </fieldset>
                <fieldset id="contactsFieldset">
                    <div class="row">
                        <div class="col-md-6">
                            <legend>Contactos</legend>
                        </div>
                    </div>
                    
                    <?php if( !isset($userData->contacts) ): 
                                $userData = new StdClass();
                                $userData->contacts = array(1);
                            endif;
                    ?> 
                        <?php foreach($userData->contacts as $cont): ?>                                                                        
                                    <div class="row">
                                        <?php if ( isset($cont->pk_id) ) :?>
                                            <input type="hidden" name="conId[]" value="<?=$cont->pk_id?>">
                                        <?php endif; ?>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Descripción</label>
                                                <input type="text" class="form-control input-sm" id="description" name="contactdesc[]" value="<?=isset($cont->description) ? $cont->description:''?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Nombre</label>
                                                <input type="text" class="form-control input-sm" id="via" name="contactname[]" value="<?=isset($cont->name) ? $cont->name:''?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Apellido</label>
                                                <input type="text" class="form-control input-sm" id="via" name="contactlastname[]"value="<?=isset($cont->lastname) ? $cont->lastname:''?>">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Teléfono</label>
                                                <input type="text" class="form-control input-sm" id="portal" name="contactphone[]" value="<?=isset($cont->telephone) ? $cont->telephone:''?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label class="control-label">Móvil</label>
                                                <input type="text" class="form-control input-sm" id="floor" name="contactmobile[]" value="<?=isset($cont->mobile) ? $cont->mobile:''?>"">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Email</label>
                                                <input type="text" class="form-control input-sm" id="locality" name="contactemail[]" value="<?=isset($cont->email) ? $cont->email:''?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1 text-right">
                                            <div class="form-group">
                                                <label class="control-label">&nbsp;</label>
                                                <button type="button" class="btn btn-default btn-block btn-sm" onclick="if ( $('#contactsFieldset .row').length == 3) return; $(this).closest('.row').remove();"><span class="glyphicon glyphicon-remove" arei-hidden="true"></span></button>
                                            </div>
                                        </div>
                                    </div>    
                                <?php endforeach; ?>
                    <div class="row">
                        <div class="col-md-1 text-left">
                            <div class="form-group">
                                <button type="button" class="btn btn-default btn-block btn-sm" onclick="newCont(this)" ><span class="glyphicon glyphicon-plus" arei-hidden="true"></span></button>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="submit" name="btnSubmit" class="btn btn-primary" value="Guardar">
                        </div>
                    </div>
                </div>
            </form>
        </div>    
    </div>
<script type="text/javascript">  

    function newDir(caller) {
        $('#directionsFieldset .row:eq(1)').clone(true).insertBefore('#directionsFieldset .row:last');
        $('#directionsFieldset .row:last').prev().find('input:text').val('');
        $('#directionsFieldset .row:last').prev().find("[name^='dirid']").remove();        
    }
    
    function newCont(caller) {
        
        $('#contactsFieldset .row:eq(1)').clone(true).insertBefore('#contactsFieldset .row:last');
        $('#contactsFieldset .row:last').prev().find('input:text').val('')
        $('#contactsFieldset .row:last').prev().find("[name^='conId']").remove();  
    }

</script>