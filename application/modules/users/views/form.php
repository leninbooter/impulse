<form method="post">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">                
                <label class="control-label">Tipo de Usuario</label>
                <select name="fk_document_type" class="form-control input-sm">                    
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
        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label">Cargo</label>            
                <input type="text" class="form-control input-sm" id="charge" name="charge" value="<?=isset($userData) ? $userData->charge:''?>">
            </div>
        </div>                        
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label">Nombre Usuario</label>
                <input  type="text" 
                        class="form-control input-sm" 
                        id ="username" 
                        name ="username" 
                        value="<?=isset($userData) ? $userData->username:''?>">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label">Contraseña</label>
                <input type="password" class="form-control input-sm" id="pwd" name="pwd" value="<?=isset($userData) ? $userData->pwd:''?>">
            </div>
        </div>
    </div>    
            
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="btn_guardar" value="Guardar">
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">  
</script>