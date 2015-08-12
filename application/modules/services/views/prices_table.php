<table class="table table-hover table-responsive" style="width:100%">
    <thead>
        <th>Créditos desde</th>
        <th>Créditos hasta</th>
        <th>Precio</th>
    </thead>
    <tbody>
        <?php foreach( $prices->prices as $p): ?>
            <tr>
                <td><?=$p->credits_min_int?></td>
                <td><?=$p->credits_max_int?></td>
                <td style="text-align:right"><?=$p->price_amt?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>