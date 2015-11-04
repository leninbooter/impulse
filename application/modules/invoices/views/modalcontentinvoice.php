 <div class="modal-header">
    <h4 class="modal-title">Facturación</h4>
</div>
<form method="POST" action="<?=base_url('index.php/invoices/generate')?>">
    <div  class="modal-body container-fluid">
        <?=$form?>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" name="save" value="Guardar">
        <input type="submit" class="btn btn-primary" name="saveandprint" value="Guardar e imprimir">
    </div>            
</form>