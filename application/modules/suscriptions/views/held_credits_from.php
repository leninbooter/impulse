<section class="content-header">
  <h1>Bonos de  <?=$customerData->name." ".$customerData->lastname?></h1>
    <h3>Créditos bloqueados para  <?=$service->description_ln?></h2>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">            
            <div class="box">
                <div class="box-body table-responsive">
                    <table class="table table-condensed table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width:10%; text-align:left">Fecha</th>
                                <th style="width:30%; text-align:left">Descripción</th>
                                <th style="width:10%; text-align:center">Creditos</th>
                            </tr>
                        </thead>
                        <tbody>        
                            <?php if ( !empty($transactions)): ?>
                                <?php foreach( $transactions as $k=>$t): ?>
                                <tr>
                                    <td><?=$t->datetime_dtm?></td>
                                    <td style="text-align:left"><?=$t->notes_txt?></td>
                                    <td style="text-align:center"><?=$t->credits_int?></td>                
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>