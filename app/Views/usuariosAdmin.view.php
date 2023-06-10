<main id="usuariosAdmin">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="col-6">
                    <h2 class="m-0 installfont-weight-bold text-primary">Usuarios del sistema</h2> 
                </div>
                <div class="col-6">
                    <?php
                    if (strpos($_SESSION['permisos']['usuarios_sistema'], 'w') !== false) {
                        ?>
                        <div class="m-0 font-weight-bold justify-content-end">
                            <a href="/usuariosAdmin/add/" class="btn btn-primary ml-1 float-right"> Nuevo Usuario del Sistema <i class="fas fa-plus-circle"></i></a>
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
        if (count($usuarios_sistema) > 0) {
            ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>User</th>
                            <th>Rol</th>
                            <?php if (strpos($_SESSION['permisos']['usuarios_sistema'], 'w') !== false) { ?>
                                <th>Actions</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios_sistema as $u) { ?>
                            <tr class="<?php echo $u['baja'] != '0' ? 'table-danger' : ''; ?>">
                                <td><?php echo $u['nombre']; ?></td>
                                <td><?php echo $u['user']; ?></td>
                                <td><?php echo $u['nombre_rol']; ?></td>
                                <?php if (strpos($_SESSION['permisos']['usuarios_sistema'], 'w') !== false) { ?>
                                    <td>
                                        <a href="/usuariosAdmin/edit/<?php echo $u['id_usuario']; ?>" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                    <?php } ?>
                                    <?php if (strpos($_SESSION['permisos']['usuarios_sistema'], 'w') !== false) { ?>
                                        <a href="/usuariosAdmin/baja/<?php echo $u['id_usuario']; ?>" class="btn <?php echo ($u['baja'] == 0) ? 'btn-primary' : 'btn-secondary'; ?>"> <i class="<?php echo $u['baja'] != 0 ? 'fas fa-toggle-off' : 'fas fa-toggle-on'; ?>"></i></a>                                           
                                    <?php } ?>
                                    <?php if (strpos($_SESSION['permisos']['usuarios_sistema'], 'd') !== false) { ?>
                                        <a href="/usuariosAdmin/delete/<?php echo $u['id_usuario']; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        Total de registros: <?php echo count($usuarios_sistema); ?>
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