<div class="row">
    <div class="col-md-6 text-left">
        <section class="content-header">
          <h1>Clientes </h1>  
        </section>
    </div>
    <div class="col-md-6 text-right">
          <section class="content-header">
            <a href="<?php echo site_url('customers/form'); ?>"><button type="button" class="btn btn-sm btn-flat btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar</button></a>
        </section>
    </div>
</div>
<section class="content">

    <div class="box">
        <div class="box-header">
        </div><!-- /.box-header -->
        <div class="box-body">

            <div class="row">
                <div class="col-md-12">
                    <table id="customersTable" class="table table-condensed table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width:50%">Name</th>
                                <th style="text-align:right"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach( $customers as $k=>$customer): ?>
                            <tr>
                                <td><?= $customer->name." ".$customer->lastname?></td>
                                <td style="text-align:right">                
                                    <a href="<?=base_url('index.php/dashboard/customerProfile/'.$customer->pk_id)?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ver/Editar</a>
<!--                                    <a href="<?=base_url('index.php/suscriptions/actives?custId='.$customer->pk_id)?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Bonos</a>                        -->
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $('#customersTable').dataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        },
        "columns": [
                    null,                                     
                    { "orderable": false }
                  ]
    });
</script>