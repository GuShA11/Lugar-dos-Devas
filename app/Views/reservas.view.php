<main>
<h2>Hotel Reservation Form</h2>
<form action="/reservas/add" method="POST">
    <h3>Informacion del cliente</h3>
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required>
    <p class="text-danger"><?php echo isset($errores['nombre']) ? $errores['nombre'] : ''; ?></p>
    <br><br>
    
    <label for="email">Email Address:</label>
    <input type="email" id="email" name="email" required>
    <p class="text-danger"><?php echo isset($errores['email']) ? $errores['email'] : ''; ?></p>
    <br><br>
    
    <h3>Detalles de la reserva</h3>
    <div class="mb-3 col-sm-4">
    <label for="habitacion">Habitación:</label>
    <select class="form-control select2-container--default" name="habitacion" id="habitacion" required>
        <?php
        if (count($productos) > 0) {
            foreach ($productos as $c) {
                ?>
                <option value="<?php echo $c['id_habitacion'] ?>"><?php echo $c['id_habitacion'].': '.$c['nombre_habitacion'] ?></option>
                <?php
            }
        }
        ?>
    </select>
    <p class="text-danger"><?php echo isset($errores['habitacion']) ? $errores['habitacion'] : ''; ?></p>
</div>
<div id="dateInputs" style="display: none;">
    <label for="fecha-llegada">Fecha de Llegada:</label>
    <input type="date" id="fecha-llegada" name="fecha-llegada" required >
    <p class="text-danger"><?php echo isset($errores['fecha']) ? $errores['fecha'] : ''; ?></p>
    <br><br>
    
    <label for="fecha-salida">Fecha de Salida:</label>
    <input type="date" id="fecha-salida" name="fecha-salida" required>
    <p class="text-danger"><?php echo isset($errores['fecha']) ? $errores['fecha'] : ''; ?></p>
    <br><br>
</div>
    <input type="submit" value="Submit">
</form>
<script>
    $(document).ready(function() {
        // When the room selection changes
        $('#habitacion').change(function() {
      <?php ?>
    // Get the selected room value
    var selectedRoom = $(this).val();

    // Show or hide the date inputs based on the selection
    if (selectedRoom !== '') {
      $('#dateInputs').show();
    } else {
      $('#dateInputs').hide();
    }
  });
});
  </script>
  </main>