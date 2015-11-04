<div class="row">
    <div class="col-md-6 text-left">
        <section class="content-header">
          <h1>Movimientos de Caja </h1>  
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
                                <th style="width:15%">Fecha</th>
                                <th style="text-align:left">Tipo</th>
                                <th style="text-align:left">Concepto</th>
                                <th style="text-align:right">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach( $transactions as $k=>$v): ?>
                            <tr>
                                <td><?=$v->created_at?></td>
                                <td><?=$v->invoice_id == null ? $v->note_txt:"Fago a factura #{$v->invoice_id}"?></td>
                                <td><?=$v->note_txt?></td>
                                <td style="text-align: right"><?=$v->ammount_amt?></td>
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