<form id="newSuscriptionForm" class="form-horizontal" method="post" action="" onsubmit="return false;">    
    <input type="hidden" name="suscription[customerId]" value="<?=$customerId?>">
    <input type="hidden" name="redirect" value="<?=base_url("index.php/dashboard/customerprofile/{$customerId}")?>">
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

<script>

    function invoice(saleid) {
            
        $('#addServiceModalContent').addClass('magictime loading');
        
        $('#addServiceModalContent').load(
            '<?=base_url('index.php/invoices/invoice')?>' + '/' + saleid + '/true',
            {},
            function() {
                $('#addServiceModalContent').removeClass('magictime loading');                
            }
        );
    }
    
    $('#newSuscriptionForm').submit( function() {
        
        $.post( '<?=base_url('index.php/suscriptions/add')?>', 
            $('#newSuscriptionForm').serialize(),
            function( result ) {
                if ( result.result == 'OK') {
                    
                    $('#addServiceModalContent').modal({
                       
                       show: true,
                        backdrop: 'static',
                        keyboard: false
                       
                    });                                        
                    
                    invoice(result.saleid);
                    
                }else {
                    
                    alert('Technical error!');
                }
            },
            'json');
        
    });
    
    
</script>