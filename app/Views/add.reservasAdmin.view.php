<main>
    <form action="" method="POST" class="form-container" >
        <h3>Informacion del cliente</h3>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo isset($input['nombre']) ? $input['nombre'] : ''; ?>">
        <p class="text-danger"><?php echo!empty($errores['nombre']) ? $errores['nombre'] : ''; ?></p>
        <br><br>
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" value="<?php echo isset($input['email']) ? $input['email'] : ''; ?>">
        <p class="text-danger"><?php echo!empty($errores['email']) ? $errores['email'] : ''; ?></p>
        <br><br>

        <label for="habitacion">Habitación:</label>
        <select name="habitacion" required>
            <option value="-1" disabled selected>seleccione una habitacion</option>
            <?php
            if (count($habitacionesAvailable) > 0) {
                foreach ($habitacionesAvailable as $c) {
                    ?>
                    <option value="<?php echo $c['id_habitacion'] ?>"><?php echo $c['id_habitacion'] . ': ' . $c['nombre_habitacion'] ?></option>
                    <?php
                }
            }
            ?>
        </select>
        <p class="text-danger"><?php echo!empty($errores['habitacion']) ? $errores['habitacion'] : ''; ?></p>
        <div style="display:none;">
            <input type="date" id="fecha-llegada" name="fecha-llegada" value="<?php echo $_POST['fecha-llegada'] ?>">
            <input type="date" id="fecha-salida" name="fecha-salida" value="<?php echo $_POST['fecha-salida'] ?>">
        </div>
        <input type="submit" value="Submit">
    </form>
</main>
