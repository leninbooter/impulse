<div class="modal-header">
    <h4 class="modal-title">Checkout</h4>
</div>
<div class="modal-body container-fluid form-horizontal">
        <input type="hidden" name="apptid" value="<?=$apptid?>">                     
            <div class="form-group">
                <h4 class="col-xs-3 control-label text-left" style="text-align: left; margin-top:0" ><i class="fa fa-clock-o"></i> Duración:</h4>
                <div class="col-xs-6" style="padding-left:0">
                    <select id="duration" name="duration" class="form-control" style="width: 100%">
                        <?php $i = 0.25;
                            while(true): ?>
                        <option value="<?=$i?>"><?php $h = floor($i); echo $h > 0 ? $h.' hora':''; echo $h > 1 ? 's':''?> <?php $m = ($i-(floor($i)))*60; echo $m > 0 ? $m.' mins':''?></option>                         
                        <?php 
                            $i += 0.25;
                            if($i > 2) break;
                        endwhile; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                 <div class="col-xs-offset-3 col-xs-8" style="padding-left: 0">
                 <label><h4 class=" control-label text-left" style="text-align: left; margin-top:0" ><input type="radio" name="processas" value="invoice" checked> Factura</h4></label>
                 <label><h4 class=" control-label text-left" style="text-align: left; margin-top:0" ><input type="radio" name="processas" value="receipt" > Recibo</h4></label>
                 </div>
            </div>
            <div class="form-group">
                <div class="col-xs-offset-3 col-xs-3" style="padding-left: 0"> 
                    <input type="button" class="btn btn-primary  btn-block" id="btn_checkout" name="btn_checkout" name="checkout" value="Continuar">
                 </div>
                 <div class="col-xs-offset-0 col-xs-3" style="padding-left: 0"> 
                    <input type="button" class="btn btn-default btn-block" value="Cancelar"  data-dismiss="modal">
                 </div>
            </div>
    </div>