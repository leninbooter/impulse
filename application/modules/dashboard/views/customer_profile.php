<section class="content-header">
  <h1><?=$sectionTittle?></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12" style="padding: 0">
            <ul class="nav nav-tabs nav-tabs-noborder" role="tablist">
                 <li role="presentation" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">Detalles</a></li>
                 <li role="presentation" class=""><a href="#invoices" aria-controls="invoices" role="tab" data-toggle="tab">Facturas y Recibos</a></li>
            </ul>
            
            <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active" id="details">
                    <div class="row">
                         <div class="col-xs-6">
                            <h2>Datos Personales</h2>
                            <div class="">
                            <?=$customerForm?>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <h2>Bonos Contratados</h2>
                            <?=$bonus?>
                        </div>
                    </div>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="invoices">
                    <div class="box">
                        <div class="box-body no-padding">
                            <table class="table  table-responsive table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Estado</th>
                                        <th>Documento</th>
                                        <th style="width: 10%">Factura / Recibo</th>
                                        <th>Creada</th>
                                        <th style="width: 10% ; text-align: right;">Monto</th>
                                        <th style="width: 10% ; text-align: right;">Pagado</th>
                                        <th style="width: 10% ; text-align: right;">Balance</th>
                                        <th style="text-align: center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach( $invoices as $v ): ?>
                                    <tr>
                                        <td style="text-align: center"><?=$v->balance_amt > 0 ? '<span class="label label-warning">Impaga</span>':'<span class="label label-success">Pagada</span>'?></td>
                                        <td>Factura</td>
                                        <td style="text-align: center">#<?=$v->pk_id?></td>
                                        <td><?=date('d-m-Y', strtotime($v->created_at))?></td>
                                        <td style="text-align:right"><?=number_format($v->total_amt, 2, ',', '.')?> €</td>
                                        <td style="text-align:right"><?=number_format($v->paid_amt, 2, ',', '.')?> €</td>
                                        <td style="text-align:right"><?=number_format($v->balance_amt, 2, ',', '.')?> €</td>
                                        <td style="text-align: center">
                                            <div class="btn-group">
                                              <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Opciones <span class="caret"></span>
                                              </button>
                                              <ul class="dropdown-menu">
                                                <li><a href="#" data-toggle="modal" data-target="#paymentModal" data-backdrop="static" data-invoice="<?=$v->pk_id?>">Pagar</a></li>                                                
                                              </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    
                                    <?php foreach( $receipts as $v ): ?>
                                    <tr>
                                        <td style="text-align: center"><?=$v->balance_amt > 0 ? '<span class="label label-warning">Impaga</span>':'<span class="label label-success">Pagada</span>'?></td>
                                        <td>Recibo</td>
                                        <td style="text-align: center">#<?=$v->pk_id?></td>
                                        <td><?=date('d-m-Y', strtotime($v->created_at))?></td>
                                        <td style="text-align:right"><?=number_format($v->total_amt, 2, ',', '.')?> €</td>
                                        <td style="text-align:right"><?=number_format($v->paid_amt, 2, ',', '.')?> €</td>
                                        <td style="text-align:right"><?=number_format($v->balance_amt, 2, ',', '.')?> €</td>
                                        <td style="text-align: center">
                                            <div class="btn-group">
                                              <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Opciones <span class="caret"></span>
                                              </button>
                                              <ul class="dropdown-menu">
                                                <li><a href="#" data-toggle="modal" data-target="#paymentModal" data-backdrop="static" data-receipt="<?=$v->pk_id?>">Pagar</a></li>                                                
                                              </ul>
                                            </div>                                            
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        
                        </div>
                    </div>
                  </div>
            </div>
        </div>
    
       
    </div>
        
    <?=$lastAppts?>
</section>

<div class="modal" id="paymentModal">
  <div class="modal-dialog modal-sm ">
    <div class="modal-content">
    <form id="newpaymentform" method="POST" onsubmit="return false">
        <div class="modal-header container-fluid">
            <h4 class="modal-title">Pago</h4>
        </div>
        <div class="modal-body container-fluid form-horizontal">
            <input type="hidden" name="invid" id="invid" value="">            
            <input type="hidden" name="recid" id="recid" value="">            
            
            <div class="form-group" style="margin-bottom: 0">
                    <div class="col-xs-offset-2 col-xs-10 radio">
                      <label>
                        <input type="radio" name="paymentmeth" id="cash" value="1" checked>
                        Efectivo
                      </label>
                    </div>
                </div>    
             <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-10 radio">
                      <label>
                        <input type="radio" name="paymentmeth" id="card" value="2" >
                        Débito/Crédito
                      </label>
                    </div>
                </div>    
            
            
            <div class="form-group">
                <label for="ammount" class="col-xs-2 control-label">Monto </label>
                <div class="col-xs-10">
                   <input name="payment_ammount" class="form-control" value="" type="text">
                </div>
            </div>
            
            <div class="form-group">
                <label for="ammount" class="col-xs-2 control-label">Detalles </label>
                <div class="col-xs-10">
                   <input name="payment_description" class="form-control" value="" type="text">
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-offset-2 col-xs-10">
                    <input type="submit" class="btn btn-primary" value="Aceptar" name="save">                    
                </div>
            </div>
        </div>        
    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<style>
.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
    color: #000;
    background-color: #FFF;
    border-width: 1px;
    border-style: solid;
    border-color: #DDD #DDD transparent;
    -moz-border-top-colors: none;
    -moz-border-right-colors: none;
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    border-image: none;
    cursor: default;
}
.nav-tabs-noborder > li > a {
    border-top-right-radius: 0px !important;
    border-top-left-radius: 0px !important;
    border-top: 0px none !important;
}
.nav-tabs > li > a {
    margin-right: 2px;
    line-height: 1.42857;
    border: 1px solid transparent;
    border-radius: 4px 4px 0px 0px;
    background: #e9e9e9;
    color: #646464;
}
</style>

<script>
    $('#paymentModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        
        var invid = button.data('invoice');
        var recid = button.data('receipt');
              
        var modal = $(this);
        modal.find('#invid').val(invid);
        modal.find('#recid').val(recid);
    })
    
    $('#newpaymentform').submit( function() {

        $.post('<?=base_url('index.php/payments/add')?>', 
            $(this).serialize(),
            function(result) {
                
                if ( result.result == 'OK') {
                    
                     location.reload();
                }
            },
            'json'
            );
    });
    
</script>