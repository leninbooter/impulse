 <div class="modal-header">
    <h4 class="modal-title">Recibo</h4>
</div>
<form method="POST" action="<?=base_url('index.php/receipts/generate')?>">
    <div  class="modal-body container-fluid">
        <?=$form?>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="Guardar">
    </div>            
</form>