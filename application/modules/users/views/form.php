<?php 

    if ( isset($userData) ){
        
        $customerId = $userData->pk_id;
        
    }else {
        
        $customerId = '';
    }
?>  
<form method="post" action="<?=base_url("index.php/users/form/{$customerId}")?>" class="form-inline" >
    <div class="form-group" style="">
        <label for="exampleInputName2" class="control-label" >Tipo de Usuario</label>
        <select name="fk_document_type" class="form-control input-sm bg">
            <?php foreach( $userTypes as $k=>$type ): ?>
                <option value="<?=$k?>" <?= isset($userData->fk_user_type_id) && $userData->fk_user_type_id == $k ? 'selected':''?>  ><?=$type?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <fieldset>        
        <div class="form-group" style="">
            <label class="control-label" >Nombre</label>
            <input  type="text" 
                    class="form-control input-sm bg" 
                    id ="name" 
                    name ="name" 
                    value="<?=isset($userData) ? $userData->name:''?>"> 
        </div>
        <div class="form-group" style="">
            <label class="control-label " >Apellido</label>
            <input type="text" class="form-control input-sm bg" id="lastname" name="lastname" value="<?=isset($userData) ? $userData->lastname:''?>">
        </div>
        
        <div class="form-group">
            <label class="control-label" >Cargo</label>            
            <input type="text" class="form-control input-sm bg" id="charge" name="charge" value="<?=isset($userData) ? $userData->charge:''?>">
        </div>
    </fieldset>
    
    <fieldset>
        <legend>Credenciales</legend>
        <div class="form-group" >
            <label class="control-label" >Nombre Usuario</label>
            <input  type="text" 
                    class="form-control input-sm" 
                    id ="username" 
                    name ="username" 
                    value="<?=isset($userData) ? $userData->username:''?>">
        </div>
        <div class="form-group">
            <label class="control-label">Contraseña</label>
            <input type="password" class="form-control input-sm bg" id="pwd" name="pwd" value="<?=isset($userData) ? $userData->pwd:''?>">
        </div>      
    </fieldset>        
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="btn_guardar" value="Guardar">
            </div>
        </div>
    </div>
</form>

<style>
    fieldset {
        
        margin-bottom: 10px;
    }

    .form-group label {
        
        display:block;
    }
    
    @media ( min-width: 768px  ) {
        .form-group {
            
            width: 200px;
            margin-bottom:7px !important;
        }
        
        .form-group .bg,
        .form-group select .bg {
            
            width: 190px !important;
        }
        
        .form-group input .sm,
        .form-group select .sm {
            
            width: 150px;
        }
    }
    
    @media ( max-width: 767px ) {
        
        .form-group {
            width: 100%;            
            margin-bottom:7px;
        }
        
        .form-group input,
        .form-select {
            
            width: 100%;
        }
        
    }
</style>

<script type="text/javascript">  
</script>