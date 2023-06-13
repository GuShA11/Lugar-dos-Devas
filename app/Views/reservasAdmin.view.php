<main>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="col-6">
                    <h2 class="m-0 installfont-weight-bold text-primary">Reservas</h2> 
                </div>
                <div class="col-6">
                    <?php
                    if (strpos($_SESSION['permisos']['usuarios_sistema'], 'w') !== false) {
                        ?>
                        <div class="m-0 font-weight-bold justify-content-end">
                            <a href="/reservasAdmin/add" class="btn btn-primary ml-1 float-right"> Nueva Reserva <i class="fas fa-plus-circle"></i></a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
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
                <div class="alert alert-<?php echo $mensaje['class']; ?>"><p><?php echo $mensaje['texto']; ?></p></div>
            </div>
            <?php
        }
        ?>
        <?php
        if (count($reservas) > 0) {
            ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Fecha llegada</th>
                            <th>Fecha salida</th>
                            <th>Habitacion</th>
                            <?php if (strpos($_SESSION['permisos']['usuarios_sistema'], 'w') !== false) { ?>
                                <th>Actions</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservas as $r) { ?>
                            <tr>
                                <td><?php echo $r['email']; ?></td>
                                <td><?php echo $r['fecha_llegada']; ?></td>
                                <td><?php echo $r['fecha_salida']; ?></td>
                                <td><?php echo $r['nombre_habitacion']; ?></td>
                                <?php if (strpos($_SESSION['permisos']['usuarios_sistema'], 'w') !== false) { ?>
                                    <td>
                                        <a href="/reservasAdmin/edit/<?php echo $r['id_reserva']; ?>" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                        <?php
                                    }
                                    if (strpos($_SESSION['permisos']['usuarios_sistema'], 'd') !== false) {
                                        ?>
                                        <a href="/reservasAdmin/delete/<?php echo $r['id_reserva']; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                    </td>
                                <?php } ?>
                            <?php } ?>
                        </tr>
                    </tbody>
                    <tfoot>
                        Total de Reservas: <?php echo count($reservas); ?>
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
    </div>
</main>