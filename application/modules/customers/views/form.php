<form method="post">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">                
                <label class="control-label">Tipo de Cliente</label>
                <select name="fk_document_type" class="form-control input-sm">
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
                        name ="name" 
                        value="<?=isset($userData) ? $userData->name:''?>">
            </div>
        </div>        
        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label">Apellido</label>
                <input type="text" class="form-control input-sm" id="lastname" name="lastname" value="<?=isset($userData) ? $userData->lastname:''?>">
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <label class="control-label">Documento</label>            
                <select name="fk_document_type"  class="form-control input-sm">
                    <?php foreach( $documentTypes as $k=>$v): ?>
                        <option value="<?=$k?>" <?=isset($userData) && $userData->fk_document_type == $k ? 'selected':''?>  ><?=$v?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>        
        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label">&nbsp;</label>
                <input type="text" class="form-control input-sm" id="NIF" name="NIF" value="<?=isset($userData) ? $userData->NIFNIF:''?>">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label">Teléfono</label>
                <input type="text" class="form-control input-sm" id="telephone" name="telephone" value="<?=isset($userData) ? $userData->telephone:''?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Móvil</label>
                <input  type="text" 
                        class="form-control input-sm" 
                        id ="mobile" 
                        name ="mobile" 
                        value="<?=isset($userData) ? $userData->mobile:''?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">E-mail</label>
                <input type="text" class="form-control input-sm" id="email" name="email" value="<?=isset($userData) ? $userData->email:''?>">
            </div>
        </div>
    </div>    
    
    <fieldset>
        <legend>Direcciones</legend>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Descripción</label>
                    <input type="text" class="form-control input-sm" id="description" name="description" value="<?=''?>">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label class="control-label">Tipo de vía</label>
                    <select name="fk_document_type"  class="form-control input-sm" name="via_type">
                        <option>Avenida</option>
                        <option>Calle</option>
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label class="control-label">Vía</label>
                    <input type="text" class="form-control input-sm" id="via" name="via" value="<?=''?>">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label class="control-label">Portal</label>
                    <input type="text" class="form-control input-sm" id="portal" name="portal" value="<?=''?>">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label class="control-label">Piso</label>
                    <input type="text" class="form-control input-sm" id="floor" name="floor" value="<?=''?>">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label class="control-label">Localidad</label>
                    <input type="text" class="form-control input-sm" id="locality" name="locality" value="<?=''?>">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label class="control-label">CP</label>
                    <input type="text" class="form-control input-sm" id="CP" name="CP" value="<?=''?>">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label class="control-label">Provincia</label>
                    <input type="text" class="form-control input-sm" id="province" name="province" value="<?=''?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">País</label>
                    <select name="fk_country_id"  class="form-control input-sm">
                        <?php foreach( $countries as $k=>$v): ?>
                            <option value="<?=$k?>"  ><?=$v?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="+">
            </div>
        </div>
    </div>
    </fieldset>
    <fieldset>
        <legend>Contactos</legend>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Descripción</label>
                    <input type="text" class="form-control input-sm" id="description" name="description" value="<?=''?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Nombre</label>
                    <select name="fk_document_type"  class="form-control input-sm" name="via_type">
                        <option>Avenida</option>
                        <option>Calle</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Apellido</label>
                    <input type="text" class="form-control input-sm" id="via" name="via" value="<?=''?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Teléfono</label>
                    <input type="text" class="form-control input-sm" id="portal" name="portal" value="<?=''?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Móvil</label>
                    <input type="text" class="form-control input-sm" id="floor" name="floor" value="<?=''?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Email</label>
                    <input type="text" class="form-control input-sm" id="locality" name="locality" value="<?=''?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Observaciones</label>
                    <input type="text" class="form-control input-sm" id="locality" name="locality" value="<?=''?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="+">
                </div>
            </div>
        </div>
    </fieldset>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Enviar">
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">  
</script>