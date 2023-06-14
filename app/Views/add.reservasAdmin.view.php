<main id="addReserva">
    <div class="col-6 cajaReservas">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h4 class="m-0 font-weight-bold text-primary">Informacion del cliente</h4>     
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="row">
                        <div class="mb-3 col-sm-3">
                            <label for="nombre">Nombre:</label>
                            <input class="form-control" type="text" id="nombre" name="nombre" value="<?php echo isset($input['nombre']) ? $input['nombre'] : ''; ?>">
                            <p class="text-danger"><?php echo isset($errores['nombre']) ? $errores['nombre'] : ''; ?></p>
                        </div>
                        <div class="mb-3 col-sm-3">
                            <label for="email">Email:</label>
                            <input class="form-control" type="text" id="email" name="email" value="<?php echo isset($input['email']) ? $input['email'] : ''; ?>">
                            <p class="text-danger"><?php echo isset($errores['email']) ? $errores['email'] : ''; ?></p>
                        </div>
                        <div class="mb-3 col-sm-3">
                            <label for="habitacion">Habitación:</label>
                            <select name="habitacion" required>
                                <option value="-1" disabled selected>seleccione una habitacion</option>
                                <?php
                                if (count($habitacionesAvailable) > 0) {
                                    foreach ($habitacionesAvailable as $c) {
                                        ?>
                                        <option value="<?php echo $c['id_habitacion'] ?>"><?php echo $c['nombre_habitacion'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <p class="text-danger"><?php echo isset($errores['habitacion']) ? $errores['habitacion'] : ''; ?></p>
                            <div style="display:none;">
                                <input type="date" id="fecha-llegada" name="fecha-llegada" value="<?php echo $_POST['fecha-llegada'] ?>">
                                <input type="date" id="fecha-salida" name="fecha-salida" value="<?php echo $_POST['fecha-salida'] ?>">
                            </div>
                        </div>
                        <div class="col-12 text-right">                            
                            <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
