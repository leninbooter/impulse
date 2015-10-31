<section class="content-header">
  <h1>Servicios</h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
                              
                <div class="box">
                    
                    <div class="box-body">
                        <table class="table  table-condensed" style="with:100%; border-top:none !important">
                            <thead>
                                <tr>              
                                    <th rowspan="2" style=" width:15.0%; ">Nombre</th>
                                    <th rowspan="2" style=" width:20.0%; ">Descripción</th>
                                    <th colspan="3" style="text-align:center; width:33.33%; ">Precios Bonos</th>
                                </tr>
                                <tr>              
                                    <th style="text-align:center; width:11.11%; ">Créditos desde</th>
                                    <th style="text-align:center; width:11.11%; ">Créditos hasta</th>
                                    <th style="text-align:center; width:11.11%; ">Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach( $services as $s ): ?>
                                <tr style="cursor:pointer" onclick='location.href = "<?=base_url("index.php/services/form/{$s->pk_id}")?>"'>
                                    <td><?=$s->description_ln?></td>
                                    <td><?=$s->observations_txt?></td>
                                    <td colspan="3">
                                        <?php if( isset($s->prices) ): ?>
                                            <table class="table table-condensed" style="border-top:none !important; width: 100%">
                                                <?php foreach( $s->prices as $prices ): ?>                                        
                                                    <tr>
                                                    <td style="width:33.33%; border-top:none !important; text-align:center"><?=$prices->credits_min_int?></td>
                                                    <td style="width:33.33%; border-top:none !important; text-align:center"><?=$prices->credits_max_int?></td>
                                                    <td style="width:33.33%; border-top:none !important; text-align:right"><?=$prices->price_amt?> €</td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </table>
                                    <?php endif; ?>
                                    </td>                                    
                                </tr>
                            <?php endforeach; ?>                               
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div>                                    
        </div>
    </div>
</section>