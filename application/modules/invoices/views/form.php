<input type="hidden" name="custid" value="<?=$appt->cust_id?>">
<input type="hidden" name="apptid" value="<?=$appt->pk_id?>">
<div class="row">
    <div class="col-xs-6">
        <div  class="box-header ui-sortable-handle" style="padding-left:0; padding-top:0">
           <h3 class="box-title"><i class="fa fa-user"></i> Paciente</h3>            
        </div>
          
         <div class="form-group" style="margin-bottom:0">
            <h4 style="margin-top:0; margin-bottom: 0"><small>Nombre</small><br>
            <?="{$appt->name} {$appt->lastname}"?></h4>
          </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-4">
         <div class="form-group" style="margin-bottom:0">
            <h4 style="margin-top:0"><small>Dirección</small><br>
            <?="{$cust_addrs[0]->via} {$cust_addrs[0]->via_number}, {$cust_addrs[0]->portal} {$cust_addrs[0]->floor}. {$cust_addrs[0]->locality}, {$cust_addrs[0]->province}. {$cust_addrs[0]->CP}"?></h4>
          </div>
    </div>
    <div class="col-xs-3">
         <div class="form-group" style="margin-bottom:0">
            <h4 style="margin-top:0"><small>Teléfono</small><br>
            <?="{$cust->mobile}"?></h4>
          </div>
    </div>
    <div class="col-xs-3">
         <div class="form-group" style="margin-bottom:0">
            <h4 style="margin-top:0"><small>Email</small><br>
            <?="{$cust->email}"?></h4>
          </div>
    </div>
</div>
<div class="row" style="margin-top: 30px">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div  class="box-header ui-sortable-handle">
                <i class="ion ion-clipboard"></i>
                <h3 class="box-title">Servicios</h3>              
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="padding-top:0">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Cant.</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                            <tr>
                                <td>1<input type="hidden" name="itemqty[]" value="1"></td>
                                <td><?=$service->description_ln?><input type="hidden" name="itemid[]" value="<?=$service->pk_id?>"><input type="hidden" name="itmdesc[]" value="<?=$service->description_ln?>"></td>
                                <td style="text-align: right"><?=$servicePrice->price_amt?><input type="hidden" name="itemprice[]" value="<?=$servicePrice->price_amt?>"></td>
                            </tr>
                       
                    </tbody>
                </table>
                <table class="table" style="border:none">                   
                    <tbody>                       
                        <tr>
                            <td style="width: 80%; text-align: right; border:none"><h4 style="margin:0"><b>Subtotal:</b></h4></td><td style="text-align: right; border:none"><h3 style="margin:0"><?=$servicePrice->price_amt?></h4><input type="hidden" name="subtotal" value="<?=$servicePrice->price_amt?>"></td>
                        </tr>
                        <tr>
                            <td style="text-align: right; border:none"><h4 style="margin:0"><b>Total:</b></h4></td><td style="text-align: right; border:none"><h3 style="margin:0"><?=$servicePrice->price_amt?></h4><input type="hidden" name="total" value="<?=$servicePrice->price_amt?>"></td>
                        </tr>                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <h4 style="margin-top:0"><small>Forma de Pago</small></h4>
        <div class="radio">
          <label>
            <input type="radio" name="paymentmeth[]" id="cash" value="1" checked>
            Efectivo
          </label>
          <label>
            <input type="radio" name="paymentmeth[]" id="card" value="2" >
            Débito/Crédito
          </label>
        </div>
    </div>
</div>