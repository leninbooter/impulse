<div class="row">
    <div class="col-md-6 text-left">
        <section class="content-header">
          <h1>Empleados </h1>  
        </section>
    </div>
    <div class="col-md-6 text-right">
          <section class="content-header">
            <a href="<?php echo site_url('dashboard/userForm'); ?>"><button type="button" class="btn btn-sm btn-flat btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar</button></a>
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
                                <th style="width:20%">Nombre</th>
                                <th style="width:20%">Tipo</th>
                                <th style="width:20%">Cargo</th>
                                <th style="width:10%">Fecha Creación</th>
                                <th style="text-align:right"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach( $users as $k=>$user): ?>
                            <tr>
                                <td><?= $user->name." ".$user->lastname?></td>
                                <td><?= $user->type->name?></td>
                                <td><?= $user->charge?></td>
                                <td><?= $user->created_at?></td>
                                <td style="text-align:right">                
                                    <a href="<?=base_url('index.php/dashboard/userForm/'.$user->pk_id)?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ver/Editar</a>
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

<div class="modal fade" id="addUserModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Nuevo Usuario</h4>
      </div>
      <div class="modal-body container-fluid">
        <?=$formAddUser?>        
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<script type="text/javascript">
    $('#customersTable').dataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        },
         "columns": [
                    null,
                    null,
                    null,
                    null,
                    { "orderable": false }
                  ]
    });
</script>