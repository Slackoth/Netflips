<?php $i = 1; ?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nombres</th>
            <th scope="col">Apellidos</th>
            <th scope="col">Plan</th>
            <th scope="col">Tipo</th>
            <th scope="col">Costo total</th>
            <th scope="col">Fecha de inicio</th>
            <th scope="col">Fecha de expiracion</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($clients as $key => $value): ?>
        <tr>
            <th scope="row"><?= $i++; ?></th>
            <td><?= $value["firstname"] ?></td>
            <td><?= $value["lastname"] ?></td>
            <td><?= $value["plan"] ?></td>
            <td><?= $value["type"] ?></td>
            <td><?= $value["total_cost"] ?></td>
            <td><?= date("d/m/y", strtotime($value["initiation_date"])) ?></td>
            <td><?= date("d/m/y", strtotime($value["expiration_date"])) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>