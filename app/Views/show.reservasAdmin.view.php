<main>
    <h2>Alta reserva</h2>
    <div>
        <p>Por favor indique las fechas de su estadía para comprobar la disponibilidad de nuestras habitaciones!</p>
    </div>
    <form action="reservasAdmin/add" method="POST">
        <div id="dateInputs">
            <label for="fecha-llegada">Fecha de Llegada:</label>
            <input type="date" id="fecha-llegada" name="fecha-llegada"  value="<?php echo isset($input['fecha-llegada']) ? $input['fecha-llegada'] : ''; ?>">
            <br><br>

            <label for="fecha-salida">Fecha de Salida:</label>
            <input type="date" id="fecha-salida" name="fecha-salida" value="<?php echo isset($input['fecha-salida']) ? $input['fecha-salida'] : ''; ?>">
            <br><br>
            <p class="text-danger"><?php echo isset($errores['fecha']) ? $errores['fecha'] : ''; ?></p>
        </div>
        <input type="submit" value="Submit">
    </form>
</main>