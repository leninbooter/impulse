<section class="content-header">
  <h1>Servicios</h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
        
            <?php foreach( $services as $s ): ?>                  
                <div class="box">
                    <div class="box-header">
                      <h3 class="box-title"><?=$s->description_ln?></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <h3>Precios Bonos</h3>
                        <table class="table table-hover table-boreder table-responsibe" style="with:100%">
                            <thead>
                                <tr>              
                                    <th>Créditos desde</th>
                                    <th>Créditos hasta</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if( isset($s->prices) ): ?>                  
                                    <?php foreach( $s->prices as $prices ): ?>                  
                                        <tr>                        
                                            <td><?=$prices->credits_min_int?></td>
                                            <td><?=$prices->credits_max_int?></td>
                                            <td class="text-right"><?=$prices->price_amt?> €</td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <tr style="display:none">                        
                                    <td><input type="text" class="form-control"></td>
                                    <td><input type="text" class="form-control"></td>
                                    <td class="text-right"><input type="text" class="form-control"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div>
            <?php endforeach; ?>        
                    
        </div>
    </div>
</section>