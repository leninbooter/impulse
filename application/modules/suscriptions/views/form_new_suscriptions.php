<form id="newSuscriptionForm" class="form-horizontal" method="post" action="<?=base_url('index.php/suscriptions/add')?>">    
    <input type="hidden" name="suscription[customerId]" value="<?=$customerId?>">
    <input type="hidden" name="redirect" value="<?=base_url('index.php/dashboard/customerProfile?custId='-$customerId)?>">
    <div class="form-group">        
        <label class="col-sm-2 control-label">Servicio</label>
        <div class="col-sm-5">
            <select id="suscription_serviceid"  name="suscription[serviceId]" class="form-control">
                <?php foreach( $services as $k=>$s ): ?>
                    <option value="<?=$k?>"><?=$s?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <label class="col-sm-2 control-label">Créditos</label>
        <div class="col-sm-3">
            <input type="text" name="suscription[credits]" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-10 col-sm-2">
          <button type="submit" class="btn btn-default">Guardar</button>
        </div>
    </div>    
</form>