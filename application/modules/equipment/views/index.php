<section class="content-header">
  <h1>Equipos</h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-responsive" style="width: 100%">
                <tr>
                    <th></th>
                    <th>Serial</th>
                    <th style="width: 50%"></th>
                    <th>Tiempo de Uso</th>
                </tr>
                <tbody>
                    <?php for($i=0; $i<count($equipment); $i++ ): ?>
                        <tr>
                            <th><?=$equipment[$i]->name_sn?></th>
                            <td><?=$equipment[$i]->serial_ln?></td>
                            <td>
                                <div class="progress">
                                  <div class="progress-bar" role="progressbar" aria-valuenow="<?=$equipment[$i]->usagetime?>" aria-valuemin="" aria-valuemax="<?=$totalusage?>" style="width: <?=$equipment[$i]->usagetime != null && $equipment[$i]->usagetime > 0 ? ($equipment[$i]->usagetime/$totalusage)*100:0?>%;">
                                    <span class="sr-only"></span>
                                  </div>
                                </div>
                            </td>
                            <td><?php 
                                $h = floor($equipment[$i]->usagetime);
                                echo $h > 0 ? $h.' hora':'';
                                echo $h > 1 ? 's':'';
                                echo $h > 0 ? ' y ':' ';
                                $m = ($equipment[$i]->usagetime - $h)*60;
                                echo $m.' mins';
                                
                                ?></td>
                        </tr>
                    <?php endfor;?>
                </tbody>
            </table>
        
        </div>
    </div>
    
</section>

<style>
    .content h4 {
        
        margin: 0;
        padding: 0;
    }
</style>