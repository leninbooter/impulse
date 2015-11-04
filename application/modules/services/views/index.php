<section class="content-header">
  <h1>Servicios</h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
                              
                <div class="box">
                    
                    <div class="box-body">
                        <table id="services" class="table  table-condensed" style="with:100%; border-top:none !important">
                            <thead>
                                <tr>              
                                    <th rowspan="2" style=" width:15.0%; ">Nombre</th>
                                    <th rowspan="2" style=" width:20.0%; ">Descripción</th>
                                    <th colspan="3" style="text-align:center; width:33.33%; border-top: 1px solid; border-right: 1px solid; border-left: 1px solid">Paquetes por Créditos</th>
                                    <th colspan="3" style="text-align:center; width:33.33%; border-top: 1px solid; border-right: 1px solid; border-left: 1px solid">Paquetes por Tiempo</th>
                                </tr>
                                <tr>              
                                    <th style="text-align:center; width:11.11%; border-left: 1px solid">Créditos desde</th>
                                    <th style="text-align:center; width:11.11%; ">Créditos hasta</th>
                                    <th style="text-align:center; width:11.11%; ">Precio</th>
                                    <th style="text-align:center; width:11.11%; border-left: 1px solid">Meses</th>
                                    <th style="text-align:center; width:11.11%; border-left: 1px solid">Citas Mensuales</th>
                                    <th style="text-align:center; width:11.11%; border-right: 1px solid">Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach( $services as $s ): ?>
                                <tr style="cursor:pointer" onclick='location.href = "<?=base_url("index.php/services/form/{$s->pk_id}")?>"'>
                                    <td><h4 style="padding:0; margin:0"><?=$s->description_ln?></h4></td>
                                    <td><?=$s->observations_txt?></td>
                                    <td colspan="3" style="border-left: 1px solid; border-right: 1px solid;">
                                        <?php if( isset($s->prices) ): ?>
                                            <table class="table table-condensed" style="border-top:none !important; width: 100%">
                                                <?php foreach( $s->prices as $prices ): ?>                                        
                                                    <tr>
                                                    <td style="width:33.33%; border-top:none !important; text-align:center; "><?=$prices->credits_min_int?></td>
                                                    <td style="width:33.33%; border-top:none !important; text-align:center"><?=$prices->credits_max_int?></td>
                                                    <td style="width:33.33%; border-top:none !important; text-align:right"><?=number_format($prices->price_amt, 2, ',', '.')?> €</td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </table>
                                    <?php endif; ?>
                                    </td>
                                    <td colspan="3" style="border-left: 1px solid; border-right: 1px solid;">
                                        <?php if( isset($s->timebundles) ): ?>
                                            <table class="table table-condensed" style="border-top:none !important; width: 100%">
                                                <?php foreach( $s->timebundles as $prices ): ?>                                        
                                                    <tr>
                                                    <td style="width:33.33%; border-top:none !important; text-align:center; "><?=$prices->time_bundle_int?></td>
                                                    <td style="width:33.33%; border-top:none !important; text-align:right"><?=$prices->month_appts_int?></td>
                                                    <td style="width:33.33%; border-top:none !important; text-align:right"><?=number_format($prices->price_amt, 2, ',', '.')?> €</td>
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
<style>
   #services > tbody > tr:last-child > td:nth-child(1n+3) {
       border-bottom: 1px solid;
   }
   
   #services  table td {
       
      // border-bottom: 1px solid
   }
</style>