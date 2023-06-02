<main id="usuariosAdmin">
    <h2>Usuarios ADMIN</h2>
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
    <div>
        <div class="col-6">
            <h6 class="m-0 installfont-weight-bold text-primary">Usuarios del sistema</h6> 
        </div>
        <div class="col-6">
            <?php
            if (strpos($_SESSION['permisos']['usuarios_sistema'], 'w') !== false) {
                ?>
                <div class="m-0 font-weight-bold justify-content-end">
                    <a href="/usuariosAdmin/add/" class="btn btn-primary ml-1 float-right"> Nuevo Usuario del Sistema ADD</a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
    if (count($usuarios_sistema) > 0) {
        ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>User</th>
                        <th>Rol</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios_sistema as $u) { ?>
                        <tr class="<?php echo $u['baja'] != '0' ? 'table-danger' : ''; ?>">
                            <td><?php echo $u['id_usuario']; ?></td>
                            <td><?php echo $u['nombre']; ?></td>
                            <td><?php echo $u['user']; ?></td>
                            <td><?php echo $u['nombre_rol']; ?></td>
                            <td>
                                <?php if (strpos($_SESSION['permisos']['usuarios_sistema'], 'w') !== false) { ?>
                                    <div>
                                        <a href="/usuariosAdmin/edit/<?php echo $u['id_usuario']; ?>" class="btn btn-success">EDIT</a>
                                    </div>
                                <?php } ?>
                                <?php if (strpos($_SESSION['permisos']['usuarios_sistema'], 'w') !== false) { ?>
                                    <div>
                                        <a href="/usuariosAdmin/baja/<?php echo $u['id_usuario']; ?>" class="btn <?php echo ($u['baja'] == 0) ? 'btn-primary' : 'btn-secondary'; ?>">
                                            <?php echo $u['baja'] != 0 ? 'BAJA FALSE' : 'BAJA TRUE'; ?>
                                        </a>
                                    </div>
                                <?php } ?>
                                <?php if (strpos($_SESSION['permisos']['usuarios_sistema'], 'd') !== false) { ?>
                                    <div>
                                        <a href="/usuariosAdmin/delete/<?php echo $u['id_usuario']; ?>" class="btn btn-danger">DELETE</a>
                                    </div>
                                <?php } ?>
                            </td>
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
</main>