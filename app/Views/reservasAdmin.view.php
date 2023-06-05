<main>
    <h2>Reservas ADMIN</h2>
    <?php
    if (isset($error)) {
        ?>
        <div class="col-12">
            <div class="alert alert-danger"><p><?php echo $error; ?></p></div>
        </div>
        <?php
    }
    ?>
    <?php
    if (isset($mensaje)) {
        ?>
        <div class="col-12">
            <div class="alert"><p><?php echo $mensaje['texto']; ?></p></div>
        </div>
        <?php
    }
    ?>
    <div>
        <div class="col-6">
            <h6 class="m-0 installfont-weight-bold text-primary">Reservas sistema</h6> 
        </div>
        <div class="col-6">
            <?php
            if (strpos($_SESSION['permisos']['usuarios_sistema'], 'w') !== false) {
                ?>
                <div class="m-0 font-weight-bold justify-content-end">
                    <a href="/reservasAdmin/add" class="btn btn-primary ml-1 float-right">Nuevo reserva del Sistema ADD</a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
    if (count($reservas) > 0) {
        ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Nombre</th>
                        <th>Precio Total</th>
                        <th>Fecha llegada</th>
                        <th>Fecha salida</th>
                        <th>Habitacion</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $r) { ?>
                        <tr>
                            <td><?php echo $r['id_reserva']; ?></td>
                            <td><?php echo $r['email']; ?></td>
                            <td><?php echo $r['nombre']; ?></td>
                            <td><?php echo $r['precio_total']; ?></td>
                            <td><?php echo $r['fecha_llegada']; ?></td>
                            <td><?php echo $r['fecha_salida']; ?></td>
                            <td><?php echo $r['nombre_habitacion']; ?></td>
                            <td>
                                <?php if (strpos($_SESSION['permisos']['usuarios_sistema'], 'w') !== false) { ?>
                                    <div>
                                        <a href="/reservasAdmin/edit/<?php echo $r['id_reserva']; ?>" class="btn btn-success">EDIT</a>
                                    </div>
                                <?php }
                                if (strpos($_SESSION['permisos']['usuarios_sistema'], 'd') !== false) {
                                    ?>
                                    <div>
                                        <a href="/reservasAdmin/delete/<?php echo $r['id_reserva']; ?>" class="btn btn-danger">DELETE</a>
                                    </div>
                            <?php } ?>
                            </td>
    <?php } ?>
                    </tr>
                </tbody>
                <tfoot>
                    Total de registros: <?php echo count($reservas); ?>
                </tfoot>
            </table>
        </div>

        <?php
    } else {
        ?>
        <p class="text-danger">No existen registros que cumplan los requisitos.</p>
        <?php
    }
    ?>
</main>