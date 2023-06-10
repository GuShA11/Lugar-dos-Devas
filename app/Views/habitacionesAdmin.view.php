<main>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="col-6">
                    <h2 class="m-0 installfont-weight-bold text-primary">Habitaciones</h2> 
                </div>
                <div class="col-6">
                    <?php
                    if (strpos($_SESSION['permisos']['usuarios_sistema'], 'w') !== false) {
                        ?>
                        <div class="m-0 font-weight-bold justify-content-end">
                            <a href="/habitacionesAdmin/add/" class="btn btn-primary ml-1 float-right">Nueva Habitación <i class="fas fa-plus-circle"></i></a>
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
        if (count($habitaciones) > 0) {
            ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre Habitacion</th>
                            <th>Precio/noche (€)</th>
                            <th>Descripcion</th>
                            <?php if (strpos($_SESSION['permisos']['usuarios_sistema'], 'w') !== false) { ?>
                                <th>Actions</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($habitaciones as $u) { ?>
                            <tr>
                                <td><?php echo $u['nombre_habitacion']; ?></td>
                                <td><?php echo $u['precio_noche']; ?></td>
                                <td><?php echo $u['descripcion']; ?></td>
                                <?php if (strpos($_SESSION['permisos']['usuarios_sistema'], 'w') !== false) { ?>
                                    <td>
                                        <a href="/habitacionesAdmin/edit/<?php echo $u['id_habitacion']; ?>" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                    <?php } ?>
                                    <?php if (strpos($_SESSION['permisos']['usuarios_sistema'], 'd') !== false) { ?>
                                        <a href="/habitacionesAdmin/delete/<?php echo $u['id_habitacion']; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        Total de registros: <?php echo count($habitaciones); ?>
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