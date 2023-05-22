<main>
<h2>Hotel Reservation Form</h2>
<form action="/reservas/add" method="POST">
    <h3>Informacion del cliente</h3>
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo isset($input['nombre']) ? $input['nombre'] : ''; ?>">
    <p class="text-danger"><?php echo isset($errores['nombre']) ? $errores['nombre'] : ''; ?></p>
    <br><br>
    
    <label for="email">Email Address:</label>
    <input type="email" id="email" name="email" value="<?php echo isset($input['email']) ? $input['email'] : ''; ?>">
    <p class="text-danger"><?php echo isset($errores['email']) ? $errores['email'] : ''; ?></p>
    <br><br>
  <?php  if(isset($errores)){
    var_dump($errores);
  }
  ?>
    <h3>Detalles de la reserva</h3>
    <div class="mb-3 col-sm-4">
    <label for="habitacion">Habitación:</label>
    <select name="habitacion" id="habitacion">
    <option value="default">seleccione una habitacion</option>

        <?php
        if (count($habitaciones) > 0) {
            foreach ($habitaciones as $c) {
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
    <input type="date" id="fecha-llegada" name="fecha-llegada"  value="<?php echo isset($input['fecha-llegada']) ? $input['fecha-llegada'] : ''; ?>">
    <p class="text-danger"><?php echo isset($errores['fecha']) ? $errores['fecha'] : ''; ?></p>
    <br><br>
    
    <label for="fecha-salida">Fecha de Salida:</label>
    <input type="date" id="fecha-salida" name="fecha-salida" value="<?php echo isset($input['fecha-salida']) ? $input['fecha-salida'] : ''; ?>">
    <p class="text-danger"><?php echo isset($errores['fecha']) ? $errores['fecha'] : ''; ?></p>
    <br><br>
</div>
    <input type="submit" value="Submit">
</form>
    <script>
  // Get the room selection element
  var roomSelect = document.getElementById('habitacion');
  
  // Get the date inputs container
  var dateInputs = document.getElementById('dateInputs');
  
  // Add event listener to room selection change
  roomSelect.addEventListener('change', function() {
    var selectedRoom = this.value;
    
    // Show or hide the date inputs based on the selection
    if (selectedRoom !== '') {
      dateInputs.style.display = 'block';
    } else {
      dateInputs.style.display = 'none';
    }
  });
</script>
</main>